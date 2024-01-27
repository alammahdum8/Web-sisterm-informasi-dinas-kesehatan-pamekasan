<?php
// Mulai session
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Jika belum login, arahkan ke halaman login
    header('Location: login.php');
    exit();
}
// Koneksi ke database
$username = "root";
$password = "";
$database = "dinkes1";

$conn = new mysqli("localhost", $username, $password, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mengambil data dari tabel surat
$query = "SELECT * FROM surat";
$result = $conn->query($query);

// Query untuk menambahkan surat
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $namaSurat = $_POST['nama_surat'];
    $namaUpload = $_POST['nama_upload'];

    // Mengatur lokasi untuk menyimpan file
    $targetDirectory = "../admin/surat/";

    $fileExtension = strtolower(pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION));
    $fileName = $namaSurat . '.' . $fileExtension;
    $targetFile = $targetDirectory . $fileName;
    $uploadOk = 1;

    // Periksa apakah file sudah ada
    if (file_exists($targetFile)) {
        echo "Maaf, file sudah ada.";
        $uploadOk = 0;
    }

    // Izinkan hanya beberapa tipe file tertentu
    if ($fileExtension != "pdf" && $fileExtension != "doc" && $fileExtension != "docx") {
        echo "Maaf, hanya file PDF, DOC, dan DOCX yang diizinkan.";
        $uploadOk = 0;
    }

    // Periksa apakah $uploadOk bernilai 0 karena terjadi kesalahan
    if ($uploadOk == 0) {
        echo "File tidak dapat diunggah.";
    } else {
        // Jika semuanya beres, coba unggah file
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
            $file = $fileName;

            $insertQuery = "INSERT INTO surat (nama_surat, file, nama_upload, tgl_upload) 
                            VALUES ('$namaSurat', '$file', '$namaUpload', CURRENT_TIMESTAMP)";

            if ($conn->query($insertQuery) === TRUE) {
                // Redirect setelah berhasil menambahkan surat
                header('Location: index.php');
                exit();
            } else {
                echo "Error: " . $insertQuery . "<br>" . $conn->error;
            }
        } else {
            echo "Terjadi kesalahan saat mengunggah file.";
        }
    }
}
// Query for updating surat details after form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_surat'])) {
    $editID = $_POST['edit_surat'];
    $namaSurat = $_POST['edit_nama_surat'];
    $namaUpload = $_POST['edit_nama_upload'];

    // Get the old file name from the database
    $selectFileQuery = "SELECT file FROM surat WHERE id = $editID";
    $selectFileResult = $conn->query($selectFileQuery);

    if ($selectFileResult->num_rows > 0) {
        $oldFile = $selectFileResult->fetch_assoc()['file'];
    }

    // Check if a new file is provided
    if ($_FILES['edit_file']['size'] > 0) {
        // Delete the old file
        $oldFilePath = "../admin/surat/" . $oldFile;
        unlink($oldFilePath);

        // Upload the new file
        $targetDirectory = "../admin/surat/";
        $fileExtension = strtolower(pathinfo($_FILES["edit_file"]["name"], PATHINFO_EXTENSION));
        $fileName = $namaSurat . '.' . $fileExtension;
        $targetFile = $targetDirectory . $fileName;

        if (move_uploaded_file($_FILES["edit_file"]["tmp_name"], $targetFile)) {
            $file = $fileName;
        } else {
            echo "Terjadi kesalahan saat mengunggah file baru.";
            exit();
        }
    } else {
        // If no new file is provided, use the existing file name if nama surat is changed
        $file = $namaSurat . '.' . pathinfo($oldFile, PATHINFO_EXTENSION);

        if ($oldFile !== $file) {
            // Rename the file if the nama surat is changed
            $oldFilePath = "../admin/surat/" . $oldFile;
            $newFilePath = "../admin/surat/" . $file;
            rename($oldFilePath, $newFilePath);
        }
    }

    // Update surat details in the database
    $updateQuery = "UPDATE surat SET nama_surat='$namaSurat', file='$file', nama_upload='$namaUpload' WHERE id=$editID";

    if ($conn->query($updateQuery) === TRUE) {
        // Redirect after successful update
        header('Location: surat.php');
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}


// Handle delete action
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $deleteID = $_GET['id'];

    // Ambil nama file sebelum menghapus dari database
    $selectFileQuery = "SELECT file FROM surat WHERE id = $deleteID";
    $selectFileResult = $conn->query($selectFileQuery);

    if ($selectFileResult->num_rows > 0) {
        $fileToDelete = $selectFileResult->fetch_assoc()['file'];

        // Hapus file dari folder
        $filePath = "../admin/surat/" . $fileToDelete;
        if (file_exists($filePath)) {
            unlink($filePath);
        } else {
            echo "File tidak ditemukan: " . $fileToDelete;
        }
    }

    // Hapus data dari database
    $deleteQuery = "DELETE FROM surat WHERE id = $deleteID";
    if ($conn->query($deleteQuery) === TRUE) {
        // Redirect kembali ke index setelah berhasil menghapus
        header('Location: index.php');
        exit();
    } else {
        echo "Error: " . $deleteQuery . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Galeri Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="icon" type="image/png" href="../img/Logo-Pamekasan.png" />
    <style>
        .view-file {
            color: black; /* Warna teks awal (hitam) */
            transition: color 0s; /* Animasi perubahan warna selama 0.3 detik */
        }

        .view-file:hover {
            color: blue; /* Warna teks saat kursor mendekat (biru) */
        }
    </style>
</head>
<body class="sb-nav-fixed">
<!-- Navbar atas-->
<nav class="sb-topnav navbar navbar-expand navbar-dark" style="background-color: #3B4045;">
    <div class="container-fluid">
        <a class="navbar-brand ps-3" href="../index.php"><b>SISTEM INFORMASI KESEHATAN</b></a>
        <div class="d-flex">
            <div class="text-white pe-3">
                <?php
                // Periksa apakah pengguna sudah login
                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                    echo '<a href="logout.php" class="btn btn-transparent" style="color: #fff;"><i class="fas fa-sign-out-alt" style="color: #fff;"></i> Logout</a>';
                }
                ?>
            </div>
        </div>
    </div>
</nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav" style="background-image: url('img/sidebar.jpg'); background-size: cover; background-position: center;">
            <nav class="sb-sidenav accordion " style="background-image: linear-gradient(to top, rgba(50, 205, 50, 0.7), rgba(0, 0, 0, 0.2));" id="sidenavAccordion">
                <div class="sb-sidenav-menu ">
                    <div class="nav">
                        <div class="text-center "><br>
                            <img src="img/Logo-Pamekasan.png" class="user-image img-responsive rounded" width="160" />
                            <p class='mt-3 mb-3' style='color: white'> Dinas Kesehatan Pamekasan</p>
                        </div>
                        <a class="nav-link" href="index.php"><i class="fas fa-calendar"></i>&ensp;Dashboard </a>
                        <a class="nav-link" href="puskesmas/index.php"><i class="fa-solid fa-hospital"></i>&ensp;Puskesmas</a>
                        <a class="nav-link" href="apotek/index.php"><i class="fa-solid fa-pills"></i>&ensp;Apotek</a>
                        <a class="nav-link" href="klinik/index.php"><i class="fa-solid fa-bed"></i></i>&ensp;Klinik</a>
                        <a class="nav-link" href="surat.php"><i class="fas fa-envelope"></i>&ensp;Data Surat</a>
                        <a class="nav-link" href="data.php"><i class="fa-solid fa-file-alt"></i>&ensp;Daftar Data</a>
                        <a class="nav-link" href="programdinkes/index.php"><i class="fa-solid fa-book-atlas"></i>&ensp;Program Dinkes</a>
                        <a class="nav-link" href="background.php"><i class="fa-solid fa-image"></i>&ensp;Gambar Slide</a>
                    </div>
                </div>
            </nav>
        </div>

        <div id="layoutSidenav_content">
            <main>
                <div class="container mt-1 p-4">
                    <h2><b>Surat</b></h2>
                    <hr>
                    <div class="row mb-4">
                        <div class="col-md-8 d-flex">
                            <div class="dropdown">
                                <a class="nav-link dropdown-toggle text-dark" href="#" role="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-sort text-dark"></i>&ensp;<span id="selectedSort">Urut berdasarkan</span>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="sortDropdown">
                                    <li><a class="dropdown-item text-dark" href="#" onclick="sortTable(1, 'NamaSurat'); updateSelectedSort('NamaSurat'); return false;">Nama</a></li>
                                    <li><a class="dropdown-item text-dark" href="#" onclick="sortTable(2, 'Jenis'); updateSelectedSort('Jenis'); return false;">Jenis</a></li>
                                    <li><a class="dropdown-item text-dark" href="#" onclick="sortTable(3, 'Alamat'); updateSelectedSort('Alamat'); return false;">Alamat</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input class="form-control" type="search" id="myInput" onkeyup="myFunction()" placeholder="Cari...">
                                <button class="btn btn-success"><i class="bi bi-search"></i></button>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Edit Surat -->
                    <div class="modal fade" id="editSuratModal" tabindex="-1" role="dialog" aria-labelledby="editSuratModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editSuratModalLabel">Edit Surat</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- Form Edit Surat -->
                                    <form method="post" action="" enctype="multipart/form-data">
                                        <input type="hidden" name="edit_surat" id="edit_surat">
                                        <div class="form-group">
                                            <label for="edit_nama_surat">Nama Surat:</label>
                                            <input type="text" class="form-control" id="edit_nama_surat" name="edit_nama_surat" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="edit_file">File Baru:</label>
                                            <input type="file" class="form-control-file" id="edit_file" name="edit_file">
                                        </div>
                                        <div class="form-group">
                                            <label for="edit_nama_upload">Nama Upload:</label>
                                            <input type="text" class="form-control" id="edit_nama_upload" name="edit_nama_upload" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary" name="update_surat">Update</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal untuk Menampilkan File -->
                    <div class="modal fade" id="fileModal" tabindex="-1" role="dialog" aria-labelledby="fileModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="fileModalLabel">Tampilan File</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <iframe id="fileViewer" src="" frameborder="0" style="width: 100%; height: 500px;"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <?php
                            if ($result->num_rows > 0) {
                                echo "<table class='table table-bordered'>
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nama Surat</th>
                                                <th>File</th>
                                                <th>Nama Upload</th>
                                                <th>Tanggal Upload</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>";
                                    $i = 1;
                                    while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                            <td>{$i}</td>
                                            <td>{$row['nama_surat']}</td>
                                            <td>
                                                <a href='#' class='view-file' data-file='../admin/surat/{$row['file']}' data-toggle='modal' data-target='#fileModal'>
                                                    {$row['file']}
                                                </a>
                                            </td>
                                            <td>{$row['nama_upload']}</td>
                                            <td>{$row['tgl_upload']}</td>
                                            <td>
                                                <button class='btn btn-warning edit-surat-btn' 
                                                        data-id='{$row['id']}' 
                                                        data-nama-surat='{$row['nama_surat']}' 
                                                        data-nama-upload='{$row['nama_upload']}'>
                                                    <i class='fas fa-edit'></i> <!-- Ikon edit dari FontAwesome -->
                                                </button>
                                                <a href='index.php?action=delete&id={$row['id']}' onclick='return confirmDelete();' class='btn btn-danger'>
                                                    <i class='fas fa-trash'></i> <!-- Ikon delete dari FontAwesome -->
                                                </a>
                                            </td>
                                        </tr>";
                                        $i++;
                                }

                                echo "</tbody></table>";
                            } else {
                                echo "<p class='text-center'>Tidak ada data surat.</p>";
                            }
                        $conn->close();
                        ?>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/viewerjs@1.9.2/dist/viewer.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
         // JavaScript to handle edit button click event
         $(document).ready(function () {
            $('.edit-surat-btn').click(function () {
                var id = $(this).data('id');
                var namaSurat = $(this).data('nama-surat');
                var namaUpload = $(this).data('nama-upload');

                // Set values in the edit modal
                $('#edit_surat').val(id);
                $('#edit_nama_surat').val(namaSurat);
                $('#edit_nama_upload').val(namaUpload);

                // Show the edit modal
                $('#editSuratModal').modal('show');
            });
        });
        // JavaScript to handle file viewing
        $(document).ready(function () {
            $('.view-file').click(function () {
                var fileURL = $(this).data('file');
                $('#fileViewer').attr('src', fileURL);
            });
        });

        // JavaScript to handle edit button click event
        $(document).ready(function () {
            $('.edit-surat-btn').click(function () {
                var id = $(this).data('id');
                var namaSurat = $(this).data('nama-surat');
                var namaUpload = $(this).data('nama-upload');

                // Set values in the edit modal
                $('#edit_surat').val(id);
                $('#edit_nama_surat').val(namaSurat);
                $('#edit_nama_upload').val(namaUpload);

                // Show the edit modal
                $('#editSuratModal').modal('show');
            });
        });
        function myFunction() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            table = document.getElementsByTagName("table")[0];
            tr = table.getElementsByTagName("tr");

            var visibleRowCounter = 1; // Counter for visible rows

            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1]; // Assuming "No" is in the second column (index 1)
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        // Display the row and update the "No" column
                        tr[i].style.display = "";
                        tr[i].getElementsByTagName("td")[0].innerText = visibleRowCounter++;
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
        function sortTable(columnIndex, sortBy) {
            var table, rows, switching, i, x, y, shouldSwitch;
            table = document.getElementsByTagName("table")[0];
            switching = true;

            while (switching) {
                switching = false;
                rows = table.rows;

                for (i = 1; i < rows.length - 1; i++) {
                    shouldSwitch = false;

                    x = rows[i].getElementsByTagName("td")[columnIndex];
                    y = rows[i + 1].getElementsByTagName("td")[columnIndex];

                    if (columnIndex !== 0) {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    } else {
                        if (parseInt(x.innerHTML) > parseInt(y.innerHTML)) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                }

                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                }
            }

            // Update button text with the selected sorting option
            var sortDropdown = document.querySelector('#sortDropdown');
            sortDropdown.innerHTML = '<i class="fa-solid fa-sort"></i>&ensp;Urut berdasarkan ' + sortBy;
            sortDropdown.setAttribute("data-sortby", sortBy);

            // Reassign sequential numbers after sorting
            for (i = 1; i < rows.length; i++) {
                rows[i].getElementsByTagName("td")[0].innerHTML = i;
            }
        }
        
        function confirmDelete() {
            return confirm('Apakah Anda yakin ingin menghapus data ini?');
        }
    </script>
</body>
</html>
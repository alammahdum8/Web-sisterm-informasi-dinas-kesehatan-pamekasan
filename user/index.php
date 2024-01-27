<?php
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
        header('Location: index.php');
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
    <meta charset="UTF-8">
    <title>Data Surat</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-...." crossorigin="anonymous" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/viewerjs@1.9.2/dist/viewer.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="icon" type="image/png" href="../admin/img/Logo-Pamekasan.png" />
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css" integrity="sha384-x7p5a9xKXQU+K6Ly1OdbzGyWjexd05jO5en3/2L7kA2UL2VfNT/vDHVL9Kb4XtkD" crossorigin="anonymous">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
        }

        table {
        border-collapse: collapse;
        width: 100%;
        margin-top: 20px;
        }

        table, th, td {
        border: 1px solid #ddd;
        }

        th, td {
        padding: 12px;
        text-align: center;
        }

        th {
        background-color: #f2f2f2;
        text-align: center;
        }

        .modal-body {
            background-color: #fff;
        }

        .modal-content {
            border-radius: 0;
        }

        .modal-header {
            background-image: url('https://img.freepik.com/premium-vector/beautiful-green-art-with-linear-floral-pattern_76645-131.jpg');            color: #fff;
        }

        iframe {
            width: 100%;
            height: 400px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        h2 {
            color: #343a40;
        }

        .jumbotron {
            background: url('../img/wallpaper.png') center/cover;
            color: #fff;
            text-align: center;
            padding: 100px 0;
            border-radius: 0;
            margin-bottom: 0;
        }

        .jumbotron h1 {
            font-size: 3.5rem;
            font-weight:bold;
        }

        .jumbotron p {
            font-size: 2.5rem;
        }
        body::-webkit-scrollbar{
	        display: none;
        }
        #detailTable{
            overflow-x: auto;
            margin-bottom: 50px;
        }

        @media screen and (max-width: 800px) {
        .container {
            margin-top: 30px;
        }
        .col-md-8{
            margin-bottom: 10px;
        }
        .input-group {
            width: 100%; /* Adjust the width to take full space */
        }

        .jumbotron h1 {
            font-size: 2.5rem;
        }

        .jumbotron p {
            font-size: 1.5rem;
        }
        .btn-warning{
            margin-bottom: 10px;
        }
        
    }
    </style>
</head>
<body>

    <div class="jumbotron">
        <h1 class="display-4">Selamat Datang</h1>
        <p class="lead">Kelola Data Surat Dengan Mudah</p>
    </div>

    <div class="container mt-3">
    <div class="row">
        <div class="col-md-8 d-flex">
            <button type="button" class="btn btn-success me-2" data-toggle="modal" data-target="#tambahSuratModal">Tambah</button>
            <div class="dropdown">
                <a class="nav-link dropdown-toggle text-dark" href="#" role="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-sort text-dark"></i>&ensp;<span id="selectedSort">Urutkan</span>
                </a>
                <ul class="dropdown-menu" aria-labelledby="sortDropdown">
                    <li><a class="dropdown-item text-dark" href="#" onclick="sortTable(1, 'Surat'); updateSelectedSort('nama_surat'); return false;">Nama Surat</a></li>
                    <li><a class="dropdown-item text-dark" href="#" onclick="sortTable(3, 'Nama'); updateSelectedSort('nama_upload'); return false;">Nama Pengupload</a></li>
                    <li><a class="dropdown-item text-dark" href="#" onclick="sortTable(4, 'Tanggal'); updateSelectedSort('tgl_upload'); return false;">Tanggal</a></li>
                </ul>
            </div>
        </div>
        <div class="col-md-4">
            <!-- Search input (unchanged) -->
            <div class="input-group">
                <input class="form-control" type="search" id="myInput" onkeyup="myFunction()" placeholder="Cari...">
                <button class="btn btn-success"><i class="bi bi-search"></i></button>
            </div>
        </div>
    </div>

        <div id=detailTable>
        <?php
        if ($result->num_rows > 0) {
            echo "<table class='table table-bordered'>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Surat</th>
                            <th>File</th>
                            <th>Nama Pengunggah</th>
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

    <!-- Modal Tambah Surat -->
    <div class="modal fade" id="tambahSuratModal" tabindex="-1" role="dialog" aria-labelledby="tambahSuratModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahSuratModalLabel">Tambah Surat</h5>
                    <button type="button" class="close" style="color: white;" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form Tambah Surat -->
                    <form method="post" action="" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="nama_surat">Nama Surat:</label>
                            <input type="text" class="form-control" id="nama_surat" name="nama_surat" required>
                        </div>
                        <div class="form-group">
                            <label for="file">File:</label>
                            <input type="file" class="form-control-file" id="file" name="file" required>
                        </div>
                        <div class="form-group">
                            <label for="nama_upload">Nama Pengunggah:</label>
                            <input type="text" class="form-control" id="nama_upload" name="nama_upload" required>
                        </div>
                        <button type="submit" class="btn btn-success">Tambahkan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Edit Surat -->
    <div class="modal fade" id="editSuratModal" tabindex="-1" role="dialog" aria-labelledby="editSuratModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSuratModalLabel">Edit Surat</h5>
                    <button type="button" class="close" style="color: white;" data-dismiss="modal" aria-label="Close">
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
                            <label for="edit_nama_upload">Nama Pengunggah:</label>
                            <input type="text" class="form-control" id="edit_nama_upload" name="edit_nama_upload" required>
                        </div>
                        <button type="submit" class="btn btn-success" name="update_surat">Update</button>
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
    <!-- Bootstrap and Viewer.js scripts -->
    <script src="https://cdn.jsdelivr.net/npm/viewerjs@1.9.2/dist/viewer.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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
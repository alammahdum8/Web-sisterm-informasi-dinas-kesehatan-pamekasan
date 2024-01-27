<?php
// Mulai session
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Jika belum login, arahkan ke halaman login
    header('Location: login.php');
    exit();
}
$servername = "localhost";
$username = "root";
$password = "";
$database = "dinkes1";

$koneksi = new mysqli($servername, $username, $password, $database);

// Periksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi Gagal: " . $koneksi->connect_error);
}

// Fungsi untuk mendapatkan data file dari database
function getFiles() {
    global $koneksi;
    $query = "SELECT * FROM data";
    $result = $koneksi->query($query);
    $files = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $files[] = $row;
        }
    }

    return $files;
}

// Fungsi untuk menambah file baru
function tambahFile($judul_file, $file) {
    global $koneksi;

    // Ambil informasi file
    $nama_file_asli = $file['name'];
    $ukuran_file = $file['size'];
    $error = $file['error'];
    $tmp_name = $file['tmp_name'];

    // Ekstensi yang diizinkan
    $ekstensi_diizinkan = array('xlsx', 'csv', 'pdf');

    // Periksa ekstensi file
    $ekstensi = strtolower(pathinfo($nama_file_asli, PATHINFO_EXTENSION));
    if (!in_array($ekstensi, $ekstensi_diizinkan)) {
        echo "Maaf, hanya file dengan format XLSX, CSV, dan PDF yang diizinkan.";
        return;
    }

    // Ganti spasi dengan karakter pengganti (misalnya garis bawah)
    $judul_file_tanpa_spasi = str_replace(' ', '_', $judul_file);

    // Tentukan folder untuk menyimpan file
    $folder_simpan = "data/";

    // Buat nama file baru dengan menambahkan ekstensi
    $nama_file_baru = $judul_file_tanpa_spasi . '.' . $ekstensi;

    // Pindahkan file ke folder yang ditentukan
    if (move_uploaded_file($tmp_name, $folder_simpan . $nama_file_baru)) {
        // Insert data file ke database
        $query = "INSERT INTO data (judul_file, nama_file) VALUES ('$judul_file', '$nama_file_baru')";
        if ($koneksi->query($query) === TRUE) {
            // Sukses menambahkan file, tambahkan suara
            echo '<audio autoplay><source src="sukses.mp3" type="audio/mpeg"></audio>';
            echo "File berhasil ditambahkan.";
        } else {
            echo "Terjadi kesalahan saat menambahkan file ke database.";
        }
    } else {
        echo "Terjadi kesalahan saat mengupload file.";
    }
}

// Fungsi untuk mengupdate file berdasarkan ID
function updateFile($id, $judul_file, $file) {
    global $koneksi;

    // Ambil informasi file
    $nama_file_asli = $file['name'];
    $ukuran_file = $file['size'];
    $error = $file['error'];
    $tmp_name = $file['tmp_name'];

    // Ekstensi yang diizinkan
    $ekstensi_diizinkan = array('xlsx', 'csv', 'pdf');

    // Periksa ekstensi file
    $ekstensi = strtolower(pathinfo($nama_file_asli, PATHINFO_EXTENSION));
    if (!in_array($ekstensi, $ekstensi_diizinkan)) {
        echo "Maaf, hanya file dengan format XLSX, CSV, dan PDF yang diizinkan.";
        return;
    }

    // Ganti spasi dengan karakter pengganti (misalnya garis bawah)
    $judul_file_tanpa_spasi = str_replace(' ', '_', $judul_file);

    // Tentukan folder untuk menyimpan file
    $folder_simpan = "data/";

    // Buat nama file baru dengan menambahkan ekstensi
    $nama_file_baru = $judul_file_tanpa_spasi . '.' . $ekstensi;

    // Ambil nama file lama dari database
    $query_select_old = "SELECT nama_file FROM data WHERE id=$id";
    $result_select_old = $koneksi->query($query_select_old);

    if ($result_select_old->num_rows > 0) {
        $row_old = $result_select_old->fetch_assoc();
        $nama_file_old = $row_old['nama_file'];

        // Hapus file lama dari folder
        $file_path_old = "data/" . $nama_file_old;
        if (file_exists($file_path_old)) {
            unlink($file_path_old);
        }

        // Pindahkan file ke folder yang ditentukan
        if (move_uploaded_file($tmp_name, $folder_simpan . $nama_file_baru)) {
            // Update data file di database
            $query_update = "UPDATE data SET judul_file='$judul_file', nama_file='$nama_file_baru' WHERE id=$id";
            if ($koneksi->query($query_update) === TRUE) {
                // Sukses mengupdate file, tambahkan suara
                echo '<audio autoplay><source src="sukses.mp3" type="audio/mpeg"></audio>';
                echo "File berhasil diupdate.";
            } else {
                echo "Terjadi kesalahan saat mengupdate file di database.";
            }
        } else {
            echo "Terjadi kesalahan saat mengupload file.";
        }
    }
}

// Fungsi untuk menghapus file berdasarkan ID
function deleteFile($id) {
    global $koneksi;

    // Ambil nama file dari database
    $query = "SELECT nama_file FROM data WHERE id=$id";
    $result = $koneksi->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nama_file = $row['nama_file'];

        // Hapus file dari folder
        $file_path = "data/" . $nama_file;
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        // Hapus data file dari database
        $query_delete = "DELETE FROM data WHERE id=$id";
        if ($koneksi->query($query_delete) === TRUE) {
            echo "File berhasil dihapus.";
        } else {
            echo "Terjadi kesalahan saat menghapus file dari database.";
        }
    }
}

// Ambil ID file dari parameter URL
$id_file = isset($_GET['edit']) ? $_GET['edit'] : '';

// Jika formulir edit disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_file'])) {
    $id_edit = $_POST['edit_id'];
    $judul_file_edit = $_POST['edit_judul_file'];
    $file_edit = $_FILES['edit_file'];

    // Panggil fungsi untuk mengupdate file
    updateFile($id_edit, $judul_file_edit, $file_edit);
}

// Jika formulir tambah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah_file'])) {
    $judul_file = $_POST['judul_file'];
    $file = $_FILES['file'];

    // Panggil fungsi untuk menambah file baru
    tambahFile($judul_file, $file);
}

// Jika parameter delete di URL diset
if (isset($_GET['delete'])) {
    $id_delete = $_GET['delete'];

    // Panggil fungsi deleteFile
    if (deleteFile($id_delete)) {
        echo "File berhasil dihapus.";
    } else {
        echo "Terjadi kesalahan saat menghapus file.";
    }
}

// Ambil data file dari database
$files = getFiles();
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
    <link rel="icon" type="image/png" href="img/Logo-Pamekasan.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css" integrity="sha384-x7p5a9xKXQU+K6Ly1OdbzGyWjexd05jO5en3/2L7kA2UL2VfNT/vDHVL9Kb4XtkD" crossorigin="anonymous">
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
                        <a class="nav-link" href="surat.php"><i class="fa fa-envelope"></i>&ensp;Data Surat</a>
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
                    <h2><b>DAFTAR DATA</b></h2>
                    <hr>
                    <div class="row mb-4">
                        <div class="col-md-8 d-flex">
                            <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#modalTambahFile">Tambah</button>
                            <div class="dropdown">
                                <a class="nav-link dropdown-toggle text-dark" href="#" role="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-sort text-dark"></i>&ensp;<span id="selectedSort">Urut berdasarkan</span>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="sortDropdown">
                                    <li><a class="dropdown-item text-dark" href="#" onclick="sortTable(1, 'judul_file'); updateSelectedSort('judul_file'); return false;">Judul File</a></li>
                                    <li><a class="dropdown-item text-dark" href="#" onclick="sortTable(2, 'nama_file'); updateSelectedSort('nama_file'); return false;">Nama File</a></li>
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

                    <!-- Modal untuk tambah file -->
                    <div class="modal fade" id="modalTambahFile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Tambah File Baru</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                   <!-- Formulir untuk upload file -->
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="judul_file" class="form-label">Judul File</label>
                                        <input type="text" class="form-control" id="judul_file" name="judul_file" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="file" class="form-label">Pilih File (XLSX/CSV/PDF)</label>
                                        <input type="file" class="form-control" id="file" name="file" accept=".xlsx, .csv, .pdf" required>
                                    </div>
                                    <button type="submit" name="tambah_file" class="btn btn-success">Tambah</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal for editing file -->
                    <div class="modal fade" id="modalEditFile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit File</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Formulir untuk edit file -->
                                    <form action="" method="post" enctype="multipart/form-data">
                                        <div class="mb-3">
                                            <label for="edit_judul_file" class="form-label">Judul File</label>
                                            <input type="text" class="form-control" id="edit_judul_file" name="edit_judul_file" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit_file" class="form-label">Pilih File Baru (XLSX/CSV/PDF)</label>
                                            <input type="file" class="form-control" id="edit_file" name="edit_file" accept=".xlsx, .csv, .pdf">
                                        </div>
                                        <input type="hidden" name="edit_id" id="edit_id">
                                        <button type="submit" name="update_file" class="btn btn-success">Simpan Perubahan</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabel untuk menampilkan daftar file -->
                    <div class="table-responsive"><br>
                        <table class="table table-bordered table-striped ">
                            <tr class="text-center">
                                <th>No</th>
                                <th>Judul File</th>
                                <th>Aksi</th>
                            </tr>
                            <?php
                            $id_manual = 1;
                            foreach ($files as $item) :
                            ?>
                                <tr>
                                    <td><?php echo $id_manual; ?></td>
                                    <td><?php echo $item['judul_file']; ?></td>
                                    <td>
                                    <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditFile" onclick="prepareEdit('<?php echo $item['id']; ?>', '<?php echo $item['judul_file']; ?>')">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                        <a href="?delete=<?php echo $item['id']; ?>" onClick="return confirm('Yakin?')" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash-fill"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php
                            $id_manual++;
                            endforeach;
                            ?>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var judulFileInput = document.getElementById('judul_file');
            judulFileInput.addEventListener('input', validateJudulFile);
        });

        function validateJudulFile() {
            // Tidak ada validasi khusus untuk karakter judul file
            // Biarkan pengguna memasukkan karakter apa pun
        }

        function prepareEdit(id, judul_file) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_judul_file').value = judul_file;
        }
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
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


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

// Fungsi untuk mendapatkan data gambar dari database
function getGambar() {
    global $koneksi;
    $query = "SELECT * FROM gambar";
    $result = $koneksi->query($query);
    $gambar = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $gambar[] = $row;
        }
    }

    return $gambar;
}

// Fungsi untuk menambah gambar baru
function tambahGambar($nama_gambar_baru, $file_gambar) {
    global $koneksi;

    // Ambil informasi file gambar
    $nama_file = $file_gambar['name'];
    $ukuran_file = $file_gambar['size'];
    $error = $file_gambar['error'];
    $tmp_name = $file_gambar['tmp_name'];

    // Ekstensi yang diizinkan
    $ekstensi_diizinkan = array('jpg', 'jpeg', 'png');

    // Periksa ekstensi file
    $ekstensi = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
    if (!in_array($ekstensi, $ekstensi_diizinkan)) {
        echo "Maaf, hanya file gambar dengan format JPG dan PNG yang diizinkan.";
        return;
    }

    // Tentukan folder untuk menyimpan gambar
    $folder_simpan = "Slide/";

    // Generate nama file baru berdasarkan input nama gambar
    $nama_file_baru = $nama_gambar_baru . '.' . $ekstensi;

    // Pindahkan file gambar ke folder yang ditentukan
    if (move_uploaded_file($tmp_name, $folder_simpan . $nama_file_baru)) {
        // Insert data gambar ke database
        $query = "INSERT INTO gambar (nama_gambar) VALUES ('$nama_file_baru')";
        if ($koneksi->query($query) === TRUE) {
            // Sukses menambahkan gambar, tambahkan suara
            echo '<audio autoplay><source src="sukses.mp3" type="audio/mpeg"></audio>';
            echo "Gambar berhasil ditambahkan.";
        } else {
            echo "Terjadi kesalahan saat menambahkan gambar ke database.";
        }
    } else {
        echo "Terjadi kesalahan saat mengupload gambar.";
    }
}

// Fungsi untuk menghapus gambar berdasarkan ID
function deleteGambar($id) {
    global $koneksi;

    // Ambil nama file gambar dari database
    $query = "SELECT nama_gambar FROM gambar WHERE id=$id";
    $result = $koneksi->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nama_gambar = $row['nama_gambar'];

        // Hapus file gambar dari folder
        $file_path = "Slide/" . $nama_gambar;
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        // Hapus data gambar dari database
        $query_delete = "DELETE FROM gambar WHERE id=$id";
        if ($koneksi->query($query_delete) === TRUE) {
            echo "Gambar berhasil dihapus.";
        } else {
            echo "Terjadi kesalahan saat menghapus gambar dari database.";
        }
    }
}

// Ambil ID gambar dari parameter URL
$id_gambar = isset($_GET['edit']) ? $_GET['edit'] : '';

// Jika formulir tambah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah_gambar'])) {
    $nama_gambar_baru = $_POST['nama_gambar_baru'];
    $file_gambar = $_FILES['file_gambar'];

    // Panggil fungsi untuk menambah gambar baru
    tambahGambar($nama_gambar_baru, $file_gambar);
}

// Jika parameter delete di URL diset
if (isset($_GET['delete'])) {
    $id_delete = $_GET['delete'];

    // Panggil fungsi deleteGambar
    if (deleteGambar($id_delete)) {
        echo "Gambar berhasil dihapus.";
    } else {
        echo "Terjadi kesalahan saat menghapus gambar.";
    }
}

// Ambil data gambar dari database
$gambar = getGambar();
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
    <!-- Navbar samping-->
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav" style="background-image: url('img/sidebar.jpg'); background-size: cover; background-position: center;">
            <nav class="sb-sidenav accordion " style="background-image: linear-gradient(to top, rgba(50, 205, 50, 0.7), rgba(0, 0, 0, 0.2));" id="sidenavAccordion">
                <div class="sb-sidenav-menu ">
                    <div class="nav">
                        <!--Profil-->
                        <div class="text-center "><br>
                            <img src="img/Logo-Pamekasan.png" class="user-image img-responsive rounded" width="160" />
                            <p class='mt-3 mb-3' style='color: white'> Dinas Kesehatan Pamekasan</p>
                        </div>

                        <!--Menu navbar samping-->
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
        <!-- Navbar samping end-->

        <!-- content start-->
        <div id="layoutSidenav_content">
            <main>
                <div class="container mt-1 p-4">
                    <h2><b>SLIDE GAMBAR</b></h2>
                    <hr>
                    <div class="row mb-4">
                        <div class="col-md-8 d-flex">
                            <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#modalTambahGambar">Tambah</button>
                        </div>
                    <!-- Modal untuk tambah gambar -->
                    <div class="modal fade" id="modalTambahGambar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Gambar Baru</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Formulir untuk upload gambar -->
                                    <form action="" method="post" enctype="multipart/form-data">
                                        <div class="mb-3">
                                            <label for="file_gambar" class="form-label">Pilih Gambar (JPG/PNG)</label>
                                            <input type="file" class="form-control" id="file_gambar" name="file_gambar" accept=".jpg, .jpeg, .png" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="nama_gambar_baru" class="form-label">Nama Gambar</label>
                                            <input type="text" class="form-control" id="nama_gambar_baru" name="nama_gambar_baru" required>
                                        </div>
                                        <button type="submit" name="tambah_gambar" class="btn btn-success">Tambah</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabel untuk menampilkan daftar gambar -->
                    <div class="table-responsive"><br>
                        <table class="table table-bordered table-striped text-center">
                            <tr>
                                <th>No</th>
                                <th>Nama Gambar</th>
                                <th>Gambar</th>
                                <th>Aksi</th>
                            </tr>
                            <?php
                            $id_manual = 1;
                            foreach ($gambar as $item) :
                            ?>
                                <tr>
                                    <td><?php echo $id_manual; ?></td>
                                    <td><?php echo $item['nama_gambar']; ?></td>
                                    <td><img src="Slide/<?php echo $item['nama_gambar']; ?>" alt="Gambar" width="50"></td>
                                    <td>
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
        <!-- content end -->
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

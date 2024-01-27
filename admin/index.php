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

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetching counts from each table
$query_puskesmas = "SELECT COUNT(*) AS puskesmas_count FROM puskesmas";
$query_apotek = "SELECT COUNT(*) AS apotek_count FROM apotek";
$query_klinik = "SELECT COUNT(*) AS klinik_count FROM klinik";
$query_programdinkes = "SELECT COUNT(*) AS programdinkes_count FROM programdinkes";
$query_gambar = "SELECT COUNT(*) AS gambar_count FROM gambar";
$query_data = "SELECT COUNT(*) AS data_count FROM data";
$query_surat = "SELECT COUNT(*) AS surat_count FROM surat"; // New query for "surat"
$result_data = $conn->query($query_data);
$result_puskesmas = $conn->query($query_puskesmas);
$result_apotek = $conn->query($query_apotek);
$result_klinik = $conn->query($query_klinik);
$result_programdinkes = $conn->query($query_programdinkes);
$result_gambar = $conn->query($query_gambar);
$result_surat = $conn->query($query_surat); // New result for "surat"

// Checking if queries are successful
if (!$result_puskesmas || !$result_apotek || !$result_klinik || !$result_programdinkes || !$result_gambar || !$result_data || !$result_surat) {
    die("Query failed: " . $conn->error);
}

// Fetching counts
$row_puskesmas = $result_puskesmas->fetch_assoc();
$row_apotek = $result_apotek->fetch_assoc();
$row_klinik = $result_klinik->fetch_assoc();
$row_programdinkes = $result_programdinkes->fetch_assoc();
$row_gambar = $result_gambar->fetch_assoc();
$row_data = $result_data->fetch_assoc();
$row_surat = $result_surat->fetch_assoc(); // New row for "surat"

// Closing database connection
$conn->close();
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
    <style>
        .count-box {
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
            background-color: #fff; /* You can change the background color */
            box-shadow: 0 16px 32px rgba(0, 0, 0, 0.1);
            text-align: center;
            cursor: pointer;
            transition: transform 0.3s ease-in-out;
        }

        .count-box:hover {
            transform: scale(1.05);
        }

        .count-icon {
            font-size: 2rem;
            color: #0d730d; /* You can change the icon color */
        }

        .count-title {
            font-size: 1.2rem;
            margin-top: 10px; /* Added margin top for spacing */
        }

        .count-number {
            font-size: 2rem;
            font-weight: bold;
            margin-top: 10px;
        }

        /* Additional styling for the dashboard title */
        h2 {
            margin-bottom: 20px;
            text-align: center;
            color: #3B4045; /* You can change the title color */
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
                        <a class="nav-link" href="surat.php"><i class="fas fa-envelope"></i>&ensp;Data Surat</a>
                        <a class="nav-link" href="data.php"><i class="fa-solid fa-file-alt"></i>&ensp;Daftar Data</a>
                        <a class="nav-link" href="programdinkes/index.php"><i class="fa-solid fa-book-atlas"></i>&ensp;Program Dinkes</a>
                        <a class="nav-link" href="background.php"><i class="fa-solid fa-image"></i>&ensp;Gambar Slide</a>
                    </div>
                </div>
            </nav>
        </div>
        <!-- Navbar samping end-->

        <!--content start-->
        <div id="layoutSidenav_content">
            <main>
            <div class="container mt-1 p-4">
            <h2><b>DASHBOARD</b></h2>

            <div class="row">
                <div class="col-md-3" onclick="window.location.href='puskesmas/index.php';">
                    <div class="count-box">
                        <i class="fas fa-hospital count-icon"></i>
                        <h5 class="count-title">Puskesmas</h5>
                        <div class="count-number"><?php echo $row_puskesmas['puskesmas_count']; ?></div>
                    </div>
                </div>

                <div class="col-md-3" onclick="window.location.href='apotek/index.php';">
                    <div class="count-box">
                        <i class="fas fa-pills count-icon"></i>
                        <h5 class="count-title">Apotek</h5>
                        <div class="count-number"><?php echo $row_apotek['apotek_count']; ?></div>
                    </div>
                </div>

                <div class="col-md-3" onclick="window.location.href='klinik/index.php';">
                    <div class="count-box">
                        <i class="fas fa-bed count-icon"></i>
                        <h5 class="count-title">Klinik</h5>
                        <div class="count-number"><?php echo $row_klinik['klinik_count']; ?></div>
                    </div>
                </div>

                <div class="col-md-3" onclick="window.location.href='programdinkes/index.php';">
                    <div class="count-box">
                        <i class="fas fa-book-medical count-icon"></i>
                        <h5 class="count-title">Program Dinkes</h5>
                        <div class="count-number"><?php echo $row_programdinkes['programdinkes_count']; ?></div>
                    </div>
                </div>

                <div class="col-md-3" onclick="window.location.href='data.php';">
                    <div class="count-box">
                        <i class="fas fa-file-alt count-icon"></i>
                        <h5 class="count-title">Data</h5>
                        <div class="count-number"><?php echo $row_data['data_count']; ?></div>
                    </div>
                </div>

                <div class="col-md-3" onclick="window.location.href='background.php';">
                    <div class="count-box">
                        <i class="fas fa-image count-icon"></i>
                        <h5 class="count-title">Slide</h5>
                        <div class="count-number"><?php echo $row_gambar['gambar_count']; ?></div>
                    </div>
                </div>
                <div class="col-md-3" onclick="window.location.href='surat.php';">
                    <div class="count-box">
                        <i class="fas fa-envelope count-icon"></i>
                        <h5 class="count-title">Data Surat</h5>
                        <div class="count-number"><?php echo $row_surat['surat_count']; ?></div>
                    </div>
                </div>
            </div>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
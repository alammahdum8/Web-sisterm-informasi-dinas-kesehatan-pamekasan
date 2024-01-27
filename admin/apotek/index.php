<?php
// Mulai session
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Jika belum login, arahkan ke halaman login
    header('Location: ../login.php');
    exit();
}
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$database = "dinkes1";
// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $database);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query untuk mengambil data apotek
$query = "SELECT * FROM apotek";
$result = $conn->query($query);

// Proses penambahan data apotek
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['addApotek'])) {
        $nama = $_POST['nama'];
        $alamat = $_POST['alamat'];
        $kecamatan = $_POST['kecamatan'];
        $latitude = $_POST['latitude'];
        $longtitude = $_POST['longtitude'];

        // Query untuk menambahkan data apotek
        $insertQuery = "INSERT INTO apotek (nama, alamat, kecamatan, latitude, longtitude) 
                        VALUES ('$nama', '$alamat', '$kecamatan', '$latitude', '$longtitude')";

        if ($conn->query($insertQuery) === TRUE) {
            header("Location: index.php?status=success");
            exit();
        } else {
            header("Location: index.php?status=failed");
            exit();
        }
    }

    // Proses update data apotek
    if (isset($_POST['edit_no'])) {
        $edit_no = $_POST['edit_no'];
        $edit_nama = $_POST['edit_nama'];
        $edit_alamat = $_POST['edit_alamat'];
        $edit_kecamatan = $_POST['edit_kecamatan'];
        $edit_latitude = $_POST['edit_latitude'];
        $edit_longtitude = $_POST['edit_longtitude'];

        // Query untuk mengupdate data apotek
        $updateQuery = "UPDATE apotek SET nama='$edit_nama', alamat='$edit_alamat', kecamatan='$edit_kecamatan', 
                        latitude='$edit_latitude', longtitude='$edit_longtitude' WHERE no=$edit_no";

        if ($conn->query($updateQuery) === TRUE) {
            header("Location: index.php?status=success");
            exit();
        } else {
            header("Location: index.php?status=failed");
            exit();
        }
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
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="icon" type="image/png" href="../img/Logo-Pamekasan.png" />
    <style>
        #alertDiv {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-34%);
            z-index: 1;
            width: 100%;
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
                    echo '<a href="../logout.php" class="btn btn-transparent" style="color: #fff;"><i class="fas fa-sign-out-alt" style="color: #fff;"></i> Logout</a>';
                }
                ?>
            </div>
        </div>
    </div>
</nav>

    <!-- Navbar samping-->
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav" style="background-image: url('../img/sidebar.jpg'); background-size: cover; background-position: center;">
            <nav class="sb-sidenav accordion " style="background-image: linear-gradient(to top, rgba(50, 205, 50, 0.7), rgba(0, 0, 0, 0.2));" id="sidenavAccordion">
                <div class="sb-sidenav-menu ">
                    <div class="nav">
                        <!--Profil-->
                        <dev class="text-center "><br>
                            <img src="../img/Logo-Pamekasan.png" class="user-image img-responsive rounded" width="160" />
                            <p class='mt-3 mb-3' style='color: white'> Dinas Kesehatan Pamekasan</p>
                        </dev>
                        <!--Menu navbar samping-->
                        <a class="nav-link" href="../index.php"><i class="fas fa-calendar"></i>&ensp;Dashboard </a>
                        <a class="nav-link" href="../puskesmas/index.php"><i class="fa-solid fa-hospital"></i>&ensp;Puskesmas</a>
                        <a class="nav-link" href="../apotek/index.php"><i class="fa-solid fa-pills"></i>&ensp;Apotek</a>
                        <a class="nav-link" href="../klinik/index.php"><i class="fa-solid fa-bed"></i></i>&ensp;Klinik</a>
                        <a class="nav-link" href="../surat.php"><i class="fa fa-envelope"></i>&ensp;Data Surat</a>
                        <a class="nav-link" href="../data.php"><i class="fa-solid fa-file-alt"></i>&ensp;Daftar Data</a>
                        <a class="nav-link" href="../programdinkes/index.php"><i class="fa-solid fa-book-atlas"></i>&ensp;Program Dinkes</a>
                        <a class="nav-link" href="../background.php"><i class="fa-solid fa-image"></i>&ensp;Gambar Slide</a>
                    </div>
                </div>
            </nav>
        </div>
        <!-- Navbar samping end-->

        <!-- Content start-->
        <div id="layoutSidenav_content">
            <main>
                <div class="container mt-1 p-4">
                    <h2><b>APOTEK</b></h2>
                    <hr>
                    <!-- Fitur tambah dan pencarian -->
                    <div class="row mb-1">
                        <div class="col-md-1">
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addApotekModal">Tambah</button>
                        </div>
                        <div class="dropdown col-md-7">
                            <a class="nav-link dropdown-toggle text-dark" href="#" role="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-sort text-dark"></i>&ensp;<span id="selectedSort">Urut berdasarkan</span>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="sortDropdown">
                                <li><a class="dropdown-item text-dark" href="#" onclick="sortTable(1, 'Nama'); updateSelectedSort('Nama'); return false;">Nama</a></li>
                                <li><a class="dropdown-item text-dark" href="#" onclick="sortTable(2, 'Alamat'); updateSelectedSort('Alamat'); return false;">Alamat</a></li>
                                <li><a class="dropdown-item text-dark" href="#" onclick="sortTable(3, 'Kecamatan'); updateSelectedSort('Kecamatan'); return false;">Kecamatan</a></li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input class="form-control" type="search" id="myInput" onkeyup="myFunction()" placeholder="Cari...">
                                <button class="btn btn-success"><i class="bi bi-search"></i></button>
                            </div>
                        </div>
                    </div>

                    <!-- Tabel start -->
                    <div class="table-responsive"><br>
                        <table class="table table-bordered table-striped text-center">
                            <!-- Tabel header -->
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Kecamatan</th>
                                <th>Latitude</th>
                                <th>Longtitude</th>
                                <th>Aksi</th>
                            </tr>
                            <?php
                                $i = 1;
                                while ($baris = mysqli_fetch_assoc($result)) {
                            ?> 
                                <!-- Tabel isi -->
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $baris['nama']; ?></td>
                                    <td class="text-truncate" style="max-width: 450px; word-wrap: break-word; white-space: pre-wrap;"><?php echo $baris['alamat']; ?></td>
                                    <td><?php echo $baris['kecamatan']; ?></td>
                                    <td><?php echo $baris['latitude']; ?></td>
                                    <td><?php echo $baris['longtitude']; ?></td>
                                    <!-- button edit dan hapus -->
                                    <td class="action-icons">
                                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editApotekModal" onclick="populateEditModal(<?php echo $baris['no']; ?>, '<?php echo $baris['nama']; ?>', '<?php echo $baris['alamat']; ?>', '<?php echo $baris['kecamatan']; ?>', '<?php echo $baris['latitude']; ?>', '<?php echo $baris['longtitude']; ?>')">
                                            <i class="bi bi-pencil-square"></i> 
                                        </button>
                                        <a href="delete_apotek.php?no=<?php echo $baris['no']; ?>" onClick="return confirm('Yakin?')" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash-fill"></i> 
                                        </a>
                                    </td>
                                </tr>
                                <?php $i++; ?>
                            <?php } ?>
                        </table>
                    </div>
                    <!-- Tabel end -->

                    <!-- Modal for adding apotek -->
                    <div class="modal fade" id="addApotekModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Apotek</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                <div class="modal-body">
                                    <form method="post" action="">
                                        <div class="mb-3">
                                            <label for="nama" class="form-label">Nama Apotek</label>
                                            <input type="text" class="form-control" id="nama" name="nama" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="alamat" class="form-label">Alamat Apotek</label>
                                            <textarea class="form-control" id="alamat" name="alamat" required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="kecamatan" class="form-label">Kecamatan</label>
                                            <input type="text" class="form-control" id="kecamatan" name="kecamatan" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="latitude" class="form-label">Latitude</label>
                                            <input type="text" class="form-control" id="latitude" name="latitude" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="longtitude" class="form-label">Longitude</label>
                                            <input type="text" class="form-control" id="longtitude" name="longtitude" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary" name="addApotek">Tambah</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal for editing apotek -->
                    <div class="modal fade" id="editApotekModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Apotek</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="">
                                        <div class="mb-3">
                                            <label for="edit_nama" class="form-label">Nama Apotek</label>
                                            <input type="text" class="form-control" id="edit_nama" name="edit_nama" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit_alamat" class="form-label">Alamat Apotek</label>
                                            <textarea class="form-control" id="edit_alamat" name="edit_alamat" required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit_kecamatan" class="form-label">Kecamatan</label>
                                            <input type="text" class="form-control" id="edit_kecamatan" name="edit_kecamatan" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit_latitude" class="form-label">Latitude</label>
                                            <input type="text" class="form-control" id="edit_latitude" name="edit_latitude" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit_longtitude" class="form-label">Longitude</label>
                                            <input type="text" class="form-control" id="edit_longtitude" name="edit_longtitude" required>
                                        </div>
                                        <input type="hidden" id="edit_no" name="edit_no">
                                        <button type="submit" class="btn btn-primary" name="editApotek">Simpan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ... (existing modal content) ... -->
            </main>
        </div>
        <!-- Content end-->

        <!-- Script Fitur pencarian -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
        <script>
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

            // Fungsi untuk menyembunyikan alert setelah beberapa detik
            function hideAlert() {
                var alertDiv = document.getElementById('alertDiv');
                alertDiv.style.display = 'none';
            }

            // Ambil status dari URL
            var urlParams = new URLSearchParams(window.location.search);
            var status = urlParams.get('status');

            // Tampilkan alert sesuai dengan status
            if (status === 'success' || status === 'failed') {
                setTimeout(function () {
                    hideAlert();
                }, 2000); // Menghilangkan alert setelah 2 detik
            }

            function populateEditModal(edit_no, edit_nama, edit_alamat, edit_kecamatan, edit_latitude, edit_longtitude) {
                // Populate the edit form fields with the current values
                document.getElementById('edit_no').value = edit_no;
                document.getElementById('edit_nama').value = edit_nama;
                document.getElementById('edit_alamat').value = edit_alamat;
                document.getElementById('edit_kecamatan').value = edit_kecamatan;
                document.getElementById('edit_latitude').value = edit_latitude;
                document.getElementById('edit_longtitude').value = edit_longtitude;
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
    </body>
</html>
              
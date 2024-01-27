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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["submit"])) {
        // Process form submission for adding data
        $nama = $_POST["nama"];
        $alamat = $_POST["alamat"];
        $kelurahan = $_POST["kelurahan"];
        $kecamatan = $_POST["kecamatan"];
        $longtitude = $_POST["longtitude"];
        $latitude = $_POST["latitude"];
        $website = $_POST["website"];
        $email = $_POST["email"];

        // Perform the SQL query to insert data
        $insertQuery = "INSERT INTO puskesmas (nama, alamat, kelurahan, kecamatan, longtitude, latitude, website, email) 
                        VALUES ('$nama', '$alamat', '$kelurahan', '$kecamatan', '$longtitude', '$latitude', '$website', '$email')";

        if ($conn->query($insertQuery) === TRUE) {
            // Redirect to the same page to avoid resubmission
            header("Location: ".$_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "Error: " . $insertQuery . "<br>" . $conn->error;
        }
    } elseif (isset($_POST["update"])) {
        // Process form submission for updating data
        $editNo = $_POST["editNo"];
        $nama = $_POST["editNama"];
        $alamat = $_POST["editAlamat"];
        $kelurahan = $_POST["editKelurahan"];
        $kecamatan = $_POST["editKecamatan"];
        $longtitude = $_POST["editLongtitude"];
        $latitude = $_POST["editLatitude"];
        $website = $_POST["editWebsite"];
        $email = $_POST["editEmail"];

        $updateQuery = "UPDATE puskesmas SET nama='$nama', alamat='$alamat', kelurahan='$kelurahan', kecamatan='$kecamatan', longtitude='$longtitude', latitude='$latitude', website='$website', email='$email' WHERE no=$editNo";

        if ($conn->query($updateQuery) === TRUE) {
            // Redirect to the same page to avoid resubmission
            header("Location: ".$_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "Error: " . $updateQuery . "<br>" . $conn->error;
        }
    }
}

// Query untuk mengambil data puskesmas setelah data ditambahkan
$query = "SELECT * FROM puskesmas";
$result = $conn->query($query);
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

        <div id="layoutSidenav_content">
            <main>
                <div class="container mt-1 p-4">
                    <h2><b>PUSKESMAS</b></h2>
                    <hr>
                    <div class="row mb-4">
                        <div class="col-md-8 d-flex">
                            <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#addPuskesmasModal">Tambah</button>
                            <div class="dropdown">
                                <a class="nav-link dropdown-toggle text-dark" href="#" role="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-sort text-dark"></i>&ensp;<span id="selectedSort">Urut berdasarkan</span>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="sortDropdown">
                                    <li><a class="dropdown-item text-dark" href="#" onclick="sortTable(1, 'Nama'); updateSelectedSort('Nama'); return false;">Nama</a></li>
                                    <li><a class="dropdown-item text-dark" href="#" onclick="sortTable(2, 'Alamat'); updateSelectedSort('Alamat'); return false;">Alamat</a></li>
                                    <li><a class="dropdown-item text-dark" href="#" onclick="sortTable(3, 'Kelurahan'); updateSelectedSort('Kelurahan'); return false;">Kelurahan</a></li>
                                    <li><a class="dropdown-item text-dark" href="#" onclick="sortTable(4, 'Kecamatan'); updateSelectedSort('Kecamatan'); return false;">Kecamatan</a></li>
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
                    <!-- Modal for Add Puskesmas -->
                    <div class="modal fade" id="addPuskesmasModal" tabindex="-1" aria-labelledby="addPuskesmasModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addPuskesmasModalLabel">Tambah Puskesmas</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="" method="post">
                                        <div class="mb-3">
                                            <label for="nama" class="form-label">Nama</label>
                                            <input type="text" class="form-control" id="nama" name="nama" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="alamat" class="form-label">Alamat</label>
                                            <textarea class="form-control" id="alamat" name="alamat" required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="kelurahan" class="form-label">Kelurahan</label>
                                            <input type="text" class="form-control" id="kelurahan" name="kelurahan" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="kecamatan" class="form-label">Kecamatan</label>
                                            <input type="text" class="form-control" id="kecamatan" name="kecamatan" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="longtitude" class="form-label">Longtitude</label>
                                            <input type="text" class="form-control" id="longtitude" name="longtitude" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="latitude" class="form-label">Latitude</label>
                                            <input type="text" class="form-control" id="latitude" name="latitude" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="website" class="form-label">Website</label>
                                            <input type="text" class="form-control" id="website" name="website" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" required>
                                        </div>

                                        <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                   <!-- Modal for Edit Puskesmas -->
                    <div class="modal fade" id="editPuskesmasModal" tabindex="-1" aria-labelledby="editPuskesmasModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editPuskesmasModalLabel">Edit Puskesmas</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="" method="post">
                                        <input type="hidden" id="editNo" name="editNo">
                                        <div class="mb-3">
                                            <label for="editNama" class="form-label">Nama</label>
                                            <input type="text" class="form-control" id="editNama" name="editNama" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="editAlamat" class="form-label">Alamat</label>
                                            <textarea class="form-control" id="editAlamat" name="editAlamat" required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="editKelurahan" class="form-label">Kelurahan</label>
                                            <input type="text" class="form-control" id="editKelurahan" name="editKelurahan" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="editKecamatan" class="form-label">Kecamatan</label>
                                            <input type="text" class="form-control" id="editKecamatan" name="editKecamatan" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="editLongtitude" class="form-label">Longtitude</label>
                                            <input type="text" class="form-control" id="editLongtitude" name="editLongtitude" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="editLatitude" class="form-label">Latitude</label>
                                            <input type="text" class="form-control" id="editLatitude" name="editLatitude" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="editWebsite" class="form-label">Website</label>
                                            <input type="text" class="form-control" id="editWebsite" name="editWebsite" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="editEmail" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="editEmail" name="editEmail" required>
                                        </div>

                                        <button type="submit" name="update" class="btn btn-primary">Simpan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <?php
                        if ($result) {
                        ?>
                            <table class="table table-bordered table-striped text-center">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Alamat</th>
                                    <th scope="col">Kelurahan</th>
                                    <th scope="col">Kecamatan</th>
                                    <th scope="col">longtitude</th>
                                    <th scope="col">latitude</th>
                                    <th scope="col">Website</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                                <?php
                                $i = 1;
                                while ($baris = mysqli_fetch_assoc($result)) {
                                ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $baris['nama']; ?></td>
                                        <td><?php echo $baris['alamat']; ?></td>
                                        <td><?php echo $baris['kelurahan']; ?></td>
                                        <td><?php echo $baris['kecamatan']; ?></td>
                                        <td><?php echo $baris['longtitude']; ?></td>
                                        <td><?php echo $baris['latitude']; ?></td>
                                        <td><?php echo $baris['website']; ?></td>
                                        <td><?php echo $baris['email']; ?></td>
                                        <td class="action-icons">
                                            <button class="btn btn-sm btn-warning" onclick="openEditModal(<?php echo $baris['no']; ?>, '<?php echo $baris['nama']; ?>', '<?php echo $baris['alamat']; ?>', '<?php echo $baris['kelurahan']; ?>', '<?php echo $baris['kecamatan']; ?>', '<?php echo $baris['longtitude']; ?>', '<?php echo $baris['latitude']; ?>', '<?php echo $baris['website']; ?>', '<?php echo $baris['email']; ?>')">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <a href="delete_puskesmas.php?no=<?php echo $baris['no']; ?>" onClick="return confirm('Yakin?')" class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i></a>
                                        </td>
                                    </tr>
                                <?php
                                    $i++;
                                }
                                ?>
                            </table>
                        <?php
                        } else {
                            echo "Error fetching data: " . $conn->error;
                        }
                        ?>
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

                            function openEditModal(no, nama, alamat, kelurahan, kecamatan, longtitude, latitude, website, email) {
                                document.getElementById('editNo').value = no;
                                document.getElementById('editNama').value = nama;
                                document.getElementById('editAlamat').value = alamat;
                                document.getElementById('editKelurahan').value = kelurahan;
                                document.getElementById('editKecamatan').value = kecamatan;
                                document.getElementById('editLongtitude').value = longtitude;
                                document.getElementById('editLatitude').value = latitude;
                                document.getElementById('editWebsite').value = website;
                                document.getElementById('editEmail').value = email;

                                // Show the edit modal
                                var editModal = new bootstrap.Modal(document.getElementById('editPuskesmasModal'));
                                editModal.show();
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
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
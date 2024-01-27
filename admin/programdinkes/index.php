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

// Query untuk mengambil data programdinkes
$query = "SELECT * FROM programdinkes";
$result = $conn->query($query);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    // Process form submission for adding data
    $daftar_data = $_POST["daftar_data"];
    $sumber_data = $_POST["sumber_data"];

    // File upload handling
    $logo_filename = $_FILES["logo"]["name"];
    $logo_tmp = $_FILES["logo"]["tmp_name"];
    $logo_destination = "../logo/" . $logo_filename;
    move_uploaded_file($logo_tmp, $logo_destination);

    // Perform the SQL query to insert data
    $insertQuery = "INSERT INTO programdinkes (daftar_data, sumber_data, logo) VALUES ('$daftar_data', '$sumber_data', '$logo_filename')";

    if ($conn->query($insertQuery) === TRUE) {
        // Redirect to the same page to avoid resubmission
        header("Location: ".$_SERVER['HTTP_REFERER']);
        exit();
    } else {
        echo "Error: " . $insertQuery . "<br>" . $conn->error;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit_submit"])) {
    $edited_id = $_POST["edited_id"];
    $edited_daftar_data = $_POST["edited_daftar_data"];
    $edited_sumber_data = $_POST["edited_sumber_data"];

    // File upload handling for edit
    $edited_logo_filename = $_FILES["edited_logo"]["name"];
    $edited_logo_tmp = $_FILES["edited_logo"]["tmp_name"];
    $edited_logo_destination = "../logo/" . $edited_logo_filename;

    // Query to get the existing logo filename
    $getLogoQuery = "SELECT logo FROM programdinkes WHERE no='$edited_id'";
    $result = $conn->query($getLogoQuery);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $existingLogo = $row["logo"];

        // Check if a new logo is uploaded
        if (!empty($edited_logo_filename)) {
            // Move the new logo to the destination
            move_uploaded_file($edited_logo_tmp, $edited_logo_destination);

            // Delete the existing logo file
            $existingLogoPath = "../logo/" . $existingLogo;
            if (file_exists($existingLogoPath)) {
                unlink($existingLogoPath);
            }

            // Update the record with the new logo filename
            $updateQuery = "UPDATE programdinkes SET daftar_data='$edited_daftar_data', sumber_data='$edited_sumber_data', logo='$edited_logo_filename' WHERE no='$edited_id'";
        } else {
            // If no new logo is uploaded, update without changing the logo
            $updateQuery = "UPDATE programdinkes SET daftar_data='$edited_daftar_data', sumber_data='$edited_sumber_data' WHERE no='$edited_id'";
        }

        if ($conn->query($updateQuery) === TRUE) {
            // Redirect to the same page to avoid resubmission
            header("Location: ".$_SERVER['HTTP_REFERER']);
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "Error retrieving existing logo filename.";
    }
}


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
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="icon" type="image/png" href="../img/Logo-Pamekasan.png" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .layoutSidenav_nav::after {
            content: '';
            display: block;
            width: 100%;
            height: 100%;
            background-image: linear-gradient(to top, rgba(50, 205, 50, 0.3), rgba(0, 0, 0, 0.2));
            position: absolute;
            bottom: 0;
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
                        <div class="text-center "><br>
                            <img src="../img/Logo-Pamekasan.png" class="user-image img-responsive rounded" width="160" />
                            <p class='mt-3 mb-3' style='color: white'> Dinas Kesehatan Pamekasan</p>
                        </div>
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
                    <h2><b>PROGRAM DINKES</b></h2>
                    <hr>
                    <div class="row mb-0">
                        <div class="col-md-8 d-flex">
                            <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#addProgramModal">Tambah</button>
                            <div class="dropdown">
                                <a class="nav-link dropdown-toggle text-dark" href="#" role="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-sort text-dark"></i>&ensp;<span id="selectedSort">Urut berdasarkan</span>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="sortDropdown">
                                    <li><a class="dropdown-item text-dark" href="#" onclick="sortTable(1, 'Daftar Data'); updateSelectedSort('Nama'); return false;">Daftar Data</a></li>
                                    <li><a class="dropdown-item text-dark" href="#" onclick="sortTable(2, 'Sumber Data'); updateSelectedSort('Jenis'); return false;">Sumber Data</a></li>
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
                    <!-- Tabel start -->
                    <div class="table-responsive"><br>
                        <table class="table table-bordered table-striped text-center">
                            <!-- Tabel header -->
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Daftar Data</th>
                                <th scope="col">Sumber Data</th>
                                <th scope="col">Logo</th>
                                <th scope="col">Aksi</th>
                            </tr>
                            <?php
                            $i = 1;
                            while ($baris = mysqli_fetch_assoc($result)) {
                            ?>
                                <!-- Tabel isi -->
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $baris['daftar_data']; ?></td>
                                    <td><?php echo $baris['sumber_data']; ?></td>
                                    <td>
                                        <?php
                                        $logo_path = "../logo/" . $baris['logo'];
                                        echo "<img src='$logo_path' alt='Logo' style='max-width: 100px; max-height: 100px;'>";
                                        ?>
                                    </td>
                                    <!-- button edit dan hapus -->
                                    <td class="action-icons">
                                        <button class="btn btn-sm btn-warning" onclick="openEditModal(<?php echo $baris['no']; ?>, '<?php echo $baris['daftar_data']; ?>', '<?php echo $baris['sumber_data']; ?>', '<?php echo $baris['logo']; ?>')"><i class="bi bi-pencil-square"></i></button>
                                        <a href="delete_programdinkes.php?no=<?php echo $baris['no']; ?>" onClick="return confirm('Yakin?')" class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i></a>
                                    </td>
                                </tr>
                                <?php $i++; ?>
                            <?php } ?>
                        </table>
                        <!-- Tabel end -->

                        <!-- Modal for Add Program -->
                        <div class="modal fade" id="addProgramModal" tabindex="-1" aria-labelledby="addProgramModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addProgramModalLabel">Tambah Program Dinkes</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="" method="post" enctype="multipart/form-data">
                                            <div class="mb-3">
                                                <label for="daftar_data" class="form-label">Daftar Data</label>
                                                <textarea class="form-control" id="daftar_data" name="daftar_data" required></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="sumber_data" class="form-label">Sumber Data</label>
                                                <input type="text" class="form-control" id="sumber_data" name="sumber_data" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="logo" class="form-label">Logo</label>
                                                <input type="file" class="form-control" id="logo" name="logo" accept="image/jpeg, image/png">
                                            </div>
                                            <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal for Edit Program -->
                        <div class="modal fade" id="editProgramModal" tabindex="-1" aria-labelledby="editProgramModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editProgramModalLabel">Edit Program Dinkes</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="" method="post" enctype="multipart/form-data">
                                            <div class="mb-3">
                                                <label for="edited_daftar_data" class="form-label">Daftar Data</label>
                                                <textarea class="form-control" id="edited_daftar_data" name="edited_daftar_data" required></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="edited_sumber_data" class="form-label">Sumber Data</label>
                                                <input type="text" class="form-control" id="edited_sumber_data" name="edited_sumber_data" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="edited_logo" class="form-label">Logo</label>
                                                <input type="file" class="form-control" id="edited_logo" name="edited_logo" accept="image/jpeg, image/png">
                                            </div>
                                            <!-- Hidden input to store the ID of the edited record -->
                                            <input type="hidden" id="edited_id" name="edited_id" value="">
                                            <button type="submit" name="edit_submit" class="btn btn-primary">Simpan</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Script Fitur pencarian -->
                        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
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

                            // Function to open the edit modal with pre-filled data
                            function openEditModal(id, daftar_data, sumber_data, logo) {
                                document.getElementById("edited_id").value = id;
                                document.getElementById("edited_daftar_data").value = daftar_data;
                                document.getElementById("edited_sumber_data").value = sumber_data;

                                // Show the edit modal
                                var editModal = new bootstrap.Modal(document.getElementById('editProgramModal'));
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


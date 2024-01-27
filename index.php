<?php
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

// Query untuk mengambil data gambar
$query = "SELECT * FROM gambar";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISTEM INFORMASI KESEHATAN</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="icon" type="image/png" href="img/Logo-Pamekasan.png" />
    <link rel="stylesheet" href="style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
     <!-- Icon -->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- scroll -->
</head>

<body>
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <!-- jumbotron mulai -->
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="2000">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="container">
                            <img src="img/Logo-Dinkes.png" alt="Logo-Dinkes" style="padding-top: 80px; padding-bottom: 10px; width: 150px; margin: 10px; user-select: none;" class="img-slideutama">
                            <img src="img/Logo-Pamekasan.png" alt="Logo-Pamekasan" style="padding-top: 80px; padding-bottom: 10px; width: 150px; margin: 10px; user-select: none;" class="img-slideutama">
                            <h1 class="display-4"><span>SISTEM INFORMASI KESEHATAN</span> <br> Dinas Kesehatan Kabupaten Pamekasan</h1>
                        </div>
                    </div>
                    <?php
                    while ($baris = mysqli_fetch_assoc($result)) {
                    ?>
                        <div class="carousel-item">
                            <div class="container">
                            <img src="admin/Slide/<?php echo $baris['nama_gambar']; ?>" alt="logo" style="width: auto; height: auto; max-width: 700px; max-height: 350px; margin-top:50px" class="img-slide" />                           
                                <p></p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
            <!-- jumbotron selesai -->
        </div>
    </div>
    <!-- jumbroton selesai -->
    <!-- container -->
    <div class="container">
        <!-- kotak panjang tengah -->
        <div class="row justify-content-center">
            <div class="col-11 info-panel">
                <div class="row">
                    <div class="col-lg">
                        <a href="#aplikasi" class="link-custom">
                            <img src="img/E-Yankes.png" alt="gambar E-Yankes" class="float-left">
                            <h4>Aplikasi</h4>
                            <p>Aplikasi Penunjang Dinas Kesehatan</p>
                        </a>
                    </div>
                    <div class="col-lg">
                        <a href="#faskes" class="link-custom">
                            <img src="img/Faskes.png" alt="gambar Faskes" class="float-left">
                            <h4>Faskes</h4>
                            <p>Fasilitas Kesehatan Lokal.</p>
                        </a>
                    </div>
                    <div class="col-lg">
                        <a href="#data" class="link-custom">
                            <img src="img/data.png" alt="gambar data" class="float-left">
                            <h4>Satu Data</h4>
                            <p>Kumpulan Daftar Data</p>
                        </a>
                    </div>
                    <div class="col-lg">
                        <a href="#media" class="link-custom">
                            <img src="img/Media.png" alt="gambar Media" class="float-left">
                            <h4>Media</h4>
                            <p>Informasi Kesehatan Online.</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- akhir kotak -->
  <div id="progress">
  </div>
  <div id="progres">
    <span id="progres-isi">&#x1F815;</span>
  </div>
  <!-- Menu header -->
    <!-- Menu header -->
    <header>
    <nav id="navbar">
    <a href="admin/login.php">
    <img src="judul.png" width="400px" class="logo" id="logo" alt="Judul">
    </a>
      <div class="navbar">
      <ul>
          <li><a href="#aplikasi">Aplikasi</a></li>
          <li><a href="#faskes">Faskes</a></li>
          <li><a href="#data">Satu Data</a></li>
          <li><a href="#media">Media</a></li>
      </ul>
      </div>

      <div class="icon">
      <div class="input-group">
        <input class="form-control" type="search" id="myInput" onkeyup="myFunction()" placeholder="Cari...">
        <button class="btn btn-success mr-3"><i class="bi bi-search"></i></button>
        <!-- Tambahkan tombol sort -->
        <div>

      </div>
        <a href="javascript:void(0)" id="icon-menu" class="list"><i class="bi bi-list"></i></a>
      </div>
    </nav>
  </header>
  
  <main>
    <?php
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
        $queryapk = "SELECT * FROM programdinkes";
        $resultapk = $conn->query($queryapk);
    ?>

    
    <div id="content">
    <!-- Menu Aplikasi -->
    <article id="aplikasi" class="card">
    <div class="aplikasi">
        <h1>Aplikasi Penunjang</h1>
        <div class="box-produk ">

        <?php
        while ($baris=mysqli_fetch_assoc($resultapk)){
        ?> 

        <div class="mini-produk" >
        <img src="admin/logo/<?php echo $baris['logo'];?>" alt="logo" class="img-produk" />
        <p><?php echo $baris['daftar_data'];?></p>

            <div class="linkprofil">
                <a href="<?php echo $baris['sumber_data'];?>" target="_blank">Lihat</a>
            </div>
        </div>

        <?php }?>
        
        </div>
    </div>        
    </article>


    <div id="content">
    <article id="faskes" class="card">
    <div class="aplikasi">
        <h1>Fasilitas Kesehatan</h1>
    <div class="faskes1">
    <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "dinkes1";
        $conn = new mysqli($servername, $username, $password, $database);

        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        $query_apotek = "SELECT COUNT(*) as count FROM apotek";
        $query_klinik = "SELECT COUNT(*) as count FROM klinik";
        $query_puskesmas = "SELECT COUNT(*) as count FROM puskesmas";

        $result_apotek = $conn->query($query_apotek);
        $result_klinik = $conn->query($query_klinik);
        $result_puskesmas = $conn->query($query_puskesmas);

        if ($result_apotek->num_rows > 0) {
            $row = $result_apotek->fetch_assoc();
            $jumlah_apotek = $row['count'];
            echo "<div class='cardfaskes apotek' id='apotekCardfaskes'>";
            echo "<i class='fa-solid fa-hospital'></i>"; // Font Awesome hospital icon
            echo "<div>"; // Container for title and content
            echo "<h3>Apotek</h3>";
            echo "<p>Jumlah Data: " . $jumlah_apotek . "</p>";
            echo "</div>";
            echo "</div>";
        }

        if ($result_klinik->num_rows > 0) {
            $row = $result_klinik->fetch_assoc();
            $jumlah_klinik = $row['count'];
            echo "<div class='cardfaskes klinik' id='klinikCardfaskes'>";
            echo "<i class='fa-solid fa-stethoscope'></i>"; // Font Awesome clinic icon
            echo "<div>"; // Container for title and content
            echo "<h3>Klinik</h3>";
            echo "<p>Jumlah Data: " . $jumlah_klinik . "</p>";
            echo "</div>";
            echo "</div>";
        }

        if ($result_puskesmas->num_rows > 0) {
            $row = $result_puskesmas->fetch_assoc();
            $jumlah_puskesmas = $row['count'];
            echo "<div class='cardfaskes puskesmas' id='puskesmasCardfaskes'>";
            echo "<i class='fa-solid fa-house-chimney-medical'></i>"; // Font Awesome hospital-alt icon
            echo "<div>"; // Container for title and content
            echo "<h3>Puskesmas</h3>";
            echo "<p>Jumlah Data: " . $jumlah_puskesmas . "</p>";
            echo "</div>";
            echo "</div>";
        }

        // Close the database connection after fetching the results
        $conn->close();
        ?>
    </div>
    <div id="map"></div>
    <div id="detailTable" style="display:none;">
        <table id="dataTable" class="table table-striped table-bordered">
            <!-- Table content will be dynamically generated here -->
        </table>
    </div>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        var apotekCard = document.querySelector(".apotek");
        var klinikCard = document.querySelector(".klinik");
        var puskesmasCard = document.querySelector(".puskesmas");
        var detailTable = document.getElementById("detailTable");
        var dataTable = document.getElementById("dataTable");
        var map;
        var marker; // Add this line


        function initMap(latitude, longtitude) {
            if (!map) {
                // Create a new map instance only if the map container doesn't exist
                map = L.map('map').setView([latitude, longtitude], 13);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);

                // Create a new marker
                marker = L.marker([latitude, longtitude]).addTo(map)
            } else {
                // If the map container already exists, just update the view and marker position
                map.setView([latitude, longtitude], 13);
                marker.setLatLng([latitude, longtitude]); // Update marker position
            }

            // Show the map container
            document.getElementById('map').style.display = 'block';

            // Explicitly set the size of the map container
            map.invalidateSize();
        }

        function showDetailTable(data, latitude, longtitude) {
            detailTable.style.display = "block";
            dataTable.innerHTML = data;

            if (latitude !== null && longtitude !== null && !isNaN(latitude) && !isNaN(longtitude)) {
                document.getElementById('map').style.display = 'block';
                initMap(latitude, longtitude);
            } else {
                document.getElementById('map').style.display = 'none';
            }
        }

        // Add an event listener for the "Show Map" buttons
        document.addEventListener('click', function (event) {
            if (event.target.classList.contains('showMapBtn')) {
                var latitude = parseFloat(event.target.getAttribute('data-latitude'));
                var longtitude = parseFloat(event.target.getAttribute('data-longtitude'));

                if (!isNaN(latitude) && !isNaN(longtitude)) {
                    initMap(latitude, longtitude);
                    var mapContainer = document.getElementById('map');
                    mapContainer.scrollIntoView({ behavior: 'smooth' });
                } else {
                    console.error('Invalid latitude or longtitude values');
                }
            }
        });

        apotekCard.addEventListener("click", function () {
            var isActive = this.classList.contains("active");

            klinikCard.classList.remove("active");
            puskesmasCard.classList.remove("active");

            if (isActive) {
                detailTable.style.display = "none";
                document.getElementById('map').style.display = 'none';
                this.classList.remove("active");
            } else {
                var latitude = this.getAttribute('data-latitude');
                var longtitude = this.getAttribute('data-longtitude');

                <?php
                $conn = new mysqli($servername, $username, $password, $database);

                if ($conn->connect_error) {
                    die("Koneksi gagal: " . $conn->connect_error);
                }

                $query_apotek_detail = "SELECT * FROM apotek";
                $result_apotek_detail = $conn->query($query_apotek_detail);

                if ($result_apotek_detail->num_rows > 0) {
                    $data = "<tr><th>No</th><th>Nama</th><th>Alamat</th><th>Kecamatan</th><th>Lokasi</th></tr>";
                    $rowNumber = 1;
                    while ($row = $result_apotek_detail->fetch_assoc()) {
                        $data .= "<tr><td>{$rowNumber}</td><td>{$row['nama']}</td><td>{$row['alamat']}</td><td>{$row['kecamatan']}</td><td><button class='btnmap showMapBtn' data-latitude='{$row['latitude']}' data-longtitude='{$row['longtitude']}'>Lihat</button></td></tr>";
                        $rowNumber++;
                    }
                    echo "showDetailTable('" . addslashes($data) . "');";
                }

                $conn->close();
                ?>;
                showDetailTable('<?php echo addslashes($data); ?>', latitude, longtitude);

                this.classList.add("active");
            }
        });

            klinikCardfaskes.addEventListener("click", function () {
                var isActive = this.classList.contains("active");

                apotekCard.classList.remove("active");
                puskesmasCard.classList.remove("active");

                if (isActive) {
                    detailTable.style.display = "none";
                    document.getElementById('map').style.display = 'none';
                    this.classList.remove("active");
                } else {
                    var latitude = this.getAttribute('data-latitude');
                    var longtitude = this.getAttribute('data-longtitude');
                <?php
                $conn = new mysqli($servername, $username, $password, $database);

                if ($conn->connect_error) {
                    die("Koneksi gagal: " . $conn->connect_error);
                }

                $query_klinik_detail = "SELECT * FROM klinik";
                $result_klinik_detail = $conn->query($query_klinik_detail);

                if ($result_klinik_detail->num_rows > 0) {
                    $data = "<tr><th>No</th><th>Nama</th><th>Jenis</th><th>Alamat</th><th>Lokasi</th></tr>";
                    $rowNumber = 1;
                    while ($row = $result_klinik_detail->fetch_assoc()) {
                        $data .= "<tr><td>{$rowNumber}</td><td>{$row['nama']}</td><td>{$row['jenis']}</td><td>{$row['alamat']}</td><td><button class='btnmap showMapBtn' data-latitude='{$row['latitude']}' data-longtitude='{$row['longtitude']}'>Lihat</button></td></tr>";
                        $rowNumber++;
                    }
                    echo "showDetailTable('" . addslashes($data) . "');";
                }

                $conn->close();
                ?>;
                showDetailTable('<?php echo addslashes($data); ?>', latitude, longtitude);

                this.classList.add("active");
                }
            });

            puskesmasCard.addEventListener("click", function () {
                var isActive = this.classList.contains("active");

                apotekCard.classList.remove("active");
                klinikCard.classList.remove("active");

                if (isActive) {
                    detailTable.style.display = "none";
                    document.getElementById('map').style.display = 'none';
                    this.classList.remove("active");
                } else {
                    var latitude = this.getAttribute('data-latitude');
                    var longtitude = this.getAttribute('data-longtitude');

                    <?php
                    $conn = new mysqli($servername, $username, $password, $database);

                    if ($conn->connect_error) {
                        die("Koneksi gagal: " . $conn->connect_error);
                    }

                    $query_puskesmas_detail = "SELECT * FROM puskesmas";
                    $result_puskesmas_detail = $conn->query($query_puskesmas_detail);

                    if ($result_puskesmas_detail->num_rows > 0) {
                        $data = "<tr><th>No</th><th>Nama</th><th>Alamat</th><th>Kelurahan</th><th>Kecamatan</th><th>Website</th><th>Lokasi</th></tr>";
                        $rowNumber = 1;
                        while ($row = $result_puskesmas_detail->fetch_assoc()) {
                            $data .= "<tr><td>{$rowNumber}</td><td>{$row['nama']}</td><td>{$row['alamat']}</td><td>{$row['kelurahan']}</td><td>{$row['kecamatan']}</td><td><a href='https://{$row['website']}' target='_blank'>{$row['website']}</a></td><td><button class='btnmap showMapBtn' data-latitude='{$row['latitude']}' data-longtitude='{$row['longtitude']}'>Lihat</button></td></tr>";
                            $rowNumber++;
                        }
                        echo "showDetailTable('" . addslashes($data) . "');";
                    }

                    $conn->close();
                    ?>;
                    showDetailTable('<?php echo addslashes($data); ?>', latitude, longtitude);

                    this.classList.add("active");
                }
            });
        });
    </script>
    </div>
    </div>  
    </article>

<!-- Content satu data -->
<div id="content"> 
    <!-- Menu satu data -->
    <article id="data" class="card">
        <div class="bisnis">
            <h1>Satu Data</h1>
            <div class="faskes1">
                <?php
                // Koneksi ke database
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "dinkes1";

                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Query untuk mengambil data dari tabel
                $sql = "SELECT * FROM data";
                $result = $conn->query($sql);

                // Tampilkan data dalam tabel HTML
                if ($result->num_rows > 0) {
                    echo "<div class='table-data'>";
                    echo "<table id='tableSatu' class='table table-striped table-bordered'>";
                    echo "<thead><tr><th>No</th><th class='judulfile'>Judul File <i class=' fas fa-sort' onclick='sortTable()'></i></th><th>File</th></tr></thead>";
                    echo "<tbody>";
                    
                    $no = 1; // Nomor baris
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" .$no. "</td>";
                        echo "<td>" . $row["judul_file"] . "</td>";
                        echo "<td><button type='button' class='btn btn-success' data-toggle='modal' data-target='#modal_" . $row["id"] . "'>Lihat</button></td>";
                        echo "</tr>";
                        $no++;
                        
                        // Modal untuk menampilkan file
                        echo "<div class='modal fade my-custom-modal' id='modal_" . $row["id"] . "' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>";
                        echo "<div class='modal-dialog modal-lg' role='document'>"; // Added modal-lg class for larger width
                        echo "<div class='modal-content'>";
                        echo "<div class='modal-header'>";
                        echo "<h5 class='modal-title' id='exampleModalLabel'>File: " . $row["judul_file"] . "</h5>";
                        echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                        echo "<span aria-hidden='true'>&times;</span>";
                        echo "</button>";
                        echo "</div>";
                        echo "<div class='modal-body'>";

                        // Menentukan tipe file dan menampilkan sesuai
                        $fileExt = pathinfo($row["nama_file"], PATHINFO_EXTENSION);
                        $filePath = "admin/data/" . $row["nama_file"];
                        echo "<a href='" . $filePath . "' class='btn btn-secondary' download><i class='fas fa-download'></i> Download</a>"; // Added download icon
                        if (strtolower($fileExt) == 'pdf') {
                            echo "<iframe src='" . $filePath . "' type='application/pdf' style='width:100%; height:500px;'></iframe>";
                        } elseif (strtolower($fileExt) == 'xlsx') {
                            echo "<div id='xlsx-container_" . $row["id"] . "' style='overflow-x: auto;'></div>";
                            echo "<script>
                                fetch('" . $filePath . "')
                                .then(response => response.arrayBuffer())
                                .then(data => {
                                    var arrayBuffer = data;
                                    var data = new Uint8Array(arrayBuffer);
                                    var workbook = XLSX.read(data, { type: 'array' });
                                    var html = XLSX.write(workbook, { bookType: 'html', sheet: 0, type: 'binary' });
                                    document.getElementById('xlsx-container_" . $row["id"] . "').innerHTML = '<table border=\"1\">' + html + '</table>';
                                });
                            </script>";
                        } else {
                            echo "Tipe file tidak didukung.";
                        }

                        echo "</div>";
                        echo "<div class='modal-footer'>";
                        echo "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Tutup</button>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                    }
                    
                    echo "</tbody>";
                    echo "</table>";
                    echo "</div>";
                } else {
                    echo "Tidak ada data dalam tabel.";
                }

                // Tutup koneksi
                $conn->close();
                ?>
                <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
                <!-- Add this script at the end of your HTML file -->
                <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                <script>
                var isAscending = true; // Menyimpan status pengurutan (ascending/descending)

                // Fungsi untuk mengurutkan tabel berdasarkan judul file secara ascending atau descending
                function sortTable() {
                    var table, rows, switching, i, x, y, shouldSwitch;
                    table = document.getElementById("tableSatu");
                    switching = true;

                    while (switching) {
                        switching = false;
                        rows = table.rows;

                        for (i = 1; i < (rows.length - 1); i++) {
                            shouldSwitch = false;

                            x = rows[i].getElementsByTagName("td")[1].innerHTML.toLowerCase();
                            y = rows[i + 1].getElementsByTagName("td")[1].innerHTML.toLowerCase();

                            if (isAscending) {
                                if (x > y) {
                                    shouldSwitch = true;
                                    break;
                                }
                            } else {
                                if (x < y) {
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

                    // Mengubah nomor baris setelah pengurutan
                    updateRowNumbers();

                    // Mengubah status pengurutan untuk urutan berikutnya
                    isAscending = !isAscending;
                }

                // Fungsi untuk mengupdate nomor baris setelah tabel diurutkan
                function updateRowNumbers() {
                    var table = document.getElementById("tableSatu");
                    var rows = table.rows;

                    for (var i = 1; i < rows.length; i++) {
                        rows[i].getElementsByTagName("td")[0].innerHTML = i; // Update nomor baris
                    }
                }

                // Menambahkan event listener untuk mengaktifkan fungsi pengurutan saat judul file diklik
                $(document).ready(function () {
                    $("#tableSatu th:nth-child(2)").click(function () {
                        sortTable();
                    });
                });
                // Menambahkan event listener untuk mendeteksi scroll
                window.addEventListener("scroll", function() {
                    // Mengambil posisi scroll
                    var scrollPosition = window.scrollY || document.documentElement.scrollTop;

                    // Mendapatkan elemen div dengan class "bisnis"
                    var bisnisDiv = document.querySelector('.data');

                    // Mendapatkan posisi vertikal elemen "bisnis" dari atas dokumen
                    var bisnisDivPosition = bisnisDiv.offsetTop;

                    // Menentukan kapan alert akan muncul (misalnya, ketika posisi scroll mencapai atau melewati elemen "bisnis")
                    if (scrollPosition >= bisnisDivPosition) {
                        // Menampilkan alert
                        alert("Anda telah mencapai elemen dengan class 'bisnis'!");
                    }
                });

                </script>
            </div>
        </div>
    </article>
</div>


    <!-- Content media -->
    <div id="content"> 
    <!-- Menu Media -->
    <article id="media" class="card">
    <div class="bisnis">
        <h1>Sosial Media Kami</h1>
        <div class="box-produk ">
        <div class="mini-produk" >
            <img src="img/Logo-Pamekasan.png" alt="pc" class="img-produk" style="width:105px"/>
            <p>Website</p>
            <div class="linkprofil">
                <a href="https://dinkes.pamekasankab.go.id/" target="_blank">Kunjungi</a>
            </div>
        </div>

        <div class="mini-produk" >
            <img src="img/instagram.png" alt="paket" class="img-produk" />
            <p>Instagram</p>
            <div class="linkprofil">
                <a href="https://www.instagram.com/dinkespamekasan/?hl=id" target="_blank">Kunjungi</a>
            </div>
        </div>

        <div class="mini-produk" >
            <img src="img/facebook.png" alt="toko" class="img-produk" />
            <p> Facebook</p>
            <div class="linkprofil">
                <a href="https://www.facebook.com/DinkesPamekasan/" target="_blank">Kunjungi</a>
            </div>
        </div>

        <div class="mini-produk" >
            <img src="img/youtube.png" alt="toko" class="img-produk" />
            <p>YouTube</p>
            <div class="linkprofil">
                <a href="https://www.youtube.com/@DinkesPamekasan" target="_blank">Kunjungi</a>
            </div>
        </div>
        
        </div>
    </div>        
    </article>
      
    </main>


    <!-- Menu Footer -->
    <footer>
      <p>Kerja Praktek Universitas Trunojoyo Madura &copy  2024, Website Sistem Informasi Kesehatan</p>
    </footer>
    
    <!-- javascript -->
    <script src="script.js"></script>
    <!-- scroll -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            // Mengatur kecepatan transisi slider
            $('#carouselExampleIndicators').carousel({
                interval: 3000 // Ganti nilai ini sesuai keinginan Anda (dalam milidetik)
            });
        });
    </script>

<script>
  function myFunction() {
    // Mendapatkan nilai pencarian dari input
    var input = document.getElementById("myInput");
    var filter = input.value.toUpperCase();

    // Mendapatkan semua elemen dengan kelas 'mini-produk'
    var produkElements = document.getElementsByClassName("mini-produk");

    // Loop melalui setiap elemen dan sembunyikan/munculkan sesuai pencarian
    for (var i = 0; i < produkElements.length; i++) {
      var daftarDataElement = produkElements[i].getElementsByTagName("p")[0];
      var txtValue = daftarDataElement.textContent || daftarDataElement.innerText;

      // Jika teks sesuai dengan pencarian, tampilkan elemen, jika tidak sembunyikan
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        produkElements[i].style.display = "";
      } else {
        produkElements[i].style.display = "none";
      }
    }

    table = document.getElementsByTagName("table")[0];
    tr = table.getElementsByTagName("tr");

    var visibleRowCounter = 1; // Counter for visible rows
    var allRowsHidden = true; // Flag to track if all rows should be hidden

    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1]; // Assuming "No" is in the second column (index 1)
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                // Display the row and update the "No" column
                tr[i].style.display = "";
                tr[i].getElementsByTagName("td")[0].innerText = visibleRowCounter++;
                // At least one row is visible, set the flag to false
                allRowsHidden = false;
            } else {
                tr[i].style.display = "none";
            }
        }
    }
    if (allRowsHidden) {
        table.style.display = "none";
    } else {
        table.style.display = ""; // Show the table if at least one row is visible
    }


    var tableSatu = document.getElementById("tableSatu");
    var trsatu = tableSatu.getElementsByTagName("tr");
    var visibleRowCountersatu = 1; // Counter for visible rows

    var allRowsHiddensatu = true; // Flag to track if all rows should be hidden

    for (k = 0; k < trsatu.length; k++) {
        var td = trsatu[k].getElementsByTagName("td")[1]; // Assuming "No" is in the second column (index 1)

        if (td) {
            var txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                // Display the row and update the "No" column
                trsatu[k].style.display = "";
                trsatu[k].getElementsByTagName("td")[0].innerText = visibleRowCountersatu++;
                
                // At least one row is visible, set the flag to false
                allRowsHiddensatu = false;
            } else {
                trsatu[k].style.display = "none";
            }
        }
    }

    // Check if all rows are hidden, then hide the entire table
    if (allRowsHiddensatu) {
        tableSatu.style.display = "none";
    } else {
        tableSatu.style.display = ""; // Show the table if at least one row is visible
    }
  }
</script>


<script>
    document.addEventListener("scroll", function() {
      var navbar = document.getElementById("navbar");

      // Jika scrollTop lebih besar dari 200, atur top navbar menjadi 0, sebaliknya atur top menjadi -50
      if (document.documentElement.scrollTop > 500) {
        navbar.style.top = "0";
      } else {
        navbar.style.top = "-70px";
      }
    });
  </script>

</body>

</html>
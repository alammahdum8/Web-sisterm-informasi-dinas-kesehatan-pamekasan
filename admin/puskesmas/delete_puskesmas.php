<!-- delete_apotek.php -->
<?php
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["no"])) {
    $no = $_GET["no"];

    // Koneksi ke database
    $conn = new mysqli("localhost", "root", "", "dinkes1");

    // Periksa koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Query untuk menghapus data apotek berdasarkan nomor
    $query = "DELETE FROM puskesmas WHERE no = $no";
    $result = $conn->query($query);

    // Periksa hasil query
    if ($result) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }

    // Tutup koneksi
    $conn->close();
} else {
    echo "Permintaan tidak valid.";
}
?>

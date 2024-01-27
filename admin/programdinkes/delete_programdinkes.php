<!-- delete_programdinkes.php -->
<?php
if(isset($_GET['no'])) {
    // Include database connection code
    include('../koneksi.php');
    
    // Get the ID from the URL parameter
    $no = $_GET['no'];

    // Query to get the logo filename
    $getLogoQuery = "SELECT logo FROM programdinkes WHERE no='$no'";
    $result = $conn->query($getLogoQuery);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $logoFilename = $row["logo"];

        // Delete the data entry from the database
        $deleteQuery = "DELETE FROM programdinkes WHERE no='$no'";
        if ($conn->query($deleteQuery) === TRUE) {
            // Delete the associated image file
            $logoPath = "../logo/" . $logoFilename;
            if (file_exists($logoPath)) {
                unlink($logoPath);
            }

            // Redirect to the programdinkes index page
            header("Location: index.php");
            exit();
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    } else {
        echo "Error retrieving logo filename.";
    }

    $conn->close();
} else {
    // If 'no' parameter is not set, redirect to the programdinkes index page
    header("Location: index.php");
    exit();
}
?>
<?php
// Mulai session
session_start();

// Cek apakah pengguna sudah login, jika ya, arahkan ke halaman dashboard
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header('Location: index.php');
    exit();
}

// Koneksi ke database (gunakan informasi koneksi database Anda)
$servername = "localhost";
$username = "root";
$password = "";
$database = "dinkes1";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fungsi untuk memproses login
function processLogin($conn) {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Query ke database untuk mencocokkan data
        $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            // Set session dan arahkan ke halaman dashboard
            $_SESSION['loggedin'] = true;
            header('Location: index.php');
            exit();
        } else {
            echo '<div class="alert alert-danger" role="alert">Login gagal. Silakan coba lagi.</div>';
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
    <title>Login Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="icon" type="image/png" href="img/Logo-Pamekasan.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css" integrity="sha384-x7p5a9xKXQU+K6Ly1OdbzGyWjexd05jO5en3/2L7kA2UL2VfNT/vDHVL9Kb4XtkD" crossorigin="anonymous">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('https://img.freepik.com/premium-vector/beautiful-green-art-with-linear-floral-pattern_76645-131.jpg');
            background-size: cover;
            color: #fff;
            font-family: 'Arial', sans-serif;
            overflow: hidden;
        }

        .login-container {
            max-width: 400px;
            margin: 0 auto;
            margin-top: 100px;
        }

        .login-form {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px #000000;
        }

        .login-form h2 {
            text-align: center;
            color: #28a745;
        }

        .login-form label {
            color: #495057;
        }

        .login-form input {
            border-radius: 5px;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            width: 80px;
            height: auto;
        }

        .btn-primary {
            background-color: #218838;
            border-color: #218838;
            display: block;
            margin: 0 auto; /* Center the button */
        }

        .btn-primary:hover {
            background-color: #1e7e34;
            border-color: #1e7e34;
        }
    </style>
</head>
<body>
    <div class="container login-container">
    <a href="../index.php">
        <div class="logo">
            <img src="img/logo-pamekasan.png" alt="Dinkes Logo">
            <img src="img/logo-Dinkes.png" alt="Dinkes Logo">
        </div>
    </a>
        <div class="row">
            <div class="col-md-12 login-form">
                <h2>Login</h2>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" class="form-control" name="username" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>

                    <!-- Use an icon for the login button -->
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="bi bi-box-arrow-in-right"></i> Login
                    </button>
                </form>

                <?php
                processLogin($conn);
                $conn->close();
                ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

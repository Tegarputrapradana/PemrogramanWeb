<?php
session_start();

$host_db = "localhost";
$user_db = "root";
$pass_db = "";
$nama_db = "login";
$koneksi = mysqli_connect($host_db, $user_db, $pass_db, $nama_db);

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validasi input (Anda dapat menambahkan validasi tambahan sesuai kebutuhan)
    if (empty($username) || empty($password)) {
        $error_message = "Silakan lengkapi semua field.";
    } else {
        // Periksa apakah username sudah digunakan
        $query = "SELECT * FROM login WHERE username = '$username'";
        $result = mysqli_query($koneksi, $query);

        if (mysqli_num_rows($result) > 0) {
            $error_message = "Username sudah digunakan. Silakan pilih username lain.";
        } else {
            // Enkripsi password sebelum menyimpannya ke database
            $hashed_password = md5($password);

            // Simpan informasi akun ke database
            $insert_query = "INSERT INTO login (username, password) VALUES ('$username', '$hashed_password')";
            $insert_result = mysqli_query($koneksi, $insert_query);

            if ($insert_result) {
                $success_message = "Akun berhasil didaftarkan. Silakan login.";
            } else {
                $error_message = "Terjadi kesalahan dalam pendaftaran akun.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <h2 class="text-center">Registrasi Akun</h2>

                <?php
                if (isset($error_message)) {
                    echo "<p class='text-danger'>$error_message</p>";
                }

                if (isset($success_message)) {
                    echo "<p class='text-success'>$success_message</p>";
                }
                ?>

                <form method="post" action="" class="form-horizontal">
                    <div class="form-group">
                        <label for="username" class="col-sm-2 control-label">Username:</label>
                        <div class="col-sm-10">
                            <input type="text" name="username" id="username" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">Password:</label>
                        <div class="col-sm-10">
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" name="register" value="Daftar" class="btn btn-primary">
                        </div>
                    </div>
                </form>

                <p class="text-center">Sudah punya akun? <a href="login.php">Login disini</a></p>
            </div>
        </div>
    </div>
</body>
</html>

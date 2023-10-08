<?php
session_start();

$host_db = "localhost";
$user_db = "root";
$pass_db = "";
$nama_db = "login";
$koneksi = mysqli_connect($host_db, $user_db, $pass_db, $nama_db);

if (isset($_POST['ubah_password'])) {
    $username = $_POST['username'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi input (Anda dapat menambahkan validasi tambahan sesuai kebutuhan)
    if (empty($username) || empty($new_password) || empty($confirm_password)) {
        $error_message = "Silakan lengkapi semua field.";
    } elseif ($new_password !== $confirm_password) {
        $error_message = "Konfirmasi password tidak sesuai.";
    } else {
        // Periksa apakah username sudah digunakan
        $query = "SELECT * FROM login WHERE username = '$username'";
        $result = mysqli_query($koneksi, $query);

        if (mysqli_num_rows($result) == 0) {
            $error_message = "Username tidak ditemukan.";
        } else {
            // Enkripsi password baru sebelum disimpan di database
            $hashed_password = md5($new_password);

            // Update password pengguna di database
            $sql = "UPDATE login SET password = '$hashed_password' WHERE username = '$username'";
            $result = mysqli_query($koneksi, $sql);

            if ($result) {
                $success_message = "Password berhasil diubah. Silakan login dengan password baru Anda.";
                // Hapus sesi untuk memaksa pengguna login kembali dengan password baru
                session_destroy();
            } else {
                $error_message = "Terjadi kesalahan dalam mengubah password.";
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
    <title>Ubah Password</title>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <h2 class="text-center">Ubah Password</h2>

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
                        <label for="new_password" class="col-sm-2 control-label">Password Baru:</label>
                        <div class="col-sm-10">
                            <input type="password" name="new_password" id="new_password" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password" class="col-sm-2 control-label">Konfirmasi Password Baru:</label>
                        <div class="col-sm-10">
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" name="ubah_password" value="Ubah Password" class="btn btn-primary">
                        </div>
                    </div>
                </form>

                <p class="text-center"><a href="login.php">Kembali ke halaman login</a></p>
            </div>
        </div>
    </div>
</body>
</html>

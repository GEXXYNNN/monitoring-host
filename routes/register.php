<?php
session_start();
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    // ✅ Ambil ID terakhir dari tabel `kunjungan`
    $result = mysqli_query($conn, "SELECT MAX(id) AS last_id FROM kunjungan");
    $row = mysqli_fetch_assoc($result);
    $last_id = $row['last_id'] ? $row['last_id'] : 0;
    $new_id = $last_id + 1; // ID baru mengikuti urutan terakhir

    // ✅ Insert ke tabel `kunjungan` dulu
    $organisasi = "Individu"; 
    $tujuan = "Belum Ditentukan";
    $durasi = "Belum Ditentukan";
    $tanggal = date('Y-m-d');

    $query_kunjungan = "INSERT INTO kunjungan (id, Nama, Organisasi, Tujuan, Durasi, Tanggal) 
                        VALUES ('$new_id', '$username', '$organisasi', '$tujuan', '$durasi', '$tanggal')";
    
    if (mysqli_query($conn, $query_kunjungan)) {
        // ✅ Insert ke tabel `users` dengan ID kunjungan yang sama
        $query_user = "INSERT INTO users (id, username, email, password, role) 
                       VALUES ('$new_id', '$username', '$email', '$password', '$role')";
        
        if (mysqli_query($conn, $query_user)) {
            $_SESSION['success'] = "Registrasi berhasil! Silakan login.";
            header("Location: ../routes/login.php");
            exit();
        } else {
            $_SESSION['error'] = "Gagal menyimpan data user: " . mysqli_error($conn);
        }
    } else {
        $_SESSION['error'] = "Gagal menyimpan data kunjungan: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="container">
        <div class="register-box">
            <h2>Registrasi</h2>
            <?php if (isset($_SESSION['error'])) { ?>
                <p class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
            <?php } ?>
            <form method="post">
                <div class="input-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" required>
                </div>
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" required>
                </div>
                <div class="input-group">
                    <label for="role">Role</label>
                    <select name="role" required>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <button type="submit">Daftar</button>
            </form>
            <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
        </div>
    </div>
</body>
</html>

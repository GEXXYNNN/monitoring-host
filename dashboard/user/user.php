<?php
session_start();
include '../../config/db.php';

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'user') {
    header("Location: ../../routes/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User</title>
    <link rel="stylesheet" href="../../assets/user-style.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Dashboard</h2>
        <ul>
            <li><a href="index.php"><i class="fas fa-home"></i> Beranda</a></li>
            <li><a href="form_kunjungan.php"><i class="fas fa-edit"></i> Form Kunjungan</a></li>
            <li><a href="data_kunjungan.php"><i class="fas fa-table"></i> Data Kunjungan</a></li>
            <li><a href="../../routes/logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>

    <!-- Konten -->
    <div class="content">
        <h1>Selamat Datang, <?php echo $_SESSION['nama']; ?>!</h1>
        <p>Anda berhasil login sebagai <strong>USER</strong>.</p>

        <div class="card-container">
            <div class="card">
                <i class="fas fa-user"></i>
                <h3>Profil</h3>
                <p><?php echo $_SESSION['nama']; ?></p>
            </div>
            <div class="card">
                <i class="fas fa-calendar"></i>
                <h3>Riwayat Kunjungan</h3>
                <p><a href="data_kunjungan.php">Lihat Data</a></p>
            </div>
        </div>
    </div>
</body>
</html>

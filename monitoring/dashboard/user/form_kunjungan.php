<?php
session_start();
include '../../config/db.php';

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'user') {
    header("Location: ../../routes/login.php");
    exit();
}

$user_id = $_SESSION['id'];

// Jika form dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $organisasi = mysqli_real_escape_string($conn, $_POST['organisasi']);
    $tujuan = mysqli_real_escape_string($conn, $_POST['tujuan']);
    $durasi = mysqli_real_escape_string($conn, $_POST['durasi']);
    $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);

    $query = "INSERT INTO kunjungan (user_id, organisasi, tujuan, durasi, tanggal) VALUES ('$user_id', '$organisasi', '$tujuan', '$durasi', '$tanggal')";

    if (mysqli_query($conn, $query)) {
        $_SESSION['success'] = "Data kunjungan berhasil disimpan!";
        header("Location: data_kunjungan.php");
        exit();
    } else {
        $_SESSION['error'] = "Gagal menyimpan data: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Kunjungan</title>
    <link rel="stylesheet" href="../../assets/style.css">
</head>
<body>
    <div class="container">
        <div class="form-box">
            <h2>Form Kunjungan</h2>
            <?php if (isset($_SESSION['error'])) { ?>
                <p class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
            <?php } ?>
            <form method="post">
                <div class="input-group">
                    <label>Organisasi</label>
                    <input type="text" name="organisasi" required>
                </div>
                <div class="input-group">
                    <label>Tujuan</label>
                    <input type="text" name="tujuan" required>
                </div>
                <div class="input-group">
                    <label>Durasi Kunjungan</label>
                    <input type="text" name="durasi" required>
                </div>
                <div class="input-group">
                    <label>Tanggal Kunjungan</label>
                    <input type="date" name="tanggal" required>
                </div>
                <button type="submit">Simpan</button>
            </form>
            <p><a href="user.php">Kembali ke Dashboard</a></p>
        </div>
    </div>
</body>
</html>

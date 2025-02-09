<?php
include '../../config/db.php';
session_start();
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM kunjungan WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Kunjungan</title>
    <link rel="stylesheet" href="assets/user-style.css">
</head>
<body>
    <div class="content">
        <h2>Riwayat Kunjungan</h2>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Organisasi</th>
                    <th>Tujuan</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['Tanggal']; ?></td>
                    <td><?php echo $row['Organisasi']; ?></td>
                    <td><?php echo $row['Tujuan']; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>

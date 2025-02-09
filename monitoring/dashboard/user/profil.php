<?php
include '../../config/db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../user.php");
    exit();
}
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya</title>
    <link rel="stylesheet" href="assets/user-style.css">
</head>
<body>
    <div class="content">
        <h2>Profil Saya</h2>
        <p>Nama: <?php echo $user['username']; ?></p>
        <p>Email: <?php echo $user['email']; ?></p>
        <a href="settings.php">Edit Profil</a>
    </div>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../../config/db.php';
    session_start();
    $user_id = $_SESSION['user_id'];
    $feedback = $_POST['feedback'];
    $query = "INSERT INTO feedback (user_id, feedback) VALUES ('$user_id', '$feedback')";
    mysqli_query($conn, $query);
    echo "Feedback berhasil dikirim.";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
    <link rel="stylesheet" href="assets/user-style.css">
</head>
<body>
    <div class="content">
        <h2>Kirim Feedback</h2>
        <form method="post">
            <textarea name="feedback" required></textarea>
            <button type="submit">Kirim</button>
        </form>
    </div>
</body>
</html>
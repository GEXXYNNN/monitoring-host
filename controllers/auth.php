<?php
require_once '../config/db.php';
function register($username, $email, $password, $role) {
    global $conn;
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $hashed_password, $role);
    if ($stmt->execute()) {
        return [
            'status' => 'success',
            'message' => 'Registrasi berhasil'
        ];
    } else {
        return [
            'status' => 'error',
            'message' => 'Registrasi gagal: ' . $stmt->error
        ];
    }
}
function login($email, $password) {
    global $conn;
    $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            return [
                'status' => 'success',
                'message' => 'Login berhasil',
                'data' => $user
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Password salah'
            ];
        }
    } else {
        return [
            'status' => 'error',
            'message' => 'Email tidak ditemukan'
        ];
    }
}
?>
<?php
session_start();
include('../../conf/cekLogin.php');
include('../../conf/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $userId = $_SESSION['id_user'];

    $query = mysqli_query($koneksi, "SELECT password FROM tb_users WHERE id = '$userId'");
    $userData = mysqli_fetch_assoc($query);

    if (password_verify($currentPassword, $userData['password'])) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $updateQuery = mysqli_query($koneksi, "UPDATE tb_users SET password = '$hashedPassword' WHERE id = '$userId'");

        if ($updateQuery) {
            echo 'success';
        } else {
            echo 'error_update';
        }
    } else {
        echo 'error_password';
    }
}
?>
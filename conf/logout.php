<?php
// mengaktifkan session php
session_start();

// Clear the "Remember Me" token cookie
setcookie("remember_token", "", time() - 3600, "/"); // Set to a past time to expire the cookie

// If the user was logged in using "Remember Me", clear the token from the database
if (isset($_SESSION['id_user'])) {
    include('config.php');
    $id = $_SESSION['id_user'];
    
    // Clear the token field in the user's record
    $query = $koneksi->query("UPDATE tb_users SET remember_token=NULL WHERE id='$id'");
}

// menghapus semua session
session_destroy();

// mengalihkan halaman ke halaman login
header("location:../index.php");
?>

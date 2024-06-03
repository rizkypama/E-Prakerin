<?php
session_start();
include('../../conf/config.php');
include('../../conf/autentikasi.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $waktu = $_POST['waktu'];

    $query = "INSERT INTO tb_pengingat (id_pengingat, judul, waktu) VALUES ('','$judul', '$waktu')";
    if (mysqli_query($koneksi, $query)) {
        // if ($_SESSION['role_id'] == 'Pemagang') {
        //     header("Location: ../pemagang/index.php");
        // } else if ($_SESSION['role_id'] == 'Pembimbing') {
        //     header("Location: ../pembimbing/index.php");
        // } else if ($_SESSION['role_id'] == 'Admin') {
        //     header("Location: ../admin/index.php");
        // }
        $referer = $_SERVER['HTTP_REFERER'];
        header("Location: $referer");
        exit;
    } else {
        // Error handling
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>

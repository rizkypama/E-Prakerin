<?php
include('../../conf/config.php');
include('../../conf/autentikasi.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id']; 

    $id_divisi = $_POST['id_divisi'];

    $updateQuery = mysqli_query($koneksi, "UPDATE tb_pemagang SET id_divisi = '$id_divisi' WHERE id = '$id'");

    if ($updateQuery) {
        if ($_SESSION['role_id'] == "Admin") {
            header('Location: ../admin/detail_pemagang.php?id=' . $id . '&success=1');
        } else {
            header('Location: ../pembimbing/detail_pemagang.php?id=' . $id . '&success=1');
        }
        exit();
    } else {
        if ($_SESSION['role_id'] == "Admin") {
            header('Location: ../admin/detail_pemagang.php?id=' . $id . '&error=1');
        } else {
            header('Location: ../pembimbing/detail_pemagang.php?id=' . $id . '&error=1');
        }
        exit();
    }
}
?>

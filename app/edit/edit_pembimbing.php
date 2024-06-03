<?php
include('../../conf/config.php');
include('../../conf/autentikasi.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id']; 

    $id_pembimbing = $_POST['id_pembimbing'];

    $updateQuery = mysqli_query($koneksi, "UPDATE tb_pemagang SET id_pembimbing = '$id_pembimbing' WHERE id = '$id'");

    if ($updateQuery) {
        if ($_SESSION['role_id'] == "Admin") {
            header('Location: ../admin/detail_pemagang.php?&success=1');
        } else {
            header('Location: ../pembimbing/detail_pemagang.php?id=' . $id . '&success=1');
        }
        exit();
    } else {
        if ($_SESSION['role_id'] == "Admin") {
            header('Location: ../admin/detail_pemagang.php?&error=1');
        } else {
            header('Location: ../pembimbing/detail_pemagang.php?id=' . $id . '&error=1');
        }
        exit();
    }
}
?>

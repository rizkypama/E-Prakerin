<?php
include('../../conf/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id']; 

    $id_divisi = $_POST['id_divisi'];

    $updateQuery = mysqli_query($koneksi, "UPDATE tb_pembimbing SET id_divisi = '$id_divisi' WHERE id = '$id'");

    if ($updateQuery) {
        header('Location: ../admin/data_pembimbing.php?&success=1');
        exit();
    } else {
        header('Location: ../admin/data_pembimbing.php?&error=1');
        exit();
    }
}
?>

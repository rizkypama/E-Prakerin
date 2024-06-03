<?php
session_start();
include('../../conf/config.php');

$id_pemagang = $_POST['id_pemagang'];
$id_pembimbing = $_POST['id_pembimbing'];
$tugas = $_POST['tugas'];

if ($_SESSION['role_id'] == 'Pemagang') {
    $query = mysqli_query($koneksi, "INSERT INTO tb_tugas (id, id_pembimbing, id_pemagang, tugas, status) VALUES('', '$id_pembimbing', '{$_SESSION['id_pemagang']}', '$tugas', 'proses')");
    header('location:../pemagang/tugas.php');
} else if ($_SESSION['role_id'] == 'Pembimbing') {
    $query = mysqli_query($koneksi, "INSERT INTO tb_tugas (id, id_pembimbing, id_pemagang, tugas, status) VALUES('', '{$_SESSION['id_pembimbing']}', '$id_pemagang', '$tugas', 'proses')");
    header('location:../pembimbing/tugas.php');
}

?>


<?php 
include('../../conf/config.php');
session_start();
$nama_pembimbing = $_POST['nama_pembimbing'];
$nama_kegiatan = $_POST['tipe'];
$des_kegiatan = $_POST['deskripsi'];

$query = mysqli_query($koneksi,"INSERT INTO tb_pengajuan (id, id_pemagang, id_pembimbing, tipe, deskripsi_kegiatan, status) VALUES('','{$_SESSION['id_pemagang']}','$nama_pembimbing','$nama_kegiatan','$des_kegiatan','proses')");
header('location:../pemagang/pengajuan.php');
?>
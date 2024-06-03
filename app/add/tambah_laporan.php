<?php 
include('../../conf/config.php');
session_start();
//tambah laporan harian
$nama_pembimbing = $_POST['nama_pembimbing'];
// $status = $_POST['status'];
$nama_kegiatan = $_POST['namakegiatan'];
$des_kegiatan = $_POST['deskripsi'];
//nama bukti kegiatan
$bukti = $_FILES ['bukti']['name'];

//lokasi foto
$file_temp = $_FILES['bukti']['tmp_name'];
move_uploaded_file($file_temp,'../file/buktilaporan/'.$bukti);

$query = mysqli_query($koneksi,"INSERT INTO tb_laporan_harian (id, id_pemagang, id_pembimbing, nama_kegiatan, deskripsi_kegiatan, bukti_file, status) VALUES('','{$_SESSION['id_pemagang']}',$nama_pembimbing,'$nama_kegiatan','$des_kegiatan','$bukti','proses')");
header('location:../pemagang/laporan-harian.php');
?>
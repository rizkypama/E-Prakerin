<?php 
session_start();
include('../../conf/config.php');
//tambah presensi
$id = $_POST['id_pemagang'];

//nama bukti kegiatan
$masuk = $_FILES ['masuk']['name'];

//lokasi foto

$file_temp = $_FILES['masuk']['tmp_name'];
move_uploaded_file($file_temp,'../file/buktipresensi/'.$masuk);

$test = mysqli_query($koneksi, "SELECT * FROM tb_presensi WHERE id_pemagang = {$_SESSION['id_pemagang']} AND created_at = CURRENT_DATE()");
var_dump(mysqli_fetch_array($test));

die;

$query = mysqli_query ($koneksi,"INSERT INTO tb_presensi (id, id_pemagang, masuk, status) VALUES('', '{$_SESSION['id_pemagang']}', '$masuk', 'proses')");
header('location:../pemagang/dashboard-pemagang.php');
?>
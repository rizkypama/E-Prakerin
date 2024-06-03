<?php 
include('../../conf/config.php');
session_start();
$instansi = $_POST['instansi'];

$query = mysqli_query($koneksi,"INSERT INTO tb_instansi (id, instansi) VALUES('','$instansi')");
header('location:../admin/data_instansi.php');
?>
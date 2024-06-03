<?php 
session_start();
include('../../conf/config.php');
//tambah presensi
// $id = $_POST['id_pemagang'];
// var_dump($_FILES);
// var_dump(date('Y-m-d'));
// die;
// $tgl_masuk =$_POST['tgl_masuk'];

//nama bukti kegiatan
$masuk = $_FILES ['masuk']['name'];

//lokasi foto

$file_temp = $_FILES['masuk']['tmp_name'];
move_uploaded_file($file_temp,'../file/buktipresensi/masuk/'.$masuk);
date_default_timezone_set("Asia/Bangkok");
$jam = date('H:i:s');
// var_dump($jam);
// die;

$test = mysqli_query($koneksi, "SELECT * FROM tb_presensi WHERE id_pemagang = {$_SESSION['id_pemagang']} AND tgl = CURDATE()");
if(mysqli_num_rows($test) > 0) {
    // echo 'Sudah masuk';
    mysqli_query($koneksi, "UPDATE tb_presensi SET jam_masuk = '$jam' WHERE tgl = CURDATE()");
    mysqli_query($koneksi, "UPDATE tb_presensi SET bukti_masuk = '$masuk' WHERE tgl = CURDATE()");
    // $queryInsert = mysqli_query($koneksi, "UPDATE tb_presensi SET jam_masuk = '$jam' AND bukti_masuk = '$masuk' WHERE id_pemagang = {$_SESSION['id_pemagang']} AND tgl = CURDATE()");
    header('location:../pemagang/index.php');
} else {
    // echo 'Silakan masuk';
    $queryInsert = mysqli_query($koneksi, "INSERT INTO tb_presensi (id, id_pemagang, bukti_masuk, tgl, jam_masuk) VALUES('', '{$_SESSION['id_pemagang']}', '$masuk', CURDATE(), '$jam')");
    header('location:../pemagang/index.php');
}
// var_dump(mysqli_fetch_array($test));

die;

$query = mysqli_query ($koneksi,"INSERT INTO tb_presensi (id, id_pemagang, bukti_masuk, tgl_masuk, jam_masuk) VALUES('', '{$_SESSION['id_pemagang']}', '$masuk', '$tgl_masuk', '$jam')");
header('location:../pemagang/index.php');
?>
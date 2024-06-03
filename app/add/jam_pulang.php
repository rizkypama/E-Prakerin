<?php 
session_start();
include('../../conf/config.php');
//tambah presensi

//nama bukti kegiatan
$pulang = $_FILES ['pulang']['name'];

//lokasi foto

$file_temp = $_FILES['pulang']['tmp_name'];
move_uploaded_file($file_temp,'../file/buktipresensi/pulang/'.$pulang);
date_default_timezone_set("Asia/Bangkok");
$jam = date('H:i:s');


$response = array(); // Initialize the response array

$test = mysqli_query($koneksi, "SELECT * FROM tb_presensi WHERE id_pemagang = {$_SESSION['id_pemagang']} AND tgl = CURDATE()");
if(mysqli_num_rows($test) > 0) {
    mysqli_query($koneksi, "UPDATE tb_presensi SET jam_pulang = '$jam' WHERE tgl = CURDATE()");
    mysqli_query($koneksi, "UPDATE tb_presensi SET bukti_pulang = '$pulang' WHERE tgl = CURDATE()");
    // $queryInsert = mysqli_query($koneksi, "UPDATE tb_presensi SET jam_masuk = '$jam' AND bukti_masuk = '$masuk' WHERE id_pemagang = {$_SESSION['id_pemagang']} AND tgl = CURDATE()");
    // header('location:../pemagang/index.php');
    $response['message'] = 'Already Checked In';
} else {
    // echo 'Silakan masuk';
    $queryInsert = mysqli_query($koneksi, "INSERT INTO tb_presensi (id, id_pemagang, bukti_pulang, tgl, jam_pulang) VALUES('', '{$_SESSION['id_pemagang']}', '$pulang', CURDATE(), '$jam')");
    // header('location:../pemagang/index.php');
    $response['message'] = 'Checked In Successfully';
}

die;

$query = mysqli_query ($koneksi,"INSERT INTO tb_presensi (id, id_pemagang, bukti_pulang, jam_pulang) VALUES('', '{$_SESSION['id_pemagang']}', '$pulang', '$jam')");
// header('location:../pemagang/index.php');
?>
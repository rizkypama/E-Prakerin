<?php
session_start();
include('../../conf/config.php');

$id_penilaian = $_POST['id_penilaian'];
$id_pemagang = $_POST['id_pemagang'];
$kedisiplinan = $_POST['kedisiplinan'];
$kerapian = $_POST['kerapian'];
$tanggungjwb = $_POST['tanggungjwb'];
$ketaatan = $_POST['ketaatan'];
$etoskerja = $_POST['etoskerja'];
$kerjasama = $_POST['kerjasama'];
$keterampilan = $_POST['keterampilan'];
$feedback = $_POST['feedback'];

$query = mysqli_query($koneksi, "UPDATE tb_penilaian SET
    kedisiplinan = '$kedisiplinan',
    kerapian = '$kerapian',
    tanggungjwb = '$tanggungjwb',
    ketaatan = '$ketaatan',
    etoskerja = '$etoskerja',
    kerjasama = '$kerjasama',
    keterampilan = '$keterampilan',
    feedback = '$feedback'
    WHERE id_pemagang = '$id_pemagang'
");

if ($query) {
    header('location:../pembimbing/detail_penilaian-pemagang.php?id-penilaian=' . $id_penilaian . '&id-pemagang=' . $id_pemagang . '&success=1');
} else {
    header('location:../pembimbing/detail_penilaian-pemagang.php?id-penilaian=' . $id_penilaian . '&id-pemagang=' . $id_pemagang . '&error=1');
}
?>

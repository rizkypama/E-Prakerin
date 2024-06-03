<?php 
session_start();
include('../../conf/config.php');

$id_pemagang = $_POST['id_pemagang'];

$existingPenilaianQuery = "SELECT id FROM tb_penilaian WHERE id_pemagang = '$id_pemagang'";
$existingPenilaianResult = mysqli_query($koneksi, $existingPenilaianQuery);

if (mysqli_num_rows($existingPenilaianResult) > 0) {
    header('location:../pembimbing/penilaian-pemagang.php?error=2');
} else {
    $kedisiplinan = $_POST['kedisiplinan'];
    $kerapian = $_POST['kerapian'];
    $tanggungjwb = $_POST['tanggungjwb'];
    $ketaatan = $_POST['ketaatan'];
    $etoskerja = $_POST['etoskerja'];
    $kerjasama = $_POST['kerjasama'];
    $keterampilan = $_POST['keterampilan'];
    $feedback = $_POST['feedback'];

    $query = mysqli_query($koneksi, "INSERT INTO tb_penilaian (id, id_pembimbing, id_pemagang, kedisiplinan, kerapian, tanggungjwb, ketaatan, etoskerja, kerjasama, keterampilan, feedback) VALUES('', '{$_SESSION['id_pembimbing']}', '$id_pemagang', '$kedisiplinan', '$kerapian', '$tanggungjwb', '$ketaatan', '$etoskerja', '$kerjasama', '$keterampilan', '$feedback')");

    if ($query) {
        header('location:../pembimbing/penilaian-pemagang.php?success=1');
    } else {
        header('location:../pembimbing/penilaian-pemagang.php?error=1');
    }
}

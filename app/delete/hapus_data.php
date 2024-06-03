<?php
session_start();

include('../../conf/config.php');
if ($_GET['method'] == 'pemagang_delete') {
    $id = $_GET['id'];
    $query = mysqli_query($koneksi, "DELETE FROM tb_pemagang WHERE id='$id'");
    header('location:../pembimbing/data_pemagang.php');
}

if ($_GET['method'] == 'pembimbing_delete') {
    $id = $_GET['id'];
    $query = mysqli_query($koneksi, "DELETE FROM tb_pembimbing WHERE id='$id'");
    header('location:../pembimbing/data_pembimbing.php');
}

if ($_GET['method'] == 'divisi_delete') {
    $id = $_GET['id'];
    $query = mysqli_query($koneksi, "DELETE FROM tb_divisi WHERE id='$id'");
    header('location:../pembimbing/data_divisi.php');
}

if ($_GET['method'] == 'laporan_delete') {
    $id = $_GET['id'];
    $query = mysqli_query($koneksi, "DELETE FROM tb_laporan_harian WHERE id='$id'");
    header('location:../pemagang/laporan-harian.php');
}

if ($_GET['method'] == 'pengajuan_delete') {
    $id = $_GET['id'];
    $query = mysqli_query($koneksi, "DELETE FROM tb_pengajuan WHERE id='$id'");
    header('location:../pemagang/pengajuan.php');
}

if ($_GET['method'] == 'penilaianpenguji_delete') {
    $id = $_GET['id'];
    $query = mysqli_query($koneksi, "DELETE FROM tb_penilaian WHERE id='$id'");
    header('location:../penilaian-penguji.php');
}

if ($_GET['method'] == 'penilaianpembimbing_delete') {
    $id = $_GET['id'];
    $query = mysqli_query($koneksi, "DELETE FROM tb_penilaian WHERE id='$id'");
    header('location:../penilaian-pembimbing.php');
}

if ($_GET['method'] == 'instansi_delete') {
    $id = $_GET['id'];
    $query = mysqli_query($koneksi, "DELETE FROM instansi WHERE id='$id'");
    header('location:../pembimbing/data_instansi.php');
}

if ($_GET['method'] == 'tugas_delete') {
    $id = $_GET['id'];
    $query = mysqli_query($koneksi, "DELETE FROM tb_tugas WHERE id='$id'");
    if ($_SESSION['role_id'] == 'Pemagang') {
        header('location:../pemagang/tugas.php');
    } else if ($_SESSION['role_id'] == 'Pembimbing'){
        header('location:../pembimbing/tugas.php');
    }
}

if ($_GET['method'] == 'tugas_delete') {
    $id = $_GET['id'];
    $query = mysqli_query($koneksi, "DELETE FROM tb_tugas WHERE id='$id'");
    if ($_SESSION['role_id'] == 'Pemagang') {
        header('location:../pemagang/tugas.php');
    } else if ($_SESSION['role_id'] == 'Pembimbing'){
        header('location:../pembimbing/tugas.php');
    }
}

if ($_GET['method'] == 'reminder_delete') {
    $reminderId = $_GET['id'];

    // Delete the reminder from the database
    $query = "DELETE FROM tb_pengingat WHERE id_pengingat = '$reminderId'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        $referer = $_SERVER['HTTP_REFERER'];
        header("Location: $referer");
        exit;
    } else {
        echo "Error deleting reminder: " . mysqli_error($koneksi);
    }
}

<?php 
include('../../conf/config.php');

if (isset($_POST['id']) && isset($_POST['status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $query = mysqli_query($koneksi, "UPDATE tb_tugas SET status ='$status' WHERE id='$id'");
    
    if ($query) {
        header('location:../pemagang/tugas.php');
        exit;
    } else {
        echo "Error updating status.";
    }
}

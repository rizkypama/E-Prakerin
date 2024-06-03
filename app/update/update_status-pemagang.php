<?php
session_start();
include('../../conf/config.php');

if ($_SESSION['role_id'] == "Pembimbing") {
    $currentDate = date("Y-m-d");
    $query = "UPDATE tb_pemagang SET status = 'Non-Aktif' WHERE tglselesai <= '$currentDate'";
    if (mysqli_query($koneksi, $query)) {
        echo "Status updated successfully!";
    } else {
        echo "Error updating status: " . mysqli_error($koneksi);
    }
} else {
    echo "You don't have permission to perform this action.";
}

<?php 
include('../../conf/config.php');

        $id = $_POST['id'];
        $status = $_POST['status'];
        $query = mysqli_query($koneksi,"UPDATE tb_pemagang SET status='$status' WHERE id='$id'");
        if($query){
            return 'data updated';
        }else{
            echo "failed to update data";
        }
?>
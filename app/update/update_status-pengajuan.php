<?php 
include('../../conf/config.php');

        $id = $_POST['id'];
        $status = $_POST['status'];
        $query = mysqli_query($koneksi,"UPDATE tb_pengajuan SET status='$status' WHERE id='$id'");
        if($query){
            // header('location:pengajuan-pemagang.php');
            return 'data updated';
            echo "<script>alert('Data berhasil diubah');window.location.href='pengajuan-pemagang.php'</script>";
        }else{
            echo "<script>alert('Data gagal diubah');window.location.href='../data_pengajuan.php'</script>";
        }
?>
<?php 
include('../../conf/config.php');

        $id = $_POST['id'];
        $status = $_POST['status'];
        $query = mysqli_query($koneksi,"UPDATE tb_laporan_harian SET status='$status' WHERE id='$id'");
        if($query){
            // header('location:pengajuan-pemagang.php');
            return 'data updated';
            echo "<script>alert('Data berhasil diubah');window.location.href='rekapan-pemagang.php'</script>";
        }else{
            echo "<script>alert('Data gagal diubah');window.location.href='../data_laporan.php'</script>";
        }
?>
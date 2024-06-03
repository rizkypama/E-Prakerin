<?php 
include('../../conf/config.php');

          $id = $_GET['id'];
          $nama_instansi = $_GET['nama_instansi'];
            $query = mysqli_query($koneksi,"UPDATE tb_instansi SET instansi='$nama_instansi' WHERE id='$id'");
        
        header('location:../admin/data_instansi.php');
?>
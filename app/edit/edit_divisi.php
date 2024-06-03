<?php 
include('../../conf/config.php');

          $id = $_GET['id'];
          $nama_divisi = $_GET['nama_divisi'];
            $query = mysqli_query($koneksi,"UPDATE tb_divisi SET nama_divisi='$nama_divisi' WHERE id='$id'");
        
        header('location:../admin/data_divisi.php');
?>
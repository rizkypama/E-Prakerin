<?php

include('../../conf/config.php');
session_start();
$method = $_GET['method'];

// Registrasi Pemagang
if ($method == 'add_pemagang') {
  $email1 = $_GET['email'];
  $query2 = mysqli_query($koneksi, "SELECT * FROM tb_users WHERE email='$email1' ");
  $cek = mysqli_num_rows($query2);
  if ($cek == 0) {
    $nama = $_GET['nama'];
    $instansi = $_GET['instansi'];
    $fakultas = $_GET['fakultas'];
    $jurusan = $_GET['jurusan'];
    $nim = $_GET['nim'];
    $jeniskelamin = $_GET['jeniskelamin'];
    $tglmulai = $_GET['tglmulai'];
    $tglselesai = $_GET['tglselesai'];
    $pembimbing = $_GET['pembimbing'];
    $divisi = $_GET['divisi'];
    $suratbappeda = $_GET['suratbappeda'];
    $email = $_GET['email'];
    $password = $_GET['password'];
    $role = "user";
    $role_id = "2";
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $checkInstansiQuery = "SELECT * FROM tb_instansi WHERE instansi = '$instansi'";
    $result = $koneksi->query($checkInstansiQuery);

    if ($result->num_rows == 0) {
      $insertInstansiQuery = "INSERT INTO tb_instansi (id, instansi) VALUES ('', '$instansi')";
      if ($koneksi->query($insertInstansiQuery)) {
      } else {
        echo 'error';
      }
    }

    $maxRegistrationsPerDivisi = 5;

    $checkSpotsFilledQuery = "SELECT COUNT(*) as total FROM tb_pemagang WHERE id_divisi = '$divisi' AND (tglmulai <= '$tglselesai' AND tglselesai >= '$tglmulai')";
    $spotsFilledResult = $koneksi->query($checkSpotsFilledQuery);
    $spotsFilledData = $spotsFilledResult->fetch_assoc();

    if ($spotsFilledData['total'] >= $maxRegistrationsPerDivisi) {
      $_SESSION['isCreateSuccess'] = false;
      header("location:../../register.php?error=1");
    } else {
      $query = "INSERT INTO tb_users (id, nama, email, password, level, role_id) VALUES('', '$nama', '$email', '$hashedPassword', '$role', '$role_id')";
      if ($koneksi->query($query)) {
        $last_id_query = $koneksi->insert_id;

        $query3 = "INSERT INTO tb_pemagang (id, id_users, nama, id_divisi, id_pembimbing, instansi, fakultas, jurusan, nim, jeniskelamin, tglmulai, tglselesai, suratbappeda, status) VALUES('', '$last_id_query', '$nama', '$divisi','$pembimbing', '$instansi', '$fakultas', '$jurusan', '$nim', '$jeniskelamin', '$tglmulai', '$tglselesai', '$suratbappeda', 'Pending')";
        if ($koneksi->query($query3)) {
        } else {
          echo 'error';
        }
      } else {
        echo 'error';
      }

      if ($query && $query3) {
        $_SESSION['isCreateSuccess'] = true;
        header('location:../../register.php?success=1');
      }
    }
  } else {
    $_SESSION['isCreateSuccess'] = false;
    header("location:../../register.php?error=2");
  }
}

if ($method == 'add_pembimbing') {
  $email1 = $_GET['email'];
  $query2 = mysqli_query($koneksi, "SELECT * FROM tb_users WHERE email='$email1'");
  $cek = mysqli_num_rows($query2);

  if ($cek == 0) {
    $nama_pembimbing = $_GET['nama'];
    $jabatan = $_GET['jabatan'];
    $nip = $_GET['nip'];
    $divisi_pembimbing = $_GET['divisi'];
    $email_pembimbing = $_GET['email'];
    $password = $_GET['password'];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $role = "pembimbing";
    $role_id = "1";

    $query = "INSERT INTO tb_users (id, nama, email, password, level, role_id) VALUES('', '$nama_pembimbing', '$email_pembimbing', '$hashedPassword', '$role', '$role_id')";

    if ($koneksi->query($query)) {
      $last_id_query = $koneksi->insert_id;

      $query2 = "INSERT INTO tb_pembimbing (id, id_users, nama_pembimbing, jabatan, nip, email, id_divisi) VALUES('', '$last_id_query', '$nama_pembimbing', '$jabatan', '$nip', '$email_pembimbing', '$divisi_pembimbing')";
      if ($koneksi->query($query2)) {
        $_SESSION['isCreateSuccess'] = true;
      } else {
        $_SESSION['isCreateSuccess'] = false;
        echo 'Error inserting into tb_pembimbing.';
      }
    } else {
      $_SESSION['isCreateSuccess'] = false;
      echo 'Error inserting into tb_users.';
    }
  } else {
    $_SESSION['isCreateSuccess'] = false;
    echo 'Email already exists.';
  }

  header('location:../admin/data_pembimbing.php');
}

if ($method == 'add_divisi') {
  $nama_divisi = $_GET['divisi'];
  $query = mysqli_query($koneksi, "INSERT INTO tb_divisi (id, nama_divisi) VALUES('','$nama_divisi')");
  header('location:../admin/data_divisi.php');
}

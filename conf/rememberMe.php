<?php 
include('conf/config.php');
// Check if the remember_token cookie is set
if (isset($_COOKIE['remember_token'])) {
  $token = $_COOKIE['remember_token'];

  // Look up the token in the database
  $query = $koneksi->query("SELECT * FROM tb_users WHERE remember_token='$token'");
  $data = mysqli_fetch_assoc($query);

  if ($data) {
    $nama = $data['nama'];

    // Redirect the user to the appropriate page based on their role
    if ($data['role_id'] == "1") {
      $id = $data['id'];
      $query1 = $koneksi->query("SELECT tbp.id as id_pembimbing, tbu.nama as nama FROM tb_users as tbu, tb_pembimbing as tbp WHERE tbu.id=tbp.id_users AND tbu.id='$id'");
      $data_pembimbing = mysqli_fetch_assoc($query1);
      $_SESSION['id_user'] = $data['id'];
      $_SESSION['second_id'] = $data_pembimbing['id_pembimbing'];
      $_SESSION['nama'] = $nama;
      $_SESSION['email'] = $email;
      $_SESSION['role_id'] = "Pembimbing";
      $_SESSION['id_pembimbing'] = $data_pembimbing['id_pembimbing'];
      $_SESSION['isLogin'] = true;
      // Redirect to the Pembimbing page
      header("location:app/pembimbing/index.php");
    } elseif ($data['role_id'] == "2") {
      $id = $data['id'];
      $query1 = $koneksi->query("SELECT tbu.nama as nama, tbp.id as id_pemagang, tbp.status as status FROM tb_users as tbu, tb_pemagang as tbp WHERE tbu.id=tbp.id_users AND tbu.id='$id'");
      $data_pemagang = mysqli_fetch_assoc($query1);
      $_SESSION['id_user'] = $data['id'];
      $_SESSION['second_id'] = $data_pemagang['id_pemagang'];
      $_SESSION['nama'] = $nama;
      $_SESSION['email'] = $email;
      $_SESSION['status'] = $data_pemagang['status'];
      $_SESSION['role_id'] = "Pemagang";
      $_SESSION['id_pemagang'] = $data_pemagang['id_pemagang'];
      $_SESSION['isLogin'] = true;
      // Redirect to the Pemagang page
      header("location:app/pemagang/index.php");
    }
    exit(); // Exit the script after redirection
  }
}
?>
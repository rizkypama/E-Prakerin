<?php
session_start();
include('config.php');

$email = $koneksi->real_escape_string($_POST['email']);
$password = $_POST['password'];

$query = $koneksi->query("SELECT * FROM tb_users WHERE email= '$email'");
$data = mysqli_fetch_assoc($query);

if ($data && password_verify($password, $data['password'])) {
    $nama = $data['nama'];

    if ($data['role_id'] == "1") {
        $id = $data['id'];
        $query1 = $koneksi->query("SELECT tbp.id as id_pembimbing, tbu.nama as nama, tbp.jabatan as jabatan, tbp.nip as nip FROM tb_users as tbu, tb_pembimbing as tbp WHERE tbu.id=tbp.id_users AND tbu.id='$id'");
        $data_pembimbing = mysqli_fetch_assoc($query1);

        $_SESSION['id_user'] = $data['id'];
        $_SESSION['second_id'] = $data_pembimbing['id_pembimbing'];
        $_SESSION['nama'] = $nama;
        $_SESSION['jabatan'] = $data_pembimbing['jabatan'];
        $_SESSION['nip'] = $data_pembimbing['nip'];
        $_SESSION['email'] = $email;
        $_SESSION['role_id'] = "Pembimbing";
        $_SESSION['id_pembimbing'] = $data_pembimbing['id_pembimbing'];
        $_SESSION['profile_picture'] = $data['profile_picture'];
        $_SESSION['isLogin'] = true;
        header("location:../app/pembimbing/");
    } else if ($data['role_id'] == "2") {
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
        $_SESSION['profile_picture'] = $data['profile_picture'];
        $_SESSION['isLogin'] = true;
        header("location:../app/pemagang/");
    } else if ($data['role_id'] == "3") {
        $id = $data['id'];
        $query1 = $koneksi->query("SELECT tbs.id as id_admin, tbu.nama as nama FROM tb_users as tbu, tb_admin as tbs WHERE tbu.id=tbs.id_users AND tbu.id='$id'");
        $data_admin = mysqli_fetch_assoc($query1);

        $_SESSION['id_user'] = $data['id'];
        $_SESSION['second_id'] = $data_admin['id_admin'];
        $_SESSION['nama'] = $nama;
        $_SESSION['email'] = $email;
        $_SESSION['role_id'] = "Admin";
        $_SESSION['id_admin'] = $data_admin['id_admin'];
        $_SESSION['profile_picture'] = $data['profile_picture'];
        $_SESSION['isLogin'] = true;
        header("location:../app/admin/");
    };
    if (isset($_POST['remember_me'])) {
        $token = bin2hex(random_bytes(16));
        setcookie("remember_token", $token, time() + (30 * 24 * 60 * 60), "/"); // Expires in 30 days

        // $token = password_hash($token, PASSWORD_DEFAULT);
        $query = $koneksi->query("UPDATE tb_users SET remember_token='$token' WHERE id='$data[id]'");
    }

} else {
    header("location:../index.php?error=1");
}
?>

<!DOCTYPE html>
<html lang="en">
<?php
session_start();
include('conf/rememberMe.php')
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Monitoring Magang SMK NU Kesesi</title>
  <link rel="icon" type="image/x-icon" href="images/dinas.svg">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    ::-webkit-scrollbar {
      display: none;
    }
  </style>
</head>

<body>
  <div component="main">
    <link rel="stylesheet" href="style/register-style.css">
    <div id="toaster"></div>
    <div class="center">
      <section class="container">
        <div style="display: flex; justify-content:center;">
          <img src="images/dinas.svg" alt="logo" width="100px" height="100px">
        </div>
        </br>
        <header>Login</header>
        <div class="black-text">SMK NU KESESI - PEKALONGAN</div>
        <form action="conf/autentikasi.php" method="post" id="registration-form" class="form" autocomplete="off">
          <div class="input-box">
            <label>Email</label>
            <input name="email" type="text" placeholder="Email" required />
          </div>
          <div class="input-box">
            <label>Password</label>
            <input name="password" type="password" placeholder="Password" required />
          </div>
          <div class="input-box">
            <input type="checkbox" name="remember_me" id="remember_me" style="width: auto; height: auto; margin-top: 5px; margin-right:5px;">
            <label for="remember_me">Remember Me</label>
          </div>
          <button id="register-button">
            Login
          </button>
        </form>
        <p class="black-text">
          Belum punya akun?&nbsp;
          <a href="register.php">Register</a>
        </p>
      </section>
    </div>
  </div>

</body>
<?php
if (isset($_GET['error'])) {
  $alert = ($_GET['error']);
  if ($alert == 1) {
    echo "
    <script>
    Swal.fire({
      title: 'Login Gagal',
      text: 'Email atau Password salah',
      icon: 'error',
      confirmButtonText: 'OK'
    }).then((result) => {
      if (result.value)
      {window.location = 'index.php';}
    })
    </script>";
  } else {
    echo "";
  }
}
?>

</html>
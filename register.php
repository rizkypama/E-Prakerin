<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="images/dinas.svg">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <title>Monitoring Magang SMK NU Kesesi</title>
  <style>
    ::-webkit-scrollbar {
      width: 6px;
    }

    ::-webkit-scrollbar-thumb {
      background-color: rgb(216, 216, 216);
      border-radius: 40px;
    }

    ::-webkit-scrollbar-track {
      background-color: transparent;
    }

    .select2-container {
      width: 100% !important;
    }

    .select2-container--default .select2-selection--single {
      position: relative;
      height: 50px;
      width: 100%;
      outline: none;
      font-size: 1rem;
      color: #707070;
      margin-top: 8px;
      border: 1px solid #ddd;
      border-radius: 6px;
      padding-right: 15px;
      padding-left: 6px;
      align-items: center;
      display: flex;
    }

    .select2-container .select2-selection--single .select2-selection__rendered {
      display: inline-flex;
      padding-right: 20px;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
      height: 26px;
      position: absolute;
      top: 10px;
      right: 1px;
      width: 20px;
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
        <header>Registrasi Magang</header>
        <div class="black-text">SMK NU KESESI - PEKALONGAN</div>
        <form id="registration-form" class="form" autocomplete="off" method="get" action="app/add/tambah_data.php">
          <input type="hidden" name="method" value="add_pemagang">
          <div class="input-box">
            <label>Nama</label>
            <input type="text" name="nama" placeholder="Nama Lengkap" required />
          </div>
          <div class="input-box">
            <label>Perguruan Tinggi / Sekolah</label>
            </br>
            <select name="instansi" id="instansiSelect" required>
              <option value="" selected disabled>Pilih Perguruan Tinggi / Sekolah</option>
              <?php
              include('conf/config.php');
              $queryInstansi = mysqli_query($koneksi, "SELECT * FROM tb_instansi");
              while ($rowInstansi = mysqli_fetch_array($queryInstansi)) {
                echo '<option value="' . $rowInstansi['instansi'] . '">' . $rowInstansi['instansi'] . '</option>';
              }
              ?>
            </select>
          </div>
          <div class="input-box">
            <label>Fakultas (Jika ada)</label>
            <input type="text" name="fakultas" placeholder="Fakultas" />
          </div>
          <div class="column">
            <div class="input-box">
              <label>Jurusan</label>
              <input type="text" name="jurusan" placeholder="Jurusan" required />
            </div>
            <div class="input-box">
              <label>NIM / NIS</label>
              <input type="text" name="nim" placeholder="NIM / NIS" required />
            </div>
          </div>
          <br>
          <label for="jeniskelamin">Jenis Kelamin:</label>
          <div>
            <input type="radio" id="Laki-laki" name="jeniskelamin" value="Laki-laki" checked>
            <label for="Laki-laki">Laki-laki</label>
          </div>
          <div>
            <input type="radio" id="Perempuan" name="jeniskelamin" value="Perempuan">
            <label for="Perempuan">Perempuan</label>
          </div>
          <div class="column">
            <div class="input-box">
              <label>Tanggal Mulai</label>
              <input type="date" name="tglmulai" placeholder="Tanggal Mulai Magang" required />
            </div>
            <div class="input-box">
              <label>Tanggal Selesai</label>
              <input type="date" name="tglselesai" placeholder="Tanggal Selesai Magang" required />
            </div>
          </div>
          <div class="input-box">
            <label>Pembimbing</label>
            </br>
            <select name="pembimbing" id="pembimbingSelect" required>
              <option value="" selected disabled>Select an Pembimbing</option>
              <?php
              include('conf/config.php');
              $queryPembimbing = mysqli_query($koneksi, "SELECT * FROM tb_pembimbing");
              while ($rowPembimbing = mysqli_fetch_array($queryPembimbing)) {
                echo '<option value="' . $rowPembimbing['id'] . '">' . $rowPembimbing['nama_pembimbing'] . '</option>';
              }
              ?>
            </select>
          </div>
          <div class="input-box">
            <label>Divisi</label>
            </br>
            <select name="divisi" id="divisiSelect" required>
              <option value="" selected disabled>Select an Divisi</option>
              <?php
              include('conf/config.php');
              $queryDivisi = mysqli_query($koneksi, "SELECT * FROM tb_divisi");
              while ($rowDivisi = mysqli_fetch_array($queryDivisi)) {
                echo '<option value="' . $rowDivisi['id'] . '">' . $rowDivisi['nama_divisi'] . '</option>';
              }
              ?>
            </select>
          </div>
          <div class="input-box">
            <label>Nomor Surat Rekomendasi</label>
            <input type="text" name="suratbappeda" placeholder="Nomor Surat Rekomendasi" required />
          </div>
          <div class="input-box">
            <label>Email</label>
            <input type="email" name="email" placeholder="Email" required />
          </div>
          <div class="input-box">
            <label>Password</label>
            <input type="password" name="password" placeholder="Password" required />
          </div>

          <button id="register-button">
            Submit
          </button>
        </form>
        <p class="black-text">
          Sudah punya akun?&nbsp;
          <a href="index.php">Login</a>
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
      title: 'Registrasi Gagal',
      text: 'Kuota magang sudah penuh!',
      icon: 'error',
      confirmButtonText: 'OK'
    }).then((result) => {
      if (result.value)
      {window.location = 'register.php';}
    })
    </script>";
  } else if ($alert == 2) {
    echo "
    <script>
    Swal.fire({
      title: 'Registrasi Gagal',
      text: 'Email sudah terdaftar!',
      icon: 'error',
      confirmButtonText: 'OK'
    }).then((result) => {
      if (result.value)
      {window.location = 'register.php';}
    })
    </script>";
  } else {
    echo "";
  }
}

if (isset($_GET['success'])) {
  $alert = ($_GET['success']);
  if ($alert == 1) {
    echo "
    <script>
    Swal.fire({
      title: 'Registrasi berhasil',
      text: 'Silahkan login!',
      icon: 'success',
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
<script>
  $(document).ready(function() {
    $('#instansiSelect').select2({
      placeholder: 'Masukkan atau Pilih PT / Sekolah',
      tags: true,
      createTag: function(params) {
        return {
          id: params.term,
          text: params.term,
          newOption: true
        };
      },
      templateResult: function(data) {
        var $result = $("<span></span>");

        $result.text(data.text);

        if (data.newOption) {
          $result.append(" <em>(Baru)</em>");
        }

        return $result;
      }
    });
  });

  $(document).ready(function() {
    $('#pembimbingSelect').select2({
      placeholder: 'Pilih Pembimbing',
      tags: true,
      createTag: function(params) {
        return {
          id: params.term,
          text: params.term,
        };
      },
      templateResult: function(data) {
        var $result = $("<span></span>");

        $result.text(data.text);

        return $result;
      }
    });
  });

  $(document).ready(function() {
    $('#divisiSelect').select2({
      placeholder: 'Pilih Divisi',
      tags: true,
      createTag: function(params) {
        return {
          id: params.term,
          text: params.term,
        };
      },
      templateResult: function(data) {
        var $result = $("<span></span>");

        $result.text(data.text);

        return $result;
      }
    });
  });
</script>

</html>
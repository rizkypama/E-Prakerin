<?php
session_start();
include('../../conf/cekLogin.php');
include('../../conf/config.php');
?>

<html>

<head>
  <title>Presensi</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
</head>

<body>
  <div class="container">
    <h2>Log Presensi</h2>
    <h4>All Logs</h4>
    <div class="data-tables datatable-dark">
      <!-- Masukkan table nya disini, dimulai dari tag TABLE -->
      <table id="mauexport" class="table table-hover">
        <thead>
          <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Nama</th>
            <th>Jam Masuk</th>
            <th>Jam Pulang</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $id_pembimbing = $_SESSION['id_pembimbing'];
          $no = 0;
          $query = mysqli_query($koneksi, "SELECT p.tgl, p.jam_masuk, p.jam_pulang, m.nama
          FROM tb_presensi p
          INNER JOIN tb_pemagang m ON p.id_pemagang = m.id
          WHERE m.id_pembimbing = '$id_pembimbing' ORDER BY p.tgl DESC");
          while ($row = mysqli_fetch_array($query)) {
            $no++;
          ?>
            <tr>
              <td width='7%'>
                <?php echo $no; ?>
              </td>
              <td>
                <?php echo $row['tgl']; ?>
              </td>
              <td>
                <?php echo $row['nama']; ?>
              </td>
              <td>
                <?php echo $row['jam_masuk']; ?>
              </td>
              <td>
                <?php echo $row['jam_pulang']; ?>
              </td>
            </tr>
          <?php } ?>
        </tbody>
        <tfoot>
        </tfoot>
      </table>

    </div>
  </div>

  <script>
    $(document).ready(function() {
      $('#mauexport').DataTable({
        dom: 'Bfrtip',
        buttons: [
          'pdf',
          'print',
          'excel',
          'copy',
          'csv',
        ]
      });
    });
  </script>

  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>



</body>

</html>
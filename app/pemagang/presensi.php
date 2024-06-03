<!DOCTYPE html>
<html lang="en">
<?php session_start();
include('../../conf/cekLogin.php');
include('../../conf/config.php');
include('../../conf/cekPemagang.php');
include('header.php')
?>

<body>
    <?php include('preloader.php') ?>

    <div class="container">
        <?php $hal = "Log Presensi" ?>
        <?php include('sidebar.php'); ?>

        <!-- Main Content -->
        <main>
            <h1>Presensi</h1>
            <div class="recent-orders">
                <h2>Presensi Terbaru</h2>
                <div class="add-button">
                    <button type="button" class="action-btn" id="action-btn">
                        Export
                    </button>
                    <select class="js-example-basic-multiple" name="states[]" onchange="window.location='?bulan='+this.value">
                        <option value="" disabled selected>Bulan</option>
                        <option value="1">Jan</option>
                        <option value="2">Feb</option>
                        <option value="3">Mar</option>
                        <option value="4">Apr</option>
                        <option value="5">May</option>
                        <option value="6">Jun</option>
                        <option value="7">Jul</option>
                        <option value="8">Aug</option>
                        <option value="9">Sep</option>
                        <option value="10">Oct</option>
                        <option value="11">Nov</option>
                        <option value="12">Dec</option>
                    </select>
                </div>
                </br>

                <table id="example1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Date</th>
                            <th>Masuk</th>
                            <th>Pulang</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $bulan = (!isset($_GET['bulan'])) ? date("m") : $_GET['bulan'];
                        function last_day_of_the_month($date = '')
                        {
                            $month  = date('m', strtotime($date));
                            $year   = date('Y', strtotime($date));
                            $result = strtotime("{$year}-{$month}-01");
                            $result = strtotime('-1 second', strtotime('+1 month', $result));
                            return date('d', $result);
                        }
                        $jam_absen_pulang = 16;
                        $datapresensi = [];
                        $datapengajuan = [];
                        $datarawpresensi = (mysqli_query(
                            $koneksi,
                            "SELECT *, (jam_masuk > time('07:30:00')) as mt, (jam_pulang < time('$jam_absen_pulang:00:00')) as pc
                        FROM tb_presensi 
                        WHERE month(tgl)='$bulan' 
                        AND id_pemagang='{$_SESSION['id_pemagang']}'"
                        ));
                        $datarawpengajuan = (mysqli_query(
                            $koneksi,
                            "SELECT *, date(created_at) as tgl
                        FROM tb_pengajuan 
                        WHERE month(created_at)='$bulan' and id_pemagang='{$_SESSION['id_pemagang']}' "
                        ));
                        while ($row = mysqli_fetch_assoc($datarawpresensi)) $datapresensi[$row['tgl']] = $row;
                        while ($wor = mysqli_fetch_assoc($datarawpengajuan)) $datapengajuan[$wor['tgl']] = $wor;
                        $no = 0;
                        for ($i = 0; $i < last_day_of_the_month(date("Y") . "-$bulan-1"); $i++) {
                            $isodate = date("Y-m-d", strtotime(date("Y") . "-$bulan-" . ($i + 1)));
                            $isFriday = (date('N', strtotime($isodate)) === '5');

                            if ((date('N', strtotime($isodate)) >= 6)) continue;
                            $no++;

                            $jam_pulang = '-';
                            $jam_masuk = '-';
                            $status = "A";
                            if (isset($datapresensi[$isodate])) {
                                $sa = $datapresensi[$isodate];
                                $jam_pulang = $sa['jam_pulang'];
                                $jam_masuk = $sa['jam_masuk'];
                                if ($sa['mt'] == 1 && $sa['pc'] == 1 && (date("H") >= $jam_absen_pulang && date("I") > 0)) {
                                    $status = "HTPC (Hadir Telambat Pulang Cepat)";
                                } else if ($jam_masuk != "07:30:00" && $jam_pulang != "16:00:00" && $sa['mt'] == 1) {
                                    $status = "HT (Hadir Telambat)";
                                } else if (!$isFriday && $jam_masuk != "00:00:00" && $jam_pulang != "00:00:00" && $sa['pc'] == 1) {
                                    $status = "HPC (Hadir Pulang Cepat)";
                                } else if ($jam_masuk != "00:00:00" && $sa['mt'] == 0 && $sa['pc'] == 0) {
                                    $status = "H";
                                } else if ($isodate == date("Y-m-d") && (date("H") < $jam_absen_pulang)) {
                                    $status = "...";
                                } else if ($jam_masuk != "00:00:00" && $jam_pulang == "00:00:00") {
                                    $status = "HTAP (Hadir Tanpa Absen Pulang)";
                                } else if ($jam_masuk == "00:00:00" && $jam_pulang != "00:00:00") {
                                    $status = "HTAM (Hadir Tanpa Absen Masuk)";
                                } else if ($isFriday && ($jam_pulang >= '11:30:00')) {
                                    $status = "H"; // Set status as "H" (Hadir)
                                }
                            } else if (isset($datapengajuan[$isodate])) {
                                $sa = $datapengajuan[$isodate];
                                if ($sa['status'] == "disetujui") $status =  $sa['tipe'] == "sakit" ? "SDK (Sakit Dengan Keterangan)" : "IDK (Izin Dengan Keterangan)";
                            }
                            $rowClass = $no <= 5 ? 'first-five-row' : 'remaining-row';
                        ?>

                            <tr class="<?= $rowClass ?>">
                                <td><?php echo $no; ?></td>
                                <td>
                                    <?= date("d/m/Y", strtotime(date("Y") . "-$bulan-" . ($i + 1))); ?>
                                </td>
                                <td>
                                    <?= $jam_masuk ?>
                                </td>
                                <td><?= $jam_pulang ?></td>
                                <td>
                                    <?php
                                    /*
                                    H = Hadir (presensi jam_pulang >= 17:00:00 && jam_masuk <= 08:00:00)
                                    HT = Hadir Terlambat (presensi jam_pulang >= 17:00:00 && jam_masuk > 08:00:00)
                                    HTAP = Hadir Tanpa Absen Pulang (presensi jam_pulang = 00:00:00)
                                    HPC = Hadir Pulang Cepat (presensi jam_pulang < 17:00:00 && jam_masuk <= 08:00:00)
                                    HTAM = Hadir Tanpa Absen Masuk (presensi jam_pulang)
                                    IDK = Izin Dengan Keterangan (izin,pembimbing)
                                    SDK = Sakit Dengan Keterangan (izin,pembimbing)
                                    A = Alpha (no data)
                                    */
                                    echo $status;
                                    ?>
                                </td>
                            </tr>
                        <?php
                        } ?>
                    </tbody>
                </table>
                <a href="#" class="show-all-link">Show All</a>
                <a href="#" class="show-less-link" style="display: none;">Show Less</a>
            </div>
            </br>
        </main>
        <!-- End of Main Content -->

        <!-- Right Section -->
        <?php include('right-section.php'); ?>
        <!-- End of Right Section -->
    </div>
    <!-- Start of Modal -->
    <div class="modal">
        <div class="modal-content">
            <h2 class="modal-title">New Permission for Leave</h2>
            <span class="close-button">&times;</span>
            <form method="post" action="../add/tambah_pengajuan.php" enctype="multipart/form-data">
                <label for="nama_pembimbing">Pembimbing:</label>
                <select id="nama_pembimbing" name="nama_pembimbing" required>
                    <option selected="selected">...</option>
                    <?php $query = mysqli_query($koneksi, "SELECT * FROM tb_pembimbing"); ?>
                    <?php while ($row = mysqli_fetch_array($query)) { ?>
                        <option value="<?= $row['id']; ?>"><?= $row['nama_pembimbing']; ?></option>
                    <?php } ?>
                </select>

                <label for="alasan">Alasan:</label>
                <div>
                    <input type="radio" id="sakit" name="tipe" value="sakit" checked>
                    <label for="sakit">Sakit</label>
                </div>
                <div>
                    <input type="radio" id="izin" name="tipe" value="izin">
                    <label for="izin">Izin</label>
                </div>

                <label for=" textArea">Keterangan:</label>
                <textarea id="textArea" name="deskripsi" rows="4" required></textarea>

                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
    <!-- End of Modal -->

    <?php include('footer.php'); ?>

    <script>
        document.getElementById('action-btn').addEventListener('click', function() {
            var id = this.getAttribute('data-id');
            window.location.href = '../export/export-presensi-pemagang.php';
        });
    </script>

</body>

</html>
<!DOCTYPE html>
<html lang="en">
<?php session_start();
include('../../conf/cekLogin.php');
include('../../conf/config.php');
include('../../conf/cekAdmin.php');
include('header.php')
?>

<body>
    <?php include('preloader.php') ?>

    <div class="container">
        <?php $hal = "Presensi" ?>
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
                </div>
                </br>
                <table id="example1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama</th>
                            <th>Masuk</th>
                            <th>Pulang</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $currentWeek = date("W");
                        $no = 0;
                        $query = mysqli_query($koneksi, "SELECT * FROM tb_presensi WHERE WEEK(tgl) = $currentWeek");
                        while ($row = mysqli_fetch_array($query)) {
                            $no++;
                            $rowClass = $no <= 5 ? 'first-five-row' : 'remaining-row';

                        ?>
                            <tr class="<?= $rowClass ?>">
                                <td><?php echo $no; ?></td>
                                <td>
                                    <?php echo $row['tgl'] ?>
                                </td>
                                <td class="truncate-text">
                                    <span class="original-text">
                                        <?php
                                        $query2 = mysqli_query($koneksi, "SELECT * FROM tb_pemagang WHERE id='{$row['id_pemagang']}'");
                                        $row2 = mysqli_fetch_array($query2);
                                        echo $row2['nama'];
                                        ?>
                                    </span>
                                    <span class="truncated-version">
                                        <?php
                                        $sentence = $row2['nama'];
                                        $split = substr($sentence, 0, 20) . '...';
                                        $words = str_word_count($sentence, 1);

                                        if (strlen($sentence) > 5) {
                                            echo $split;
                                        } else {
                                            echo $sentence;
                                        }
                                        ?>
                                    </span>
                                </td>
                                <td>
                                    <?php echo $row['jam_masuk']; ?>
                                </td>
                                <td>
                                    <?php echo $row['jam_pulang']; ?>
                                </td>
                                <td>
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
            window.location.href = '../export/export-presensi-all.php';
        });
    </script>

</body>

</html>
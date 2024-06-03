<!DOCTYPE html>
<html lang="en">
<?php session_start();
include('../../conf/cekLogin.php');
include('../../conf/config.php');
include('../../conf/cekPembimbing.php');
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
                        $id_pembimbing = $_SESSION['id_pembimbing'];

                        $query = mysqli_query($koneksi, "SELECT p.tgl, p.jam_masuk, p.jam_pulang, m.nama
              FROM tb_presensi p
              INNER JOIN tb_pemagang m ON p.id_pemagang = m.id
              WHERE m.id_pembimbing = '$id_pembimbing'
              AND WEEK(p.tgl) = WEEK(CURRENT_DATE())");
                        $no = 0;
                        while ($row = mysqli_fetch_array($query)) {
                            $no++;
                            $rowClass = $no <= 5 ? 'first-five-row' : 'remaining-row';
                        ?>
                            <!-- Your table rows here -->
                            <tr class="<?= $rowClass ?>">
                                <td><?php echo $no; ?></td>
                                <td><?php echo $row['tgl'] ?></td>
                                <td class="truncate-text">
                                    <span class="original-text">
                                        <?php echo $row['nama']; ?>
                                    </span>
                                    <span class="truncated-version">
                                        <?php
                                        $sentence = $row['nama'];
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
                                <td><?php echo $row['jam_masuk']; ?></td>
                                <td><?php echo $row['jam_pulang']; ?></td>
                                <td></td>
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

    <?php include('footer.php'); ?>

    <script>
        document.getElementById('action-btn').addEventListener('click', function() {
            var id = this.getAttribute('data-id');
            window.location.href = '../export/export-presensi.php';
        });
    </script>

</body>

</html>
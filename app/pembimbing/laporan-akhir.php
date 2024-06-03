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
        <?php
        $hal = "Laporan akhir";
        $halaman = 'Laporan';
        ?>
        <?php include('sidebar.php'); ?>

        <!-- Main Content -->
        <main>
            <h1>Laporan</h1>
            <div class="recent-orders">
                <h2>Semua Laporan</h2>
                <table id="example1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Total Laporan</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 0;
                        $query = mysqli_query($koneksi, "SELECT tbp.id, tbp.nama, tbp.instansi, tbp.status, 
                                         (SELECT COUNT(*) FROM tb_laporan_harian WHERE id_pemagang = tbp.id) AS total_laporan
                                         FROM tb_pemagang as tbp 
                                         WHERE tbp.status != 'Ditolak' AND tbp.id_pembimbing='{$_SESSION['id_pembimbing']}'");
                        while ($row = mysqli_fetch_array($query)) {
                            $no++;
                            $rowClass = $no <= 5 ? 'first-five-row' : 'remaining-row';
                        ?>
                            <tr class="table-row <?= $rowClass ?>">
                                <td>
                                    <?php echo $no; ?>
                                </td>
                                <td>
                                    <span class="original-text">
                                        <?php
                                        echo $row['nama'];
                                        ?>
                                    </span>
                                    <span class="truncated-version">
                                        <?php
                                        $sentence = $row['nama'];
                                        $split = substr($sentence, 0, 15) . '...';
                                        $words = str_word_count($sentence, 1);

                                        if (strlen($sentence) > 5) {
                                            echo $split;
                                        } else {
                                            echo $sentence;
                                        }
                                        ?>
                                    </span>
                                </td>
                                <td><?php echo $row['total_laporan']; ?></td>
                                <td>
                                    <a href="../export/cetak-laporan-akhir.php?id-pemagang=<?= $row['id'] ?>">
                                        <span class="material-icons-sharp primary">
                                            file_download
                                        </span>
                                    </a>
                                </td>
                                <td>
                                    <a href="detail_laporan-akhir.php?id=<?= $row['id']; ?>"class="btn btn-sm btn-outline-info">
                                        <span class="material-icons-sharp">
                                            info
                                        </span>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
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
            window.location.href = '../export/export-laporan.php';
        });
    </script>

</body>

</html>
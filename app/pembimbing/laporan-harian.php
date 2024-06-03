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
        $hal = "Laporan harian";
        $halaman = 'Laporan';
        ?>
        <?php include('sidebar.php'); ?>

        <!-- Main Content -->
        <main>
            <h1>Laporan</h1>
            <div class="recent-orders">
                <h2>Laporan Hari Ini</h2>
                <table id="example1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama</th>
                            <th>Kegiatan</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 0;
                        $twentyFourHoursAgo = date('Y-m-d H:i:s', strtotime('-24 hours'));

                        $query = mysqli_query($koneksi, "SELECT * FROM tb_laporan_harian WHERE id_pembimbing='{$_SESSION['id_pembimbing']}' AND created_at >= '$twentyFourHoursAgo'");
                        while ($row = mysqli_fetch_array($query)) {
                            $no++;
                            $rowClass = $no <= 5 ? 'first-five-row' : 'remaining-row';
                            $created_at = $row['created_at'];
                            $timestamp = strtotime($created_at);
                            $created_at = date('d-m-Y', $timestamp);
                        ?>
                            <tr class="<?= $rowClass ?>">
                                <td>
                                    <?php echo $no; ?>
                                </td>
                                <td>
                                    <?php echo $created_at; ?>
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
                                        $split = substr($sentence, 0, 6) . '...';
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
                                    <span class="original-text">
                                        <?php
                                        echo $row['nama_kegiatan'];
                                        ?>
                                    </span>
                                    <span class="truncated-version">
                                        <?php
                                        $sentence = $row['nama_kegiatan'];
                                        $split = substr($sentence, 0, 6) . '...';
                                        $words = str_word_count($sentence, 1);

                                        if (strlen($sentence) > 5) {
                                            echo $split;
                                        } else {
                                            echo $sentence;
                                        };
                                        ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg <?= ($row['status'] == 'proses' ? 'warning' : ($row['status'] == 'disetujui' ? 'success' : 'danger')); ?>"><?php echo $row['status']; ?></span>
                                </td>
                                <td>
                                    <a href="detail_laporan-pemagang.php?id-laporan=<?= $row['id']; ?>&id-pemagang=<?= $row['id_pemagang'] ?>" class="btn btn-sm btn-outline-info">
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

</body>

</html>
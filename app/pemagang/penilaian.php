<!DOCTYPE html>
<html lang="en">
<?php session_start();
include('../../conf/cekLogin.php');
include('../../conf/config.php');
include('../../conf/cekPemagang.php');
include('header.php')
?>

<?php
$idPemagang = $_SESSION['id_pemagang'];
$id_user = $_SESSION['id_user'];
$query = mysqli_query($koneksi, "SELECT tp.* FROM tb_penilaian as tp, tb_pemagang as tbp WHERE tbp.id = tp.id_pemagang AND tbp.id = '$idPemagang'");
$view = mysqli_fetch_array($query);
if ($view !== null) {
    $idPenilaian = $view['id'];
}
?>

<body>
    <?php include('preloader.php') ?>

    <div class="container">
        <?php $hal = "Penilaian" ?>
        <?php include('sidebar.php'); ?>

        <!-- Main Content -->
        <main>
            <h1>Penilaian</h1>
            <div class="add-container back-button">
                <span class="material-icons-sharp">
                    arrow_back
                </span>
                <h3>Back</h3>
            </div>
            <?php if ($view !== null) : ?>
                <div class="add-button">
                    <button type="button" class="action-btn" id="action-btn">
                        Cetak
                    </button>
                </div>
            <?php else : ?>
                <div class="add-button">
                    <button type="button" class="action-btn" disabled>
                        Cetak
                    </button>
                </div>
            <?php endif; ?>
            <div class="recent-orders">
                <div class="new-users">
                    <h2>Nama Pembimbing</h2>
                    <div class="user-list">
                        <div class="user">
                            <h2>
                                <?php
                                $query2 = mysqli_query($koneksi, "SELECT id_pembimbing FROM tb_pemagang as tbp, tb_users as tbu WHERE tbp.id_users = tbu.id AND tbp.id_users = '$id_user'");
                                $idPembimbing = mysqli_fetch_array($query2)['id_pembimbing'];
                                $query3 = mysqli_query($koneksi, "SELECT tbpm.nama_pembimbing FROM tb_pembimbing as tbpm, tb_pemagang as tbp WHERE tbp.id_pembimbing = tbpm.id AND tbp.id_pembimbing = '$idPembimbing'");
                                $view3 = mysqli_fetch_array($query3);
                                echo $view3['nama_pembimbing']
                                ?>
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="new-users">
                    <h2>Nilai</h2>
                </div>
                <?php if ($view !== null) : ?>
                    <table id="example1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Indikator</th>
                                <th>Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>
                                    Kedisiplinan
                                </td>
                                <td>
                                    <?php echo $view['kedisiplinan']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>
                                    Kerapian
                                </td>
                                <td>
                                    <?php echo $view['kerapian']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>
                                    Tanggung Jawab
                                </td>
                                <td>
                                    <?php echo $view['tanggungjwb']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>
                                    Ketaatan
                                </td>
                                <td>
                                    <?php echo $view['ketaatan']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>
                                    Etos Kerja
                                </td>
                                <td>
                                    <?php echo $view['etoskerja']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>
                                    Kerja Sama
                                </td>
                                <td>
                                    <?php echo $view['kerjasama']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>
                                    Keterampilan
                                </td>
                                <td>
                                    <?php echo $view['keterampilan']; ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                <?php else : ?>
                    <div class="new-users">
                        <div class="user-list">
                            <div class="user">
                                <h2>Belum Ada Penilaian</h2>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="new-users">
                <h2>Feedback</h2>
                <div class="user-list">
                    <div class="user">
                        <?php if ($view !== null) : ?>
                            <h2><?php echo $view['feedback'] ?>
                            </h2>
                        <?php else : ?>
                            <h2>Belum Ada Penilaian</h2>
                        <?php endif; ?>
                    </div>
                </div>
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
            window.location.href = '../export/cetak-penilaian-pemagang.php?id-penilaian=<?= $idPenilaian ?>&id-pemagang=<?= $idPemagang ?>';
        });
    </script>

</body>

</html>
<!DOCTYPE html>
<html lang="en">
<?php session_start();
include('../../conf/cekLogin.php');
include('../../conf/config.php');
include('../../conf/cekPemagang.php');
include('header.php')
?>

<?php
$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM tb_pengajuan WHERE id='$id'");
$view = mysqli_fetch_array($query);
?>

<body>
    <?php include('preloader.php') ?>

    <div class="container">
        <?php $hal = "Laporan Harian" ?>
        <?php include('sidebar.php'); ?>

        <!-- Main Content -->
        <main>
            <h1>Detail Pengajuan</h1>
            <div class="add-container back-button">
                <span class="material-icons-sharp">
                    arrow_back
                </span>
                <h3>Back</h3>
            </div>
            <div class="new-users">
                <h2>Pembimbing</h2>
                <div class="user-list">
                    <div class="user">
                        <h2><?php $query2 = mysqli_query($koneksi, "SELECT * FROM tb_pembimbing"); ?>
                            <?php while ($dataPembimbing = mysqli_fetch_array($query2)) { ?>
                                <?php if ($dataPembimbing['id'] == $view['id_pembimbing']) : ?>
                                    <?= $dataPembimbing['nama_pembimbing']; ?>
                                    <?php continue; ?>
                                <?php endif ?>
                            <?php } ?>
                        </h2>
                    </div>
                </div>
            </div>
            <div class="new-users">
                <h2>Alasan</h2>
                <div class="user-list">
                    <div class="user">
                        <h2><?php echo $view['tipe'] ?>
                        </h2>
                    </div>
                </div>
            </div>
            <div class="new-users">
                <h2>Deskripsi Kegiatan</h2>
                <div class="user-list">
                    <div class="user">
                        <h2>
                            <?php echo $view['deskripsi_kegiatan'] ?>
                        </h2>
                    </div>
                </div>
            </div>
        </main>
        <!-- End of Main Content -->

        <!-- Right Section -->
        <?php include('right-section.php'); ?>
        <!-- End of Right Section -->
    </div>

    <?php include('footer.php'); ?>

</body>

</html>
<!DOCTYPE html>
<html lang="en">
<?php session_start();
include('../../conf/cekLogin.php');
include('../../conf/config.php');
include('../../conf/cekPemagang.php');
include('header.php')
?>

<?php
$id = $_SESSION['id_pemagang'];
$query = mysqli_query($koneksi, "SELECT * FROM tb_pemagang WHERE id='$id'");
$view = mysqli_fetch_array($query);
$tglmulai = $view['tglmulai'];
$tglmulai = strtotime($tglmulai);
$tglmulai = date('d-m-Y', $tglmulai);
$tglselesai = $view['tglselesai'];
$tglselesai = strtotime($tglselesai);
$tglselesai = date('d-m-Y', $tglselesai);
?>

<body>
    <?php include('preloader.php') ?>

    <div class="container">
        <?php $hal = "Profile" ?>
        <?php include('sidebar.php'); ?>

        <main>
            <h1>Profile</h1>
            <div class="add-container back-button">
                <span class="material-icons-sharp">
                    arrow_back
                </span>
                <h3>Back</h3>
            </div>
            <div class="recent-orders">
                <div class="new-users">
                    <h2>Nama</h2>
                    <div class="user-list">
                        <div class="user">
                            <h2><?php echo $view['nama'] ?>
                            </h2>
                        </div>
                    </div>
                </div>

                <div class="new-users">
                    <h2>Perguruan Tinggi/Sekolah</h2>
                    <div class="user-list">
                        <div class="user">
                            <h2><?php echo $view['instansi'] ?>
                            </h2>
                        </div>
                    </div>
                </div>

                <div class="new-users">
                    <h2>Fakultas</h2>
                    <div class="user-list">
                        <div class="user">
                            <h2><?php echo $view['fakultas'] ?>
                            </h2>
                        </div>
                    </div>
                </div>

                <div class="new-users">
                    <h2>Jurusan</h2>
                    <div class="user-list">
                        <div class="user">
                            <h2><?php echo $view['jurusan'] ?>
                            </h2>
                        </div>
                    </div>
                </div>

                <div class="new-users">
                    <h2>NIM</h2>
                    <div class="user-list">
                        <div class="user">
                            <h2><?php echo $view['nim'] ?>
                            </h2>
                        </div>
                    </div>
                </div>

                <div class="new-users">
                    <h2>Nomor Surat Rekomendasi</h2>
                    <div class="user-list">
                        <div class="user">
                            <h2><?php echo $view['suratbappeda'] ?>
                            </h2>
                        </div>
                    </div>
                </div>

                <div class="new-users">
                    <h2>Tanggal Mulai</h2>
                    <div class="user-list">
                        <div class="user">
                            <h2><?php echo $tglmulai; ?>
                            </h2>
                        </div>
                    </div>
                </div>

                <div class="new-users">
                    <h2>Tanggal Selesai</h2>
                    <div class="user-list">
                        <div class="user">
                            <h2><?php echo $tglselesai; ?>
                            </h2>
                        </div>
                    </div>
                </div>
                </br>
        </main>

        <!-- Right Section -->
        <?php include('right-section.php'); ?>
        <!-- End of Right Section -->
    </div>

    <?php include('footer.php'); ?>

</body>

</html>
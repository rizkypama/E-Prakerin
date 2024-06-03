<!DOCTYPE html>
<html lang="en">
<?php session_start();
include('../../conf/cekLogin.php');
include('../../conf/config.php');
include('../../conf/cekPembimbing.php');
include('header.php')
?>

<?php
$idLaporan = $_GET['id-laporan'];
$idPemagang = $_GET['id-pemagang'];
$query = mysqli_query($koneksi, "SELECT * FROM tb_laporan_harian WHERE id='$idLaporan'");
$query1 = mysqli_query($koneksi, "SELECT * FROM tb_pemagang WHERE id='$idPemagang'");
$view = mysqli_fetch_array($query);
$view1 = mysqli_fetch_array($query1);
?>

<body>
    <?php include('preloader.php') ?>

    <div class="container">
        <?php
        $halaman = 'Laporan';
        $hal = "Laporan harian"
        ?>
        <?php include('sidebar.php'); ?>

        <!-- Main Content -->
        <main>
            <h1>Detail Laporan</h1>
            <div class="add-container back-button">
                <span class="material-icons-sharp">
                    arrow_back
                </span>
                <h3>Back</h3>
            </div>
            <div class="add-button">
                <button type="button" class="action-btn" id="action-btn" data-id="<?= $_GET['id-laporan'] ?>">
                    Actions
                </button>
            </div>
            <div class="new-users">
                <h2>Nama</h2>
                <div class="user-list">
                    <div class="user">
                        <h2>
                            <?php echo $view1['nama'] ?>
                        </h2>
                    </div>
                </div>
            </div>
            <div class="new-users">
                <h2>Nama Kegiatan</h2>
                <div class="user-list">
                    <div class="user">
                        <h2><?php echo $view['nama_kegiatan'] ?>
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

    <script>
        document.getElementById('action-btn').addEventListener('click', function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Apakah mau ditolak atau diterima?',
                icon: 'question',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: 'Terima',
                denyButtonText: 'Tolak',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire('Diterima!', '', 'success');

                    $.ajax({
                        url: '../update/update_status-laporan.php',
                        type: 'POST',
                        data: {
                            'id': id,
                            'status': 'disetujui'
                        },
                        success: function(data) {
                            console.log(data);
                        }
                    });
                } else if (result.isDenied) {
                    Swal.fire('Ditolak!', '', 'warning')
                    $.ajax({
                        url: '../update/update_status-laporan.php',
                        type: 'POST',
                        data: {
                            'id': id,
                            'status': 'ditolak'
                        },
                        success: function(data) {
                            console.log(data);
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>
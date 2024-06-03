<!DOCTYPE html>
<html lang="en">
<?php session_start();
include('../../conf/cekLogin.php');
include('../../conf/config.php');
include('../../conf/cekPembimbing.php');
include('header.php')
?>

<?php 
$id_pemagang = $_GET['id']; 
$queryNama = mysqli_query($koneksi, "SELECT nama FROM tb_pemagang WHERE id='$id_pemagang'");
$view = mysqli_fetch_array($queryNama);
?>

<body>
    <?php include('preloader.php') ?>

    <div class="container">
        <?php 
        $halaman = 'Laporan';
        $hal = "Laporan akhir" 
        ?>
        <?php include('sidebar.php'); ?>

        <style>
            #example1>tbody>tr>td:nth-child(5) {
                text-align: center;
            }
        </style>

        <!-- Main Content -->
        <main>
            <h1>Laporan</h1>
            <div class="recent-orders">
                <h2>Detail Laporan Peserta</h2>
                <div class="add-container back-button">
                    <span class="material-icons-sharp">
                        arrow_back
                    </span>
                    <h3>Back</h3>
                </div>
                <div class="add-button">
                    <button type="button" class="action-btn" id="action-btn">
                        Cetak
                    </button>
                </div>
                <div class="new-users">
                    <div class="user-list">
                        <div class="user">
                            <h2 style="margin-bottom:0;"><?php echo $view['nama']; ?>
                            </h2>
                        </div>
                    </div>
                </div>
                </br>
                <table id="example1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Kegiatan</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 0;
                        $query = mysqli_query($koneksi, "SELECT * FROM tb_laporan_harian WHERE id_pemagang='$id_pemagang' ORDER BY created_at DESC");
                        while ($row = mysqli_fetch_array($query)) {
                            $no++;
                            $rowClass = $no <= 5 ? 'first-five-row' : 'remaining-row';

                        ?>
                            <tr class="<?= $rowClass ?>">
                                <td><?php echo $no; ?></td>
                                <td><?php echo $row['created_at'] ?></td>
                                <td><?php echo $row['nama_kegiatan']; ?></td>
                                <td><span class="badge bg <?= ($row['status'] == 'proses' ? 'warning' : ($row['status'] == 'disetujui' ? 'success' : 'danger')); ?>"><?php echo $row['status']; ?></span></td>
                                <td>
                                    <a href="detail_laporan-pemagang.php?id-laporan=<?= $row['id']; ?>&id-pemagang=<?= $row['id_pemagang'] ?>">
                                        <span class="material-icons-sharp">
                                            info
                                        </span>
                                    </a>
                                </td>
                                <td>
                                    <span class="material-icons-sharp danger delete-task" data-task-id="<?php echo $row['id']; ?>">
                                        delete
                                    </span>
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
        const deleteTaskIcons = document.querySelectorAll('.delete-task');

        deleteTaskIcons.forEach(icon => {
            icon.addEventListener('click', function() {
                const taskId = icon.getAttribute('data-task-id');
                confirmDelete(taskId);
            });
        });

        function confirmDelete(taskId) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data akan dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    const deleteUrl = `../delete/hapus_data.php?method=laporan_delete&id=${taskId}`;
                    fetch(deleteUrl)
                        .then(response => {
                            if (response.ok) {
                                location.reload();
                            } else {
                                console.error('Error deleting task');
                            }
                        })
                        .catch(error => {
                            console.error('Error deleting task', error);
                        });
                }
            });
        }
    </script>

    <script>
        document.getElementById('action-btn').addEventListener('click', function() {
            var id = this.getAttribute('data-id');
            window.location.href = "../export/cetak-laporan-akhir.php?id-pemagang=<?= $id_pemagang ?>";
        });
    </script>
</body>

</html>
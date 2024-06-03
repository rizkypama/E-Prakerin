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
        <?php $hal = "Laporan Harian" ?>
        <?php include('sidebar.php'); ?>

        <style>
            #example1>tbody>tr>td:nth-child(5) {
                text-align: center;
            }
        </style>

        <!-- Main Content -->
        <main>
            <h1>Laporan Harian</h1>
            <div class="recent-orders">
                <h2>Semua Laporan</h2>
                <div class="add-button">
                    <button type="button" class="action-btn" id="action-btn">
                        Cetak
                    </button>
                    <div tabindex="0" class="plusButton">
                        <svg class="plusIcon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
                            <g mask="url(#mask0_21_345)">
                                <path d="M13.75 23.75V16.25H6.25V13.75H13.75V6.25H16.25V13.75H23.75V16.25H16.25V23.75H13.75Z"></path>
                            </g>
                        </svg>
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
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 0;
                        $query = mysqli_query($koneksi, "SELECT * FROM tb_laporan_harian WHERE id_pemagang='{$_SESSION['id_pemagang']}' ORDER BY created_at DESC");
                        while ($row = mysqli_fetch_array($query)) {
                            $no++;
                            $rowClass = $no <= 5 ? 'first-five-row' : 'remaining-row';
                            $created_at = $row['created_at'];
                            $timestamp = strtotime($created_at);
                            $created_at = date('d-m-Y', $timestamp);
                        ?>
                            <tr class="<?= $rowClass ?>">
                                <td><?php echo $no; ?></td>
                                <td><?php echo $created_at; ?></td>
                                <td><?php echo $row['nama_kegiatan']; ?></td>
                                <td><span class="badge bg <?= ($row['status'] == 'proses' ? 'warning' : ($row['status'] == 'disetujui' ? 'success' : 'danger')); ?>"><?php echo $row['status']; ?></span></td>
                                <td>
                                    <span class="material-icons-sharp danger delete-task" data-task-id="<?php echo $row['id']; ?>">
                                        delete
                                    </span>
                                </td>
                                <td>
                                    <a href="detail_laporan-harian.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-outline-info">
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

    <!-- Start of Modal -->
    <div class="modal">
        <div class="modal-content">
            <h2 class="modal-title">Tambah Laporan Baru</h2>
            <span class="close-button">&times;</span>
            <form method="post" action="../add/tambah_laporan.php" enctype="multipart/form-data">
                <label for="nama_pembimbing">Nama Pembimbing:</label>
                <select id="nama_pembimbing" name="nama_pembimbing" class="js-example-basic-multiple" name="states[]" required>
                    <option value="" disabled selected>Pilih Pembimbing</option>
                    <?php $query = mysqli_query($koneksi, "SELECT * FROM tb_pembimbing"); ?>
                    <?php while ($row = mysqli_fetch_array($query)) { ?>
                        <option value="<?= $row['id']; ?>"><?= $row['nama_pembimbing']; ?></option>
                    <?php } ?>
                </select>

                <label for="nama">Nama Kegiatan:</label>
                <input type="text" id="nama" name="namakegiatan" required>

                <label for=" textArea">Deskripsi Kegiatan:</label>
                <textarea id="textArea" name="deskripsi" rows="4" required></textarea>

                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
    <!-- End of Modal -->

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
            window.location.href = "../export/cetak-laporan-akhir.php?id-pemagang=<?= $_SESSION['id_pemagang'] ?>";
        });
    </script>
</body>

</html>
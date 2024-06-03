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
        <?php $hal = "Tugas" ?>
        <?php include('sidebar.php'); ?>

        <!-- Main Content -->
        <main>
            <h1>Tugas</h1>
            <div class="recent-orders">
                <h2>Tugas Terbaru</h2>
                <div class="add-container">
                    <div tabindex="0" class="plusButton">
                        <svg class="plusIcon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
                            <g mask="url(#mask0_21_345)">
                                <path d="M13.75 23.75V16.25H6.25V13.75H13.75V6.25H16.25V13.75H23.75V16.25H16.25V23.75H13.75Z"></path>
                            </g>
                        </svg>
                    </div>
                </div>

                <table id="example1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama</th>
                            <th>Tugas</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 0;
                        $query = mysqli_query($koneksi, "SELECT * FROM tb_tugas WHERE id_pembimbing='{$_SESSION['id_pembimbing']}' ORDER BY created_at DESC");
                        while ($row = mysqli_fetch_array($query)) {
                            $no++;
                            $rowClass = $no <= 5 ? 'first-five-row' : 'remaining-row';

                            $query2 = mysqli_query($koneksi, "SELECT tbp.nama FROM tb_pemagang as tbp, tb_tugas as tbt WHERE tbt.id_pemagang = tbp.id");
                            $row2 = mysqli_fetch_array($query2);
                            $nama_pemagang = $row2['nama'];
                            $created_at = $row['created_at'];
                            $timestamp = strtotime($created_at);
                            $created_at = date('d-m-Y', $timestamp);
                        ?>
                            <tr class="<?= $rowClass ?>">
                                <td><?php echo $no; ?></td>
                                <td><?php echo $created_at; ?></td>
                                <td><?php echo $nama_pemagang; ?></td>
                                <td><?php echo $row['tugas']; ?></td>
                                <td><span class="badge bg <?= ($row['status'] == 'proses' ? 'warning' : ($row['status'] == 'selesai' ? 'success' : 'danger')); ?>"><?php echo $row['status']; ?></span></td>
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

    <!-- Start of Modal -->
    <div class="modal">
        <div class="modal-content">
            <h2 class="modal-title">Tugas Baru</h2>
            <span class="close-button">&times;</span>
            <form method="post" action="../add/tambah_tugas.php" enctype="multipart/form-data">
                <label for="nama">Nama Peserta Magang:</label>
                <select id="nama" name="id_pemagang" class="js-example-basic-multiple" name="states[]" required>
                    <option value="" disabled selected>Pilih Peserta Magang</option>
                    <?php $query = mysqli_query($koneksi, "SELECT * FROM tb_pemagang WHERE status = 'Aktif' AND id_pembimbing='{$_SESSION['id_pembimbing']}'"); ?>
                    <?php while ($row = mysqli_fetch_array($query)) { ?>
                        <option value="<?= $row['id']; ?>"><?= $row['nama']; ?></option>
                    <?php } ?>
                </select>

                <label for=" textArea">Tugas:</label>
                <textarea id="textArea" name="tugas" rows="4" required></textarea>

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
                    const deleteUrl = `../delete/hapus_data.php?method=tugas_delete&id=${taskId}`;
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

</body>

</html>
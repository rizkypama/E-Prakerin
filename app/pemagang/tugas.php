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
                <style>
                    @media (max-width: 768px) {

                        #example1 th:nth-child(3),
                        #example1 td:nth-child(3) {
                            display: none;
                        }
                    }
                </style>
                <table id="example1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Pembimbing</th>
                            <th>Tugas</th>
                            <th>Status</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 0;
                        $query = mysqli_query($koneksi, "SELECT * FROM tb_tugas WHERE id_pemagang='{$_SESSION['id_pemagang']}' ORDER BY created_at DESC");
                        while ($row = mysqli_fetch_array($query)) {
                            $no++;
                            $rowClass = $no <= 5 ? 'first-five-row' : 'remaining-row';
                            $created_at = $row['created_at'];
                            $timestamp = strtotime($created_at);
                            $created_at = date('d-m-Y', $timestamp);

                            $query2 = mysqli_query($koneksi, "SELECT tbp.nama_pembimbing FROM tb_pembimbing as tbp, tb_tugas as tbt WHERE tbt.id_pembimbing = tbp.id");
                            $row2 = mysqli_fetch_array($query2);
                            $namaPembimbing = $row2['nama_pembimbing'];
                        ?>
                            <tr class="<?= $rowClass ?>">
                                <td><?php echo $no; ?></td>
                                <td><?php echo $created_at; ?></td>
                                <td><?php echo $namaPembimbing; ?></td>
                                <td><?php echo $row['tugas']; ?></td>
                                <td><span class="badge bg <?= ($row['status'] == 'proses' ? 'warning' : ($row['status'] == 'selesai' ? 'success' : 'danger')); ?>"><?php echo $row['status']; ?></span></td>
                                <td>
                                    <span class="material-icons-sharp warning edit-task" data-task-id="<?php echo $row['id']; ?>">
                                        edit
                                    </span>
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

    <!-- Start of Modal -->
    <div class="modal">
        <div class="modal-content">
            <h2 class="modal-title">Tugas Baru</h2>
            <span class="close-button">&times;</span>
            <form method="post" action="../add/tambah_tugas.php" enctype="multipart/form-data">
                <label for="nama">Nama Pembimbing:</label>
                <select id="nama" name="id_pembimbing" class="js-example-basic-multiple" name="states[]" required>
                    <option value="" disabled selected>Pilih Pembimbing</option>
                    <?php $query = mysqli_query($koneksi, "SELECT * FROM tb_pembimbing"); ?>
                    <?php while ($row = mysqli_fetch_array($query)) { ?>
                        <option value="<?= $row['id']; ?>"><?= $row['nama_pembimbing']; ?></option>
                    <?php } ?>
                </select>

                <label for=" textArea">Tugas:</label>
                <textarea id="textArea" name="tugas" rows="4" required></textarea>

                <button type="submit">Submit</button>
            </form>
        </div>
    </div>

    <div class="edit-modal">
        <div class="modal-content">
            <h2 class="modal-title">Tugas Baru</h2>
            <span class="close-button">&times;</span>
            <form method="post" action="../edit/edit_tugas.php">
                <label for="status">Status:</label>
                <select id="status" name="status" required>
                    <option value="" disabled selected>Status</option>
                    <option value="selesai">Selesai</option>
                    <option value="proses">Proses</option>
                </select>
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
    <!-- End of Modal -->

    <?php include('footer.php'); ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editModal = document.querySelector('.edit-modal');
            const editSpan = document.querySelector('.material-icons-sharp.warning');
            const editModalCloseButton = editModal.querySelector('.close-button');

            function openEditModal() {
                editModal.style.display = 'block';
            }

            function closeEditModal() {
                editModal.style.display = 'none';
            }

            const editSpans = document.querySelectorAll('.edit-task');

            editSpans.forEach((editSpan) => {
                editSpan.addEventListener('click', function() {
                    const taskId = editSpan.getAttribute('data-task-id');
                    const idInput = editModal.querySelector('input[name="id"]');
                    idInput.value = taskId;
                    openEditModal();
                });
            });

            editModalCloseButton.addEventListener('click', closeEditModal);

            window.addEventListener('click', function(event) {
                if (event.target === editModal) {
                    closeEditModal();
                }
            });
        });
    </script>

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
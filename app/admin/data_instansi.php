<!DOCTYPE html>
<html lang="en">
<?php session_start();
include('../../conf/cekLogin.php');
include('../../conf/config.php');
include('../../conf/cekAdmin.php');
include('header.php')
?>

<body>
    <?php include('preloader.php') ?>

    <div class="container">
        <?php $hal = "Perguruan Tinggi/Sekolah" ?>
        <?php include('sidebar.php'); ?>

        <!-- Main Content -->
        <main>
            <h1>Perguruan Tinggi/Sekolah</h1>
            <div class="recent-orders">
                <h2>Daftar Perguruan Tinggi/Sekolah</h2>
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
                            <th>Perguruan Tinggi/Sekolah</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 0;
                        $query = mysqli_query($koneksi, "SELECT id, instansi FROM tb_instansi");
                        while ($row = mysqli_fetch_array($query)) {
                            $no++;
                            $rowClass = $no <= 5 ? 'first-five-row' : 'remaining-row';

                        ?>
                            <tr class="<?= $rowClass ?>">
                                <td>
                                    <?php echo $no; ?>
                                </td>
                                <td>
                                    <?php
                                    echo $row['instansi'];
                                    ?>
                                </td>
                                <td>
                                    <span class="material-icons-sharp warning edit-task" data-task-id="<?php echo $row['id']; ?>" data-nama-instansi="<?php echo $row['instansi']; ?>">
                                        edit
                                    </span>
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
            <h2 class="modal-title">Tambah Perguruan Tinggi/Sekolah Baru</h2>
            <span class="close-button">&times;</span>
            <form method="post" action="../add/tambah_instansi.php?" enctype="multipart/form-data">
                <label for="instansi">Nama Perguruan Tinggi/Sekolah:</label>
                <input type="text" id="instansi" name="instansi" required>
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>

    <div class="edit-modal">
        <div class="modal-content">
            <h2 class="modal-title">Edit Nama Perguruan Tinggi/Sekolah</h2>
            <span class="close-button">&times;</span>
            <form method="get" action="../edit/edit_instansi.php">
                <label for="nama_instansi">Nama Perguruan Tinggi/Sekolah:</label>
                <input type="text" id="edit_nama_instansi" name="nama_instansi" autocomplete="off" required>
                <input type="hidden" name="id" value="">
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
            const editNamaInstansiInput = editModal.querySelector('#edit_nama_instansi');
            const editIcons = document.querySelectorAll('.edit-task');

            editIcons.forEach(icon => {
                icon.addEventListener('click', function() {
                    const id = this.getAttribute('data-task-id');
                    const namaInstansi = this.getAttribute('data-nama-instansi');

                    editNamaInstansiInput.value = namaInstansi;
                    editModal.querySelector('[name="id"]').value = id;

                    editModal.style.display = 'block';
                });
            });

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
                    const deleteUrl = `../delete/hapus_data.php?method=instansi_delete&id=${taskId}`;
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
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
        <?php $hal = "Dashboard Pemagang" ?>
        <?php include('sidebar.php'); ?>

        <!-- Main Content -->
        <main>
            <h1>Dashboard</h1>

            <?php date_default_timezone_set("Asia/Jakarta"); ?>

            <div class="button-container">
                <div class="text-container">
                    <h3 id="date_time"></h3>
                </div>
                <div class="buttons">
                    <?php

                    $date = date('d');
                    $hours = date('d-m-Y H:i:s');
                    $hoursNow = date('H');
                    $test = date(18);

                    $query = mysqli_query($koneksi, "SELECT * FROM tb_presensi WHERE tgl = CURDATE() AND id_pemagang = '{$_SESSION['id_pemagang']}' AND jam_masuk != '00:00:00'");
                    $query1 = mysqli_query($koneksi, "SELECT * FROM tb_presensi WHERE tgl = CURDATE() AND id_pemagang = '{$_SESSION['id_pemagang']}' AND jam_pulang != '00:00:00'");

                    $new_hours = date('H', strtotime($hours));
                    $new_hours1 = date('H', strtotime('+2 hours', strtotime($hours)));

                    $count = mysqli_num_rows($query);
                    $count1 = mysqli_num_rows($query1);
                    ?>

                    <?php $disableButtons = $_SESSION['status'] !== 'Aktif'; ?>
                    <button class="Btn" id="confirmMasuk" <?php echo $count > 0 ? 'disabled' : ''; ?> <?php echo $disableButtons ? 'disabled' : ''; ?>>
                        <div class="sign"><svg viewBox="0 0 512 512">
                                <path d="M217.9 105.9L340.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L217.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1L32 320c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM352 416l64 0c17.7 0 32-14.3 32-32l0-256c0-17.7-14.3-32-32-32l-64 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l64 0c53 0 96 43 96 96l0 256c0 53-43 96-96 96l-64 0c-17.7 0-32-14.3-32-32s14.3-32 32-32z"></path>
                            </svg>
                        </div>
                        <div class="text" style="color: var(--color-white) !important;">Masuk</div>
                    </button>

                    <button class="Btn_out" id="confirmKeluar" <?php echo $count1 > 0 ? 'disabled' : ''; ?> <?php echo $disableButtons ? 'disabled' : ''; ?>>
                        <div class="sign">
                            <svg viewBox="0 0 512 512">
                                <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z">
                                </path>
                            </svg>
                        </div>
                        <div class="text" style="color: var(--color-white) !important;">Pulang</div>
                    </button>
                </div>
            </div>
            <div class="recent-orders">
                <h2>Laporan Harian</h2>
            </div>
            <div class="analyse">
                <div class="pemagang">
                    <div class="status">
                        <div class="info">
                            <h3>Disetujui</h3>
                            <?php
                            $query = mysqli_query($koneksi, "SELECT * FROM tb_laporan_harian WHERE status = 'disetujui' AND id_pemagang = '$_SESSION[id_pemagang]'");
                            $jumlahDisetujui = mysqli_num_rows($query);
                            ?>
                            <h1><?= $jumlahDisetujui ?></h1>
                        </div>
                        <span class="material-icons-sharp">
                            check_circle_outline
                        </span>
                    </div>
                </div>
                <div class="visits">
                    <div class="status">
                        <div class="info">
                            <h3>Ditolak</h3>
                            <?php
                            $query = mysqli_query($koneksi, "SELECT * FROM tb_laporan_harian WHERE status = 'ditolak' AND id_pemagang = '$_SESSION[id_pemagang]'");
                            $jumlahDitolak = mysqli_num_rows($query);
                            ?>
                            <h1><?= $jumlahDitolak ?></h1>
                        </div>
                        <span class="material-icons-outlined">
                            do_not_disturb_on
                        </span>
                    </div>
                </div>
                <div class="searches">
                    <div class="status">
                        <div class="info">
                            <h3>Diproses</h3>
                            <?php
                            $query = mysqli_query($koneksi, "SELECT * FROM tb_laporan_harian WHERE status = 'proses' AND id_pemagang = '$_SESSION[id_pemagang]'");
                            $jumlahDiproses = mysqli_num_rows($query);
                            ?>
                            <h1><?= $jumlahDiproses ?></h1>
                        </div>
                        <span class="material-icons-sharp">
                            timer
                        </span>
                    </div>
                </div>
            </div>
            <div class="new-users">
                <h2>Calon Peserta Magang</h2>
                <div class="user-list">
                    <?php
                    $query = mysqli_query($koneksi, "SELECT nama, id_users, instansi, created_at FROM tb_pemagang WHERE status='pending' ORDER BY created_at ASC LIMIT 4");
                    $num_rows = mysqli_num_rows($query);

                    if ($num_rows > 0) {
                        while ($row = mysqli_fetch_assoc($query)) {
                            $nama = $row['nama'];
                            $nama_parts = explode(' ', $nama, 2);
                            $nama = $nama_parts[0];
                    ?>
                            <div class="user">
                                <?php
                                $userId2 = $row['id_users'];
                                $query2 = mysqli_query($koneksi, "SELECT profile_picture FROM tb_users WHERE id=$userId2");
                                $row2 = mysqli_fetch_array($query2);
                                $profilePic = "../../images/profile_pics/" . $row2['profile_picture'];
                                $created_at = $row['created_at'];
                                $timestamp = strtotime($created_at);
                                $created_at = date('d-m-Y', $timestamp);
                                ?>
                                <img src="<?php echo $profilePic ?>" alt="User Image">
                                <h2><?php echo $nama; ?></h2>
                                <p class="truncate-text">
                                    <?php
                                    $sentence = $row['instansi'];
                                    $split = substr($sentence, 0, 20) . '...';
                                    $words = str_word_count($sentence, 1);

                                    if (strlen($sentence) > 5) {
                                        echo $split;
                                    } else {
                                        echo $sentence;
                                    }
                                    ?>
                                </p>
                                <p><?php echo $created_at; ?></p>
                            </div>
                    <?php
                        }
                    } else {
                        echo '<div class="user">';
                        echo '<h2>Tidak ada peserta magang baru</h2>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
            <?php if ($_SESSION['status'] === 'Aktif') : ?>
                <div class="recent-orders">
                    <h2>Tugas Terbaru</h2>
                    <table id="example1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Pembimbing</th>
                                <th>Tugas</th>
                                <th>Status</th>
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
            <?php endif; ?>
            </br>

        </main>
        <!-- End of Main Content -->

        <!-- Right Section -->
        <?php include('right-section.php'); ?>
        <!-- End of Right Section -->

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

    <script>
        // Check-in
        document.getElementById('confirmMasuk').addEventListener('click', function() {
            Swal.fire({
                icon: 'warning',
                title: 'Apakah Kamu Yakin?',
                text: 'Presensi hanya dapat dilakukan sekali setiap hari.',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    const xhr = new XMLHttpRequest();
                    xhr.open('GET', '../add/jam_masuk.php', true);
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === XMLHttpRequest.DONE) {
                            if (xhr.status === 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Sukses!',
                                    text: 'Anda berhasil melakukan presensi.',
                                    timer: 2000
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'You have already confirmed your attendance today.',
                                });
                            }
                        }
                    };
                    xhr.send();
                }
            });
        });
        // Check-out
        document.getElementById('confirmKeluar').addEventListener('click', function() {
            Swal.fire({
                icon: 'warning',
                title: 'Apakah Kamu Yakin?',
                text: 'Presensi hanya dapat dilakukan sekali setiap hari.',
                showCancelButton: true,
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Yes',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    const xhr = new XMLHttpRequest();
                    xhr.open('GET', '../add/jam_pulang.php', true);
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === XMLHttpRequest.DONE) {
                            if (xhr.status === 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Suskes!',
                                    text: 'Anda berhasil melakukan presensi.',
                                    timer: 2000
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'You have already confirmed your attendance today.',
                                });
                            }
                        }
                    };
                    xhr.send();
                }
            });
        });
    </script>
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

    <?php include('footer.php'); ?>

    <!-- Date -->
    <script type="text/javascript">
        function date_time(id) {
            date = new Date;
            year = date.getFullYear();
            month = date.getMonth();
            months = new Array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
            d = date.getDate();
            day = date.getDay();
            days = new Array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
            h = date.getHours();
            if (h < 10) {
                h = "0" + h;
            }
            m = date.getMinutes();
            if (m < 10) {
                m = "0" + m;
            }
            s = date.getSeconds();
            if (s < 10) {
                s = "0" + s;
            }
            result = '' + days[day] + ' ' + d + ' ' + months[month] + ' ' + year + ' ' + h + ':' + m + ':' + s;
            document.getElementById(id).innerHTML = result;
            setTimeout('date_time("' + id + '");', '1000');
            return true;
        }
    </script>

    <!-- Date -->
    <script type="text/javascript">
        window.onload = date_time('date_time');
    </script>

</body>

</html>
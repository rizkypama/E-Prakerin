<!DOCTYPE html>
<html lang="en">
<?php session_start();
include('../../conf/cekLogin.php');
include('../../conf/config.php');
include('../../conf/cekAdmin.php');
include('header.php');
?>

<body>
    <?php include('preloader.php') ?>

    <div class="container">
        <?php $hal = "Dashboard Pemagang" ?>
        <?php include('sidebar.php'); ?>

        <!-- Main Content -->
        <main>
            <h1>Dashboard</h1>
            <div class="recent-orders">
                <h2>Informasi</h2>
            </div>
            <?php date_default_timezone_set("Asia/Jakarta"); ?>
            <div class="button-container">
                <div class="text-container">
                    <h3 id="date_time"></h3>
                </div>
            </div>
            <div class="analyse">
                <div class="pemagang pemagang-link">
                    <div class="status">
                        <div class="info">
                            <h3>Peserta</h3>
                            <?php
                            $query = mysqli_query($koneksi, "SELECT * FROM tb_pemagang WHERE status = 'Aktif'");
                            $jumlahPemagang = mysqli_num_rows($query);
                            ?>
                            <h1><?= $jumlahPemagang ?></h1>
                        </div>
                        <span class="material-icons-sharp">
                            groups
                        </span>
                    </div>
                </div>
                <div class="visits visits-link">
                    <div class="status">
                        <div class="info">
                            <h3>Pembimbing</h3>
                            <?php
                            $query = mysqli_query($koneksi, "SELECT * FROM tb_pembimbing");
                            $jumlahPembimbing = mysqli_num_rows($query);
                            ?>
                            <h1><?= $jumlahPembimbing ?></h1>
                        </div>
                        <span class="material-icons-sharp">
                            supervisor_account
                        </span>
                    </div>
                </div>
                <div class="searches searches-link">
                    <div class="status">
                        <div class="info">
                            <h3>Perguruan Tinggi/Sekolah</h3>
                            <?php
                            $query = mysqli_query($koneksi, "SELECT * FROM tb_instansi");
                            $jumlahInstansi = mysqli_num_rows($query);
                            ?>
                            <h1><?= $jumlahInstansi ?></h1>
                        </div>
                        <span class="material-icons-sharp">
                            school
                        </span>
                    </div>
                </div>
            </div>

            <div class="new-users">
                <h2>Calon Peserta Magang</h2>
                <div class="user-list">
                    <?php
                    $query = mysqli_query($koneksi, "SELECT id, id_users, nama, instansi, created_at FROM tb_pemagang WHERE status='Pending' ORDER BY created_at ASC LIMIT 10");
                    $num_rows = mysqli_num_rows($query);

                    if ($num_rows > 0) {
                        while ($row = mysqli_fetch_assoc($query)) {
                            $nama = $row['nama'];
                            $nama_parts = explode(' ', $nama, 2);
                            $nama = $nama_parts[0];
                            $userId = $row['id'];

                            $userDetailURL = "detail_pemagang.php?id=$userId";
                    ?>
                            <a href="<?php echo $userDetailURL; ?>" class="user">
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
                            </a>
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
            </br>
        </main>
        <!-- End of Main Content -->

        <!-- Right Section -->
        <?php include('right-section.php'); ?>
        <!-- End of Right Section -->
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const pemagangLink = document.querySelector('.pemagang-link');
            pemagangLink.addEventListener('click', function(event) {
                event.preventDefault();
                window.location.href = 'data_pemagang.php';
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            const visitsLink = document.querySelector('.visits-link');
            visitsLink.addEventListener('click', function(event) {
                event.preventDefault();
                window.location.href = 'data_pembimbing.php';
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            const searchesLink = document.querySelector('.searches-link');
            searchesLink.addEventListener('click', function(event) {
                event.preventDefault();
                window.location.href = 'data_instansi.php';
            });
        });
    </script>

    <script>
        // Check-in
        document.getElementById('confirmMasuk').addEventListener('click', function() {
            Swal.fire({
                icon: 'warning',
                title: 'Are you sure?',
                text: 'This action cannot be undone.',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    const xhr = new XMLHttpRequest();
                    xhr.open('GET', '../add/jam_masuk.php', true);
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === XMLHttpRequest.DONE) {
                            if (xhr.status === 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Action Completed',
                                    text: 'The action has been completed successfully.',
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
                title: 'Are you sure?',
                text: 'This action cannot be undone.',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    const xhr = new XMLHttpRequest();
                    xhr.open('GET', '../add/jam_pulang.php', true);
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === XMLHttpRequest.DONE) {
                            if (xhr.status === 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Action Completed',
                                    text: 'The action has been completed successfully.',
                                    timer: 2000
                                });
                            } else {
                                // Error handling
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

    <?php include('footer.php'); ?>

</body>

</html>
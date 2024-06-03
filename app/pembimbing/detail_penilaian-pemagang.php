<!DOCTYPE html>
<html lang="en">
<?php session_start();
include('../../conf/cekLogin.php');
include('../../conf/config.php');
include('../../conf/cekPembimbing.php');
include('header.php')
?>

<?php
$idPenilaian = $_GET['id-penilaian'];
$idPemagang = $_GET['id-pemagang'];
$query = mysqli_query($koneksi, "SELECT * FROM tb_penilaian WHERE id='$idPenilaian'");
$view = mysqli_fetch_array($query);
$nilai = array(
    'Kedisiplinan' => $view['kedisiplinan'],
    'Kerapian' => $view['kerapian'],
    'Tanggung Jawab' => $view['tanggungjwb'],
    'Ketaatan' => $view['ketaatan'],
    'Etos Kerja' => $view['etoskerja'],
    'Kerja Sama' => $view['kerjasama'],
    'Keterampilan' => $view['keterampilan']
);


$query1 = mysqli_query($koneksi, "SELECT * FROM tb_pemagang WHERE id='$idPemagang'");
$view1 = mysqli_fetch_array($query1);
?>

<body>
    <?php include('preloader.php') ?>

    <div class="container">
        <?php $hal = "Penilaian" ?>
        <?php include('sidebar.php'); ?>

        <!-- Main Content -->
        <main>
            <h1>Penilaian</h1>
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
            <div class="recent-orders">
                <div class="new-users">
                    <h2>Nama</h2>
                    <div class="user-list">
                        <div class="user">
                            <h2><?php echo $view1['nama'] ?>
                            </h2>
                        </div>
                    </div>
                </div>

                <div class="new-users">
                    <h2>Perguruan Tinggi/Sekolah</h2>
                    <div class="user-list">
                        <div class="user">
                            <h2><?php echo $view1['instansi'] ?>
                            </h2>
                        </div>
                    </div>
                </div>

                <div class="new-users">
                    <h2>Fakultas</h2>
                    <div class="user-list">
                        <div class="user">
                            <h2><?php echo $view1['fakultas'] ?>
                            </h2>
                        </div>
                    </div>
                </div>

                <div class="new-users">
                    <h2>Jurusan</h2>
                    <div class="user-list">
                        <div class="user">
                            <h2><?php echo $view1['jurusan'] ?>
                            </h2>
                        </div>
                    </div>
                </div>

                <div class="new-users">
                    <h2>NIM</h2>
                    <div class="user-list">
                        <div class="user">
                            <h2><?php echo $view1['nim'] ?>
                            </h2>
                        </div>
                    </div>
                </div>

                <div class="new-users" style="display:flex; gap:2rem;">
                    <h2>Penilaian
                    </h2>
                    <span class="material-icons-sharp warning" id="openModal">
                        edit
                    </span>
                </div>

                <table id="example1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Indikator</th>
                            <th>Nilai</th>
                            <th>Huruf</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Loop through the $nilai array and display the values and 'Huruf'
                        $no = 0;
                        foreach ($nilai as $indikator => $value) {
                            $no++;
                            $huruf = '';

                            if ($value > 85) {
                                $huruf = 'A';
                            } elseif ($value >= 70 && $value <= 84.9) {
                                $huruf = 'B';
                            } elseif ($value >= 55 && $value <= 69.9) {
                                $huruf = 'C';
                            } elseif ($value >= 40 && $value <= 54.9) {
                                $huruf = 'D';
                            } else {
                                $huruf = 'E';
                            }

                            echo '<tr>';
                            echo '<td>' . $no . '</td>';
                            echo '<td>' . $indikator . '</td>';
                            echo '<td>' . $value . '</td>';
                            echo '<td>' . $huruf . '</td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="new-users">
                <h2>Feedback</h2>
                <div class="user-list">
                    <div class="user">
                        <h2><?php echo $view['feedback'] ?>
                        </h2>
                    </div>
                </div>
            </div>
            </br>
        </main>
        <!-- End of Main Content -->

        <!-- Right Section -->
        <?php include('right-section.php'); ?>
        <!-- End of Right Section -->
    </div>

    <!-- Start of Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <h2 class="modal-title">Edit Penilaian</h2>
            <span class="close-penilaian-button">&times;</span>
            <form method="post" action="../edit/edit_penilaian.php" enctype="multipart/form-data">
                <input type="text" id="id_penilaian" name="id_penilaian" placeholder="<?php $idPenilaian ?>" value="<?php echo $idPenilaian ?>" hidden>
                <input type="text" id="id_pemagang" name="id_pemagang" placeholder="<?php $idPemagang ?>" value="<?php echo $idPemagang ?>" hidden>
                <label for="nama">Nama Peserta Magang:</label>
                <input type="text" id="nama" name="nama" value="<?php echo $view1['nama'] ?>" readonly>
                <label for="kedisiplinan">Kedisiplinan:</label>
                <input type="number" id="kedisiplinan" name="kedisiplinan" value="<?php echo $view['kedisiplinan']; ?>" required min="0" max="100" oninvalid="this.setCustomValidity('Nilai harus kurang dari atau sama dengan 100')">
                <label for="kerapian">Kerapian:</label>
                <input type="number" id="kerapian" name="kerapian" value="<?php echo $view['kerapian']; ?>" required min="0" max="100" oninvalid="this.setCustomValidity('Nilai harus kurang dari atau sama dengan 100')">
                <label for="tanggungjwb">Tanggung Jawab:</label>
                <input type="number" id="tanggungjwb" name="tanggungjwb" value="<?php echo $view['tanggungjwb']; ?>" required min="0" max="100" oninvalid="this.setCustomValidity('Nilai harus kurang dari atau sama dengan 100')">
                <label for="ketaatan">Ketaatan:</label>
                <input type="number" id="ketaatan" name="ketaatan" value="<?php echo $view['ketaatan']; ?>" required min="0" max="100" oninvalid="this.setCustomValidity('Nilai harus kurang dari atau sama dengan 100')">
                <label for="etoskerja">Etos Kerja:</label>
                <input type="number" id="etoskerja" name="etoskerja" value="<?php echo $view['etoskerja']; ?>" required min="0" max="100" oninvalid="this.setCustomValidity('Nilai harus kurang dari atau sama dengan 100')">
                <label for="kerjasama">Kerja Sama:</label>
                <input type="number" id="kerjasama" name="kerjasama" value="<?php echo $view['kerjasama']; ?>" required min="0" max="100" oninvalid="this.setCustomValidity('Nilai harus kurang dari atau sama dengan 100')">
                <label for="keterampilan">Keterampilan:</label>
                <input type="number" id="keterampilan" name="keterampilan" value="<?php echo $view['keterampilan']; ?>" required min="0" max="100" oninvalid="this.setCustomValidity('Nilai harus kurang dari atau sama dengan 100')">
                <label for=" textArea">Feedback:</label>
                <textarea id="textArea" name="feedback" rows="4"><?php echo $view['feedback'] ?></textarea>

                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
    <!-- End of Modal -->

    <?php
    if (isset($_GET['error'])) {
        $alert = ($_GET['error']);
        if ($alert == 1) {
            echo "
    <script>
    setTimeout(function() {
        Swal.fire({
            title: 'Ubah Data Gagal',
            text: 'Silahkan coba lagi!',
            icon: 'error',
            confirmButtonText: 'OK'
          })
    }, 1200);
    
    </script>";
        } else {
            echo "";
        }
    }

    if (isset($_GET['success'])) {
        $alert = ($_GET['success']);
        if ($alert == 1) {
            echo "
    <script>
    setTimeout(function() {
        Swal.fire({
            title: 'Ubah Data Berhasil',
            text: 'Data berhasil diubah!',
            icon: 'success',
            confirmButtonText: 'OK'
          })
    }, 1200);
    </script>";
        } else {
            echo "";
        }
    }
    ?>

    <script>
        var modal = document.getElementById("myModal");
        var span = document.getElementById("openModal");
        const closePenilaianModal = document.getElementsByClassName('close-penilaian-button')[0];

        closePenilaianModal.addEventListener('click', () => {
            modal.style.display = 'none';
        });

        span.onclick = function() {
            modal.style.display = "block";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>

    <?php include('footer.php'); ?>

    <script>
        document.getElementById('action-btn').addEventListener('click', function() {
            var id = this.getAttribute('data-id');
            window.location.href = '../export/cetak-penilaian-pemagang.php?id-penilaian=<?= $view['id']; ?>&id-pemagang=<?= $view['id_pemagang'] ?>';
        });
    </script>

</body>

</html>
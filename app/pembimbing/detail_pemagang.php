<!DOCTYPE html>
<html lang="en">
<?php session_start();
include('../../conf/cekLogin.php');
include('../../conf/config.php');
include('../../conf/cekPembimbing.php');
include('header.php')
?>

<?php
$id = $_GET['id'];
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
        <?php $hal = "Pemagang" ?>
        <?php include('sidebar.php'); ?>

        <main>
            <h1>Detail Pemagang</h1>
            <div class="add-container back-button">
                <span class="material-icons-sharp">
                    arrow_back
                </span>
                <h3>Back</h3>
            </div>
            <div class="add-button">
                <button type="button" class="action-btn" id="action-btn" data-id="<?= $id ?>">
                    Actions
                </button>
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

                <div class="new-users">
                    <h2>Nama Pembimbing</h2>
                    <div id="editPembimbingModalTrigger" class="user-list">
                        <div class="user">
                            <h2><?php
                                $id_pembimbing = $view['id_pembimbing'];
                                $query2 = mysqli_query($koneksi, "SELECT nama_pembimbing FROM tb_pembimbing WHERE id = '$id_pembimbing'");
                                $view2 = mysqli_fetch_assoc($query2);
                                echo $view2['nama_pembimbing'] ?>
                            </h2>
                        </div>
                    </div>
                </div>

                <div class="new-users">
                    <h2>Divisi</h2>
                    <div id="editDivisiModalTrigger" class="user-list">
                        <div class="user">
                            <h2><?php
                                $id_divisi = $view['id_divisi'];
                                $query2 = mysqli_query($koneksi, "SELECT nama_divisi FROM tb_divisi WHERE id = '$id_divisi'");
                                $view2 = mysqli_fetch_assoc($query2);
                                echo $view2['nama_divisi'] ?>
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

    <!-- Start of Modal -->
    <div class="edit-pembimbing-modal" id="editPembimbingModal">
        <div class="modal-content">
            <h2 class="modal-title">Ubah Pembimbing</h2>
            <span class="close-pembimbing-button">&times;</span>
            <form method="post" action="../edit/edit_pembimbing.php" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $id ?>">
                <label for="nama_pembimbing">Nama Pembimbing:</label>
                <select id="nama_pembimbing" name="id_pembimbing" class="js-example-basic-multiple" name="states[]" required>
                    <option value="" disabled selected>Pilih Pembimbing</option>
                    <?php $query = mysqli_query($koneksi, "SELECT * FROM tb_pembimbing"); ?>
                    <?php while ($row = mysqli_fetch_array($query)) { ?>
                        <option value="<?= $row['id']; ?>"><?= $row['nama_pembimbing']; ?></option>
                    <?php } ?>
                </select>
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>

    <div class="edit-divisi-modal" id="editDivisiModal">
        <div class="modal-content">
            <h2 class="modal-title">Ubah Divisi Pemagang</h2>
            <span class="close-divisi-button">&times;</span>
            <form method="post" action="../edit/edit_divisi-pemagang.php" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $id ?>">
                <label for="nama_divisi">Nama divisi:</label>
                <select id="nama_divisi" name="id_divisi" class="js-example-basic-multiple" name="states[]" required>
                    <option value="" disabled selected>Pilih Divisi</option>
                    <?php $query = mysqli_query($koneksi, "SELECT * FROM tb_divisi"); ?>
                    <?php while ($row = mysqli_fetch_array($query)) { ?>
                        <option value="<?= $row['id']; ?>"><?= $row['nama_divisi']; ?></option>
                    <?php } ?>
                </select>
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
    <!-- End of Modal -->

    <?php include('footer.php'); ?>

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
        const editPembimbingModalTrigger = document.getElementById('editPembimbingModalTrigger');
        const editPembimbingModal = document.getElementById('editPembimbingModal');
        const closePembimbingModal = document.getElementsByClassName('close-pembimbing-button')[0];

        editPembimbingModalTrigger.addEventListener('click', () => {
            editPembimbingModal.style.display = 'block';
        });

        closePembimbingModal.addEventListener('click', () => {
            editPembimbingModal.style.display = 'none';
        });

        window.addEventListener('click', (event) => {
            if (event.target === editPembimbingModal) {
                editPembimbingModal.style.display = 'none';
            }
        });
    </script>

<script>
        const editDivisiModalTrigger = document.getElementById('editDivisiModalTrigger');
        const editDivisiModal = document.getElementById('editDivisiModal');
        const closeDivisiModal = document.getElementsByClassName('close-divisi-button')[0];

        editDivisiModalTrigger.addEventListener('click', () => {
            editDivisiModal.style.display = 'block';
        });

        closeDivisiModal.addEventListener('click', () => {
            editDivisiModal.style.display = 'none';
        });

        window.addEventListener('click', (event) => {
            if (event.target === editDivisiModal) {
                editDivisiModal.style.display = 'none';
            }
        });
    </script>

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
                        url: '../update/update_pemagang.php',
                        type: 'POST',
                        data: {
                            'id': id,
                            'status': 'Aktif'
                        },
                        success: function(data) {
                            console.log(data);
                        }
                    });
                } else if (result.isDenied) {
                    Swal.fire('Ditolak!', '', 'warning')
                    $.ajax({
                        url: '../update/update_pemagang.php',
                        type: 'POST',
                        data: {
                            'id': id,
                            'status': 'Ditolak'
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
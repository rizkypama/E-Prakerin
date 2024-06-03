<!DOCTYPE html>
<html lang="en">
<?php session_start();
include('../../conf/cekLogin.php');
include('../../conf/config.php');
include('../../conf/cekAdmin.php');
include('header.php')
?>

<?php
$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM tb_pembimbing WHERE id='$id'");
$view = mysqli_fetch_array($query);
?>

<body>
    <?php include('preloader.php') ?>

    <div class="container">
        <?php $hal = "Pembimbing" ?>
        <?php include('sidebar.php'); ?>

        <main>
            <h1>Detail Pembimbing</h1>
            <div class="add-container back-button">
                <span class="material-icons-sharp">
                    arrow_back
                </span>
                <h3>Back</h3>
            </div>
            <div class="recent-orders">
                <div class="new-users">
                    <h2>Nama</h2>
                    <div class="user-list">
                        <div class="user">
                            <h2><?php echo $view['nama_pembimbing'] ?>
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
    <div class="edit-divisi-modal" id="editDivisiModal">
        <div class="modal-content">
            <h2 class="modal-title">Ubah Divisi Pembimbing</h2>
            <span class="close-divisi-button">&times;</span>
            <form method="post" action="../edit/edit_divisi-pembimbing.php" enctype="multipart/form-data">
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

</body>

</html>
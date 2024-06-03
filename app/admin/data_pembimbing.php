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
        <?php $hal = "Pembimbing" ?>
        <?php include('sidebar.php'); ?>

        <!-- Main Content -->
        <main>
            <h1>Pembimbing</h1>
            <div class="recent-orders">
                <h2>Daftar Pembimbing</h2>

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
                            <th>Nama</th>
                            <th>Divisi</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 0;
                        $query = mysqli_query($koneksi, "SELECT tbp.id, nama_pembimbing, nama_divisi FROM tb_pembimbing as tbp, tb_divisi as tbd WHERE tbd.id = tbp.id_divisi");
                        while ($row = mysqli_fetch_array($query)) {
                            $no++;
                            $rowClass = $no <= 5 ? 'first-five-row' : 'remaining-row';

                        ?>
                            <tr class="<?= $rowClass ?>">
                                <td>
                                    <?php echo $no; ?>
                                </td>
                                <td class="truncate-text">
                                    <span class="original-text">
                                        <?php
                                        echo $row['nama_pembimbing'];
                                        ?>
                                    </span>
                                    <span class="truncated-version">
                                        <?php
                                        $sentence = $row['nama_pembimbing'];
                                        $split = substr($sentence, 0, 15) . '...';
                                        $words = str_word_count($sentence, 1);

                                        if (strlen($sentence) > 5) {
                                            echo $split;
                                        } else {
                                            echo $sentence;
                                        }
                                        ?>
                                    </span>
                                </td>
                                <td class="truncate-text">
                                    <span class="original-text">
                                        <?php
                                        echo $row['nama_divisi'];
                                        ?>
                                    </span>
                                    <span class="truncated-version">
                                        <?php
                                        $sentence = $row['nama_divisi'];
                                        $split = substr($sentence, 0, 15) . '...';
                                        $words = str_word_count($sentence, 1);

                                        if (strlen($sentence) > 5) {
                                            echo $split;
                                        } else {
                                            echo $sentence;
                                        }
                                        ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="detail_pembimbing.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-outline-info">
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
            <!-- End of Recent Orders -->
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
            <h2 class="modal-title">Pembimbing Baru</h2>
            <span class="close-button">&times;</span>
            <form method="get" action="../add/tambah_data.php">
                <input type="hidden" name="method" value="add_pembimbing">
                <label for="nama">Nama Pembimbing:</label>
                <input type="text" id="nama" name="nama" required>
                <label for="jabatan">Jabatan:</label>
                <input type="text" id="jabatan" name="jabatan" required>
                <label for="nip">NIP:</label>
                <input type="text" id="nip" name="nip" required>
                <label for="divisi">Divisi:</label>
                <select id="divisi" name="divisi" class="js-example-basic-multiple" name="states[]" required>
                    <option value="" disabled selected>Pilih Divisi</option>
                    <?php $query = mysqli_query($koneksi, "SELECT * FROM tb_divisi"); ?>
                    <?php while ($row = mysqli_fetch_array($query)) { ?>
                        <option value="<?= $row['id']; ?>"><?= $row['nama_divisi']; ?></option>
                    <?php } ?>
                </select>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" autocomplete="off" required>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" autocomplete="off" required>
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
    <!-- End of Modal -->

    <?php include('footer.php'); ?>

    <script>
        document.getElementById('action-btn').addEventListener('click', function() {
            var id = this.getAttribute('data-id');
            window.location.href = '../export/export-pembimbing.php';
        });
    </script>

</body>

</html>
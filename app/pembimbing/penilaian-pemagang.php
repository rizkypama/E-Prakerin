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
        <?php $hal = "Penilaian" ?>
        <?php include('sidebar.php'); ?>

        <!-- Main Content -->
        <main>
            <h1>Penilaian</h1>
            <div class="recent-orders">
                <h2>Penilaian Peserta</h2>
                <div class="add-container">
                    <link rel="stylesheet" href="../../style/search.css">
                    <div class="search-body">
                        <div class="search">
                            <input type="text" id="searchInput" placeholder="Cari" />
                            <div class="symbol">
                                <svg class="lens">
                                    <use xlink:href="#lens" />
                                </svg>
                            </div>
                        </div>

                        <!-- SVG -->
                        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                            <symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" id="lens">
                                <path d="M15.656,13.692l-3.257-3.229c2.087-3.079,1.261-7.252-1.845-9.321c-3.106-2.068-7.315-1.25-9.402,1.83
	s-1.261,7.252,1.845,9.32c1.123,0.748,2.446,1.146,3.799,1.142c1.273-0.016,2.515-0.39,3.583-1.076l3.257,3.229
	c0.531,0.541,1.404,0.553,1.95,0.025c0.009-0.008,0.018-0.017,0.026-0.025C16.112,15.059,16.131,14.242,15.656,13.692z M2.845,6.631
	c0.023-2.188,1.832-3.942,4.039-3.918c2.206,0.024,3.976,1.816,3.951,4.004c-0.023,2.171-1.805,3.918-3.995,3.918
	C4.622,10.623,2.833,8.831,2.845,6.631L2.845,6.631z" />
                            </symbol>
                        </svg>
                    </div>
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
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 0;
                        $query = mysqli_query($koneksi, "SELECT * FROM tb_penilaian WHERE id_pembimbing='{$_SESSION['id_pembimbing']}'");
                        while ($row = mysqli_fetch_array($query)) {
                            $no++;
                            $rowClass = $no <= 5 ? 'first-five-row' : 'remaining-row';
                            $created_at = $row['created_at'];
                            $timestamp = strtotime($created_at);
                            $created_at = date('d-m-Y', $timestamp);
                        ?>
                            <tr class="table-row <?= $rowClass ?>">
                                <td>
                                    <?php echo $no; ?>
                                </td>
                                <td>
                                    <?php echo $created_at; ?>
                                </td>
                                <td class="truncate-text">
                                    <span class="original-text">
                                        <?php
                                        $query2 = mysqli_query($koneksi, "SELECT * FROM tb_pemagang WHERE id='{$row['id_pemagang']}'");
                                        $row2 = mysqli_fetch_array($query2);
                                        echo $row2['nama'];
                                        ?>
                                    </span>
                                    <span class="truncated-version">
                                        <?php
                                        $sentence = $row2['nama'];
                                        $split = substr($sentence, 0, 20) . '...';
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
                                    <a href="../export/cetak-penilaian-pemagang.php?id-penilaian=<?= $row['id']; ?>&id-pemagang=<?= $row['id_pemagang'] ?>">
                                        <span class="material-icons-sharp primary">
                                            file_download
                                        </span>
                                    </a>
                                </td>
                                <td>
                                    <a href="detail_penilaian-pemagang.php?id-penilaian=<?= $row['id']; ?>&id-pemagang=<?= $row['id_pemagang'] ?>">
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
            <h2 class="modal-title">Penilaian Baru</h2>
            <span class="close-button">&times;</span>
            <form method="post" action="../add/tambah_penilaian.php" enctype="multipart/form-data">
                <label for="nama">Nama Peserta Magang:</label>
                <select id="nama" name="id_pemagang" class="js-example-basic-multiple" name="states[]" required>
                    <option value="" disabled selected>Pilih Peserta Magang</option>
                    <?php $query = mysqli_query($koneksi, "SELECT * FROM tb_pemagang WHERE status = 'Aktif' AND id_pembimbing='{$_SESSION['id_pembimbing']}'"); ?>
                    <?php while ($row = mysqli_fetch_array($query)) { ?>
                        <option value="<?= $row['id']; ?>"><?= $row['nama']; ?></option>
                    <?php } ?>
                </select>
                <label for="kedisiplinan">Kedisiplinan:</label>
                <input type="number" id="kedisiplinan" name="kedisiplinan" required min="0" max="100" oninvalid="this.setCustomValidity('Nilai harus kurang dari atau sama dengan 100')"> 
                <label for="kerapian">Kerapian:</label>
                <input type="number" id="kerapian" name="kerapian" required min="0" max="100" oninvalid="this.setCustomValidity('Nilai harus kurang dari atau sama dengan 100')">
                <label for="tanggungjwb">Tanggung Jawab:</label>
                <input type="number" id="tanggungjwb" name="tanggungjwb" required min="0" max="100" oninvalid="this.setCustomValidity('Nilai harus kurang dari atau sama dengan 100')">
                <label for="ketaatan">Ketaatan:</label>
                <input type="number" id="ketaatan" name="ketaatan" required min="0" max="100" oninvalid="this.setCustomValidity('Nilai harus kurang dari atau sama dengan 100')">
                <label for="etoskerja">Etos Kerja:</label>
                <input type="number" id="etoskerja" name="etoskerja" required min="0" max="100" oninvalid="this.setCustomValidity('Nilai harus kurang dari atau sama dengan 100')">
                <label for="kerjasama">Kerja Sama:</label>
                <input type="number" id="kerjasama" name="kerjasama" required min="0" max="100" oninvalid="this.setCustomValidity('Nilai harus kurang dari atau sama dengan 100')">
                <label for="keterampilan">Keterampilan:</label>
                <input type="number" id="keterampilan" name="keterampilan" required min="0" max="100" oninvalid="this.setCustomValidity('Nilai harus kurang dari atau sama dengan 100')">
                <label for=" textArea">Feedback:</label>
                <textarea id="textArea" name="feedback" rows="4" required></textarea>
                <button type="submit">Submit</button>
                <!-- <p style="display: flex; justify-content:center;" class="danger">Tidak bisa diubah!</p> -->
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
            title: 'Gagal Menambahkan Data',
            text: 'Silahkan coba lagi!',
            icon: 'error',
            confirmButtonText: 'OK'
          })
    }, 1200);
    
    </script>";
        } else if ($alert == 2) {
            echo "
    <script>
    setTimeout(function() {
        Swal.fire({
            title: 'Gagal Menambahkan Data',
            text: 'Peserta sudah dinilai, klik ikon info untuk mengubah nilai!',
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
            title: 'Berhasil Menambahkan Data',
            text: 'Data berhasil ditambahkan!',
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
        $(document).ready(function() {
            $("#searchInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $(".table-row").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });

                // Show "Show All" or "Show Less" links based on the search result count
                var visibleRows = $(".table-row:visible").length;
                if (visibleRows > 5) {
                    $(".show-all-link").show();
                    $(".show-less-link").hide();
                } else {
                    $(".show-all-link").hide();
                    $(".show-less-link").hide();
                }
            });

            $(".show-all-link").click(function() {
                $(".table-row").show();
                $(this).hide();
                $(".show-less-link").show();
            });

            $(".show-less-link").click(function() {
                $(".table-row:not(.first-five-row)").hide();
                $(this).hide();
                $(".show-all-link").show();
            });
        });
    </script>
</body>

</html>
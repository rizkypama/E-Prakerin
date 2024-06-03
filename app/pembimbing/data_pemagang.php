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
        <?php $hal = "Pemagang" ?>
        <?php include('sidebar.php'); ?>

        <!-- Main Content -->
        <main>
            <h1>Peserta Magang</h1>
            <div class="recent-orders">
                <h2>Semua Peserta</h2>
                <div class="add-button">
                    <button type="button" class="action-btn" id="action-btn">
                        Export
                    </button>
                </div>
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

                </br>

                <table id="example1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Perguruan Tinggi/Sekolah</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 0;
                        $query = mysqli_query($koneksi, "SELECT id_pembimbing, tbp.id, tbp.nama, tbp.instansi, status FROM tb_pemagang as tbp WHERE status != 'Ditolak' AND id_pembimbing='{$_SESSION['id_pembimbing']}'");
                        while ($row = mysqli_fetch_array($query)) {
                            $no++;
                            $rowClass = $no <= 5 ? 'first-five-row' : 'remaining-row';

                        ?>
                            <tr class="table-row <?= $rowClass ?>">
                                <td>
                                    <?php echo $no; ?>
                                </td>
                                <td class="truncate-text">
                                    <span class="original-text">
                                        <?php
                                        echo $row['nama'];
                                        ?>
                                    </span>
                                    <span class="truncated-version">
                                        <?php
                                        $sentence = $row['nama'];
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
                                        echo $row['instansi'];
                                        ?>
                                    </span>
                                    <span class="truncated-version">
                                        <?php
                                        $sentence = $row['instansi'];
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
                                    <span class="badge bg <?= $row['status'] == 'Pending' ? 'warning' : ($row['status'] == 'Aktif' ? 'success' : 'danger'); ?>"><?php echo $row['status']; ?></span>
                                </td>

                                <td>
                                    <a href="detail_pemagang.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-outline-info">
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

    <?php include('footer.php'); ?>

    <script>
        document.getElementById('action-btn').addEventListener('click', function() {
            var id = this.getAttribute('data-id');
            window.location.href = '../export/export-pemagang.php';
        });
    </script>
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
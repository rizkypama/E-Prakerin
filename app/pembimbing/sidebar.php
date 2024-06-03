<!-- Sidebar Section -->
<aside>
    <div class="toggle">
        <div class="logo">
            <img src="../../images/dinas.svg">
            <h2>SMK<span style="color:#3966ff;">NU Kesesi</span></h2>
        </div>
        <div class="close" id="close-btn">
            <span class="material-icons-sharp">
                close
            </span>
        </div>
    </div>

    <div class="sidebar">
        <a href="index.php" class="<?php echo $hal == 'Dashboard Pemagang' ? 'active red' : ''; ?>">
            <span class="material-icons-sharp <?php echo $hal == 'Dashboard Pemagang' ? 'red' : ''; ?>">
                dashboard
            </span>
            <h3>Dashboard</h3>
        </a>
        <a href="presensi.php" class="<?php echo $hal == 'Presensi' ? 'active red' : ''; ?>">
            <span class="material-icons-sharp <?php echo $hal == 'Presensi' ? 'red' : ''; ?>">
                insights
            </span>
            <h3>Presensi</h3>
        </a>
        <a href="#" onclick="toggleLaporanLinks();">
            <span class="material-icons-sharp">
                arrow_drop_down
            </span>
            <h3>Laporan</h3>
        </a>
        <div id="laporanLink" style="display: <?php echo isset($halaman) && $halaman == 'Laporan' ? 'block' : 'none'; ?>">
            <a href="laporan-harian.php" class="<?php echo $hal == 'Laporan harian' ? 'active red' : ''; ?>">
                <span class="material-icons-sharp <?php echo $hal == 'Laporan harian' ? 'red' : ''; ?>">
                    receipt
                </span>
                <h3>Laporan Harian</h3>
            </a>
            <a href="laporan-akhir.php" class="<?php echo $hal == 'Laporan akhir' ? 'active red' : ''; ?>">
                <span class="material-icons-sharp <?php echo $hal == 'Laporan akhir' ? 'red' : ''; ?>">
                    receipt_long
                </span>
                <h3>Laporan Akhir</h3>
            </a>
        </div>
        <a href="tugas.php" class="<?php echo $hal == 'Tugas' ? 'active red' : ''; ?>">
            <span class="material-icons-sharp <?php echo $hal == 'Tugas' ? 'red' : ''; ?>">
                assignment
            </span>
            <h3>Tugas</h3>
        </a>
        <a href="pengajuan-pemagang.php" class="<?php echo $hal == 'Pengajuan Pemagang' ? 'active red' : ''; ?>">
            <span class="material-icons-sharp <?php echo $hal == 'Pengajuan Pemagang' ? 'red' : ''; ?>">
                announcement
            </span>
            <h3>Pengajuan</h3>
        </a>
        <a href="penilaian-pemagang.php" class="<?php echo $hal == 'Penilaian' ? 'active red' : ''; ?>">
            <span class="material-icons-sharp <?php echo $hal == 'Penilaian' ? 'red' : ''; ?>">
                credit_score
            </span>
            <h3>Penilaian</h3>
        </a>
        <a href="data_pemagang.php" class="<?php echo $hal == 'Pemagang' ? 'active red' : ''; ?>">
            <span class="material-icons-sharp <?php echo $hal == 'Pemagang' ? 'red' : ''; ?>">
                groups
            </span>
            <h3>Peserta</h3>
        </a>
        <a href="settings.php" class="<?php echo $hal == 'Settings' ? 'active red' : ''; ?>">
            <span class="material-icons-sharp <?php echo $hal == 'Settings' ? 'red' : ''; ?>">
                settings
            </span>
            <h3>Settings</h3>
        </a>
        <a href="#" id="logout-link">
            <span class="material-icons-sharp">
                logout
            </span>
            <h3>Logout</h3>
        </a>
    </div>
</aside>
<script>
    function toggleLaporanLinks() {
        var laporanLink = document.getElementById('laporanLink');

        // Toggle visibility
        laporanLink.style.display = laporanLink.style.display === 'none' ? 'block' : 'none';
    }
</script>
<!-- End of Sidebar Section -->
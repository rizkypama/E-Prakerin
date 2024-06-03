<!-- Sidebar Section -->
<aside>
    <div class="toggle">
        <div class="logo">
            <img src="../../images/dinas.svg">
            <h2>SMK NU Kesesi<span class="danger"></span></h2>
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
        <?php if ($_SESSION['status'] === 'Aktif') : ?>
            <a href="presensi.php" class="<?php echo $hal == 'Log Presensi' ? 'active red' : ''; ?>">
                <span class="material-icons-sharp <?php echo $hal == 'Log Presensi' ? 'red' : ''; ?>">
                    insights
                </span>
                <h3>Log Presensi</h3>
            </a>
            <a href="laporan-harian.php" class="<?php echo $hal == 'Laporan Harian' ? 'active red' : ''; ?>">
                <span class="material-icons-sharp <?php echo $hal == 'Laporan Harian' ? 'red' : ''; ?>">
                    receipt_long
                </span>
                <h3>Laporan Harian</h3>
            </a>
            <a href="pengajuan.php" class="<?php echo $hal == 'Pengajuan' ? 'active red' : ''; ?>">
                <span class="material-icons-sharp <?php echo $hal == 'Pengajuan' ? 'red' : ''; ?>">
                    announcement
                </span>
                <h3>Pengajuan</h3>
            </a>
            <a href="tugas.php" class="<?php echo $hal == 'Tugas' ? 'active red' : ''; ?>">
                <span class="material-icons-sharp <?php echo $hal == 'Tugas' ? 'red' : ''; ?>">
                    assignment
                </span>
                <h3>Tugas</h3>
            </a>
            <a href="penilaian.php" class="<?php echo $hal == 'Penilaian' ? 'active red' : ''; ?>">
                <span class="material-icons-sharp <?php echo $hal == 'Penilaian' ? 'red' : ''; ?>">
                    credit_score
                </span>
                <h3>Penilaian</h3>
            </a>
        <?php endif; ?>
        <a href="profile.php" class="<?php echo $hal == 'Profile' ? 'active red' : ''; ?>">
            <span class="material-icons-sharp <?php echo $hal == 'Profile' ? 'red' : ''; ?>">
                account_circle
            </span>
            <h3>Profile</h3>
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
<!-- End of Sidebar Section -->
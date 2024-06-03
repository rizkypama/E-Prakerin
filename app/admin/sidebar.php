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
        <a href="data_instansi.php" class="<?php echo $hal == 'Instansi' ? 'active red' : ''; ?>">
            <span class="material-icons-sharp <?php echo $hal == 'Instansi' ? 'red' : ''; ?>">
                apartment
            </span>
            <h3>Sekolah</h3>
        </a>
        <a href="data_pemagang.php" class="<?php echo $hal == 'Pemagang' ? 'active red' : ''; ?>">
            <span class="material-icons-sharp <?php echo $hal == 'Pemagang' ? 'red' : ''; ?>">
                groups
            </span>
            <h3>Peserta</h3>
        </a>
        <a href="data_pembimbing.php" class="<?php echo $hal == 'Pembimbing' ? 'active red' : ''; ?>">
            <span class="material-icons-sharp <?php echo $hal == 'Pembimbing' ? 'red' : ''; ?>">
                supervisor_account
            </span>
            <h3>Pembimbing</h3>
        </a>
        <a href="data_divisi.php" class="<?php echo $hal == 'Divisi' ? 'active red' : ''; ?>">
            <span class="material-icons-sharp <?php echo $hal == 'Divisi' ? 'red' : ''; ?>">
                safety_divider
            </span>
            <h3>Divisi</h3>
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
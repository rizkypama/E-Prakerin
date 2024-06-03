<div class="right-section">
    <div class="nav">
        <div class="toggle-mode">
            <button id="menu-btn" class="button-1">
                <span class="material-icons-sharp">
                    menu
                </span>
            </button>
            <div class="dark-mode">
                <span class="material-icons-sharp active">
                    light_mode
                </span>
                <span class="material-icons-sharp">
                    dark_mode
                </span>
            </div>
        </div>

        <div class="profile">
            <div class="info">
                <p>Hey, <b>
                        <?php
                        $nama = $_SESSION['nama'];
                        $nama_parts = explode(' ', $nama, 2);
                        $nama = $nama_parts[0];
                        echo $nama;
                        ?>
                    </b></p>
            </div>
            <?php
            $profilePicture = "../../images/profile_pics/" . $_SESSION['profile_picture'];
            ?>
            <div class="profile-photo profileModalTrigger" style="cursor: pointer;">
                <style>
                    img {
                        width: 40px;
                        height: 40px;
                        object-fit: cover !important;
                    }
                </style>
                <img src="<?php echo $profilePicture; ?>" alt="Profile Picture">
            </div>
        </div>

    </div>

    <a href="profile.php" class="user-profile">
        <div class="logo">
            <h2><?php echo $_SESSION['nama']; ?></h2>
            <p>Status: <?php echo $_SESSION['status']; ?></p>
        </div>
    </a>



    <?php if ($_SESSION['status'] === 'Aktif') : ?>
        <div class="user-profile danger" id="update-status-button">
            <div class="logo">
                <p>Update Status</p>
            </div>
        </div>
    <?php endif; ?>

    <div class="reminders">
        <div class="header">
            <h2>Reminders</h2>
            <span class="material-icons-sharp">
                notifications_none
            </span>
        </div>

        <?php
        $query = mysqli_query($koneksi, "SELECT * FROM tb_pengingat");
        $numReminders = mysqli_num_rows($query);

        if ($numReminders > 0) {
            while ($reminder = mysqli_fetch_assoc($query)) {
        ?>
                <div class="notification">
                    <div class="icon">
                        <span class="material-icons-sharp">
                            volume_up
                        </span>
                    </div>
                    <div class="content">
                        <div class="info">
                            <h3><?php echo $reminder['judul']; ?></h3>
                            <small class="text_muted">
                                <?php echo $reminder['waktu']; ?>
                            </small>
                        </div>
                    </div>
                </div>
        <?php
            }
        } else {
            echo '
            <div class="notification">
                    <div class="content"  style="justify-content:center !important;">
                        <div class="info">
                            <h3>-</h3>
                            <small class="text_muted">
                            </small>
                        </div>
                    </div>
                </div>
                ';
        }
        ?>

        <?php if ($_SESSION['status'] === 'Aktif') : ?>
            <div class="notification add-reminder" id="addReminder">
                <div>
                    <span class="material-icons-sharp">
                        add
                    </span>
                    <h3>Add Reminder</h3>
                </div>
            </div>
        <?php endif; ?>

        <!-- Modal -->
        <div id="reminderModal" class="reminder-modal">
            <div class="modal-content">
                <h2>Add Reminder</h2>
                <span class="close-reminder-button">&times;</span>
                <form id="reminderForm" action="../add/tambah_reminder.php" method="POST">
                    <label for="judul">Judul:</label>
                    <input type="text" id="judul" name="judul" required>
                    <label for="waktu">Waktu:</label>
                    <input type="datetime-local" id="waktu" name="waktu" required>
                    </br>
                    <button type="submit">Tambah</button>
                </form>
            </div>
        </div>
        <div id="profileModal" class="profile-modal">
            <div class="modal-content">
                <h2>Edit Profile</h2>
                <span class="close-profile-button">&times;</span>
                <form id="profileForm" action="../edit/edit_profil.php" method="POST" enctype="multipart/form-data">
                    <div style="display:flex; justify-content:center; align-items:center;">
                        <img src="<?php echo $profilePicture; ?>" alt="Profile Picture" style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%; overflow: hidden;">
                        </br>
                    </div>
                    <div class="upload-profile-pic">
                        <label for="upload" class="add-reminder">
                            <h3 style="margin: 10px;">Upload Foto</h3>
                        </label>
                        <span id="file-chosen">No file chosen</span>
                        <input id="upload" type="file" accept=".png,.jpg,.gif,.jpeg,.webp" name="profile_picture" hidden>
                    </div>
                    <label for="newName">Nama:</label>
                    <input type="text" id="newName" name="newName" value="<?php echo $_SESSION['nama']; ?>" required>
                    <label for="newEmail">Email:</label>
                    <input type="email" id="newEmail" name="newEmail" value="<?php echo $_SESSION['email']; ?>" required>
                    <button type="submit">Simpan</button>
                </form>
            </div>
        </div>

        <script>
            const profile_picture = document.getElementById('upload');

            const fileChosen = document.getElementById('file-chosen');

            profile_picture.addEventListener('change', function() {
                fileChosen.textContent = this.files[0].name
            })
        </script>

        <script>
            const profileModalTrigger = document.querySelectorAll('.profileModalTrigger')[0];
            const profileModal = document.getElementById('profileModal');
            const closeProfileModal = document.getElementsByClassName('close-profile-button')[0];

            profileModalTrigger.addEventListener('click', () => {
                profileModal.style.display = 'block';
            });

            closeProfileModal.addEventListener('click', () => {
                profileModal.style.display = 'none';
            });

            window.addEventListener('click', (event) => {
                if (event.target === profileModal) {
                    profileModal.style.display = 'none';
                }
            });
        </script>

        <script>
            const addReminderBtn = document.getElementById('addReminder');
            const reminderModal = document.getElementById('reminderModal');
            const closeModal = document.getElementsByClassName('close-reminder-button')[0];

            addReminderBtn.addEventListener('click', () => {
                reminderModal.style.display = 'block';
            });

            closeModal.addEventListener('click', () => {
                reminderModal.style.display = 'none';
            });

            window.addEventListener('click', (event) => {
                if (event.target === reminderModal) {
                    reminderModal.style.display = 'none';
                }
            });
        </script>

        <script>
            $(document).ready(function() {
                $("#update-status-button").click(function() {
                    $.ajax({
                        url: "../update/update_status-pemagang.php",
                        type: "POST",
                        success: function(response) {
                            Swal.fire({
                                title: 'Update Status Peserta Berhasil!',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                        },
                        error: function() {
                            Swal.fire({
                                title: 'Error',
                                text: 'An error occurred while updating status.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                });
            });
        </script>

    </div>

</div>
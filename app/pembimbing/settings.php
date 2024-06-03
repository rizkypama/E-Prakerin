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
        <?php $hal = "Settings" ?>
        <?php include('sidebar.php'); ?>

        <!-- Main Content -->
        <main>
            <h1>Settings</h1>
            </br>
            <h2>Ubah Password</h2>
            <div class="settings-form">
                <form id="password-form" method="post">
                    <label for="current_password">Password Saat Ini:</label>
                    <input type="password" name="current_password" required>

                    <label for="new_password">Password Baru:</label>
                    <input type="password" name="new_password" required>

                    <button type="submit">Update Password</button>
                </form>
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
        document.getElementById('password-form').addEventListener('submit', function(event) {
            event.preventDefault();
            updatePassword();
        });

        function updatePassword() {
            var formData = new FormData(document.getElementById('password-form'));

            $.ajax({
                url: '../update/update_password.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Password telah diubah!',
                        });

                        document.getElementById('password-form').reset();
                    } else if (response === 'error_password') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Password saat ini salah.',
                        });
                    } else if (response === 'error_update') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan saat mengubah password.',
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan.',
                    });
                }
            });
        }
    </script>

</body>

</html>
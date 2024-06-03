<?php 
if ($_SESSION['role_id'] !== "Pembimbing") {
    header("Location: ../../index.php");
    exit();
}
?>
<?php 
if ($_SESSION['role_id'] !== "Admin") {
    header("Location: ../../index.php");
    exit();
}
?>
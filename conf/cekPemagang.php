<?php 
if ($_SESSION['role_id'] !== "Pemagang") {
    header("Location: ../../index.php");
    exit();
}
?>
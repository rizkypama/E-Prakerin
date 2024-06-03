<?php
session_start();
include('../../conf/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newName = $koneksi->real_escape_string($_POST['newName']);
    $newEmail = $koneksi->real_escape_string($_POST['newEmail']);
    $userId = $_SESSION['id_user'];
    $userRole = $_SESSION['role_id'];
    $targetDir = "../../images/profile_pics/";

    $updateUserQuery = "UPDATE tb_users SET nama='$newName', email='$newEmail' WHERE id='$userId'";
    $resultUser = $koneksi->query($updateUserQuery);

    if ($userRole == 'Pemagang') {
        $updatePemagangQuery = "UPDATE tb_pemagang SET nama='$newName' WHERE id_users='$userId'";
        $resultPemagang = $koneksi->query($updatePemagangQuery);
    } elseif ($userRole == 'Pembimbing') {
        $jabatan = $_POST['jabatan'];
        $nip = $_POST['nip'];
        $updatePembimbingQuery = "UPDATE tb_pembimbing SET nama_pembimbing='$newName', jabatan='$jabatan', nip='$nip' WHERE id_users='$userId'";
        $resultPembimbing = $koneksi->query($updatePembimbingQuery);
    } elseif ($userRole == 'Admin') {
        $updateAdminQuery = "UPDATE tb_admin SET nama_admin='$newName' WHERE id_users='$userId'";
        $resultAdmin = $koneksi->query($updateAdminQuery);
    }

    if (isset($_FILES["profile_picture"]) && $_FILES["profile_picture"]["error"] === UPLOAD_ERR_OK) {
        $fileName = basename($_FILES["profile_picture"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'webp');

        $currentProfilePic = $_SESSION['profile_picture'];

        if (in_array($fileType, $allowTypes)) {
            if (!empty($currentProfilePic) && $currentProfilePic !== 'default.png') {
                $currentProfilePicPath = $targetDir . $currentProfilePic;
                if (file_exists($currentProfilePicPath)) {
                    unlink($currentProfilePicPath);
                }
            }
            $uniqueFileName = "pfp_" . $userId . "." . $fileType;
            $targetFilePath = $targetDir . $uniqueFileName;
            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $targetFilePath)) {
                $updatePfp = "UPDATE tb_users SET profile_picture = '$uniqueFileName' WHERE id = $userId";
                $resultUpdatePfp = $koneksi->query($updatePfp);

                if (!$resultUpdatePfp) {
                    echo "Error updating profile picture: " . $koneksi->error;
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "Invalid file type. Allowed file types are JPG, JPEG, PNG, GIF, WEBP.";
        }
    }

    if ($resultUser || ($resultPemagang || $resultPembimbing || $resultAdmin)) {
        $_SESSION['nama'] = $newName;
        $_SESSION['email'] = $newEmail;

        if (isset($fileType, $allowTypes)) {
            $_SESSION['profile_picture'] = $uniqueFileName;
        }

        $referer = $_SERVER['HTTP_REFERER'];
        header("Location: $referer");
        exit;
    } else {
        echo "Error updating profile: " . $koneksi->error;
    }
}

$koneksi->close();

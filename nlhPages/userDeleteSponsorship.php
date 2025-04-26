<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">

<head>
    <title>Delete Sponsorship - Nine Lives Haven</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<?php
session_start();
require 'connectdb.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: userSignInPage.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sponsorship_id = $_GET['sponsorship_id'] ?? null;

if (!$sponsorship_id) {
    die("Invalid request.");
}

$delete_query = "DELETE FROM sponsorships WHERE sponsorship_id = ? AND user_id = ?";
$stmt = $con->prepare($delete_query);
$stmt->bind_param("ii", $sponsorship_id, $user_id);

if ($stmt->execute()) {
    echo "<script>
            Swal.fire({
                title: 'Deleted!',
                text: 'Your sponsorship has been deleted.',
                icon: 'success',
                confirmButtonText: 'Okay'
            }).then(function() {
                window.location.href = 'userViewSponsorshipsPage.php';
            });
          </script>";
} else {
    echo "<script>
            Swal.fire({
                title: 'Error!',
                text: 'There was an issue deleting the sponsorship.',
                icon: 'error',
                confirmButtonText: 'Okay'
            });
          </script>";
}
?>




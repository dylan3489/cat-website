<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">

<head>
    <title>Admin Account Overview - Nine Lives Haven</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
    <link rel="stylesheet" href="../nlhCSS/adminAccountCSS.css">
</head>

<?php

session_start();
require 'connectdb.php';
include 'navbar.php'; // banner and nav bar


// if the admin is not logged in, redirect to sign in page
if (!isset($_SESSION['user_id']) || $_SESSION['admin_status'] != 1) {
    header('Location:adminSignInPage.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE user_id = '$user_id'";
$result = mysqli_query($con, $query);
$user = mysqli_fetch_assoc($result);
?>

<body>
    <section class="page-title-section">
        <h1>Admin Account Overview</h1>
    </section>

    <section class="account-details-section">
        <div class="account-box-left">
            <h2>Account Information</h2>
            <p><strong>Name:</strong> <?php echo $user['first_name'] . ' ' . $user['last_name']; ?></p>
            <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
            <p><strong>Phone Number:</strong> <?php echo $user['phone_number']; ?></p>
            <p><strong>Admin Key:</strong> <?php echo $user['admin_key']; ?></p>
            <p><strong>Address:</strong>
                <?php echo $user['street_address'] . ', ' . $user['city'] . ', ' . $user['post_code']; ?></p>
            <a href="adminEditDetails.php" class="edit-details-btn">Edit Details</a>
        </div>

        <div class="account-box-right">
            <h2>Quick Links</h2>
            <ul>
                <li><a href="adminEditDetails.php">Edit Your Account</a></li>
                <li><a href="adminViewApplicationsPage.php">Adoption Applications</a></li>
                <li><a href="adminAppointmentsDatabasePage.php">Appointments</a></li>
                <li><a href="adminCatDatabasePage.php">Cat Database</a></li>
                <li><a href="adminUserDatabasePage.php">User Database</a></li>
            </ul>
        </div>
    </section>

</body>

<?php include 'footer.php'; // footer
?>

</html>

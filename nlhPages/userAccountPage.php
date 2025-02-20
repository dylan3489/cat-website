<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">

<head>
    <title>Account Overview - Nine Lives Haven</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
    <link rel="stylesheet" href="../nlhCSS/userAccountCSS.css">
</head>

<?php

session_start();
require 'connectdb.php';
include 'navbar.php'; // banner and nav bar


// if the user is not logged in, redirect to sign in page
if(!isset($_SESSION['user_id'])){
    header("Location: userSignInPage.php");
    exit();
}

// fetch user details from the database
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE user_id = '$user_id'";
$result = mysqli_query($con, $query);
$user = mysqli_fetch_assoc($result);
?>

<body>
    <section class="page-title-section">
        <h1>Your Account</h1>
    </section>

    <!-- user account details with two boxes -->
    <section class="account-details-section">
        <div class="account-box-left">
            <h2>Account Information</h2>
            <p><strong>Name:</strong> <?php echo $user['first_name'] . ' ' . $user['last_name']; ?></p>
            <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
            <p><strong>Phone Number:</strong> <?php echo $user['phone_number']; ?></p>
            <p><strong>Address:</strong>
                <?php echo $user['street_address'] . ', ' . $user['city'] . ', ' . $user['post_code']; ?></p>
            <a href="userEditDetails.php" class="edit-details-btn">Edit Details</a>
        </div>

        <div class="account-box-right">
            <h2>Quick Links</h2>
            <ul>
                <li><a href="userViewApplicationsPage.php">Your Adoption Applications</a></li>
                <li><a href="userViewAppointmentsPage.php">Your Appointments</a></li>
                <li><a href="userDonationHistoryPage.php">Your Donation History</a></li>
                <li><a href="userViewSponsorshipsPage.php">Your Sponsorships</a></li>
            </ul>
            <a href="userBookAppointmentPage.php" class="book-appointment-btn">Book an Appointment</a>
        </div>
    </section>

</body>

<?php include 'footer.php'; // footer
?>

</html>

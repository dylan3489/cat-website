<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">

<?php
session_start();

require 'connectdb.php';
include 'navbar.php'; // banner and nav bar
?>

<head>
    <title>Make a Donation - Nine Lives Haven</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../nlhCSS/userMakeDonationCSS.css">

</head>

<?php
// checks if the user is logged in, if not they are redirected
if (!isset($_SESSION['user_id'])) {
    echo '<script>
        Swal.fire({
            icon: "warning",
            title: "Sign In Required",
            text: "Thank you for expressing interest in donating to us - however in order to accept any payments and to allow you keep track of your donations, you will need to create an account!",
            confirmButtonText: "Sign In",
            confirmButtonColor: "#f4ac6d",
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "userSignInPage.php";
            }
        });
    </script>';
    exit();
}
?>

<body>
    <div class="page-header">
        <img src="../nlhImages/background.jpg" alt="Background Image">
        <h1 class="page-title">Make a Donation</h1>
    </div>
    <div class="donation-form-container">
        <form class="donation-form" action="donation.php" method="POST">
            <h2>Support Our Mission</h2>
            <label for="amount">Donation Amount (£):</label>
            <input type="number" id="amount" name="amount" step="0.01" min="0.01" required>

            <label for="message">Message (optional):</label>
            <textarea id="message" name="message" rows="4" placeholder="Write a message..."></textarea>

            <label for="card-number">Card Number:</label>
            <input type="text" id="card-number" name="card_number" required>

            <label for="expiry-date">Expiry Date:</label>
            <input type="month" id="expiry-date" name="expiry_date" required>

            <label for="cvv">CVV:</label>
            <input type="text" id="cvv" name="cvv" maxlength="3" required>

            <button type="submit">Donate Now</button>
        </form>
    </div>

    <script>
        window.onload = function () {
            console.log(typeof Swal);
        };
    </script>

</body>
<?php include 'footer.php'; // footer ?>

</html>

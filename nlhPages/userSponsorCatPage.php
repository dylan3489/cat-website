<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">

<?php
session_start();
require 'connectdb.php';
include 'navbar.php'; // banner and nav bar
?>

<head>
    <title>Sponsor a Cat - Nine Lives Haven</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
    <link rel="stylesheet" href="../nlhCSS/userSponsorCatCSS.css">
    <script>
        // JS function to toggle visibility of the renewal date
        function toggleRenewalDate() {
            var sponsorshipType = document.querySelector("select[name='sponsorship_type']").value;
            var renewalDateRow = document.querySelector(".renewal-date-row");

            if (sponsorshipType === "recurring") {
                renewalDateRow.style.display = "block";
            } else {
                renewalDateRow.style.display = "none";
                document.querySelector("input[name='renewal_date']").value = "";
            }
        }
    </script>
    <style>

    </style>
</head>

<?php
// checks if the user is logged in, if not they are redirected
if (!isset($_SESSION['user_id'])) {
    echo '<script>
    window.onload = function() {
        Swal.fire({
            icon: "warning",
            title: "Sign In Required",
            text: "Thank you for expressing interest in sponsoring one of our cats - we do need to know some details for security purposes on who our sponsorships come from, so please sign in or create an account to continue the process!",
            confirmButtonText: "Sign In",
            confirmButtonColor: "#f4ac6d",
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "userSignInPage.php";
            }
        });
    };
</script>';
    exit();
}
?>

<body>
    <div class="page-header">
        <h1 class="page-title">Setup a Sponsorship!</h1>
        <p>Please sponsor one of our lovely cats and help us provide a safe home for them.</p>
    </div>

    <div class="sponsorship-form-container">
        <form class="sponsorship-form" action="sponsor.php" method="POST">
            <h2>Support Our Mission</h2>

            <label for="sponsorship_amount">Sponsorship Amount (£):</label>
            <input type="number" id="sponsorship_amount" name="sponsorship_amount" step="0.01" min="0.01" required>

            <label for="cat_name">Desired Cat to Sponsor:</label>
            <select name="cat_name" id="cat_name">
                <?php
                $query = "SELECT cat_id, cat_name FROM cats";
                $result = $con->query($query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['cat_name'] . "'>" . $row['cat_name'] . "</option>";
                    }
                } else {
                    echo "<option value=''>No cats available</option>";
                }
                ?>
            </select><br>

            <label for="sponsorship_type">Sponsorship Type:</label>
            <select name="sponsorship_type" id="sponsorship_type" onchange="toggleRenewalDate()" required>
                <option value="one-time">One-time</option>
                <option value="recurring">Recurring</option>
            </select><br>

            <div class="renewal-date-row">
                <label for="renewal_date">Renewal Date:</label>
                <input type="date" name="renewal_date" id="renewal_date"><br>
            </div>

            <div class="card-details">
                <h3>Payment Information</h3>
                <label for="card-number">Card Number:</label>
                <input type="text" id="card-number" name="card_number" required>

                <label for="expiry-date">Expiry Date:</label>
                <input type="month" id="expiry-date" name="expiry_date" required>

                <label for="cvv">CVV:</label>
                <input type="text" id="cvv" name="cvv" maxlength="3" required>
            </div>

            <button type="submit">Sponsor Now</button>
        </form>
    </div>

    <script>
        window.onload = function () {
            toggleRenewalDate();
        };
    </script>
</body>

<?php include 'footer.php'; // footer ?>

</html>

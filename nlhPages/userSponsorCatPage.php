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
    <script>
        // JS function to toggle visibility of the renewal date field based on sponsorship type
        function toggleRenewalDate() {
            var sponsorshipType = document.querySelector("select[name='sponsorship_type']").value;
            var renewalDateRow = document.querySelector(".renewal-date-row");

            if (sponsorshipType === "recurring") {
                renewalDateRow.style.display = "block";
            } else {
                renewalDateRow.style.display = "none";
                document.querySelector("input[name='renewal_date']").value = ""; // clears renewal date if not recurring
            }
        }
    </script>
</head>

<?php
// checks if the user is logged in, if not they are redirected
if (!isset($_SESSION['user_id'])) {
    echo '<script>
    window.onload = function() {
        console.log("SweetAlert2 is loading..."); 
        if (typeof Swal === "undefined") {
            console.log("Swal is undefined");
        } else {
            console.log("Swal is defined"); 
            Swal.fire({
                icon: "warning",
                title: "Sign In Required",
                text: "Thank you for expressing interest in sponsoring one of our cats - we do need to know some details for security purposes on who our sponsorships come from,
                so please sign in or create an account to continue the process!",
                confirmButtonText: "Sign In",
                confirmButtonColor: "#f4ac6d",
                allowOutsideClick: false
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "userSignInPage.php";
                }
            });
        }
    };
</script>';
    exit();
}
?>

<body>
    <h1 class="page-title">Setup a Sponsorship!</h1>

    <div class="sponsorship-form-container">
        <form class="sponsorship-form" action="sponsor.php" method="POST">
            <h2>Support Our Mission</h2>

            <label for="sponsorship_amount">Sponsorship Amount (£):</label>
            <input type="number" id="sponsorship_amount" name="sponsorship_amount" step="0.01" min="0.01" required>

            <label for="cat_name">Desired Cat to Sponsor:</label>
            <select name="cat_name" id="cat_name">
                <?php
                // fetch cat from the database
                $query = "SELECT cat_id, cat_name FROM cats";
                $result = $con->query($query);

                // check if any cats are returned
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

            <!-- renewal date (visible if recurring sponsorship) -->
            <div class="renewal-date-row" style="display:none;">
                <label for="renewal_date">Renewal Date:</label>
                <input type="date" name="renewal_date" id="renewal_date"><br>
            </div>

            <button type="submit">Sponsor Now</button>
        </form>
    </div>

    <script>
        // initialize form based on the default sponsorship type on load
        window.onload = function () {
            toggleRenewalDate();
        };
    </script>
</body>

<?php include 'footer.php' // footer ?> 

</html>

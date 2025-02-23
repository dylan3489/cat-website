<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">

<head>
    <title>Request an Appointment - Nine Lives Haven</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../nlhCSS/userBookAppointmentCSS.css">
</head>

<?php

session_start();
require 'connectdb.php';
include 'navbar.php'; // banner and nav bar

// if the user is not logged in, redirect to sign in page
if (!isset($_SESSION['user_id'])) {
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
    <section class="section-bg1">
        <div>
            <h1>Book an Appointment</h1>
            <p>Welcome to our appointment booking page. Here you can schedule a meeting to discuss adoption
                opportunities, cat care, or any other questions you may have. Please fill in the form below to book your
                appointment.</p>
        </div>
    </section>

    <section class="section-bg2">
        <div class="form-box">
            <h2>Schedule Your Appointment</h2>
            <form action="processBookAppointment.php" method="post">
                <label for="cat_id">Select Adopted Cat:</label>
                <select name="cat_id" required>
                    <option value="">--Select--</option>
                    <?php
                    session_start();
                    require 'connectdb.php';

                    if (!isset($_SESSION['loggedin'])) {
                        header("Location: userSignInPage.php");
                        exit();
                    }

                    $user_id = $_SESSION['user_id'];
                    $query = "
                        SELECT c.cat_id, c.cat_name
                        FROM cats AS c
                        INNER JOIN adoption_applications AS aa ON c.cat_id = aa.cat_id
                        WHERE c.adoption_status = 'adopted' 
                          AND aa.user_id = '$user_id' 
                          AND aa.application_status = 'accepted'
                    ";
                    $result = mysqli_query($con, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='{$row['cat_id']}'>{$row['cat_name']}</option>";
                    }
                    ?>
                </select>

                <label for="appointment_date">Appointment Date:</label>
                <input type="text" id="appointment_date" name="appointment_date" required>
                <script>
                    flatpickr("#appointment_date", {
                        enableTime: true,
                        dateFormat: "Y-m-d H:i",
                    });
                </script>

                <label for="vet_name">Vet Name:</label>
                <input type="text" name="vet_name" placeholder="Optional">

                <label for="notes">Notes:</label>
                <textarea name="notes" placeholder="Any additional notes"></textarea>

                <button type="submit">Request Appointment</button>
            </form>
        </div>
    </section>

    <section class="links-box">
        <h3>Explore More</h3>
        <a href="ourCatsPage.php">Meet Our Cats</a>
        <a href="aboutUsPage.php">Learn About Us</a>
        <a href="contactUsPage.php">Get in Touch</a>
    </section>
</body>

<?php include 'footer.php'; // footer ?>

</html>

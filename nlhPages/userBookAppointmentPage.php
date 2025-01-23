<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">

<head>
    <title>Request an Appointment - Nine Lives Haven</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
</head>

<?php

session_start();
require 'connectdb.php';

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
    <header>
        <nav class="banner">
            <a href="homePage.php"><img src="logo" class="logo" alt="Company Logo"></a>
            <!-- this is the navigation bar -written using php to show 1 of three versions depending on 
                    the type of user i.e. Admin, Registered User or Visitor-->
            <?php
            if (isset($_SESSION['loggedin'])) {
                if (isset($_SESSION['admin_status']) && $_SESSION['admin_status'] == 1) {
                    ?>
                    <nav class="header-nav">
                        <ul class="navigation-bar">
                            <li><a href="homePage.php">Home</a></li>
                            <li><a href="aboutUsPage.php">About Us</a></li>
                            <li><a href="ourCatsPage.php">Our Cats</a></li>
                            <nav class=CatCare>
                                <a href="catCarePage.php"><button class="dropbtn">Cat Care</button></a>
                                <nav class="products-content">
                                    <a href="faqPage.php">FAQs</a>
                                    <a href="catCarePage.php">Advice on Cat Care</a>
                                    <a href="vetServicesPage.php">Vetinary Services</a>
                                </nav>
                                <nav class=AdminDropDown>
                                    <a href="adminAccountPage.php"><button class="dropbtn">Your Admin Account</button></a>
                                    <nav class="products-content">
                                        <a href="adminEditAccountPage.php">Edit Your Account</a>
                                        <a href="adminViewApplicationsPage.php">View Adoption Applications</a>
                                        <a href="adminAppointmentsDatabasePage.php">View Appointments</a>
                                        <a href="adminDonationsDatabasePage.php">Donations Database</a>
                                        <a href="adminSponsorshipDatabasePage.php">Sponsorships Database</a>
                                        <a href="adminStoriesDatabasePage.php">Success Stories Database</a>
                                        <a href="adminUserDatabasePage.php">User Database</a>
                                    </nav>
                                </nav>
                                <li><a href="contactUsPage.php">Contact Us </a></li>
                                <button><a href="userMakeDonationPage.php">Donate</a></button>
                                <button><a href="logout.php">Logout</a></button>
                        </ul>
                    </nav>
                </nav>
                <?php
                } else if (isset($_SESSION['admin_status']) && $_SESSION['admin_status'] == 0) {
                    ?>
                    <nav class="header-nav">
                        <ul class="navigation-bar">
                            <li><a href="homePage.php">Home</a></li>
                            <li><a href="aboutUsPage.php">About Us</a></li>
                            <li><a href="ourCatsPage.php">Our Cats</a></li>
                            <nav class=CatCare>
                                <a href="catCarePage.php"><button class="dropbtn">Cat Care</button></a>
                                <nav class="products-content">
                                    <a href="faqPage.php">FAQs</a>
                                    <a href="catCarePage.php">Advice on Cat Care</a>
                                    <a href="vetServicesPage.php">Vetinary Services</a>
                                </nav>
                                <nav class=AdminDropDown>
                                    <a href="userAccountPage.php"><button class="dropbtn">Your Account</button></a>
                                    <nav class="products-content">
                                        <a href="userEditAccountPage.php">Edit Your Account</a>
                                        <a href="userViewApplicationsPage.php">View Adoption Applications</a>
                                        <a href="userViewAppointmentsPage.php">View Appointments</a>
                                        <a href="userDonationHistoryPage.php">Donations Database</a>
                                        <a href="userViewSponsorshipsPage.php">Sponsorships Database</a>
                                    </nav>
                                </nav>
                                <li><a href="contactUsPage.php">Contact Us </a></li>
                                <button><a href="userMakeDonationPage.php">Donate</a></button>
                                <button><a href="logout.php">Logout</a></button>
                        </ul>
                    </nav>
                    </nav>
                <?php
                }
            } else {
                ?>
            <nav class="header-nav">
                <ul class="navigation-bar">
                    <li><a href="homePage.php">Home</a></li>
                    <li><a href="aboutUsPage.php">About Us</a></li>
                    <li><a href="ourCatsPage.php">Our Cats</a></li>
                    <nav class=CatCare>
                        <a href="catCarePage.php"><button class="dropbtn">Cat Care</button></a>
                        <nav class="products-content">
                            <a href="faqPage.php">FAQs</a>
                            <a href="catCarePage.php">Advice on Cat Care</a>
                            <a href="vetServicesPage.php">Vetinary Services</a>
                        </nav>
                        <li><a href="contactUsPage.php">Contact Us </a></li>
                        <button><a href="userMakeDonationPage.php">Donate</a></button>
                        <button><a href="userSignInPage.php">Sign In</a></button>
                </ul>
            </nav>
            </nav>
            <?php
            }
            ?>
        </nav>
    </header>

    <section class="section-bg1">
        <div class="intro">
            <h1>Book an Appointment</h1>
            <p>Welcome to our appointment booking page. Here you can schedule a meeting to discuss adoption
                opportunities, cat care, or any other questions you may have. Please fill in the form below to book your
                appointment.</p>
        </div>
        <img src="cat_image.jpg" alt="Cat Image">
    </section>

    <!-- appointment form -->
    <section class="section-bg2">
    <div class="form-box">
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
                    <input type="datetime-local" name="appointment_date" required>

                    <label for="vet_name">Vet Name:</label>
                    <input type="text" name="vet_name" placeholder="Optional">

                    <label for="notes">Notes:</label>
                    <textarea name="notes" placeholder="Any additional notes"></textarea>

                    <button type="submit">Book Appointment</button>
                </form>
            </div>
        <div class="links-box">
            <h3>Explore More</h3>
            <a href="ourCatsPage.php">Meet Our Cats</a>
            <a href="aboutUsPage.php">Learn About Us</a>
            <a href="contactUsPage.php">Get in Touch</a>
        </div>
    </section>

</body>

<footer class="footer">
    <div class="footer-section">
        <div>
            <img src="logo.png" class="logo" alt="Company Logo"></a>
        </div>
        <div>

            <p>
                Images and products on this page were sourced from the following websites:<br>
                <br>
                https://www.istockphoto.com/search/2/image-film?phrase=cat+rescue <br>

                <br>
                © 2024 NineLivesHaven. All rights reserved.

                The content, design, and images on this website are the property of Nine Lives Haven and are protected
                by
                international copyright laws. Unauthorized use or reproduction of any materials without the express
                written
                consent of Nine Lives Haven is strictly prohibited. Nine Lives Haven and the Nine Lives Haven logo are
                trademarks of
                Nine Lives Haven.

                For inquiries regarding the use or reproduction of any content on this website, please contact us at
                nineliveshaven@rescue.com
            </p>

        </div>
    </div>
</footer>

</html>

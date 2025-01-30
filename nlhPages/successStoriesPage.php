<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">

<head>
    <title>Success Stories - Nine Lives Haven</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>

</head>

<?php
session_start();

require 'connectdb.php';
$query = "SELECT s.story_text, s.after_image_url, c.cat_name 
          FROM success_stories s 
          JOIN cats c ON s.cat_id = c.cat_id 
          ORDER BY s.story_date DESC 
          LIMIT 3";

$result = mysqli_query($con, $query);
$stories = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_close($con);
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

        <body>
            <section class="stories-intro">
                <h1>Success Stories</h1>
                <div class="intro-box">
                    <p>Read heartwarming success stories of rescued cats finding their forever homes.</p>
                </div>
                <h2>Recent Stories</h2>
            </section>

            <?php if (count($stories) >= 3): ?>
                <!-- first story-->
                <section class="story-block bg-1">
                    <img src="../nlhImages/<?php echo $stories[0]['after_image_url']; ?>.jpg"
                        alt="<?php echo $stories[0]['cat_name']; ?>" class="story-image">
                    <div class="story-text">
                        <h3><?php echo $stories[0]['cat_name']; ?></h3>
                        <p><?php echo $stories[0]['story_text']; ?></p>
                    </div>
                </section>

                <!-- second story -->
                <section class="story-block bg-2 right">
                    <div class="story-text">
                        <h3><?php echo $stories[1]['cat_name']; ?></h3>
                        <p><?php echo $stories[1]['story_text']; ?></p>
                    </div>
                    <img src="../nlhImages/<?php echo $stories[1]['after_image_url']; ?>.jpg"
                        alt="<?php echo $stories[1]['cat_name']; ?>" class="story-image">
                </section>

                <!-- third story -->
                <section class="story-block bg-3">
                    <img src="../nlhImages/<?php echo $stories[2]['after_image_url']; ?>.jpg"
                        alt="<?php echo $stories[2]['cat_name']; ?>" class="story-image">
                    <div class="story-text">
                        <h3><?php echo $stories[2]['cat_name']; ?></h3>
                        <p><?php echo $stories[2]['story_text']; ?></p>
                    </div>
                </section>
            <?php else: ?>
                <p class="no-stories">Not enough success stories available.</p>
            <?php endif; ?>
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

                        The content, design, and images on this website are the property of Nine Lives Haven and are
                        protected
                        by
                        international copyright laws. Unauthorized use or reproduction of any materials without the
                        express
                        written
                        consent of Nine Lives Haven is strictly prohibited. Nine Lives Haven and the Nine Lives Haven
                        logo are
                        trademarks of
                        Nine Lives Haven.

                        For inquiries regarding the use or reproduction of any content on this website, please contact
                        us at
                        nineliveshaven@rescue.com
                    </p>

                </div>
            </div>
        </footer>

<?php
session_start();

require 'connectdb.php';
?>

<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

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

        <section class="cat-section">
            <?php
            // Retrieve the cat ID from the URL query parameter
            $id = $_GET['id'];
            // Query to fetch cat details based on the cat ID, protect against SQL injection, 
            // execute query
            $query = "SELECT cat_id, cat_name, breed, cat_age, cat_health, cat_description, special_requirements FROM cats WHERE cat_id = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param("s", $id);
            $stmt->execute();
            // get the results of query and fetch data as an associative array
            $result = $stmt->get_result();
            $cat = $result->fetch_assoc();

            ?>
            <!-- Display the cat's image using its ID in the filename -->
            <p class="catImg">
                <?php
                echo "<img src='nlhImages/" . $cat['cat_id'] . ".jpg' alt='" . $cat['cat_id'] . "' style='max-height: 550px; max-width: 500px;'><br>"; ?>
            </p>

            <?php
            if (isset($_SESSION['loggedin'])) {
                $user_id = $_SESSION['user_id'];
                $query1 = "SELECT first_name, last_name FROM users WHERE user_id = ?";
                $stmt1 = $con->prepare($query1);
                $stmt1->bind_param("s", $user_id);
                $stmt1->execute();
                $stmt1->bind_result($first_name, $last_name);
                $stmt1->fetch();
                $stmt1->close();
            }
            ?>

            <title>
                <?php echo $cat['cat_name']; ?>
            </title>
            <div class="cat-details">
                <!-- Display the cat's details -->
                <p class="catName">
                    <?php echo "My name is: " . $cat['cat_name']; ?>
                </p>
                <p class="catBreed">
                    <?php echo "What type of cat am I: " . $cat['breed']; ?>
                </p>
                <div class="pStatusBasket">
                    <p class="catAge">
                        <?php echo "How old am I: " . $cat['cat_age']; ?>
                    </p>
                    <!-- stand in form for applying for adoption of the cat -->
                    <form method="post" action="applyForAdoption.php" class="catApply">
                        <input type="hidden" name="cat_id" value="<?= $cat['cat_id']; ?>">
                        <input type="submit" value="Apply for Adoption">
                    </form>
                </div>
                <p class="catHealth">
                    <?php echo "How healthy am I?: " . $cat['cat_health']; ?>
                </p>
                <p class="cat_requirements">
                    <?php echo "Do I have any special requirements?: " . $cat['special_requirements']; ?>
                </p>
            </div>

            <section class="aftercare-section">
                <div class="aftercare-title">Aftercare Information</div>
                <div class="aftercare-text">
                    <p>After adopting or sponsoring a cat, it is important to provide proper care and attention. Resources can be found....</p>
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
                <br>
                <br><br>
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

<?php
session_start();

require 'connectdb.php';

// if the user is logged in, they are redirected
if(isset($_SESSION['user_id'])){
    header('Location:homePage.php');
    }
    
// check that the form has been submitted, using POST to check for submit key. then assigns the values submitted to variables of the the same name to use in sql queries.
// password hash hashes the password securely using PHPs built in password_hash() function
if (isset($_POST["submit"])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $date_of_birth = $_POST['date_of_birth'];
    $email = $_POST['email'];
    $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phone_number = $_POST['phone_number'];
    $street_address = $_POST['street_address'];
    $city = $_POST['city'];
    $post_code = $_POST['post_code'];

    // verify the email is not alerady used
    $verify_query = mysqli_query($con, "SELECT email FROM users WHERE email='$email'");
    if (mysqli_num_rows($verify_query) != 0) {
        echo '<script>alert("This email is used, please try another one!");</script>';
        echo '<script>window.location.href = "userSignUpPage.php";</script>';
    } else {
        mysqli_query($con, "INSERT INTO users (first_name, last_name, date_of_birth, email, password_hash, phone_number, street_address, city, post_code, admin_status) 
        VALUES ('$first_name', '$last_name', '$date_of_birth', '$email', '$password_hash', '$phone_number', '$street_address', '$city', '$post_code', 0)") or die("Error Occured");
        echo '<script>alert("Registration Successful! Please sign in!");</script>';
        echo '<script>window.location.href = "userSignInPage.php";</script>';
        exit();
    }
} else {
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <meta charset="UTF-8">

    <head>
        <title>User Sign Up - Nine Lives Haven</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
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

            <div class="page-header">
                <h1 class="page-title">User Sign Up!</h1>
            </div>

            <!-- user registration form -->
            <section class="registration-container">
                <form class="register" id="registerForm" method="post">
                    <div class="content">
                        <table class="registration-table">
                            <tr>
                                <th colspan="2">
                                    <h3>Create an account</h3>
                                </th>
                            </tr>
                            <tr>
                                <td>
                                    <label for="first_name">First name:</label>
                                </td>
                                <td>
                                    <input type="text" id="first_name" name="first_name" placeholder="First Name" required>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="last_name">Last name:</label>
                                </td>
                                <td>
                                    <input type="text" id="last_name" name="last_name" placeholder="Last Name" required>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="date_of_birth">Date of Birth:</label>
                                </td>
                                <td>
                                    <input type="date" id="date_of_birth" name="date_of_birth" placeholder="Date of Birth"
                                        required>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="email">Email:</label>
                                </td>
                                <td>
                                    <input type="email" id="email" name="email" placeholder="Email" required>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="password">Password:</label>
                                </td>
                                <td>
                                    <input type="password" id="password" name="password" placeholder="Password" required>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="phone_number">Mobile Number:</label>
                                </td>
                                <td>
                                    <input type="tel" id="phone_number" name="phone_number" placeholder="Mobile Number"
                                        required>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="street_address">Street Address:</label>
                                </td>
                                <td>
                                    <input type="text" id="street_address" name="street_address"
                                        placeholder="Street Address" required>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="city">City:</label>
                                </td>
                                <td>
                                    <input type="text" id="city" name="city" placeholder="City">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="post_code">Post Code:</label>
                                </td>
                                <td>
                                    <input type="text" id="post_code" name="post_code" placeholder="Post Code" required>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input type="submit" id="submit" name="submit" value="Register">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="adminSignUpPage.php" class="admin-link">Are you an adminstrator? Register an admin account here.</a>
                                </td>
                            </tr>
                        </table>
                        <div id="feedback-message" class="message" style="display: none;"></div>
                    </div>
                </form>
            </section>

        <?php } ?>
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

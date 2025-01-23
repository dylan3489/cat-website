<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">

<head>
    <title>Our Cats - Nine Lives Haven</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>

</head>

<?php
session_start();

require 'connectdb.php';
$cats = []; // empty array to avoid errors if no data is retrieved.

// search and sorting (optional)
$search = isset($_GET['search']) ? mysqli_real_escape_string($con, $_GET['search']) : '';
$sort = isset($_GET['sort']) ? mysqli_real_escape_string($con, $_GET['sort']) : 'cat_name';
$order = isset($_GET['order']) && in_array($_GET['order'], ['asc', 'desc']) ? $_GET['order'] : 'asc';

$query = "SELECT * FROM cats WHERE cat_name LIKE '%$search%' ORDER BY $sort $order";

$result = mysqli_query($con, $query);

if ($result) {
    $cats = mysqli_fetch_all($result, MYSQLI_ASSOC); // fetch all rows as an associative array
} else {
    echo "Error fetching data: " . mysqli_error($con);
}
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

        <section class="content">
            <!-- this is the search/filter tab that allows users to filter cats by chosen attributes-->
            <form action="ourCatsPage.php" method="get">
                <input type="text" name="search" class="search-bar"
                    value="<?= isset($search) && $search !== '' ? htmlspecialchars($search) : '' ?>"
                    placeholder="Search...">
                <select name="sort">
                    <option value="cat_name">Name</option>
                    <option value="breed">Breed</option>
                    <option value="cat_age">Age</option>
                    <option value="cat_health">Health</option>
                    <option value="special_requirements">Special Requirements</option>
                </select>

                <select name="order">
                    <option value="asc">Ascending</option>
                    <option value="desc">Descending</option>
                </select>
                <input type="submit" value="Search">
            </form>
            </section>

            <section class="cat-profiles">
            <h1 id="cats-header">Our Cats</h1><br>
            <!-- this is the section where all cat profiles will be displayed from the database,
             where users can access their profiles or apply to adopt-->
            <div class="cats-container">
                <?php foreach ($cats as $cat): ?>
                    <div class="cat-box">
                        <a href="catProfilePage.php?id=<?php echo $cat['cat_id']; ?>">
                            <img src="../nlhImages/<?php echo $cat['image_url']; ?>.jpg" alt="<?php echo $cat['cat_name']; ?>"
                                style="height:200px; max-width:300px;">
                            <p class="cat-name">
                                <?php echo $cat['cat_name']; ?>
                            </p>
                        </a>
                        <p class="cat-breed">
                            <?php echo $cat['breed']; ?>
                        </p>
                        <p class="cat-age">
                            <?php echo $cat['cat_age']; ?>
                        </p>
                        <p class="cat-health">
                            <?php echo $cat['cat_health']; ?>
                        </p>
                        <p class="cat-requirements">
                            <?php echo $cat['special_requirements']; ?>
                        </p>
                    </div>
                <?php endforeach; ?>
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

<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">

<head>
    <title>Your Adoption Applications - Nine Lives Haven</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
</head>

<?php
session_start();

// if the admin is not logged in, redirect to sign in page
if (!isset($_SESSION['user_id']) || $_SESSION['admin_status'] != 1) {
    header('Location:adminSignInPage.php');
    exit();
}

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
    </header>

    <section class="page-title">
        <h1>Your Adoption Applications</h1>
    </section>

    <!-- cat table -->
    <section class="cat-database">
                <!-- search and sort form -->
        <form action="adminCatDatabasePage.php" method="get">
            <input type="text" name="search" class="search-bar"
                value="<?= isset($search) && $search !== '' ? htmlspecialchars($search) : '' ?>"
                placeholder="Search...">
            <select name="sort">
                <option value="cat_id">Cat ID</option>
                <option value="cat_name">Cat Name</option>
                <option value="breed">Cat Breed</option>
                <option value="cat_health">Health</option>
                <option value="cat_description">Description</option>
                <option value="adoption_status">Adoption Status</option>
                <option value="special_requirements">Special Requirements</option>
            </select>

            <select name="order">
                <option value="asc">Ascending</option>
                <option value="desc">Descending</option>
            </select>
            <input type="submit" value="Search">
        </form>


        <table border="1">
            <thead>
                <tr>
                    <th>Cat Image</th>
                    <th>Cat ID</th>
                    <th>Cat Name</th>
                    <th>Cat Breed</th>
                    <th>Health</th>
                    <th>Description</th>
                    <th>Adoption Status</th>
                    <th>Special Requirements</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cats as $cat): ?>
                    <tr>
                        <td><img src="../nlhImages/<?php echo $cat['image_url']; ?>.jpg" alt="Cat Image"
                                style="width:100px;height:100px;"></td>
                        <td><?= htmlspecialchars($cat['cat_id']) ?></td>
                        <td><?= htmlspecialchars($cat['cat_name']) ?></td>
                        <td><?= htmlspecialchars($cat['breed']) ?></td>
                        <td><?= htmlspecialchars($cat['cat_health']) ?></td>
                        <td><?= htmlspecialchars($cat['cat_description']) ?></td>
                        <td><?= htmlspecialchars($cat['adoption_status']) ?></td>
                        <td><?= htmlspecialchars($cat['special_requirements']) ?></td>
                        <td>
                            <form action="editCatDetails.php" method="get">
                                <input type="hidden" name="cat_id" value="<?= htmlspecialchars($cat['cat_id']) ?>">
                                <button type="submit">Edit</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
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

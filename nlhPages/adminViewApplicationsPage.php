<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">

<head>
    <title>Applications Database - Nine Lives Haven</title>
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

// searching and sorting
$search = isset($_GET['search']) ? mysqli_real_escape_string($con, $_GET['search']) : '';
$sort = isset($_GET['sort']) && in_array($_GET['sort'], ['application_date', 'first_name', 'cat_name', 'application_status'])
    ? mysqli_real_escape_string($con, $_GET['sort']) : 'application_date';
$order = isset($_GET['order']) && in_array($_GET['order'], ['asc', 'desc'])
    ? mysqli_real_escape_string($con, $_GET['order']) : 'desc';

// fetch applications with search/filter applied, as well as linking other tables
$query = "
    SELECT 
        aa.application_id,
        aa.application_date,
        aa.application_status,
        u.user_id,
        u.first_name,
        u.last_name,
        u.phone_number,
        u.email,
        c.cat_id,
        c.cat_name,
        c.adoption_status
    FROM 
        adoption_applications AS aa
    INNER JOIN 
        users AS u ON aa.user_id = u.user_id
    INNER JOIN 
        cats AS c ON aa.cat_id = c.cat_id
    WHERE 
        (u.first_name LIKE '%$search%' OR 
         u.last_name LIKE '%$search%' OR 
         c.cat_name LIKE '%$search%' OR 
         aa.application_status LIKE '%$search%')
    ORDER BY 
        $sort $order
";

$result = mysqli_query($con, $query);

if (!$result) {
    echo "Error fetching data: " . mysqli_error($con);
    exit();
}

$applications = mysqli_fetch_all($result, MYSQLI_ASSOC);
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
        <h1>Adoption Applications</h1>
    </section>

    <!-- applications table -->
    <section class="applications-database">
        <!-- search and sort form -->
        <form method="get" action="">
            <input type="text" name="search" value="<?= htmlspecialchars($search) ?>"
                placeholder="Search applications...">
            <select name="sort">
                <option value="application_date" <?= $sort === 'application_date' ? 'selected' : '' ?>>Application Date
                </option>
                <option value="first_name" <?= $sort === 'first_name' ? 'selected' : '' ?>>Applicant Name</option>
                <option value="cat_name" <?= $sort === 'cat_name' ? 'selected' : '' ?>>Cat Name</option>
                <option value="application_status" <?= $sort === 'application_status' ? 'selected' : '' ?>>Application
                    Status</option>
            </select>
            <select name="order">
                <option value="asc" <?= $order === 'asc' ? 'selected' : '' ?>>Ascending</option>
                <option value="desc" <?= $order === 'desc' ? 'selected' : '' ?>>Descending</option>
            </select>
            <button type="submit">Search</button>
        </form>

        <!-- applications table -->
        <table border="1">
            <thead>
                <tr>
                    <th>Application ID</th>
                    <th>Application Date</th>
                    <th>Application Status</th>
                    <th>User ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th>Cat ID</th>
                    <th>Cat Name</th>
                    <th>Adoption Status</th>
                </tr>
            </thead>
            <tbody> <?php foreach ($applications as $application): ?>
                    <tr>
                        <td><?= htmlspecialchars($application['application_id']) ?></td>
                        <td><?= htmlspecialchars($application['application_date']) ?></td>
                        <td><?= htmlspecialchars($application['application_status']) ?></td>
                        <td><?= htmlspecialchars($application['user_id']) ?></td>
                        <td><?= htmlspecialchars($application['first_name']) ?></td>
                        <td><?= htmlspecialchars($application['last_name']) ?></td>
                        <td><?= htmlspecialchars($application['phone_number']) ?></td>
                        <td><?= htmlspecialchars($application['email']) ?></td>
                        <td><?= htmlspecialchars($application['cat_id']) ?></td>
                        <td><?= htmlspecialchars($application['cat_name']) ?></td>
                        <td><?= htmlspecialchars($application['adoption_status']) ?></td>
                        <td>
                            <form action="viewIndvApplication.php" method="get">
                                <input type="hidden" name="application_id"
                                    value="<?= htmlspecialchars($application['application_id']) ?>">
                                <button type="submit">View</button>
                            </form>
                        </td>
                        <td>
                            <form action="editApplicationDetails.php" method="get">
                                <input type="hidden" name="application_id" value="<?= htmlspecialchars($application['application_id']) ?>">
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

<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">

<head>
    <title>Your Adoption Applications - Nine Lives Haven</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../nlhCSS/userViewApplicationsCSS.css">
</head>

<?php
session_start();

// if the user is not logged in, redirect to sign in page
if (!isset($_SESSION['user_id'])) {
    header("Location: userSignInPage.php");
    exit();
}

require 'connectdb.php';
include 'navbar.php'; // banner and nav bar

// fetch user id from session
$user_id = $_SESSION['user_id'];

// fetch adoption application details for user
$query = "
    SELECT 
        adoption_applications.application_id, 
        adoption_applications.application_status, 
        adoption_applications.application_date, 
        cats.cat_name 
    FROM adoption_applications
    INNER JOIN cats ON adoption_applications.cat_id = cats.cat_id
    WHERE adoption_applications.user_id = '$user_id'
    ORDER BY adoption_applications.application_date DESC";

$result = mysqli_query($con, $query);
?>

<body>
    <section class="page-title">
        <h1>Your Adoption Applications</h1>
    </section>

    <section class="intro-box">
        <p>
            Here you can view the details of your ongoing and past adoption applications. If you have any questions,
            please contact us through the <a href="contactUsPage.php">Contact Us</a> page.
        </p>
    </section>

    <!-- applications table -->
    <section>
    <?php if (mysqli_num_rows($result) > 0) { ?>
        <table class="applications-table">
            <thead>
                <tr>
                    <th>Application ID</th>
                    <th>Cat Name</th>
                    <th>Status</th>
                    <th>Application Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?= htmlspecialchars($row['application_id']); ?></td>
                        <td><?= htmlspecialchars($row['cat_name']); ?></td>
                        <td><?= htmlspecialchars($row['application_status']); ?></td>
                        <td><?= htmlspecialchars($row['application_date']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php } else { ?>
            <div class="no-data">
                <p>No adoption applications found. Start your journey by visiting <a href="ourCatsPage.php">Our Cats</a>!</p>
            </div>
        <?php } ?>
    </section>
</body>
<?php include 'footer.php'; // footer ?>

</html>

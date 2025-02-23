<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">

<head>
    <title>Your Sponsorships - Nine Lives Haven</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

// fetch sponsorship details for user
$query = "
    SELECT 
        s.sponsorship_id,
        s.sponsorship_amount,
        s.sponsorship_date,
        s.status,
        s.renewal_date,
        s.sponsorship_type,
        c.cat_name
    FROM 
        sponsorships AS s
    INNER JOIN 
        cats AS c ON s.cat_id = c.cat_id
    WHERE 
        s.user_id = '$user_id'
    ORDER BY 
        s.sponsorship_date DESC";

$result = mysqli_query($con, $query);
?>

<body>
    <section class="page-title">
        <h1>Your Sponsorships</h1>
    </section>

    <section class="intro-box">
        <p>
            Here you can view the details of your previous and ongoing sponsorships. If you have any questions,
            please contact us through the <a href="contactUsPage.php">Contact Us</a> page.
        </p>
    </section>

    <!-- sponsorships table -->
    <section>
        <?php if (mysqli_num_rows($result) > 0) { ?>
            <table class="sponsorship-table" border="1">
                <thead>
                    <tr>
                        <th>Sponsorship ID</th>
                        <th>Sponsored Cat</th>
                        <th>Sponsorship Amount</th>
                        <th>Sponsorship Date</th>
                        <th>Renewal Date</th>
                        <th>Sponsorship Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?= htmlspecialchars($row['sponsorship_id']); ?></td>
                            <td><?= htmlspecialchars($row['cat_name']); ?></td>
                            <td><?= htmlspecialchars($row['sponsorship_amount']); ?></td>
                            <td><?= htmlspecialchars($row['sponsorship_date']); ?></td>
                            <td><?= htmlspecialchars($row['renewal_date']); ?></td>
                            <td><?= htmlspecialchars($row['sponsorship_type']); ?></td>
                            <td>
                                <a href="userEditSponsorship.php?sponsorship_id=<?= $row['sponsorship_id']; ?>">
                                    <button>Edit</button>
                                </a>
                                <a href="#" onclick="confirmDelete(<?= $row['sponsorship_id']; ?>)">
                                <button>Delete</button>
                            </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <div class="no-data">
                <p>No sponsorships have been found. If you wish to sponsor one of our feline friends, please visit <a
                        href="userSponsorCatPage.php">our Sponsorship page!</a>!</p>
            </div>
        <?php } ?>
    </section>

    <script>
function confirmDelete(sponsorshipId) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'Do you really want to delete this sponsorship?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'userDeleteSponsorship.php?sponsorship_id=' + sponsorshipId;
        }
    });
}
</script>

</body>
<?php include 'footer.php'; // footer ?>


</html>

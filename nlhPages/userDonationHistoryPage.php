<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">

<head>
    <title>Your Donations - Nine Lives Haven</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../nlhCSS/userViewAppointmentsCSS.css">
    <style>
        .page-title {
            text-align: center;
            margin: 20px 0;
        }

        .intro-box {
            text-align: center;
            margin: 20px;
        }

        .donations-table {
            width: 90%;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            border-collapse: collapse;
        }

        .donations-table th,
        .donations-table td {
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        .donations-table thead {
            background: #c35721;
            color: white;
        }

        tbody tr:nth-child(even) {
            background: #f2f2f2;
        }

        .no-data {
            text-align: center;
            font-size: 16px;
            padding: 20px;
        }

        .no-data a {
            color: #c35721;
            text-decoration: none;
            font-weight: bold;
        }

        .no-data a:hover {
            color: #f4ac6d;
        }
    </style>
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

$user_id = $_SESSION['user_id'];

// fetch donation details for user
$query = "
    SELECT 
        d.donation_id,
        d.amount,
        d.donation_date,
        d.message
    FROM 
        donations AS d
    WHERE 
        d.user_id = '$user_id'
    ORDER BY 
        d.donation_date DESC";

$result = mysqli_query($con, $query);
?>

<body>
    <section class="page-title">
        <h1>Your Donations</h1>
    </section>

    <section class="intro-box">
        <p>
            Here you can view the details of your previous donations. If you have any questions,
            please contact us through the <a href="contactUsPage.php">Contact Us</a> page.
        </p>
    </section>

    <section>
        <?php if (mysqli_num_rows($result) > 0) { ?>
            <table class="donations-table">
                <thead>
                    <tr>
                        <th>Donation Amount</th>
                        <th>Donation Date</th>
                        <th>Donation Message</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?= htmlspecialchars($row['amount']); ?></td>
                            <td><?= htmlspecialchars($row['donation_date']); ?></td>
                            <td><?= htmlspecialchars($row['message']); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <div class="no-data">
                <p>No donations have been found. If you wish to donate, please visit <a href="userMakeDonationPage.php">our
                        Donation page!</a></p>
            </div>
        <?php } ?>
    </section>
</body>

<?php include 'footer.php'; // footer ?>

</html>

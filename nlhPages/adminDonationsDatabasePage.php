<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">

<head>
    <title>Donations Database - Nine Lives Haven</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../nlhCSS/adminDonationsDatabaseCSS.css">
</head>

<?php
session_start();

// if the admin is not logged in, redirect to the sign-in page
if (!isset($_SESSION['user_id']) || $_SESSION['admin_status'] != 1) {
    header('Location: adminSignInPage.php');
    exit();
}

require 'connectdb.php';
include 'navbar.php'; // banner and nav bar

$donations = []; // empty array to avoid errors if no data is retrieved

// search and sorting
$search = isset($_GET['search']) ? mysqli_real_escape_string($con, $_GET['search']) : '';
$sort = isset($_GET['sort']) ? mysqli_real_escape_string($con, $_GET['sort']) : 'donation_date';
$order = isset($_GET['order']) && in_array($_GET['order'], ['asc', 'desc']) ? $_GET['order'] : 'desc';

$query = "SELECT d.donation_id, d.user_id, d.amount, d.donation_date, d.message, 
                 u.first_name, u.last_name 
          FROM donations AS d
          JOIN users AS u ON d.user_id = u.user_id
          WHERE d.message LIKE '%$search%' 
          OR u.first_name LIKE '%$search%' 
          OR u.last_name LIKE '%$search%' 
          ORDER BY $sort $order";

$result = mysqli_query($con, $query);

if ($result) {
    $donations = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    echo "Error fetching data: " . mysqli_error($con);
}
?>

<body>
    <section class="page-title">
        <h1>Donations Database</h1>
    </section>

    <section class="donations-database">
        <!-- search and sort form -->
        <form action="adminDonationsDatabasePage.php" method="get">
            <input type="text" name="search" class="search-bar"
                value="<?= isset($search) && $search !== '' ? htmlspecialchars($search) : '' ?>"
                placeholder="Search donations...">
            <select name="sort">
                <option value="donation_date">Date</option>
                <option value="amount">Amount</option>
                <option value="user_id">User ID</option>
                <option value="donation_id">Donation ID</option>
            </select>
            <select name="order">
                <option value="asc">Ascending</option>
                <option value="desc">Descending</option>
            </select>
            <input type="submit" value="Search">
        </form>

        <table>
            <thead>
                <tr>
                    <th>Donation ID</th>
                    <th>User Name</th>
                    <th>Amount</th>
                    <th>Donation Date</th>
                    <th>Message</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($donations as $donation): ?>
                    <tr>
                        <td><?= htmlspecialchars($donation['donation_id']) ?></td>
                        <td><?= htmlspecialchars($donation['first_name'] . ' ' . $donation['last_name']) ?></td>
                        <td>£<?= htmlspecialchars(number_format($donation['amount'], 2)) ?></td>
                        <td><?= htmlspecialchars($donation['donation_date']) ?></td>
                        <td><?= htmlspecialchars($donation['message']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</body>

<?php include 'footer.php'; // footer ?>

</html>

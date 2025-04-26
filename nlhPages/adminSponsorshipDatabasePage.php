<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">

<head>
    <title>Sponsorships Database - Nine Lives Haven</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
    <link rel="stylesheet" href="../nlhCSS/adminSponsorshipDatabaseCSS.css">
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

$sponsorships = [];

// search and sorting
$search = isset($_GET['search']) ? mysqli_real_escape_string($con, $_GET['search']) : '';
$sort = isset($_GET['sort']) ? mysqli_real_escape_string($con, $_GET['sort']) : 'sponsorship_date';
$order = isset($_GET['order']) && in_array($_GET['order'], ['asc', 'desc']) ? $_GET['order'] : 'desc';

$query = "SELECT s.sponsorship_id, s.user_id, s.cat_id, s.sponsorship_amount, s.sponsorship_date, s.status, s.sponsorship_type, s.renewal_date, 
                 u.first_name, u.last_name, c.cat_name 
          FROM sponsorships AS s
          JOIN users AS u ON s.user_id = u.user_id
          JOIN cats AS c ON s.cat_id = c.cat_id
          WHERE u.first_name LIKE '%$search%' 
          OR u.last_name LIKE '%$search%' 
          OR c.cat_name LIKE '%$search%' 
          ORDER BY $sort $order";

$result = mysqli_query($con, $query);

if ($result) {
    $sponsorships = mysqli_fetch_all($result, MYSQLI_ASSOC); 
} else {
    echo "Error fetching data: " . mysqli_error($con);
}
?>

<body>
    <section class="page-title">
        <h1>Sponsorships Database</h1>
    </section>

    <section>
        <div class="sponsorship-table">
            <form action="adminSponsorshipDatabasePage.php" method="get" class="search-form">
                <input type="text" name="search" class="search-bar"
                    value="<?= isset($search) && $search !== '' ? htmlspecialchars($search) : '' ?>"
                    placeholder="Search sponsorships...">
                <select name="sort">
                    <option value="sponsorship_date">Date</option>
                    <option value="sponsorship_amount">Amount</option>
                    <option value="user_id">User ID</option>
                    <option value="sponsorship_id">Sponsorship ID</option>
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
                        <th>Sponsorship ID</th>
                        <th>User Name</th>
                        <th>Cat Name</th>
                        <th>Amount</th>
                        <th>Sponsorship Date</th>
                        <th>Status</th>
                        <th>Sponsorship Type</th>
                        <th>Renewal Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sponsorships as $sponsorship): ?>
                        <tr>
                            <td><?= htmlspecialchars($sponsorship['sponsorship_id']) ?></td>
                            <td><?= htmlspecialchars($sponsorship['first_name'] . ' ' . $sponsorship['last_name']) ?></td>
                            <td><?= htmlspecialchars($sponsorship['cat_name']) ?></td>
                            <td>£<?= htmlspecialchars(number_format($sponsorship['sponsorship_amount'], 2)) ?></td>
                            <td><?= htmlspecialchars($sponsorship['sponsorship_date']) ?></td>
                            <td><?= htmlspecialchars($sponsorship['status']) ?></td>
                            <td><?= htmlspecialchars($sponsorship['sponsorship_type']) ?></td>
                            <td><?= htmlspecialchars($sponsorship['renewal_date']) ?></td>
                            <td>
                                <form action="editSponsorshipDetails.php" method="get">
                                    <input type="hidden" name="sponsorship_id"
                                        value="<?= htmlspecialchars($sponsorship['sponsorship_id']) ?>">
                                    <button type="submit">Edit</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</body>

<?php include 'footer.php'; // footer ?>

</html>

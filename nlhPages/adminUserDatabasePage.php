<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">

<head>
    <title>User Database - Nine Lives Haven</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../nlhCSS/adminUserDatabaseCSS.css"> 
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

$users = [];

// search and sorting
$search = isset($_GET['search']) ? mysqli_real_escape_string($con, $_GET['search']) : '';
$sort = isset($_GET['sort']) ? mysqli_real_escape_string($con, $_GET['sort']) : 'first_name';
$order = isset($_GET['order']) && in_array($_GET['order'], ['asc', 'desc']) ? $_GET['order'] : 'asc';

$query = "SELECT * FROM users 
          WHERE first_name LIKE '%$search%' 
          OR last_name LIKE '%$search%' 
          OR email LIKE '%$search%' 
          ORDER BY $sort $order";

$result = mysqli_query($con, $query);

if ($result) {
    $users = mysqli_fetch_all($result, MYSQLI_ASSOC); 
} else {
    echo "Error fetching data: " . mysqli_error($con);
}
?>

<body>
    <section class="page-title">
        <h1>User Database</h1>
    </section>

    <section class="cat-database">
        <form action="adminUserDatabasePage.php" method="get">
            <input type="text" name="search" class="search-bar"
                value="<?= isset($search) && $search !== '' ? htmlspecialchars($search) : '' ?>"
                placeholder="Search users...">
            <select name="sort">
                <option value="user_id">User ID</option>
                <option value="first_name">First Name</option>
                <option value="last_name">Last Name</option>
                <option value="email">Email</option>
                <option value="registration_date">Registration Date</option>
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
                    <th>User ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Admin Status</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Street Address</th>
                    <th>City</th>
                    <th>Post Code</th>
                    <th>Registration Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['user_id']) ?></td>
                        <td><?= htmlspecialchars($user['first_name']) ?></td>
                        <td><?= htmlspecialchars($user['last_name']) ?></td>
                        <td><?= htmlspecialchars($user['admin_status']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['phone_number']) ?></td>
                        <td><?= htmlspecialchars($user['street_address']) ?></td>
                        <td><?= htmlspecialchars($user['city']) ?></td>
                        <td><?= htmlspecialchars($user['post_code']) ?></td>
                        <td><?= htmlspecialchars($user['registration_date']) ?></td>
                        <td>
                            <form action="editUserDetails.php" method="get">
                                <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['user_id']) ?>">
                                <button type="submit" class="edit-btn">Edit</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</body>

<?php include 'footer.php'; // footer ?>

</html>

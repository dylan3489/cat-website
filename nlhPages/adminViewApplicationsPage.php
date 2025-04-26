<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">

<head>
    <title>Applications Database - Nine Lives Haven</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
    <link rel="stylesheet" href="../nlhCSS/adminViewApplicationsCSS.css">
</head>

<?php
session_start();

// if the admin is not logged in, redirect to sign in page
if (!isset($_SESSION['user_id']) || $_SESSION['admin_status'] != 1) {
    header('Location:adminSignInPage.php');
    exit();
}

require 'connectdb.php';
include 'navbar.php'; // banner and nav bar

// searching and sorting
$search = isset($_GET['search']) ? mysqli_real_escape_string($con, $_GET['search']) : '';
$sort = isset($_GET['sort']) && in_array($_GET['sort'], ['application_date', 'first_name', 'cat_name', 'application_status'])
    ? mysqli_real_escape_string($con, $_GET['sort']) : 'application_date';
$order = isset($_GET['order']) && in_array($_GET['order'], ['asc', 'desc'])
    ? mysqli_real_escape_string($con, $_GET['order']) : 'desc';

// fetch applications with search/filter applied + linking other tables
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
    <section class="page-title">
        <h1>Adoption Applications</h1>
    </section>

    <section class="applications-database">
        <form method="get" action="" class="search-form">
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
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($applications as $application): ?>
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
                                <input type="hidden" name="application_id"
                                    value="<?= htmlspecialchars($application['application_id']) ?>">
                                <button type="submit">Edit</button>
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

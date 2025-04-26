<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">

<head>
    <title>Appointments Database - Nine Lives Haven</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../nlhCSS/adminAppointmentsDatabaseCSS.css">
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
$sort = isset($_GET['sort']) && in_array($_GET['sort'], ['appointment_date', 'first_name', 'cat_name', 'status'])
    ? mysqli_real_escape_string($con, $_GET['sort']) : 'appointment_date';
$order = isset($_GET['order']) && in_array($_GET['order'], ['asc', 'desc'])
    ? mysqli_real_escape_string($con, $_GET['order']) : 'desc';

// fetch applications with search/filter applied, link other tables
$query = "
    SELECT 
        a.appointment_id,
        a.appointment_date,
        a.status,
        a.notes,
        u.user_id,
        u.first_name,
        u.last_name,
        u.phone_number,
        u.email,
        c.cat_id,
        c.cat_name,
        c.adoption_status
    FROM 
        appointments AS a
    INNER JOIN 
        users AS u ON a.user_id = u.user_id
    INNER JOIN 
        cats AS c ON a.cat_id = c.cat_id
    WHERE 
        (u.first_name LIKE '%$search%' OR 
         u.last_name LIKE '%$search%' OR 
         c.cat_name LIKE '%$search%' OR 
         a.status LIKE '%$search%')
    ORDER BY 
        $sort $order
";

$result = mysqli_query($con, $query);

if (!$result) {
    echo "Error fetching data: " . mysqli_error($con);
    exit();
}

$appointments = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<body>
    <section class="page-title">
        <h1>Appointments Database</h1>
    </section>

    <section class="appointments-database">
        <form method="get" action="">
            <input type="text" name="search" value="<?= htmlspecialchars($search) ?>"
                placeholder="Search applications...">
            <select name="sort">
                <option value="appointment_date" <?= $sort === 'appointment_date' ? 'selected' : '' ?>>Appointment Date
                </option>
                <option value="first_name" <?= $sort === 'first_name' ? 'selected' : '' ?>>Applicant Name</option>
                <option value="cat_name" <?= $sort === 'cat_name' ? 'selected' : '' ?>>Cat Name</option>
                <option value="status" <?= $sort === 'status' ? 'selected' : '' ?>>Appointment Status</option>
            </select>
            <select name="order">
                <option value="asc" <?= $order === 'asc' ? 'selected' : '' ?>>Ascending</option>
                <option value="desc" <?= $order === 'desc' ? 'selected' : '' ?>>Descending</option>
            </select>
            <button type="submit">Search</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Appointment ID</th>
                    <th>Appointment Date</th>
                    <th>Appointment Status</th>
                    <th>Appointment Notes</th>
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
                <?php foreach ($appointments as $appointment): ?>
                    <tr>
                        <td><?= htmlspecialchars($appointment['appointment_id']) ?></td>
                        <td><?= htmlspecialchars($appointment['appointment_date']) ?></td>
                        <td><?= htmlspecialchars($appointment['status']) ?></td>
                        <td><?= htmlspecialchars($appointment['notes']) ?></td>
                        <td><?= htmlspecialchars($appointment['user_id']) ?></td>
                        <td><?= htmlspecialchars($appointment['first_name']) ?></td>
                        <td><?= htmlspecialchars($appointment['last_name']) ?></td>
                        <td><?= htmlspecialchars($appointment['phone_number']) ?></td>
                        <td><?= htmlspecialchars($appointment['email']) ?></td>
                        <td><?= htmlspecialchars($appointment['cat_id']) ?></td>
                        <td><?= htmlspecialchars($appointment['cat_name']) ?></td>
                        <td><?= htmlspecialchars($appointment['adoption_status']) ?></td>
                        <td>
                            <form action="editAppointmentDetails.php" method="get">
                                <input type="hidden" name="appointment_id"
                                    value="<?= htmlspecialchars($appointment['appointment_id']) ?>">
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

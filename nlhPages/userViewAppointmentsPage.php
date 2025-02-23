<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">

<head>
    <title>Your Appointments - Nine Lives Haven</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
    <link rel="stylesheet" href="../nlhCSS/userViewAppointmentsCSS.css">
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
        a.appointment_id,
        a.appointment_date,
        a.status,
        a.notes,
        a.vet_name,
        c.cat_id,
        c.cat_name,
        c.adoption_status
    FROM 
        appointments AS a
    INNER JOIN 
        cats AS c ON a.cat_id = c.cat_id
    WHERE 
        a.user_id = '$user_id'
    ORDER BY 
        a.appointment_date DESC";

$result = mysqli_query($con, $query);
?>

<body>
    <section class="page-title">
        <h1>Your Appointments</h1>
    </section>

    <section class="intro-box">
        <p>
            Here you can view the details of your ongoing and past appointments. If you have any questions,
            please contact us through the <a href="contactUsPage.php">Contact Us</a> page.<br><br>

            If you want to request an appointment, <a href="userBookAppointmentPage.php">click here</a>.
        </p>
    </section>

    <!-- applications table -->
    <section>
    <?php if (mysqli_num_rows($result) > 0) { ?>
        <table class="appointments-table">
            <thead>
                <tr>
                    <th>Appointment ID</th>
                    <th>Cat Name</th>
                    <th>Appointment Status</th>
                    <th>Appointment Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?= htmlspecialchars($row['appointment_id']); ?></td>
                        <td><?= htmlspecialchars($row['cat_name']); ?></td>
                        <td><?= htmlspecialchars($row['status']); ?></td>
                        <td><?= htmlspecialchars($row['appointment_date']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php } else { ?>
            <div class="no-data">
                <p>No appointments have been found. If you need to request one, visit <a href="userBookAppointmentPage.php">Request an appointment!</a>!</p>
            </div>
        <?php } ?>
    </section>
</body>

<?php include 'footer.php'; // footer ?>

</html>

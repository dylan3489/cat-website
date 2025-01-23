<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Application</title>
</head>

<?php
session_start();
require 'connectdb.php';

// if the admin is not logged in, redirect to sign in page
if (!isset($_SESSION['loggedin']) || $_SESSION['admin_status'] != 1) {
    header('Location:adminSignInPage.php');
    exit();
}

// check if received application_id 
if (isset($_GET['application_id'])) {
    $application_id = intval($_GET['application_id']);

    // fetch application details
    $query = "
        SELECT aa.*, u.first_name, u.last_name, u.phone_number, u.email, 
               c.cat_name, c.adoption_status 
        FROM adoption_applications AS aa
        INNER JOIN users AS u ON aa.user_id = u.user_id
        INNER JOIN cats AS c ON aa.cat_id = c.cat_id
        WHERE aa.application_id = ?
    ";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $application_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $application = $result->fetch_assoc();

    if (!$application) {
        echo "Application not found.";
        exit();
    }
} else {
    echo "No application ID provided.";
    exit();
}
?>

<!-- display application details -->
<body>
    <h1>View Application Details</h1>
    <table border="1">
        <?php foreach ($application as $field => $value): ?>
            <tr>
                <th><?= htmlspecialchars(ucwords(str_replace('_', ' ', $field))) ?></th>
                <td><?= htmlspecialchars($value) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="adminViewApplicationsPage.php">Back to Applications</a>
</body>

</html>

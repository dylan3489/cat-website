<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Application Details</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .view-application-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
        }

        h2 {
            text-align: center;
            color: #8B5E3C;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background-color: #f4ac6d;
            color: white;
        }

        .view-application-container a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #f4ac6d;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 15px;
            font-size: 14px;
            max-width: 200px;
            width: auto;
        }

        .view-application-container a:hover {
            background-color: rgb(211, 133, 64);
        }
    </style>
</head>

<?php
session_start();
require 'connectdb.php';
include 'navbar.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['admin_status'] != 1) {
    header('Location:adminSignInPage.php');
    exit();
}

if (isset($_GET['application_id'])) {
    $application_id = intval($_GET['application_id']);
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

<body>
    <div class="view-application-container">
        <h2>View Application Details</h2>
        <table>
            <?php foreach ($application as $field => $value): ?>
                <tr>
                    <th><?= htmlspecialchars(ucwords(str_replace('_', ' ', $field))) ?></th>
                    <td><?= htmlspecialchars($value) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <a href="adminViewApplicationsPage.php">Back to Applications</a>
    </div>
</body>
<?php include 'footer.php'; ?>

</html>

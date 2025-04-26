<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit User Details - Nine Lives Haven</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .edit-user-container {
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

        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }

        input,
        select {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .edit-user-container button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #f4ac6d;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 15px;
        }

        .edit-user-container button:hover {
            background-color: rgb(211, 133, 64);
        }
    </style>
</head>

<?php
session_start();
require 'connectdb.php';
include 'navbar.php'; // banner and nav bar

if (!isset($_SESSION['user_id']) || $_SESSION['admin_status'] != 1) {
    header('Location: adminSignInPage.php');
    exit();
}

$user = null;
$message = '';

if (isset($_GET['user_id'])) {
    $user_id = mysqli_real_escape_string($con, $_GET['user_id']);
    $query = "SELECT * FROM users WHERE user_id = '$user_id'";
    $result = mysqli_query($con, $query);
    $user = mysqli_fetch_assoc($result);

    if (!$user) {
        $message = "User not found.";
    }
} else {
    $message = "No user selected.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = mysqli_real_escape_string($con, $_POST['user_id']);
    $first_name = mysqli_real_escape_string($con, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($con, $_POST['last_name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone_number = mysqli_real_escape_string($con, $_POST['phone_number']);
    $street_address = mysqli_real_escape_string($con, $_POST['street_address']);
    $city = mysqli_real_escape_string($con, $_POST['city']);
    $post_code = mysqli_real_escape_string($con, $_POST['post_code']);

    if (empty($message)) {
        $update_query = "UPDATE users SET 
                            first_name = ?, 
                            last_name = ?, 
                            email = ?, 
                            phone_number = ?, 
                            street_address = ?, 
                            city = ?, 
                            post_code = ?, 
                            admin_status = ?
                         WHERE user_id = ?";

        $stmt = $con->prepare($update_query);
        $stmt->bind_param("ssssssssi", $first_name, $last_name, $email, $phone_number, $street_address, $city, $post_code, $admin_status, $user_id);

        if ($stmt->execute()) {
            echo "<script>
                    Swal.fire({
                        title: 'Success!',
                        text: 'User details have been updated successfully.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(function() {
                        window.location.href = 'adminUserDatabasePage.php';
                    });
                  </script>";
        } else {
            echo "<script>
                    Swal.fire({
                        title: 'Error!',
                        text: 'There was an issue updating the user details.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                  </script>";
        }
    }
}
?>

<body>
    <div class="edit-user-container">
        <h2>Edit User Details</h2>
        <form method="post">
            <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['user_id']); ?>">

            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" value="<?= htmlspecialchars($user['first_name']); ?>" required>

            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" value="<?= htmlspecialchars($user['last_name']); ?>" required>

            <label for="email">Email:</label>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required>

            <label for="phone_number">Phone Number:</label>
            <input type="text" name="phone_number" value="<?= htmlspecialchars($user['phone_number']); ?>">

            <label for="street_address">Street Address:</label>
            <input type="text" name="street_address" value="<?= htmlspecialchars($user['street_address']); ?>" required>

            <label for="city">City:</label>
            <input type="text" name="city" value="<?= htmlspecialchars($user['city']); ?>">

            <label for="post_code">Post Code:</label>
            <input type="text" name="post_code" value="<?= htmlspecialchars($user['post_code']); ?>" required>

            <button type="submit">Update User</button>
        </form>
    </div>
</body>

<?php include 'footer.php'; // footer ?>

</html>

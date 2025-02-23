<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">

<head>
    <title>Edit Account Details - Nine Lives Haven</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>


        .edit-account-container {
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

        input {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .edit-account-container button {
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

        .edit-account-container button:hover {
            background-color:rgb(211, 133, 64);
        }

        
        .swal2-styled.swal2-confirm {
            background-color: #f4ac6d !important;
            color: white !important;
            border: none !important;
        }

        .swal2-styled.swal2-confirm:hover {
            background-color: #d68b4b !important;
        }
    </style>
</head>

<?php
session_start();
require 'connectdb.php';
include 'navbar.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: userSignInPage.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// fetch user details
$query = "SELECT * FROM users WHERE user_id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    die("User not found.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password = $_POST['current_password'];
    $new_first_name = $_POST['first_name'];
    $new_last_name = $_POST['last_name'];
    $new_phone = $_POST['phone_number'];
    $new_email = $_POST['email'];
    $new_address = $_POST['street_address'];
    $new_city = $_POST['city'];
    $new_post_code = $_POST['post_code'];
    $new_password = $_POST['new_password'] ?? null;
    $confirm_password = $_POST['confirm_password'] ?? null;

    // verify current password
    if (!password_verify($current_password, $user['password_hash'])) {
        echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Incorrect current password.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then(function() {
                    window.location.href = 'userEditDetails.php';
                });
              </script>";
        exit();
    }

    // when changing password, this will validate it
    if (!empty($new_password)) {
        if ($new_password !== $confirm_password) {
            echo "<script>
                    Swal.fire({
                        title: 'Error!',
                        text: 'New passwords do not match.',
                        icon: 'error',
                        confirmButtonText: 'OK',
                    }).then(function() {
                        window.location.href = 'userEditDetails.php';
                    });
                  </script>";
            exit();
        }
        $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);
    } else {
        $new_password_hashed = $user['password_hash']; 
    }

    // update query
    $update_query = "UPDATE users SET first_name = ?, last_name = ?, phone_number = ?, email = ?, street_address = ?, city = ?, post_code = ?, password_hash = ? WHERE user_id = ?";
    $stmt = $con->prepare($update_query);
    $stmt->bind_param("ssssssssi", $new_first_name, $new_last_name, $new_phone, $new_email, $new_address, $new_city, $new_post_code, $new_password_hashed, $user_id);

    if ($stmt->execute()) {
        echo "<script>
                Swal.fire({
                    title: 'Success!',
                    text: 'Your account details have been updated successfully.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(function() {
                    window.location.href = 'userAccountPage.php';
                });
              </script>";
    } else {
        echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'There was an issue updating your details.',
                    icon: 'error',
                    confirmButtonText: 'OK',
                });
              </script>";
    }
}
?>

<body>
    <div class="edit-account-container">
        <h2>Edit Account Details</h2>
        <form method="post">
            <label for="current_password">Current Password:</label>
            <input type="password" name="current_password" required>

            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" value="<?= htmlspecialchars($user['first_name']); ?>" required>

            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" value="<?= htmlspecialchars($user['last_name']); ?>" required>

            <label for="phone_number">Phone Number:</label>
            <input type="text" name="phone_number" value="<?= htmlspecialchars($user['phone_number']); ?>">
            
            <label for="phone_number">Email:</label>
            <input type="text" name="email" value="<?= htmlspecialchars($user['email']); ?>" required>

            <label for="street_address">Street Address:</label>
            <input type="text" name="street_address" value="<?= htmlspecialchars($user['street_address']); ?>" required>

            <label for="city">City:</label>
            <input type="text" name="city" value="<?= htmlspecialchars($user['city']); ?>">

            <label for="post_code">Post Code:</label>
            <input type="text" name="post_code" value="<?= htmlspecialchars($user['post_code']); ?>" required>

            <label for="new_password">New Password (optional):</label>
            <input type="password" name="new_password">

            <label for="confirm_password">Confirm New Password:</label>
            <input type="password" name="confirm_password">

            <button type="submit">Update Details</button>
        </form>
    </div>
</body>

<?php include 'footer.php'; ?>

</html>
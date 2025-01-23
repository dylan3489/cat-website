<!DOCTYPE html>
<html lang="en">

<?php
session_start();

require 'connectdb.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['admin_key'])) {
        $email = $_POST['email'];
        $password = $_POST['password_hash'];
        $admin_key = $_POST['admin_key'];

        $query = "SELECT user_id, email, password_hash, admin_key, admin_status FROM users WHERE email = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $verifyResult = password_verify($password, $user['password_hash']);

            if ($user && $user['admin_key'] == $admin_key && $verifyResult) { 
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['admin_status'] = 1;
                $_SESSION['loggedin'] = true;

                echo '<script>alert("Hi ' . $user['email'] . ', you are now logged in!");</script>';
                echo '<script>window.location.href = "adminAccountPage.php";</script>';
                exit();
            } else {
                echo '<script>alert("Invalid email, password, or admin ID.");</script>';
                echo '<script>window.location.href = "adminSignInPage.php";</script>';
                exit();
            }
        } else {
            echo '<script>alert("Invalid email, password, or admin ID.");</script>';
            echo '<script>window.location.href = "adminSignInPage.php";</script>';
            exit();
        }

    }
}

if ($stmt instanceof mysqli_stmt) {
    $stmt->close();
}
$con->close();
?>
</html>
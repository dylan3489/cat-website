<!DOCTYPE html>
<html lang="en">

<?php
session_start();

require 'connectdb.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $query = "SELECT user_id, email, password_hash, admin_status FROM users WHERE email = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $verifyResult = password_verify($password, hash: $user['password_hash']);

            if ($verifyResult) { 
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['admin_status'] = 0;
                $_SESSION['loggedin'] = true; 
            
                echo '<script>alert("Hi ' . $user['email'] . ', you are now logged in!");</script>';
                echo '<script>window.location.href = "userAccountPage.php";</script>';
                exit();
            } else {
                echo '<script>alert("Invalid email or password.");</script>';
                echo '<script>window.location.href = "userSignInPage.php";</script>';

                exit();
            }
        } else {
            echo '<script>alert("Invalid email or password.");</script>';
            echo '<script>window.location.href = "userSignInPage.php";</script>';
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
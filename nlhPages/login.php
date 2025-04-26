<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">

<head>
    <title>Sign In - Nine Lives Haven</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

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
            $verifyResult = password_verify($password, $user['password_hash']);

            if ($verifyResult) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['admin_status'] = $user['admin_status'];
                $_SESSION['loggedin'] = true;

                echo '<script>
                window.onload = function() {
                    Swal.fire({
                        icon: "success",
                        title: "Welcome Back!",
                        text: "Hi ' . $user['email'] . ', you are now logged in!",
                        confirmButtonColor: "#f4ac6d",
                        allowOutsideClick: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "userAccountPage.php";
                        }
                    });
                };
                </script>';
                exit();
            } else {
                echo '<script>
                window.onload = function() {
                    Swal.fire({
                        icon: "error",
                        title: "Login Failed",
                        text: "Invalid email or password.",
                        confirmButtonColor: "#f4ac6d"
                    }).then(() => {
                        window.location.href = "userSignInPage.php";
                    });
                };
                </script>';
                exit();
            }
        } else {
            echo '<script>
            window.onload = function() {
                Swal.fire({
                    icon: "error",
                    title: "Login Failed",
                    text: "Invalid email or password.",
                    confirmButtonColor: "#f4ac6d"
                }).then(() => {
                    window.location.href = "userSignInPage.php";
                });
            };
            </script>';
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

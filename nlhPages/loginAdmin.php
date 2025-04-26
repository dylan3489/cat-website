<!DOCTYPE html>
<html lang="en">

<head>
    <title>Administrator Sign In - Nine Lives Haven</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <?php
    session_start();

    require 'connectdb.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['admin_key'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
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

                    echo '<script>
                    Swal.fire({
                        icon: "success",
                        title: "Welcome Back!",
                        text: "Hi ' . $user['email'] . ', you are now logged in!",
                        confirmButtonColor: "#f4ac6d"
                    }).then(function() {
                        window.location.href = "adminAccountPage.php";
                    });
                </script>';

                    exit();
                } else {
                    echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Login Failed",
                        text: "Invalid email, password, or admin ID.",
                        confirmButtonColor: "#f4ac6d"
                    }).then(function() {
                        window.location.href = "adminSignInPage.php";
                    });
                </script>';
                    exit();
                }
            } else {
                echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Login Failed",
                    text: "Invalid email, password, or admin ID.",
                    confirmButtonColor: "#f4ac6d"
                }).then(function() {
                    window.location.href = "adminSignInPage.php";
                });
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

</body>

</html>

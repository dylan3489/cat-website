<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">

<head>
    <title>Administrator Sign Up - Nine Lives Haven</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../nlhCSS/adminSignUpCSS.css">
</head>

<body>

    <?php
    session_start();

    require 'connectdb.php';
    include 'navbar.php'; // banner and nav bar
    
    // if the user is logged in, they are redirected
    if (isset($_SESSION['user_id'])) {
        header('Location:homePage.php');
    }

    if (isset($_POST["submit"])) {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $date_of_birth = $_POST['date_of_birth'];
        $email = $_POST['email'];
        $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $phone_number = $_POST['phone_number'];
        $street_address = $_POST['street_address'];
        $city = $_POST['city'];
        $post_code = $_POST['post_code'];
        $admin_key = $_POST['admin_key'];
        $admin_code = $_POST['admin_code'];

        $verify_query = mysqli_query($con, "SELECT email FROM users WHERE email='$email'");
        if (mysqli_num_rows($verify_query) != 0) {
            echo '<script>
                    Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "This email is already used, please try another one!",
                    confirmButtonColor: "#f4ac6d"
                }).then(function() {
                    window.location.href = "javascript:self.history.back()";
                });
            </script>';

        } else {
            $admin_reference_code = 'admin2319!!';
            if ($admin_code === $admin_reference_code) {
                mysqli_query($con, "INSERT INTO users (first_name, last_name, date_of_birth, email, password_hash, phone_number, street_address, city, post_code, admin_key, admin_status) 
                    VALUES ('$first_name', '$last_name', '$date_of_birth', '$email', '$password_hash', '$phone_number', '$street_address', '$city', '$post_code', '$admin_key', 1)") or die("Error Occurred");

                echo '<script>
                Swal.fire({
                    icon: "success",
                    title: "Registration Successful!",
                    text: "Please sign in!",
                    confirmButtonColor: "#f4ac6d"
                }).then(function() {
                    window.location.href = "adminSignInPage.php";
                });
                </script>';

                exit();
            } else {
                echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Invalid Admin Reference Code!",
                    text: "The reference code you entered is incorrect.",
                    confirmButtonColor: "#f4ac6d"
                }).then(function() {
                    window.location.href = "adminSignUpPage.php";
                });
            </script>';

            }
        }
    }
    ?>

    <div class="registration-container">
        <form class="register" id="registerForm" method="post">
            <h3>Create an Administrator account</h3>
            <table class="registration-table">
                <tr>
                    <td><label for="first_name">First name:</label></td>
                    <td><input type="text" id="first_name" name="first_name" placeholder="First Name" required></td>
                </tr>
                <tr>
                    <td><label for="last_name">Last name:</label></td>
                    <td><input type="text" id="last_name" name="last_name" placeholder="Last Name" required></td>
                </tr>
                <tr>
                    <td><label for="date_of_birth">Date of Birth:</label></td>
                    <td><input type="date" id="date_of_birth" name="date_of_birth" required></td>
                </tr>
                <tr>
                    <td><label for="email">Email:</label></td>
                    <td><input type="email" id="email" name="email" placeholder="Email" required></td>
                </tr>
                <tr>
                    <td><label for="password">Password:</label></td>
                    <td><input type="password" id="password" name="password" placeholder="Password" required></td>
                </tr>
                <tr>
                    <td><label for="phone_number">Mobile Number:</label></td>
                    <td><input type="tel" id="phone_number" name="phone_number" placeholder="Mobile Number" required>
                    </td>
                </tr>
                <tr>
                    <td><label for="street_address">Street Address:</label></td>
                    <td><input type="text" id="street_address" name="street_address" placeholder="Street Address"
                            required></td>
                </tr>
                <tr>
                    <td><label for="city">City:</label></td>
                    <td><input type="text" id="city" name="city" placeholder="City"></td>
                </tr>
                <tr>
                    <td><label for="post_code">Post Code:</label></td>
                    <td><input type="text" id="post_code" name="post_code" placeholder="Post Code" required></td>
                </tr>
                <tr>
                    <td><label for="admin_key">Admin Key:</label></td>
                    <td><input type="password" id="admin_key" name="admin_key" placeholder="Admin Key" required></td>
                </tr>
                <tr>
                    <td><label for="admin_code">Admin Reference Code:</label></td>
                    <td><input type="password" id="admin_code" name="admin_code" placeholder="Admin Reference Code"
                            required></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <a href="userSignUpPage.php" class="admin-link">Not an administrator? Create a user account
                            here!</a>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" id="submit" name="submit" value="Register">
                    </td>
                </tr>
            </table>
        </form>
    </div>

</body>

</html>

<?php include 'footer.php'; // footer ?>

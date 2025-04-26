<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">

<head>
    <title>Sign In - Nine Lives Haven</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
    <link rel="stylesheet" href="../nlhCSS/userSignInCSS.css">
</head>

<?php
session_start();

require 'connectdb.php';
include 'navbar.php'; // banner and nav bar

// if the user is logged in, they are redirected
if (isset($_SESSION['user_id'])) {
    header('Location:homePage.php');
} else { ?>

    <body>

        <div class="main-container">
            <div class="left-box">
                <h1 id="login-header">User Sign In</h1>
                <form id="login-form" action="login.php" method="POST">
                    <?php
                    if (isset($_SESSION['error'])) {
                        echo '<p class="error">' . $_SESSION['error'] . '</p>';
                        unset($_SESSION['error']);
                    }
                    ?>
                    <input type="email" id="email" name="email" placeholder="Email" required><br><br>
                    <input type="password" id="password" name="password" placeholder="Password" required><br><br>
                    <a href="changePasswordPage.php">Forgotten Password?</a><br><br>
                    <input type="submit" id="login" name="login" value="Login">
                    <input type="button" value="Register" class="button" onclick="location.href='userSignUpPage.php';">
                    <input type="button" value="Admin Login" class="button" onclick="location.href='adminSignInPage.php';">
                </form>
            </div>

            <div class="right-box">
                <img src="../nlhImages/cat1.jpg" alt="Cat Image">
            </div>
        </div>
    </body>
<?php }
include 'footer.php'; // footer ?>

</html>

<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">

<head>
    <title>Administrator Sign In - Nine Lives Haven</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../nlhCSS/adminSignInCSS.css">
</head>

<?php
session_start();

require 'connectdb.php';
include 'navbar.php'; // banner and nav bar


// if user is logged in, they are redirected
if (isset($_SESSION['user_id'])) {
    header('Location:homePage.php');
} else { ?>

    <body>
        <div class="content">
            <div class="login-container">
                <h1 id="login-header">Administrator Sign In</h1>
                <?php if (isset($_SESSION['error'])) {
                    echo '<p class="error">' . $_SESSION['error'] . '</p>';
                    unset($_SESSION['error']);
                }
                ?>
                <form id="login-form" action="loginAdmin.php" method="post">
                    <input type="email" id="email" name="email" placeholder="Email" /><br><br>
                    <input type="password" id="password" name="password" placeholder="Password"><br><br>
                    <input type="admin_key" id="admin_key" name="admin_key" placeholder="Admin Key"><br><br>
                    <a href="changePasswordPage.php">Forgotten Password?</a><br><br>
                    <input type="submit" id="login" name="login" value="Login">
                    <input type="button" value="Register" id="register" class="button"
                        onclick="location.href='adminSignUpPage.php';">
                    <input type="button" value="User Login" class="button" onclick="location.href='userSignInPage.php';">
                    <br>
                </form>
            </div>
        </div>
    </body>
<?php }
include 'footer.php'; // footer  ?>

</html>

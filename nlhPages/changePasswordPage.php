<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">

<head>
    <title>Forgotten Password - Nine Lives Haven</title>
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
                <h1 id="login-header">Forgotten Password - Recovery Email</h1>
                <form id="login-form" action="login.php" method="POST">
                    <?php
                    if (isset($_SESSION['error'])) {
                        echo '<p class="error">' . $_SESSION['error'] . '</p>';
                        unset($_SESSION['error']);
                    }
                    ?>
                    <input type="email" id="email" name="email" placeholder="Email" required><br><br>
                    <a href="userSignInPage.php">Back to sign in?</a><br><br>
                    <input type="submit" id="login" name="login" value="Submit">
                </form>
            </div>

            <div class="right-box">
                <img src="../nlhImages/cat3.jpg" alt="Cat Image">
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                document.getElementById("login-form").addEventListener("submit", function (event) {
                    event.preventDefault();

                    let email = document.getElementById("email").value;
                    if (email.trim() !== "") {
                        Swal.fire({
                            icon: "success",
                            title: "Thank You!",
                            text: "An email has been sent to your account with password recovery instructions!",
                            confirmButtonColor: "#f4ac6d"
                        }).then(() => {
                            window.location.href = "userSignInPage.php";
                        });
                    }
                });
            });
        </script>

    </body>
<?php }
include 'footer.php'; // footer ?>

</html>

<?php
session_start();

require 'connectdb.php';
include 'navbar.php'; // banner and nav bar

?>

<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">

<head>
    <title>Contact Us - Nine Lives Haven</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../nlhCSS/contactUsCSS.css">
</head>

<body>
    <div class="page-header">
        <h1 class="page-title">Contact Us</h1>
        <p>Please feel free to contact us with any questions you may have about our services or kitties!</p>
    </div>

    <section class="registration-container">
        <form id="contact-form" class="contact" method="post" action="">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>

            <label for="phone">Phone Number:</label>
            <input type="tel" id="phone" name="phone"><br><br>

            <label for="contact_preference">Preferred Contact Method:</label>
            <select id="contact_preference" name="contact_preference">
                <option value="email">Email</option>
                <option value="phone">Phone</option>
            </select><br><br>

            <label for="message">Message:</label>
            <textarea id="message" name="message" required></textarea><br><br>

            <input type="submit" value="Send Message">
        </form>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById("contact-form").addEventListener("submit", function (event) {
                event.preventDefault();

                let name = document.getElementById("name").value.trim();
                let email = document.getElementById("email").value.trim();
                let message = document.getElementById("message").value.trim();

                if (name !== "" && email !== "" && message !== "") {
                    Swal.fire({
                        icon: "success",
                        title: "Message Sent!",
                        text: "Thank you for reaching out - we value any and all queries and will make sure to respond as soon as we can!.",
                        confirmButtonColor: "#f4ac6d"
                    }).then(() => {
                        window.location.href = "contactUsPage.php";
                    });
                }
            });
        });
    </script>

</body>

<?php include 'footer.php'; // footer ?>

</html>

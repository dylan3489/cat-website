<?php
session_start();

require 'connectdb.php';
include 'navbar.php'; // banner and nav bar
    
// check that the form has been submitted, using POST to check for submit key. then assigns the values submitted to variables of the the same name to use in sql queries.
// it will then send the contents as an email form.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars($_POST['phone']);
    $contact_preference = htmlspecialchars($_POST['contact_preference']);
    $message = htmlspecialchars($_POST['message']);
    
    $to = "220153489uni@gmail.com"; 
    $subject = "New Contact Us Form Submission";
    $headers = "From: $email" . "\r\n" . "Reply-To: $email";
    
    $email_body = "Name: $name\n";
    $email_body .= "Email: $email\n";
    $email_body .= "Phone: $phone\n";
    $email_body .= "Preferred Contact Method: $contact_preference\n";
    $email_body .= "Message:\n$message\n";
    
    if (mail($to, $subject, $email_body, $headers)) {
        echo "<script>alert('Your message has been sent successfully! We will make sure to get back to you within 48 hours!');</script>";
    } else {
        echo "<script>alert('There was an error sending your message. Please try again later.');</script>";
    }
}
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
        <form class="contact" method="post" action="">
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

</body>

<?php include 'footer.php'; // footer ?>

</html>

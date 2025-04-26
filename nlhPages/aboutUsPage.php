<?php
session_start();

require 'connectdb.php';
include 'navbar.php'; // banner and nav bar
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>About Us - Nine Lives Haven</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../nlhCSS/aboutUsCSS.css">
</head>

<body>
    <section class="intro-section">
        <img src="../nlhImages/catsleep.jpg" alt="About Us Background">
        <div class="intro-text">
            <h1>About Us</h1>
            <p>At Nine Lives Haven, we are dedicated to rescuing and rehabilitating stray and abandoned cats to nurturing new homes and families. Our
                organisation strives to provide these loving homes for these feline friends, ensuring they receive the care
                and attention they deserve. Through adoption programs, education, and ongoing support, we aim to
                create a brighter future for cats in need.</p>
        </div>
    </section>

    <section class="goals-section">
        <h2>Our Goals</h2>
        <div class="goal-item">
            <img src="../nlhImages/cat6.jpg" alt="Goal 1">
            <h3>Rescue More Cats</h3>
            <p>Our goal is to rescue and rehabilitate more cats each year, giving them a second chance at life.</p>
        </div>
        <div class="goal-item">
            <img src="../nlhImages/catstory1.jpg" alt="Goal 2">
            <h3>Promote Adoption</h3>
            <p>We aim to connect as many cats with their forever homes as possible, creating lasting bonds.</p>
        </div>
        <div class="goal-item">
            <img src="../nlhImages/catcare2.jpg" alt="Goal 3">
            <h3>Increase Awareness</h3>
            <p>We strive to educate the public about responsible pet ownership and the importance of adoption.</p>
        </div>
    </section>

    <section class="involved-section">
        <h2>How You Can Get Involved</h2>
        <p>There are many ways you can help! Whether you’re looking to adopt, sponsor or donate, your support means
            the world to us and our furry friends. Join our mission today!</p>
        <a href="ourCatsPage.php">Take a look at our friends looking for adoption...</a><br>
        <a href="userMakeDonationPage.php">Or look at donating to our organisation...</a><br>
        <a href="userSponsorCatPage.php">Or at sponsoring one of our cats...</a>
    </section>
</body>

</html>

<?php include 'footer.php'; // footer ?>

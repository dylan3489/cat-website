<?php
session_start();

require 'connectdb.php';
include 'navbar.php'; // banner and nav bar
?>

<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">

<head>
    <title>Nine Lives Haven</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../nlhCSS/homePageCSS.css">

</head>

<body>
    <section class="intro-section">
        <img src="../nlhImages/background.jpg" alt="Background Image">
        <div class="intro-text">
            <h1>Welcome to Nine Lives Haven</h1>
            <p>At Nine Lives Haven, it is our mission to make sure we can take in and help as many cats possible to find
                a place they can call home, and to provide as high a level of support a we can to new adopters that
                are bravely tackling the responsibilities of taking in one of our little felines. <br> <br>

                Find out more about our feline friends and how you can support them and start your adoption journey!
                <a href="ourCatsPage.php"><br><br>See our cats!</a>
            </p>
        </div>
    </section>

    <section class="success-stories">
        <h2>Recent Success Stories</h2>
        <div class="home-story-images">
            <div>
                <a href="successStoriesPage.php">
                    <img src="../nlhImages/catstory1.jpg" alt="Story 1">
                    <p>Bella found a home!</p>
                </a>
            </div>
            <div>
                <a href="successStoriesPage.php">
                    <img src="../nlhImages/catstory2.jpg" alt="Story 2">
                    <p>Tilly was adopted!</p>
                </a>
            </div>
            <div>
                <a href="successStoriesPage.php">
                    <img src="../nlhImages/catplay3.jpg" alt="Story 3">
                    <p>Felix is thriving!</p>
                </a>
            </div>
        </div>
        <a href="successStoriesPage.php">Want to check out more of our fluffy friends' journeys? Click here!</a>
    </section>


    <section class="cat-care-section">
        <h2>Considering adoption, but feeling unsure about the responsiblity? Visit our Cat Care section!</h2>
        <p>Don't worry! We understand that taking in a cat can be a daunting concept, especially one that could come
            from a troubled background.
            <br> <br>
            We want to ensure that they are looked after to the best of our ability, and this means helping out their
            new homeowners with the responsibilities and important details that come with adoption!

            <br> <br> Our cat care sections provides some helpful, accessible information on looking after a cat, the
            adoption process, links to further resources and more. <br> <br>
            <a href="catCarePage.php"> Click here!</a>

        </p>
    </section>
</body>

</html>

<?php include 'footer.php'; // footer
?>

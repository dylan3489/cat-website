<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">

<head>
    <title>Veterinary Services - Nine Lives Haven</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../nlhCSS/vetServicesCSS.css">
</head>

<?php
session_start();
require 'connectdb.php';
include 'navbar.php';
?>

<body>
    <section class="intro-section">
        <img src="../nlhImages/catcare9.jpg" alt="Cat Care Background">
        <div class="intro-text">
            <h1>Veterinary Services & Resources</h1>
            <p>Ensuring your cat receives proper veterinary care is essential for their health and well-being. Below are
                links to reputable UK-based organisations that offer expert advice on veterinary services, vaccinations,
                and overall feline healthcare.</p>
        </div>
    </section>

    <section class="vet-resources">
        <h1>Trusted UK Veterinary Resources</h1>
        <div class="care-container">
            <h2><a href="https://www.rspca.org.uk/adviceandwelfare/pets/cats/health" target="_blank">RSPCA - Cat Health
                    & Welfare</a></h2>
            <p>The Royal Society for the Prevention of Cruelty to Animals (RSPCA) provides extensive guidance on keeping
                your cat healthy, including vaccinations, neutering, and general welfare advice.</p>

            <h2><a href="https://www.cats.org.uk/help-and-advice/veterinary-guidance" target="_blank">Cats Protection -
                    Veterinary Guidance</a></h2>
            <p>Cats Protection offers in-depth veterinary advice on common feline health conditions, preventative care,
                and finding affordable vet services.</p>

            <h2><a href="https://www.bluecross.org.uk/advice/cat" target="_blank">Blue Cross - Cat Care & Health
                    Advice</a></h2>
            <p>Blue Cross provides expert advice on cat care, including first aid, dental care, and recognising signs of
                illness in cats.</p>

            <h2><a href="https://www.pdsa.org.uk/pet-help-and-advice/looking-after-your-pet/kittens-cats"
                    target="_blank">PDSA - Cat Health Advice</a></h2>
            <p>The PDSA offers guidance on vaccinations, microchipping, and common cat health concerns. They also
                provide low-cost veterinary care for eligible pet owners.</p>

        </div>
    </section>
</body>

</html>

<?php include 'footer.php'; ?>

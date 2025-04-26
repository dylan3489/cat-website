<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">

<head>
    <title>Cat Care - Nine Lives Haven</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../nlhCSS/catCareCSS.css">
</head>

<?php
session_start();
require 'connectdb.php';
include 'navbar.php';
?>

<body>
    <section class="intro-section">
        <img src="../nlhImages/catcare7.jpg" alt="Cat Care Background">
        <div class="intro-text">
            <h1>Cat Care Guide </h1>
            <p>Owning a cat is a rewarding experience, but it also comes with responsibilities. <br> <br>
                Whether you're a first-time adopter or looking to improve your feline care knowledge, it's important to
                understand their needs.<br><br>
                Cats require a safe and stimulating environment, a nutritious diet, regular veterinary care, and social
                interaction to thrive. By providing the right care, you can ensure a happy and healthy life for your
                feline companion. Read on for essential tips on adoption, nutrition, grooming, and behavior. <br><br>
                For further professional advice from reputable UK organisations, check out our <a
                    href="vetServicesPage.php">Vetinary Services section!</a></p>
        </div>
    </section>

    <section class="care-section">
        <div class="care-container">
            <h2>Adopting a Cat</h2>
            <p>Before adopting a cat, assess your lifestyle, home environment, and level of commitment. Cats can live
                for 15-20 years, so adoption is a long-term responsibility. Make sure you have a designated safe space
                for your new feline friend to adjust gradually. Invest in essential supplies such as a litter box,
                scratching posts, food and water bowls, and cozy resting areas.</p>

            <h2>Feeding & Nutrition</h2>
            <p>Cats require a high-protein diet with essential amino acids like taurine. Choose quality commercial cat
                food suited to their age and health needs. Kittens need more frequent meals, while adult cats can be fed
                twice a day. Avoid feeding them human food, as some ingredients like onions, garlic, and chocolate are
                toxic to cats. Always provide fresh water, and consider a water fountain if your cat prefers running
                water.</p>

            <h2>Health & Veterinary Care</h2>
            <p>Routine vet visits (at least once a year) are vital to keep your cat in good health. Vaccinations protect
                against common diseases, and flea, tick, and worm preventatives should be administered regularly.
                Spaying or neutering is essential for preventing unwanted litters and reducing health risks. Be
                observant of changes in behavior, appetite, or litter box habits, as these can signal health issues. For
                more advice on this, check out our <a href="vetServicesPage.php">Vetinary Services section!</a></p>

            <h2>Grooming & Hygiene</h2>
            <p>Regular grooming helps maintain a healthy coat and reduces hairballs. Short-haired cats may only need
                occasional brushing, while long-haired breeds require daily care. Trim their claws regularly to prevent
                overgrowth and scratching injuries. A clean litter box is crucial—scoop waste daily and change the
                litter frequently to maintain hygiene and prevent odors.</p>

            <h2>Enrichment & Play</h2>
            <p>Cats are intelligent and need both mental and physical stimulation. Interactive toys, puzzle feeders, and
                climbing structures help prevent boredom. Engage in daily play sessions using toys like feather wands or
                laser pointers to mimic hunting instincts. Providing scratching posts and cat trees satisfies their
                natural behaviors and prevents destructive scratching on furniture.</p>

            <h2>Understanding Cat Behavior</h2>
            <p>Each cat has a unique personality. Learning to read their body language and vocalizations helps build
                trust. Slow blinking, head bunting, and purring often indicate affection, while flattened ears or a
                twitching tail may signal stress. Provide a quiet retreat for your cat when they need solitude.</p>

            <h2>Introducing Your Cat to a New Home</h2>
            <p>Moving to a new environment can be overwhelming. Allow your cat to explore one room at a time before
                introducing them to the entire home. Gradually introduce them to other pets and family members. Using
                pheromone diffusers can help ease anxiety.</p>
        </div>
    </section>
</body>

</html>

<?php include 'footer.php'; ?>

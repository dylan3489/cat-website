<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">

<head>
    <title>Frequently Asked Questions - Nine Lives Haven</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../nlhCSS/faqCSS.css">
</head>

<?php
session_start();
require 'connectdb.php';
include 'navbar.php'; // banner and nav bar
?>

<body>
    <section class="intro-section">
        <img src="../nlhImages/catcare8.jpg" alt="Cat Care Background">
        <div class="intro-text">
            <h1>Frequently Asked Questions</h1>
            <p>Here are some of the most common questions adopters have about bringing a cat into their home. Whether
                you're wondering about care, behavior, or health, we've got answers to help make your adoption journey
                smooth and enjoyable.
                <br><br>For further professional advice from reputable UK organisations, check out our <a
                    href="vetServicesPage.php">Vetinary Services section!</a>
            </p>
        </div>
    </section>

    <section class="care-section">
        <div class="care-container">
            <h2>1. What should I consider before adopting a cat?</h2>
            <p>Before adopting, consider your lifestyle, work schedule, and financial readiness. Cats require daily
                care, vet check-ups, and attention. Additionally, assess if you have enough space and a stable
                environment, as cats thrive in consistent, low-stress households.</p>

            <h2>2. How do I prepare my home for a new cat?</h2>
            <p>Create a designated safe space where your cat can retreat and feel secure. Remove any toxic plants,
                secure small objects they could swallow, and ensure windows and doors are escape-proof. Provide a litter
                box, food and water bowls, toys, and a scratching post.</p>

            <h2>3. What type of food should I feed my cat?</h2>
            <p>Choose high-quality commercial cat food that is rich in protein and essential nutrients. Wet food
                provides hydration, while dry kibble helps with dental health. Avoid feeding cats human food such as
                onions, garlic, dairy, and chocolate, as these can be toxic.</p>

            <h2>4. How often should I take my cat to the vet?</h2>
            <p>Kittens should have frequent check-ups for vaccinations and deworming. Adult cats require annual wellness
                exams, and senior cats benefit from bi-annual visits to monitor their health. Preventative care,
                including flea treatments and dental check-ups, is essential.</p>

            <h2>5. How can I help my cat adjust to a new home?</h2>
            <p>Allow your cat to explore their new home gradually. Keep them in a quiet room initially, providing
                familiar objects like blankets or toys. Speak softly and avoid forcing interaction—let them approach you
                at their own pace.</p>

            <h2>6. How do I introduce my cat to other pets?</h2>
            <p>Introduce scents first by swapping bedding before face-to-face meetings. Gradually allow brief supervised
                interactions, rewarding calm behavior. Keep initial meetings short and positive, and never force
                interactions.</p>

            <h2>7. What vaccinations does my cat need?</h2>
            <p>Core vaccinations include feline herpesvirus, calicivirus, panleukopenia, and rabies. Additional
                vaccines, such as feline leukemia, may be recommended based on lifestyle and exposure risks.</p>

            <h2>8. Should I spay or neuter my cat?</h2>
            <p>Yes! Spaying and neutering prevent overpopulation, reduce the risk of certain cancers, and help prevent
                behavioral issues such as spraying and aggression.</p>

            <h2>9. Why is my cat scratching furniture?</h2>
            <p>Scratching is a natural instinct that helps maintain claw health and mark territory. Provide scratching
                posts and boards, and place them near furniture your cat tends to scratch. You can also use cat-safe
                deterrent sprays.</p>

            <h2>10. How do I litter train my cat?</h2>
            <p>Most cats instinctively use a litter box. Place it in a quiet, accessible area and keep it clean by
                scooping daily. If your cat stops using the litter box, consider possible stressors or health issues and
                consult a vet.</p>

            <h2>11. What are common signs of illness in cats?</h2>
            <p>Watch for changes in appetite, weight loss, lethargy, vomiting, diarrhea, or unusual litter box habits.
                Cats are good at hiding illness, so any behavioral changes should be taken seriously and checked by a
                vet.</p>

            <h2>12. How can I keep my cat entertained?</h2>
            <p>Provide toys, scratching posts, climbing structures, and daily play sessions. Cats enjoy interactive toys
                such as feather wands and laser pointers. Puzzle feeders also help stimulate their minds.</p>

            <h2>13. Why does my cat knead me?</h2>
            <p>Kneading is a comforting behavior from kittenhood. It indicates contentment and relaxation. Some cats
                knead soft surfaces before lying down as a nesting instinct.</p>

            <h2>14. What should I do if my cat goes missing?</h2>
            <p>Check hiding spots inside your home first. Search your neighborhood, post flyers, and notify shelters and
                microchip registries. Cats often hide nearby, so leave food and familiar scents outside to help them
                find their way back.</p>

            <h2>15. How do I know if my cat is happy?</h2>
            <p>A happy cat exhibits relaxed body language, purring, slow blinking, playful behavior, and a healthy
                appetite. They may also bring you toys or rub against you as a sign of affection.</p>
        </div>
    </section>

    <section class="additional-help">
        <h1>Need More Help?</h1>
        <div class="care-container">
            <p>If you have any additional questions or concerns, feel free to reach out to us!</p>
            <p><a href="contactUsPage.php">Contact Us</a> for more information or <a
                    href="userBookAppointmentPage.php">Book an Appointment</a> to speak with one of our team members.
            </p>
        </div>
    </section>
</body>

</html>

<?php include 'footer.php'; // footer ?>

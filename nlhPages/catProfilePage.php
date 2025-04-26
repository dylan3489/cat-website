<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../nlhCSS/catProfileCSS.css">
</head>

<?php
session_start();

require 'connectdb.php';
include 'navbar.php'; // banner and nav bar
?>

<body>
<section class="cat-section">
        <div class="cat-image">
            <?php
            $id = $_GET['id'];
            $query = "SELECT cat_id, cat_name, breed, cat_age, cat_health, cat_description, image_url, special_requirements, adoption_status FROM cats WHERE cat_id = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $cat = $result->fetch_assoc();

            echo "<img src='../nlhImages/" . $cat['image_url'] . ".jpg' alt='" . $cat['cat_name'] . "'>";
            ?>
        </div>

        <div class="cat-details">
            <p><strong>Name:</strong> <?= $cat['cat_name']; ?></p>
            <p><strong>Breed:</strong> <?= $cat['breed']; ?></p>
            <p><strong>Age:</strong> <?= $cat['cat_age']; ?></p>
            <p><strong>Health:</strong> <?= $cat['cat_health']; ?></p>
            <p><strong>Special Requirements:</strong> <?= $cat['special_requirements']; ?></p>
            <p><strong>Description:</strong> <?= $cat['cat_description']; ?></p>
            <p><strong>Status:</strong> 
                <span style="color: <?= ($cat['adoption_status'] == 'adopted') ? 'red' : 'white'; ?>;">
                    <?= ($cat['adoption_status'] == 'adopted') ? 'Adopted' : 'Available for Adoption'; ?>
                </span>
            </p>

            <?php if ($cat['adoption_status'] !== 'Adopted') : ?>
                <div class="cat-actions">
                    <form method="post" action="applyForAdoptionPage.php" class="apply-button">
                        <input type="hidden" name="cat_id" value="<?= $cat['cat_id']; ?>">
                        <input type="submit" value="Apply for Adoption">
                    </form>
                    <form method="post" action="userSponsorCatPage.php" class="apply-button">
                        <input type="hidden" name="cat_id" value="<?= $cat['cat_id']; ?>">
                        <input type="submit" value="Apply to Sponsor">
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <section class="aftercare-section">
        <div class="aftercare-title">Aftercare Information</div>
        <div class="aftercare-text">
            <p>After adopting or sponsoring a cat, it is important to provide proper care and attention. Ensure you have
                all the necessary supplies and stay informed about veterinary appointments. We have some helpful information available in our <a href="catCarePage.php">Cat Care section</a>, 
                and a member of our team will be happy to assist if you want to send us a <a href="contactUsPage.php">contact request</a> for advice or further resources. 
            </p>
        </div>
    </section>
</body>

</html>

<?php include 'footer.php'; // footer ?>

<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">

<head>
    <title>Success Stories - Nine Lives Haven</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../nlhCSS/successStoriesCSS.css">
</head>

<?php
session_start();

require 'connectdb.php';
include 'navbar.php'; // banner and nav bar

$query = "SELECT s.story_text, s.after_image_url, c.cat_name 
          FROM success_stories s 
          JOIN cats c ON s.cat_id = c.cat_id 
          ORDER BY s.story_date DESC 
          LIMIT 3";

$result = mysqli_query($con, $query);
$stories = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_close($con);
?>

<body>
    <section class="stories-intro">
        <h1>Success Stories</h1>
        <div class="intro-box">
            <p>Read heartwarming success stories of our rescued friends finding their forever homes.</p>
        </div>
    </section>

    <?php if (count($stories) >= 3): ?>
        <!-- first story-->
        <section class="story-block bg-1">
            <img src="../nlhImages/<?php echo $stories[0]['after_image_url']; ?>.jpg"
                alt="<?php echo $stories[0]['cat_name']; ?>" class="story-image">
            <div class="story-text">
                <h3><?php echo $stories[0]['cat_name']; ?></h3>
                <p><?php echo $stories[0]['story_text']; ?></p>
            </div>
        </section>

        <!-- second story -->
        <section class="story-block bg-2 right">
            <div class="story-text">
                <h3><?php echo $stories[1]['cat_name']; ?></h3>
                <p><?php echo $stories[1]['story_text']; ?></p>
            </div>
            <img src="../nlhImages/<?php echo $stories[1]['after_image_url']; ?>.jpg"
                alt="<?php echo $stories[1]['cat_name']; ?>" class="story-image">
        </section>

        <!-- third story -->
        <section class="story-block bg-3">
            <img src="../nlhImages/<?php echo $stories[2]['after_image_url']; ?>.jpg"
                alt="<?php echo $stories[2]['cat_name']; ?>" class="story-image">
            <div class="story-text">
                <h3><?php echo $stories[2]['cat_name']; ?></h3>
                <p><?php echo $stories[2]['story_text']; ?></p>
            </div>
        </section>
    <?php else: ?>
        <p class="no-stories">Not enough success stories available.</p>
    <?php endif; ?>

</body>
<?php include 'footer.php'; // footer ?>

</html>

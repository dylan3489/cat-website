<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply to Adopt - Nine Lives Haven</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../nlhCSS/applyForAdoptionCSS.css">


</head>

<?php
session_start();
require 'connectdb.php';
include 'navbar.php'; // banner and nav bar

// retrieve the cat ID from the URL query parameter
$id = $_POST['cat_id'];
$query = "SELECT cat_id, cat_name FROM cats WHERE cat_id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();
$cat = $result->fetch_assoc();

$cat_name = $cat['cat_name'];


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitted']) && $_POST['submitted'] == 1 && isset($_POST['cat_id'])) {
    $stmt = $con->prepare("INSERT INTO adoption_applications (
        user_id, cat_id, age, occupation, hear_about, dwelling, ownership, landlord_permission, household_people, 
        other_pets, allergies, why_interest, preference, owned_cat_before, previous_experience, secure_space, hours_alone, 
        indoor_or_outdoor, secure_outdoor_area, financial_prepared, lifetime_commitment, regular_care, 
        understood_responsibility, accuracy_confirm, home_visit_permission, understood_terms
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param(
        "iiissississsssssssssssssss",
        $_SESSION['user_id'],
        $_POST['cat_id'],
        $_POST['age'],
        $_POST['occupation'],
        $_POST['hear_about'],
        $_POST['dwelling'],
        $_POST['ownership'],
        $_POST['landlord_permission'],
        $_POST['household_people'],
        $_POST['other_pets'],
        $_POST['allergies'],
        $_POST['why_interest'],
        $_POST['preference'],
        $_POST['owned_cat_before'],
        $_POST['previous_experience'],
        $_POST['secure_space'],
        $_POST['hours_alone'],
        $_POST['indoor_or_outdoor'],
        $_POST['secure_outdoor_area'],
        $_POST['financial_prepared'],
        $_POST['lifetime_commitment'],
        $_POST['regular_care'],
        $_POST['understood_responsibility'],
        $_POST['accuracy_confirm'],
        $_POST['home_visit_permission'],
        $_POST['understood_terms']
    );

    $stmt->execute();
    $stmt->close();

    echo '<script>
        Swal.fire({
            icon: "success",
            title: "Application Submitted!",
            text: "Your adoption application has been submitted successfully.",
            confirmButtonColor: "#f4ac6d"
        }).then(function() {
            window.location.href = "userAccountPage.php";
        });
    </script>';

    exit();
}
?>

<?php
// checks if the user is logged in, if not they are redirected
if (!isset($_SESSION['user_id'])) {
    echo '<script>
        Swal.fire({
            icon: "warning",
            title: "Sign In Required",
            text: "Please sign in or create an account to apply to adopt!",
            confirmButtonText: "Sign In",
            confirmButtonColor: "#f4ac6d",
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "userSignInPage.php";
            }
        });
    </script>';
    exit();
}
?>

<body>
    <section class="page-title">
        <h1>Apply to Adopt</h1>
    </section>

    <section class="application-section">
        <div class="application-form">
            <form method="POST" action="">
                <input type="hidden" name="submitted" value="1">
                <input type="hidden" name="cat_id" value="<?php echo $_POST['cat_id']; ?>">

                <p>Cat you want to adopt: <strong><?php echo $cat_name; ?></strong></p>

                <label for="age">Your Age:</label>
                <input type="number" name="age" id="age" required>

                <label for="occupation">Your Occupation:</label>
                <input type="text" name="occupation" id="occupation" required>

                <label for="hear_about">How did you hear about us?</label>
                <input type="text" name="hear_about" id="hear_about">

                <label for="dwelling">What type of dwelling do you live in?</label>
                <input type="text" name="dwelling" id="dwelling">

                <label for="ownership">Do you own or rent your home?</label>
                <input type="text" name="ownership" id="ownership">

                <label for="landlord_permission">If renting, do you have your landlord's permission? (yes/no)</label>
                <select name="landlord_permission" id="landlord_permission">
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>

                <label for="household_people">How many people live in your household?</label>
                <input type="number" name="household_people" id="household_people">

                <label for="other_pets">Do you have other pets? (yes/no)</label>
                <select name="other_pets" id="other_pets">
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>

                <label for="allergies">Does anyone in your household have pet allergies? (yes/no)</label>
                <select name="allergies" id="allergies">
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>

                <label for="why_interest">Why are you interested in adopting this cat?</label>
                <textarea name="why_interest" id="why_interest" required></textarea>

                <label for="preference">Do you have a preference for certain cat characteristics?</label>
                <input type="text" name="preference" id="preference">

                <label for="owned_cat_before">Have you owned a cat before? (yes/no)</label>
                <select name="owned_cat_before" id="owned_cat_before">
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>

                <label for="previous_experience">Describe your previous experience with pets:</label>
                <textarea name="previous_experience" id="previous_experience"></textarea>

                <label for="secure_space">Do you have a secure space for the cat? (yes/no)</label>
                <select name="secure_space" id="secure_space">
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>

                <label for="hours_alone">How many hours per day will the cat be alone?</label>
                <input type="text" name="hours_alone" id="hours_alone">

                <label for="indoor_or_outdoor">Do you prefer the cat to be indoor or outdoor?</label>
                <input type="text" name="indoor_or_outdoor" id="indoor_or_outdoor">

                <label for="secure_outdoor_area">Do you have a secure outdoor area? (yes/no)</label>
                <select name="secure_outdoor_area" id="secure_outdoor_area">
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>

                <label for="financial_prepared">Are you financially prepared to care for a cat? (yes/no)</label>
                <select name="financial_prepared" id="financial_prepared">
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>

                <label for="lifetime_commitment">Are you ready to make a lifetime commitment? (yes/no)</label>
                <select name="lifetime_commitment" id="lifetime_commitment">
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>

                <label for="regular_care">Can you provide regular care for the cat? (yes/no)</label>
                <select name="regular_care" id="regular_care">
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>

                <label for="understood_responsibility">Do you understand the responsibilities of cat ownership?
                    (yes/no)</label>
                <select name="understood_responsibility" id="understood_responsibility">
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>

                <label for="accuracy_confirm">Do you confirm that the information provided is accurate? (yes/no)</label>
                <select name="accuracy_confirm" id="accuracy_confirm">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>

                <label for="home_visit_permission">Do you agree to a home visit? (yes/no)</label>
                <select name="home_visit_permission" id="home_visit_permission">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>

                <label for="understood_terms">Do you agree to our terms and conditions? (yes/no)</label>
                <select name="understood_terms" id="understood_terms">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>

                <button type="submit">Submit Application</button>
            </form>
        </div>
    </section>
</body>


<?php include 'footer.php'; // footer ?>

</html>

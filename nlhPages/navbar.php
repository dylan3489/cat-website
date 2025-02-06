<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');

    body {
        font-family: 'Roboto', sans-serif;
        background-color: #fff0e0;
        margin: 0;
        padding: 0;
    }
    
    section {
        padding-top: 0.7%;
    }

    /*banner Styling */
    .banner {
        background-color: #f4ac6d;
        width: 101%;
        height: 150px;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: -10px;
    }

    /* Logo Styling */
    .logo {
        width: 100%;
        max-height: 250px;
        object-fit: contain;
    }

    /* Navbar Styling */
    .header-nav {
        background-color: #f4ac6d;
        width: 101%;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 10px 0;
        margin: -10px;
    }

    /* Navigation Bar */
    .navigation-bar {
        width: 90%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0;
        margin: 0;
        list-style: none;
        font-family: 'Arial', sans-serif;
        /* Set same font-family */
    }


    .navigation-bar li {
        display: inline;

    }

    .navigation-bar a {
        text-decoration: none;
        color: white;
        font-size: 18px;
        font-weight: bold;
        padding: 10px 15px;
        transition: 0.3s;
    }

    .navigation-bar a:hover {
        background-color: rgba(255, 255, 255, 0.3);
        border-radius: 5px;
    }

    /* Dropdown Styling */
    .CatCare,
    .AdminDropDown {
        position: relative;
    }

    .dropbtn {
        background: none;
        border: none;
        color: white;
        font-size: 18px;
        font-weight: bold;
        cursor: pointer;
        padding: 10px;
        font-family: 'Arial', sans-serif;
    }

    .products-content {
        display: none;
        position: absolute;
        background-color: white;
        min-width: 180px;
        box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    .products-content a {
        color: #f4ac6d;
        padding: 10px 15px;
        display: block;
    }

    .products-content a:hover {
        background-color: #f4ac6d;
        color: white;
    }

    .CatCare:hover .products-content,
    .AdminDropDown:hover .products-content {
        display: block;
    }

    /* Button Styling */
    button {
        background-color: white;
        border: none;
        padding: 10px 15px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        border-radius: 5px;
        color: #f4ac6d;
    }

    button a {
        text-decoration: none;
        color: #f4ac6d !important;
    }
</style>

<!-- shared banner and navbar across site -->
<header>
    <div class="banner">
        <a href="homePage.php">
            <img src="../nlhImages/logo.png" class="logo" alt="Company Logo">
        </a>
    </div>

    <?php
    if (isset($_SESSION['loggedin'])) {
        if (isset($_SESSION['admin_status']) && $_SESSION['admin_status'] == 1) {
            ?>
            <nav class="header-nav">
                <ul class="navigation-bar">
                    <li><a href="homePage.php">Home</a></li>
                    <li><a href="aboutUsPage.php">About Us</a></li>
                    <li><a href="ourCatsPage.php">Our Cats</a></li>
                    <nav class="CatCare">
                        <a href="catCarePage.php"><button class="dropbtn">Cat Care</button></a>
                        <nav class="products-content">
                            <a href="faqPage.php">FAQs</a>
                            <a href="catCarePage.php">Advice on Cat Care</a>
                            <a href="vetServicesPage.php">Vetinary Services</a>
                        </nav>
                    </nav>
                    <nav class="AdminDropDown">
                        <a href="adminAccountPage.php"><button class="dropbtn">Your Admin Account</button></a>
                        <nav class="products-content">
                            <a href="adminEditAccountPage.php">Edit Your Account</a>
                            <a href="adminViewApplicationsPage.php">Adoption Applications</a>
                            <a href="adminAppointmentsDatabasePage.php">Appointments</a>
                            <a href="adminDonationsDatabasePage.php">Donations Database</a>
                            <a href="adminSponsorshipDatabasePage.php">Sponsorships Database</a>
                            <a href="adminStoriesDatabasePage.php">Success Stories Database</a>
                            <a href="adminUserDatabasePage.php">User Database</a>
                            <a href="adminCatDatabasePage.php">Cats Database</a>
                        </nav>
                    </nav>
                    <li><a href="contactUsPage.php">Contact Us </a></li>
                    <button><a href="userMakeDonationPage.php">Donate</a></button>
                    <button><a href="logout.php">Logout</a></button>
                </ul>
            </nav>
            <?php
        } else {
            ?>
            <nav class="header-nav">
                <ul class="navigation-bar">
                    <li><a href="homePage.php">Home</a></li>
                    <li><a href="aboutUsPage.php">About Us</a></li>
                    <li><a href="ourCatsPage.php">Our Cats</a></li>
                    <nav class="CatCare">
                        <a href="catCarePage.php"><button class="dropbtn">Cat Care</button></a>
                        <nav class="products-content">
                            <a href="faqPage.php">FAQs</a>
                            <a href="catCarePage.php">Advice on Cat Care</a>
                            <a href="vetServicesPage.php">Vetinary Services</a>
                        </nav>
                    </nav>
                    <nav class="AdminDropDown">
                        <a href="userAccountPage.php"><button class="dropbtn">Your Account</button></a>
                        <nav class="products-content">
                            <a href="userEditAccountPage.php">Edit Your Account</a>
                            <a href="userViewApplicationsPage.php">Your Adoption Applications</a>
                            <a href="userViewAppointmentsPage.php">Your Appointments</a>
                            <a href="userDonationHistoryPage.php">Your Donations</a>
                            <a href="userViewSponsorshipsPage.php">Your Sponsorships</a>
                        </nav>
                    </nav>
                    <li><a href="contactUsPage.php">Contact Us </a></li>
                    <button><a href="userMakeDonationPage.php">Donate</a></button>
                    <button><a href="logout.php">Logout</a></button>
                </ul>
            </nav>
            <?php
        }
    } else {
        ?>
        <nav class="header-nav">
            <ul class="navigation-bar">
                <li><a href="homePage.php">Home</a></li>
                <li><a href="aboutUsPage.php">About Us</a></li>
                <li><a href="ourCatsPage.php">Our Cats</a></li>
                <nav class="CatCare">
                    <a href="catCarePage.php"><button class="dropbtn">Cat Care</button></a>
                    <nav class="products-content">
                        <a href="faqPage.php">FAQs</a>
                        <a href="catCarePage.php">Advice on Cat Care</a>
                        <a href="vetServicesPage.php">Vetinary Services</a>
                    </nav>
                </nav>
                <li><a href="contactUsPage.php">Contact Us </a></li>
                <button><a href="userMakeDonationPage.php">Donate</a></button>
                <button><a href="userSignInPage.php">Sign In</a></button>
            </ul>
        </nav>
        <?php
    }
    ?>
    </nav>
</header>
<!DOCTYPE html>
<html lang="en">
<?php
require './Auth.php';
include './components/plans.php';
include './components/loginHeader.php';
include './components/footer.php';
include './components/card.php';

// Check if the user has an active subscription
$user_id = $_SESSION['id'];
$query_subscription = "SELECT * FROM subscription WHERE user_email = (SELECT email FROM users WHERE id = $user_id)";
$result_subscription = mysqli_query($conn, $query_subscription);
$has_subscription = mysqli_num_rows($result_subscription) > 0;
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <!-- navbar section   -->

    <?php
    include './components/header.php';
    include './components/card.php';
    include './components/plans.php';
    renderHeader();
    ?>

    <!-- hero section  -->
    <section id="home" class="hero-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-12 col-sm-12 text-content">
                    <h1> An Enchanted Card Is All You Need</h1>
                    <a href="subscription.php"> <button class="btn" style="color:white" >Book Card Now</button></a>
                </div>
                <div class="col-lg-8 col-md-12 col-sm-12">
                    <img src="images/enchantebanner.png" alt="" class="img-fluid">
                </div>

            </div>
        </div>
    </section>

    <!-- services section  -->

        <?php
        renderCard($conn);
        ?>

    <!-- about section  -->

    <!-- <section class="about-section" id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <img src="images/about.jpg" alt="" class="img-fluid">
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12 text-content">
                    <h3>who we are</h3>
                    <h1>Providing creative and technology services for growing brands.</h1>

                    <p>Our company specializes in research, brand identity design, UI/UX design, development and graphic
                        design. To help our clients improve their business, we work with them all over the world.</p>
                    <button>learn more</button>
                </div>
            </div>
        </div>
    </section> -->

    <!-- project section  -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
</body>

</html>
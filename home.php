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

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta and title tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BizVizCards</title>

    <!-- Bootstrap and stylesheets -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Call the header render function and pass $conn -->
    <?php
    loginHeaderRender($conn);
    ?>

    <!-- Content -->

    <section id="home" class="hero-section" style="background-color:white">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-12 col-sm-12 text-content" style="color:blue">
                    <p style="color:blue">Wanna look Professional?</p>
                    <h1 style="color:blue">Enchanted Card Is All You Need</h1>
                    <a href="subscription.php"> <button class="btn" style="color:white">Book Card Now</button></a>
                </div>
                <div class="col-lg-8 col-md-12 col-sm-12">
                    <img src="images/enchantebanner.png" alt="" class="img-fluid">
                </div>
            </div>
        </div>
    </section>

    <!-- Services section -->
    <?php
    renderCard($conn);
    ?>

    <!-- Subscription section -->
    <div id="subscribe">
    <?php
    // Render subscription section only if the user doesn't have an active subscription
    if (!$has_subscription) {
        renderSubscription($conn);
    } else {
        echo "
        
        ";
    }
    ?>
    </div>

    <!-- Footer section -->
    <?php
    displayFooter();
    ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>

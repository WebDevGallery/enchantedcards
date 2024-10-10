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
    <style>
        /* Additional styles for enhanced visuals */
        .hero-section {
            background-color: black;
            padding: 50px 0;
        }
        .text-content h1 {
            font-size: 2.5rem;
            font-weight: bold;
        }
        .btn {
            background-color: #007bff;
            border: none;
            padding: 10px 20px;
            font-size: 1rem;
        }
        .about-section {
            background-color: #e9ecef;
            color : black;
            padding: 50px 0;
            text-align: center;
        }
        .about-section h2 {
            font-size: 2rem;
            margin-bottom: 20px;
        }
        .about-section p {
            font-size: 1.2rem;
            max-width: 800px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <!-- Call the header render function and pass $conn -->
    <?php
    loginHeaderRender($conn);
    ?>

    <!-- Content -->

    <section id="home" class="hero-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-12 col-sm-12 text-content">
                    <p>Wanna look Professional?</p>
                    <h1>Enchanted Card Is All You Need</h1>
                    <a href="plans.php"> <button class="btn">Book Card Now</button></a>
                </div>
                <div class="col-lg-8 col-md-12 col-sm-12">
                    <img src="images/enchantebanner.png" alt="" class="img-fluid">
                </div>
            </div>
        </div>
    </section>

    <!-- About Us section -->
    <section id="about" class="about-section">
        <div class="container">
            <h2>About Us</h2>
            <p>Welcome to BizVizCards, where we specialize in creating professional and enchanting business cards that leave a lasting impression. Our team is dedicated to providing you with the highest quality designs and services to help you stand out in your professional endeavors.</p>
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
    <section id="contact" class="contact-section" style="background-color:white;color:black;padding:20px;">
        <div class="container">
            <h2>Contact Us</h2>
            <p>If you have any questions or need further information, feel free to contact us.</p>
            <form>
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" placeholder="Your Name">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" placeholder="name@example.com">
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea class="form-control" id="message" rows="3" placeholder="Your Message"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </section>
    <!-- Footer section -->
    <?php
    displayFooter();
    ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>

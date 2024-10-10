<!DOCTYPE html>
<html lang="en">
<?php
include 'connection.php';
include './components/plans.php';
include './components/header.php';
include './components/footer.php';
include './components/card.php';

$conn = 'name';

// Assuming you have a session variable to check if the user is logged in
session_start();
$isLoggedIn = isset($_SESSION['username']) && $_SESSION['username'] === true;
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">

    <link rel="stylesheet" href="css/style.css">
    <style>

    </style>
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
    <section id="home" class="hero-section" style="background-color:black;">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-12 col-sm-12 text-content">
                    <h1> An Enchanted Card Is All You Need</h1>
                    <a href="<?php echo $isLoggedIn ? 'plans.php' : 'login.php'; ?>">
                        <button class="btn" style="color:white">Book Card Now</button>
                    </a>
                </div>
                <div class="col-lg-8 col-md-12 col-sm-12">
                    <img src="images/enchantebanner.png" alt="" class="img-fluid">
                </div>

            </div>
        </div>
    </section>
    <section id="about" class="about-section" style="background-color:white;color:black;display:flex;justify-content:center;align-items:center;font-size:larger;">
        <div class="container">
            <h2>About Us</h2>
            <p>Welcome to BizVizCards, where we specialize in creating professional and enchanting business cards that leave a lasting impression. Our team is dedicated to providing you with the highest quality designs and services to help you stand out in your professional endeavors.</p>
        </div>
    </section>
    <!-- services section  -->

        <?php
        renderCard($conn);
        ?>
    
    

    <!-- project section  -->
    

    <!-- contact section -->
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

    <?php
    displayFooter();
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
</body>

</html>
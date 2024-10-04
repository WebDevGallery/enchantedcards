<?php
include "connection.php"; // Your database connection

// Get the username from the URL
if (isset($_GET['username'])) {
    $username = mysqli_real_escape_string($conn, $_GET['username']); // Sanitize the input

    // Fetch the user's profile data from the database
    $query = "SELECT * FROM profiles WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        // Profile found
        $profile = mysqli_fetch_assoc($result);
    } else {
        // Profile not found
        echo "Profile not found.";
        exit();
    }
} else {
    // No username provided
    echo "No profile specified.";
    exit();
}

// Store fetched values in variables (use default values if not found)
$name = $profile['name'] ?? 'Name not set';
$profession = $profile['profession'] ?? 'Profession not set';
$phone1 = $profile['phone1'] ?? '';
$phone2 = $profile['phone2'] ?? '';
$about = $profile['about'] ?? '';
$whatsapp = $profile['whatsapp'] ?? '';
$instagram = $profile['instagram'] ?? '';
$facebook = $profile['facebook'] ?? '';
$linkedin = $profile['linkedin'] ?? '';
$twitter = $profile['twitter'] ?? '';
$website = $profile['website'] ?? '';
$profilePicture = $profile['profile_picture'] ?? 'https://via.placeholder.com/150'; // Default placeholder image

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($name); ?>'s Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #121212;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            padding: 20px;
        }

        .card-container {
            max-width: 50%;
            width: 100%;
            background-color: #1e1e1e;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
            text-align: center;
        }

        .profile-picture {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }

        .profile-picture img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
        }

        .profile-info h1 {
            font-size: 1.8rem;
            color: #3ca4ff;
            margin-bottom: 10px;
        }

        .profile-info p {
            font-size: 1rem;
            margin-bottom: 10px;
        }

        .social-media {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin: 20px 0;
        }

        .social-media a {
            width: 50px;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            background-color: #282828;
        }

        .social-media a img {
            width: 30px;
            height: 30px;
        }

        .about-me {
            background-color: #282828;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
        }

        .whatsapp-connect a {
            text-decoration: none;
            font-size: 1.5rem;
            color: #3ca4ff;
            display: inline-flex;
            align-items: center;
        }

        .whatsapp-connect a img {
            width: 30px;
            height: 30px;
            margin-right: 10px;
        }
    </style>
</head>
<body>

<div class="card-container">
    <!-- Profile Picture -->
    <div class="profile-picture">
        <img src="<?php echo htmlspecialchars($profilePicture); ?>" alt="Profile Picture">
    </div>

    <!-- Name and Profession -->
    <div class="profile-info">
        <h1><?php echo htmlspecialchars($name); ?></h1>
        <p><?php echo htmlspecialchars($profession); ?></p>
    </div>

    <!-- Social Media Icons -->
    <div class="social-media">
        <?php if (!empty($instagram)): ?>
            <a href="<?php echo htmlspecialchars($instagram); ?>" target="_blank"><img src="https://img.icons8.com/fluency/48/instagram-new.png" alt="Instagram"></a>
        <?php endif; ?>
        <?php if (!empty($facebook)): ?>
            <a href="<?php echo htmlspecialchars($facebook); ?>" target="_blank"><img src="https://img.icons8.com/fluency/48/facebook-new.png" alt="Facebook"></a>
        <?php endif; ?>
        <?php if (!empty($linkedin)): ?>
            <a href="<?php echo htmlspecialchars($linkedin); ?>" target="_blank"><img src="https://img.icons8.com/fluency/48/linkedin.png" alt="LinkedIn"></a>
        <?php endif; ?>
        <?php if (!empty($twitter)): ?>
            <a href="<?php echo htmlspecialchars($twitter); ?>" target="_blank"><img src="https://img.icons8.com/fluency/48/twitter.png" alt="Twitter"></a>
        <?php endif; ?>
        <?php if (!empty($website)): ?>
            <a href="<?php echo htmlspecialchars($website); ?>" target="_blank"><img src="https://img.icons8.com/fluency/48/domain.png" alt="Website"></a>
        <?php endif; ?>
    </div>

    <!-- About Me Section -->
    <div class="about-me">
        <h2>About Me</h2>
        <p><?php echo htmlspecialchars($about); ?></p>
    </div>

    <!-- WhatsApp Section -->
    <?php if (!empty($whatsapp)): ?>
        <div class="whatsapp-connect">
            <a href="https://wa.me/<?php echo htmlspecialchars($whatsapp); ?>" target="_blank">
                <img src="https://img.icons8.com/fluency/48/whatsapp.png" alt="WhatsApp">
                Connect with me on WhatsApp
            </a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>

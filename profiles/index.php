<?php
include "../connection.php"; // Your database connection

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
$org = $profile['org'] ?? 'Organization not set';
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
$profilePicture = $profile['profile_picture']; // Fetch the binary data

// Check if the profile picture is available and determine its MIME type
if (!empty($profilePicture)) {
    // Convert binary data to base64 and display it with the correct MIME type
    $profilePictureBase64 = base64_encode($profilePicture);
    $profilePictureSrc = 'data:image/jpeg;base64,' . $profilePictureBase64;
} else {
    // Default placeholder if no profile picture is found
    $profilePictureSrc = 'https://via.placeholder.com/150';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($name); ?>'s Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="<?php echo htmlspecialchars($name); ?>'s Profile" />
    <meta property="og:description" content="Learn more about <?php echo htmlspecialchars($name); ?> and their profession: <?php echo htmlspecialchars($profession); ?>" />
    <meta property="og:image" content="<?php echo $profilePictureSrc; ?>" />
    <meta property="og:type" content="profile" />
    <meta property="og:url" content="<?php echo "http://bizvizcards.com/profiles/?username=" . urlencode($username); ?>" />

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="<?php echo htmlspecialchars($name); ?>'s Profile" />
    <meta name="twitter:description" content="Learn more about <?php echo htmlspecialchars($name); ?> and their profession: <?php echo htmlspecialchars($profession); ?>" />
    <meta name="twitter:image" content="<?php echo $profilePictureSrc; ?>" />
    
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

        @media screen and (max-width: 600px) {
            .card-container {
                max-width: 100%;
                width: 100%;
                padding: 15px;
            }
        }

        .fixed-save-button {
            margin-top: 20px;
            padding: 15px;
            background-color: #282828;
            color: #3ca4ff;
            border-radius: 10px;
            font-size: 1.8rem;
            text-align: center;
            cursor: pointer;
            margin-bottom: 20px;
        }

        .profile-picture {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
            margin-top: 20px;
        }

        .share-button {
            position: absolute;
            top: 40px;
            right: 10%;
            padding: 10px 15px;
            border-radius: 50%;
            color: white;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .share-button img {
            width: 30px;
            height: 30px;
        }

        .profile-picture img {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            object-fit: cover;
        }

        .profile-info h1 {
            font-size: 2.8rem;
            color: #3ca4ff;
            margin-bottom: 10px;
        }

        .profile-info p {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .social-media {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            height: 60px;
            margin: 20px 0;
            background-color: #282828;
            border-radius: 50px;
        }

        .social-media a {
            width: 50px;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            background-color: #1e1e1e;
        }

        .social-media a img {
            width: 50px;
            height: 50px;
        }

        .about-me {
            background-color: #282828;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
        }

        .whatsapp-connect {
            background-color: #282828;
            padding: 10px;
            border-radius: 10px;
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

        .profile-section {
            /* background-color: #282828; */
            padding: 3px;
            border-radius: 10px;
        }

        .theme-toggle {
            position: absolute;
            top: 20px;
            left: 20px;
            padding: 10px;
            background-color: var(--button-background);
            color: var(--button-text-color);
            border: none;
            border-radius: 50px;
            cursor: pointer;
        }

        .theme-toggle:focus {
            outline: none;
        }
    </style>
</head>
<body>


<div class="card-container">
    <div class="share-button" onclick="shareProfile()">
        <img src="https://img.icons8.com/fluency/48/share--v2.png" alt="Share">
    </div>
    <!-- Profile Picture -->
    <div class="profile-section">
        <div class="profile-picture">
            <img src="<?php echo $profilePictureSrc; ?>" alt="Profile Picture">
        </div>

        <!-- Name and Profession -->
        <div class="profile-info">
            <h1><?php echo htmlspecialchars($name); ?></h1>
            <h2 style="padding-bottom:10px;"><?php echo htmlspecialchars($org); ?></h2>
            <p><?php echo htmlspecialchars($profession); ?></p>
        </div>
    </div>

    <div class="fixed-save-button" onclick="saveContact()">Save Contact</div>

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

<script>
    document.getElementById('themeToggle').addEventListener('click', function () {
        const root = document.documentElement;
        const themeToggle = document.getElementById('themeToggle');
        if (root.style.getPropertyValue('--background-color') === '#121212') {
            // Switch to Light Mode
            root.style.setProperty('--background-color', '#f0f0f0');
            root.style.setProperty('--text-color', '#000000');
            root.style.setProperty('--card-background', '#ffffff');
            root.style.setProperty('--highlight-color', '#007bff');
            root.style.setProperty('--button-background', '#e0e0e0');
            root.style.setProperty('--button-text-color', '#007bff');
            themeToggle.textContent = '🌙 Switch to Dark Mode';
        } else {
            // Switch back to Dark Mode
            root.style.setProperty('--background-color', '#121212');
            root.style.setProperty('--text-color', '#ffffff');
            root.style.setProperty('--card-background', '#1e1e1e');
            root.style.setProperty('--highlight-color', '#3ca4ff');
            root.style.setProperty('--button-background', '#282828');
            root.style.setProperty('--button-text-color', '#3ca4ff');
            themeToggle.textContent = '🌞 Switch to Light Mode';
        }
    });
    function shareProfile() {
        if (navigator.share) {
            navigator.share({
                title: 'My Profile',
                text: 'Check out my profile!',
                url: window.location.href
            }).then(() => {
                console.log('Profile shared successfully!');
            }).catch((error) => {
                console.error('Error sharing profile:', error);
            });
        } else {
            alert('Share API is not supported in your browser.');
        }
    }

    function saveContact() {
        const name = "<?php echo htmlspecialchars($name); ?>";
        const profession = "<?php echo htmlspecialchars($org); ?>";
        const phone1 = "<?php echo htmlspecialchars($phone1); ?>";
        const phone2 = "<?php echo htmlspecialchars($phone2); ?>";
        const whatsapp = "<?php echo htmlspecialchars($whatsapp); ?>";

        const vcfContent = `BEGIN:VCARD
VERSION:3.0
FN:${name}
ORG:${profession}
TEL;TYPE=CELL:${phone1}
TEL;TYPE=CELL:${phone2}
TEL;TYPE=WHATSAPP:${whatsapp}
END:VCARD`;

        const blob = new Blob([vcfContent], { type: 'text/vcard' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `${name}_contact.vcf`;
        a.click();
        URL.revokeObjectURL(url); // Clean up the object URL after use
    }
</script>
</body>
</html>

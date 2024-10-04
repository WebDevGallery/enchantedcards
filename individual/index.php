<?php
session_start();
include "../connection.php"; // Assuming connection.php contains database connection details

// Check if a subscription message is set and display it
if (isset($_SESSION['subscription_message'])) {
  echo "<div class='notification'>" . $_SESSION['subscription_message'] . "</div>";
  unset($_SESSION['subscription_message']); // Remove it after showing
}

// Ensure the user is logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['id'])) {
    header('Location: ../login.php');
    exit();
}

// Fetch the user's subscription type for profile access
$user_id = $_SESSION['id'];
$query = "SELECT plan_name FROM plans 
          JOIN subscription ON plans.id = subscription.plan_id 
          WHERE subscription.user_email = (SELECT email FROM users WHERE id = $user_id)";
$result = mysqli_query($conn, $query);

// Check if the query was successful
if ($result && mysqli_num_rows($result) > 0) {
    $subscription = mysqli_fetch_assoc($result);
    $plan_name = $subscription['plan_name'];
} else {
    // Handle cases where no subscription is found
    $plan_name = null; // or you can redirect to an error page or display a message
}

// Check if the user's plan allows access (if not 'Individual', deny access)
if ($plan_name != 'Individual') {
    header('Location: ../home.php');
    exit();
} else {
    echo '<script>alert("Edit Your Profile Here")</script>';
}

// Store the username for display or further use
$username = $_SESSION['username'];
$username = mysqli_real_escape_string($conn, $username); // Sanitize the username

// Fetch the profile data using the sanitized username
$query = "SELECT * FROM profiles WHERE username = '$username'"; // Correctly wrap $username in quotes
$result = mysqli_query($conn, $query);

// Check if profile data exists and fetch it
if ($result && mysqli_num_rows($result) > 0) {
    $profile = mysqli_fetch_assoc($result);
} else {
    // Handle cases where no profile data is found
    $profile = [];
}

// Store fetched values in variables (or use null/empty strings if no data is found)
$org = $profile['org'] ?? '';
$name = $profile['name'] ?? '';
$profession = $profile['profession'] ?? '';
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

// If $profilePicture contains binary data, convert it to a base64 encoded string to display it as an image
if (!empty($profile['profile_picture'])) {
    $profilePicture = 'data:image/jpeg;base64,' . base64_encode($profile['profile_picture']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Card Editor</title>
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
      justify-content: space-between;
      align-items: flex-start;
      min-height: 100vh;
      padding: 20px;
      flex-wrap: wrap;
    }

    /* CMS Input Form (Left Section) */
    .cms {
      background-color: #1e1e1e;
      padding: 20px;
      width: 100%;
      max-width: 49%;
      border-radius: 12px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
      margin-bottom: 20px;
      position: relative;
    }

    .cms h2 {
      color: #3ca4ff;
      margin-bottom: 20px;
    }

    .cms label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }

    .cms input, .cms textarea {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border-radius: 8px;
      border: none;
      background-color: #282828;
      color: #fff;
      font-size: 1rem;
    }

    .cms input[type="file"] {
      padding: 5px;
    }

    .cms button {
      padding: 10px;
      width: 30%;
      background-color: #3ca4ff;
      border: none;
      border-radius: 8px;
      color: #fff;
      font-size: 1rem;
      cursor: pointer;
      margin-bottom: 15px;
    }

    /* Floating Publish Button */
    .publish-btn {
      position: fixed;
      z-index: 1000;
      bottom: 20px;
      left: 50%;
      transform: translateX(-50%);
      padding: 15px;
      background-color: #3ca4ff;
      color: #fff;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 1.2rem;
    }

    /* Profile Preview (Right Section) */
    .card-container {
      max-width: 49%;
      position: sticky;
      top:0;
      width: 100%;
      background-color: #1e1e1e;
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
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
      max-width: 100%;
      max-height: 100%;
      border-radius: 50%;
      object-fit: cover;
    }

    .profile-info {
      text-align: center;
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
      transition: background-color 0.3s;
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

    .about-me h2 {
      font-size: 1.5rem;
      margin-bottom: 10px;
    }

    /* WhatsApp Section */
    .whatsapp-connect {
      background-color: #282828;
      border-radius: 10px;
      padding: 20px;
      text-align: center;
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

    /* Fixed Save Contact Button */
    .fixed-save-button {
      padding: 15px;
      background-color: #282828;
      color: #3ca4ff;
      border-radius: 8px;
      font-size: 1rem;
      text-align: center;
      cursor: pointer;
      margin-bottom: 20px;
    }

    /* Share Button */
    .share-button {
      position: absolute;
      top: 10px;
      right: 10px;
      padding: 10px 15px;
      border-radius: 50%;
      color: white;
      cursor: pointer;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .share-button img {
      width: 24px;
      height: 24px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      body {
        flex-direction: column;
      }

      .cms, .card-container {
        max-width: 100%;
      }

      .card-container {
        margin-bottom: 20px;
      }
    }

  </style>
</head>
<body>

  <!-- CMS Form (Left Section) -->
  <div class="cms">
    <h2>Edit Profile</h2>

    <label for="imageUpload">Upload Profile Picture:</label>
    <input type="file" id="imageUpload" name="profilePicture" accept="image/*">
    <img src="<?php echo $profilePicture; ?>" alt="Profile Picture" id="profilePicturePreview" width="150px" height="150px">

    <label for="OrgInput">Organization:</label>
    <input type="text" id="OrgInput" value="<?php echo htmlspecialchars($org); ?>" placeholder="Enter your Organization Name">

    <label for="nameInput">Name:</label>
    <input type="text" id="nameInput" value="<?php echo htmlspecialchars($name); ?>" placeholder="Enter your name">

    <label for="professionInput">Profession:</label>
    <input type="text" id="professionInput" value="<?php echo htmlspecialchars($profession); ?>" placeholder="Enter your profession">

    <label for="phone1Input">Primary Phone Number:</label>
    <input type="tel" id="phone1Input" value="<?php echo htmlspecialchars($phone1); ?>" placeholder="Primary Phone Number">

    <label for="phone2Input">Secondary Phone Number:</label>
    <input type="tel" id="phone2Input" value="<?php echo htmlspecialchars($phone2); ?>" placeholder="Secondary Phone Number">

    <label for="aboutInput">About Me:</label>
    <textarea id="aboutInput" rows="4" placeholder="Write something about you"><?php echo htmlspecialchars($about); ?></textarea>

    <label for="whatsappInput">WhatsApp Number:</label>
    <input type="tel" id="whatsappInput" value="<?php echo htmlspecialchars($whatsapp); ?>" placeholder="WhatsApp number">

    <!-- Social Media Links -->
    <label for="instagramInput">Instagram URL:</label>
    <input type="url" id="instagramInput" value="<?php echo htmlspecialchars($instagram); ?>" placeholder="Instagram URL">

    <label for="facebookInput">Facebook URL:</label>
    <input type="url" id="facebookInput" value="<?php echo htmlspecialchars($facebook); ?>" placeholder="Facebook URL">

    <label for="linkedinInput">LinkedIn URL:</label>
    <input type="url" id="linkedinInput" value="<?php echo htmlspecialchars($linkedin); ?>" placeholder="LinkedIn URL">

    <label for="twitterInput">Twitter URL:</label>
    <input type="url" id="twitterInput" value="<?php echo htmlspecialchars($twitter); ?>" placeholder="Twitter URL">

    <label for="websiteInput">Website URL:</label>
    <input type="url" id="websiteInput" value="<?php echo htmlspecialchars($website); ?>" placeholder="Website URL">

    <div id="dynamicSections"></div>

    <button id="addSectionBtn" disabled>Add Section(coming soon)</button>

    <!-- Floating Publish Button -->
    <button class="publish-btn" onclick="publishProfile()">Publish</button>
  </div>

  <!-- Profile Card (Right Section) -->
  <div class="card-container">
    <!-- Share Button -->
    <div class="share-button" onclick="shareProfile()">
      <img src="https://img.icons8.com/fluency/48/share--v2.png" alt="Share">
    </div>

    <!-- Profile Picture -->
    <div class="profile-picture">
      <img src="<?php echo $profilePicture; ?>" alt="Profile Picture" id="profilePicture">
    </div>

    <!-- Name and Profession -->
    <div class="profile-info">
      
      <h1 id="profileName">Your Name</h1>
      <h2 id="profileOrg" style="padding-bottom:10px;">Your Organization</h2>
      <p id="profileProfession">Your Profession</p>
    </div>

    <!-- Save Contact Section -->
    <div class="fixed-save-button" onclick="saveContact()">Save Contact</div>

    <!-- Social Media Icons -->
    <div class="social-media">
      <a href="<?php echo htmlspecialchars($instagram); ?>" id="instagramIcon" style="display: <?php echo !empty($instagram) ? 'inline-flex' : 'none'; ?>;">
        <img src="https://img.icons8.com/fluency/48/instagram-new.png" alt="Instagram">
      </a>
      <a href="<?php echo htmlspecialchars($facebook); ?>" id="facebookIcon" style="display: <?php echo !empty($facebook) ? 'inline-flex' : 'none'; ?>;">
        <img src="https://img.icons8.com/fluency/48/facebook-new.png" alt="Facebook">
      </a>
      <a href="<?php echo htmlspecialchars($linkedin); ?>" id="linkedinIcon" style="display: <?php echo !empty($linkedin) ? 'inline-flex' : 'none'; ?>;">
        <img src="https://img.icons8.com/fluency/48/linkedin.png" alt="LinkedIn">
      </a>
      <a href="<?php echo htmlspecialchars($twitter); ?>" id="twitterIcon" style="display: <?php echo !empty($twitter) ? 'inline-flex' : 'none'; ?>;">
        <img src="https://img.icons8.com/fluency/48/twitter.png" alt="Twitter">
      </a>
      <a href="<?php echo htmlspecialchars($website); ?>" id="websiteIcon" style="display: <?php echo !empty($website) ? 'inline-flex' : 'none'; ?>;">
        <img src="https://img.icons8.com/fluency/48/domain.png" alt="Website">
      </a>
    </div>

    <!-- About Me Section -->
    <div class="about-me">
      <h2>About Me</h2>
      <p id="profileAbout">Your about me section.</p>
    </div>

    <!-- New Sections will be added here -->
    <div id="newSectionsContainer"></div>

    <!-- WhatsApp Section (moved below "About Me") -->
    <div class="whatsapp-connect">
      <a href="#" id="whatsappLink">
        <img src="https://img.icons8.com/fluency/48/whatsapp.png" alt="WhatsApp">
        Connect with me on WhatsApp
      </a>
    </div>
  </div>

  <script>
    // Handle Profile Updates
    document.getElementById('OrgInput').addEventListener('input', function() {
      document.getElementById('profileOrg').textContent = this.value || 'Your Organization Name';
    });

    document.getElementById('nameInput').addEventListener('input', function() {
      document.getElementById('profileName').textContent = this.value || 'Your Name';
    });

    document.getElementById('professionInput').addEventListener('input', function() {
      document.getElementById('profileProfession').textContent = this.value || 'Your Profession';
    });

    document.getElementById('aboutInput').addEventListener('input', function() {
      document.getElementById('profileAbout').textContent = this.value || 'Your about me section.';
    });

    // Handle WhatsApp number link update
    document.getElementById('whatsappInput').addEventListener('input', function() {
      const number = this.value;
      const whatsappLink = `https://wa.me/${number.replace(/\D/g, '')}`;
      document.getElementById('whatsappLink').setAttribute('href', whatsappLink);
    });

    // Handle social media link update
    function updateSocialMediaLink(iconId, url) {
      const icon = document.getElementById(iconId);
      if (url) {
        icon.style.display = 'inline-flex';
        icon.setAttribute('href', url);
      } else {
        icon.style.display = 'none';
        icon.setAttribute('href', '#');
      }
    }

    // Initialize social media icons on page load
    document.addEventListener('DOMContentLoaded', function() {
      updateSocialMediaLink('instagramIcon', document.getElementById('instagramInput').value);
      updateSocialMediaLink('facebookIcon', document.getElementById('facebookInput').value);
      updateSocialMediaLink('linkedinIcon', document.getElementById('linkedinInput').value);
      updateSocialMediaLink('twitterIcon', document.getElementById('twitterInput').value);
      updateSocialMediaLink('websiteIcon', document.getElementById('websiteInput').value);
    });

    // Add Section dynamically and create form fields for it
    document.getElementById('addSectionBtn').addEventListener('click', function() {
      const sectionId = Date.now(); // Unique ID for each section

      // Add new section to profile card above WhatsApp section and below About Me
      const newSection = document.createElement('div');
      newSection.classList.add('about-me');
      newSection.innerHTML = `
        <h2 id="sectionTitle-${sectionId}">New Section</h2>
        <p id="sectionContent-${sectionId}">Editable content for the new section...</p>
      `;
      document.getElementById('newSectionsContainer').appendChild(newSection);

      // Add form fields for editing the new section in the CMS
      const newSectionForm = document.createElement('div');
      newSectionForm.innerHTML = `
        <label for="sectionTitleInput-${sectionId}">Section Title:</label>
        <input type="text" id="sectionTitleInput-${sectionId}" placeholder="Section Title" oninput="updateSectionTitle(${sectionId}, this.value)">

        <label for="sectionContentInput-${sectionId}">Section Content:</label>
        <textarea id="sectionContentInput-${sectionId}" rows="4" placeholder="Section Content" oninput="updateSectionContent(${sectionId}, this.value)"></textarea>
      `;
      document.getElementById('dynamicSections').appendChild(newSectionForm);
    });

    function updateSectionTitle(sectionId, value) {
      document.getElementById(`sectionTitle-${sectionId}`).textContent = value || 'New Section';
    }

    function updateSectionContent(sectionId, value) {
      document.getElementById(`sectionContent-${sectionId}`).textContent = value || 'Editable content for the new section...';
    }

    // Handle Image Upload and Preview
    document.getElementById('imageUpload').addEventListener('change', function(event) {
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          document.getElementById('profilePicturePreview').setAttribute('src', e.target.result);
        };
        reader.readAsDataURL(file); // Convert image to base64 for preview only
      }
    });

    // Save Contact as VCF file
    function saveContact() {
      const name = document.getElementById('nameInput').value;
      const profession = document.getElementById('OrgInput').value;
      const phone1 = document.getElementById('phone1Input').value;
      const phone2 = document.getElementById('phone2Input').value;
      const whatsapp = document.getElementById('whatsappInput').value;
      
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
      URL.revokeObjectURL(url); // Clean up the object URL
    }

    // Share Profile Function
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

    // Publish Profile Function
    function publishProfile() {
    const formData = new FormData();
    formData.append('org', document.getElementById('OrgInput').value);
    formData.append('name', document.getElementById('nameInput').value);
    formData.append('profession', document.getElementById('professionInput').value);
    formData.append('phone1', document.getElementById('phone1Input').value);
    formData.append('phone2', document.getElementById('phone2Input').value);
    formData.append('about', document.getElementById('aboutInput').value);
    formData.append('whatsapp', document.getElementById('whatsappInput').value);
    formData.append('instagram', document.getElementById('instagramInput').value);
    formData.append('facebook', document.getElementById('facebookInput').value);
    formData.append('linkedin', document.getElementById('linkedinInput').value);
    formData.append('twitter', document.getElementById('twitterInput').value);
    formData.append('website', document.getElementById('websiteInput').value);
    formData.append('profilePicture', document.getElementById('imageUpload').files[0]); // Append the image file

    // Send the form data via POST
    fetch('publish_profile.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(result => {
        // Retrieve the username from PHP and redirect accordingly
        const username = "<?php echo $_SESSION['username']; ?>"; // Pass the PHP variable into JavaScript
        window.location.href = 'http://localhost/enchantedcards/profiles/?username=' + username; // Concatenate the username
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

  </script>
</body>
</html>

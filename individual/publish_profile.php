<?php
session_start();
include "../connection.php"; // Assuming connection.php contains database connection details

// Ensure the user is logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['id'])) {
    header('Location: ../login.php');
    exit();
}

$username = $_SESSION['username'];

// Get form inputs
$org = mysqli_real_escape_string($conn, $_POST['org']);
$name = mysqli_real_escape_string($conn, $_POST['name']);
$profession = mysqli_real_escape_string($conn, $_POST['profession']);
$phone1 = mysqli_real_escape_string($conn, $_POST['phone1']);
$phone2 = mysqli_real_escape_string($conn, $_POST['phone2']);
$about = mysqli_real_escape_string($conn, $_POST['about']);
$whatsapp = mysqli_real_escape_string($conn, $_POST['whatsapp']);
$instagram = mysqli_real_escape_string($conn, $_POST['instagram']);
$facebook = mysqli_real_escape_string($conn, $_POST['facebook']);
$linkedin = mysqli_real_escape_string($conn, $_POST['linkedin']);
$twitter = mysqli_real_escape_string($conn, $_POST['twitter']);
$website = mysqli_real_escape_string($conn, $_POST['website']);

// Handle the image file if uploaded
$imageData = null;
if (isset($_FILES['profilePicture']) && $_FILES['profilePicture']['error'] == 0) {
    $image = $_FILES['profilePicture']['tmp_name'];
    $imageType = mime_content_type($image); // Ensure it's an image file
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

    if (in_array($imageType, $allowedTypes)) {
        $imageData = addslashes(file_get_contents($image)); // Convert the image to binary for SQL
    } else {
        echo "Invalid image format. Only JPEG, PNG, and GIF are allowed.";
        exit();
    }
}

// Check if a profile exists for the user
$query = "SELECT * FROM profiles WHERE username = '$username'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    // Update existing profile
    $update_query = "UPDATE profiles SET 
        org = '$org',
        name = '$name', 
        profession = '$profession', 
        phone1 = '$phone1', 
        phone2 = '$phone2', 
        about = '$about', 
        whatsapp = '$whatsapp', 
        instagram = '$instagram', 
        facebook = '$facebook', 
        linkedin = '$linkedin', 
        twitter = '$twitter', 
        website = '$website'";

    // Only update profile picture if a new one is uploaded
    if ($imageData !== null) {
        $update_query .= ", profile_picture = '$imageData'";
    }

    $update_query .= " WHERE username = '$username'";

    if (mysqli_query($conn, $update_query)) {
        echo "Profile updated successfully!";
    } else {
        echo "Error updating profile: " . mysqli_error($conn);
    }
} else {
    // Insert new profile
    $insert_query = "INSERT INTO profiles 
        (username, org, name, profession, phone1, phone2, about, whatsapp, instagram, facebook, linkedin, twitter, website, profile_picture) 
        VALUES ('$username', '$org', '$name', '$profession', '$phone1', '$phone2', '$about', '$whatsapp', '$instagram', '$facebook', '$linkedin', '$twitter', '$website', '$imageData')";

    if (mysqli_query($conn, $insert_query)) {
        echo "Profile created successfully!";
    } else {
        echo "Error creating profile: " . mysqli_error($conn);
    }
}
?>

<?php

include './Auth.php';
include "connection.php";

// Display the subscription message if it exists
if (isset($_SESSION['subscription_message'])) {
    echo "<div class='notification'>" . $_SESSION['subscription_message'] . "</div>";
    unset($_SESSION['subscription_message']); // Remove it after showing
}

// Fetch the user's subscription type for profile access
$user_id = $_SESSION['id'];
$query = "SELECT plan_name FROM plans 
          JOIN subscription ON plans.id = subscription.plan_id 
          WHERE subscription.user_email = (SELECT email FROM users WHERE id = $user_id)";
$result = mysqli_query($conn, $query);
$subscription = mysqli_fetch_assoc($result);
$plan_name = $subscription['plan_name'];

// Redirect based on the subscription plan
if ($plan_name == 'Enterprise') {
    header('Location: ./enterprise');
    exit(); // Always exit after a redirect to stop further execution
} elseif ($plan_name == 'Individual') {
    header('Location: ./individual');
    exit();
} elseif ($plan_name == 'Basic') {
    header('Location: ./basic');
    exit();
} else {
    echo "<h2>Welcome to your profile. It looks like you don't have a subscription plan yet.</h2>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="css/style1.css">
</head>
<body>
<nav>
    <ul>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</nav>
</body>
</html>

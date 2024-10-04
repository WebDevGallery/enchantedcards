<?php

include '../Auth.php';
include "../connection.php";
include '../components/loginHeader.php';
include '../components/footer.php';
include '../components/card.php';

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

if ($plan_name == 'Enterprise') {
    echo'<script>alert("Edit your details here")</script>';
    exit(); // Always exit after a redirect to stop further execution
}else{
    echo'<script>alert("Content not Accessable")</script>';
    header('Location: ../home.php');
}

?>
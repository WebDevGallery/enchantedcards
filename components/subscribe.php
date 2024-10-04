<?php
session_start();
include "../connection.php";

if (!isset($_SESSION['id'])) {
    header("Location: login.php"); // Redirect if not logged in
    exit();
}

$user_id = $_SESSION['id'];

// Get the user's email (required for the subscription table)
$query = "SELECT email FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
$user_email = $user['email'];

// Check if the user already has a subscription
$check_subscription = "SELECT plans.plan_name, subscription.subscribed_date FROM subscription 
                       JOIN plans ON subscription.plan_id = plans.id 
                       WHERE user_email = '$user_email'";
$check_result = mysqli_query($conn, $check_subscription);

if (mysqli_num_rows($check_result) > 0) {
    // If the user has an active subscription, display a message
    $subscription_data = mysqli_fetch_assoc($check_result);
    $active_plan_name = $subscription_data['plan_name'];
    $subscribed_date = $subscription_data['subscribed_date'];

    echo "<div class='notification'>
            <p>You are already subscribed to the <strong>$active_plan_name</strong> plan since $subscribed_date.</p>
          </div>";
} else {
    // If no active subscription, render the subscription plans

    if (isset($_POST['buy_now'])) {
        $plan_id = $_POST['plan_id']; // Get the selected plan ID

        // Insert a new subscription if none exists
        $insert_subscription = "INSERT INTO subscription (user_email, plan_id, subscribed_date) 
                                VALUES ('$user_email', $plan_id, CURDATE())";
        $insert_result = mysqli_query($conn, $insert_subscription);

        // Fetch the plan name for the notification
        $plan_query = "SELECT plan_name FROM plans WHERE id = $plan_id";
        $plan_result = mysqli_query($conn, $plan_query);
        $plan_data = mysqli_fetch_assoc($plan_result);
        $plan_name = $plan_data['plan_name'];

        // Notify the user of their subscription
        $_SESSION['subscription_message'] = "You have successfully subscribed to the $plan_name plan.";

        // Redirect to profile/dashboard
        header("Location: ../profile.php");
        exit();
    }

    // Fetch available subscription plans from the database
    $query_plans = "SELECT * FROM plans";
    $plans_result = mysqli_query($conn, $query_plans);

    // Render the subscription options
    echo '
    <div class="subscription-plans">
        <h2>Select Your Subscription Plan</h2>
        <div class="plans-container">';

    // Loop through the plans and generate cards for each one
    while ($plan = mysqli_fetch_assoc($plans_result)) {
        echo '
            <div class="plan-card">
                <h3>' . $plan['plan_name'] . '</h3>
                <form action="subscribe.php" method="POST">
                    <input type="hidden" name="plan_id" value="' . $plan['id'] . '">
                    <button type="submit" name="buy_now" class="btn">Buy Now</button>
                </form>
            </div>';
    }

    echo '
        </div>
    </div>';
}
?>

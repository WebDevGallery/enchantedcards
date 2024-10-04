<?php
// Function to render the login header. Now accepting the $conn variable
function loginHeaderRender($conn) {
    // Check if the user session is set and retrieve user data
    if (isset($_SESSION['id'])) {
        $id = $_SESSION['id'];

        // Execute query to fetch user data
        $query = mysqli_query($conn, "SELECT * FROM users WHERE id = $id");
        if ($result = mysqli_fetch_assoc($query)) {
            $res_username = $result['username'];
            $res_email = $result['email'];
            $res_id = $result['id'];

            // Get the user's subscription plan
            $plan_query = mysqli_query($conn, "SELECT plan_name FROM plans 
                                               JOIN subscription ON plans.id = subscription.plan_id 
                                               WHERE subscription.user_email = '$res_email'");
            $plan_result = mysqli_fetch_assoc($plan_query);
            $plan_name = isset($plan_result['plan_name']) ? $plan_result['plan_name'] : 'No'; // Fallback if no plan
        }
    }

    // Output the header HTML
    echo '
    <header class="navbar-section style="background-color:black">
        <nav class="navbar navbar-expand-lg navbar-dark" style="background-color:black">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">BizVizCards</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#services">About BizVizCard</a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="#contact">Contact</a>
                        </li>';

    // Add 'My Profile' with restricted access to different CMS based on the plan
    if (isset($plan_name) && $plan_name != 'No') {
        echo '
        <li class="nav-item">
            <a class="nav-link" href="profile.php">My BizViz (' . htmlspecialchars($plan_name) . ' Plan)</a>
        </li>';
    }else{
        echo'<li class="nav-item">
                            <a class="nav-link" href="#subscribe">Buy Plan</a>
                        </li>';
    }

    // User profile dropdown menu if logged in
    if (isset($res_id)) {
        echo '
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-circle"></i> ' . htmlspecialchars($res_username) . '
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                <li><a class="dropdown-item" href="edit.php?id=' . htmlspecialchars($res_id) . '">Edit Profile</a></li>
                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
            </ul>
        </li>';
    }

    echo '
                    </ul>
                </div>
            </div>
        </nav>
    </header>';
}
?>

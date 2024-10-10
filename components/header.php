<?php
if (!function_exists('renderHeader')) {
    function renderHeader(){
        echo'
        <header class="navbar-section" style="background-color:black; ">
            <nav class="navbar navbar-expand-lg" style="background-color:black; color:black;">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#" style="color:white;">LOGO</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon" style="color:black;background-color:black;"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="#home" style="color:white;">Home</a>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link" href="#about" style="color:white;">about BizVizCard</a>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link" href="#contact" style="color:white;">contact</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="login.php" style="color:white;">login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="signup.php" style="color:white;">signup</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <hr style="color:white;height:-20px;">
        </header>
        
        ';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link rel="stylesheet" href="css/style1.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    /* Basic reset */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    /* Container and form box styling */
    .container {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background: linear-gradient(135deg, #3ca4ff, #2c3e50);
      padding: 20px;
    }

    .form-box {
      background-color: #fff;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      max-width: 400px;
      width: 100%;
    }

    header {
      font-size: 24px;
      font-weight: 600;
      text-align: center;
      margin-bottom: 20px;
    }

    .input-container {
      position: relative;
      margin-bottom: 20px;
    }

    .input-container i {
      position: absolute;
      right: -57px;
      top: 0px;
      color: #555;
      font-size: 18px;
      cursor: pointer;
    }

    .input-field {
      width: 100%;
      padding: 12px 40px 12px 12px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 16px;
      transition: 0.3s;
    }

    .input-field:focus {
      border-color: #333;
    }

    .btn {
      width: 100%;
      padding: 12px;
      background-color: #333;
      color: #fff;
      font-size: 16px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: 0.3s;
    }

    .btn:hover {
      background-color: #555;
    }

    .links {
      margin-top: 20px;
      text-align: center;
    }

    .links a {
      text-decoration: none;
      color: #333;
    }

    /* Message styles */
    .message {
      background-color: green;
      color: white;
      padding: 10px;
      border-left: 4px solid #f44336;
      margin-bottom: 10px;
    }

    /* Responsive design */
    @media (max-width: 600px) {
      .form-box {
        padding: 20px;
      }

      header {
        font-size: 20px;
      }

      .input-field {
        font-size: 14px;
      }

      .btn {
        font-size: 14px;
      }
    }

    @media (min-width: 768px) {
      .form-box {
        max-width: 500px;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="form-box box">
      <header>Sign Up</header>
      <hr>

      <form action="#" method="POST">
        <?php
        session_start();
        include "connection.php";

        if (isset($_POST['register'])) {

          $name = $_POST['username'];
          $email = $_POST['email'];
          $pass = $_POST['password'];
          $cpass = $_POST['cpass'];

          // Check if username or email already exists
          $check_username = "SELECT * FROM users WHERE username='{$name}'";
          $check_email = "SELECT * FROM users WHERE email='{$email}'";
          
          $res_username = mysqli_query($conn, $check_username);
          $res_email = mysqli_query($conn, $check_email);

          $passwd = password_hash($pass, PASSWORD_DEFAULT); // Hash the password

          // Generate a unique ID for the user
          $unique_id = bin2hex(random_bytes(12)); // 24 characters unique ID

          if (mysqli_num_rows($res_username) > 0) {
            echo "<div class='message'><p>Username '$name' already exists. Please choose another one!</p></div>";
          } elseif (mysqli_num_rows($res_email) > 0) {
            echo "<div class='message'><p>Email '$email' is already registered. Please try with another one!</p></div>";
          } else {
            if ($pass === $cpass) {
              // Insert the new user into the database
              $sql = "INSERT INTO users (username, email, password, unique_id) 
                      VALUES ('$name', '$email', '$passwd', '$unique_id')";

              $result = mysqli_query($conn, $sql);

              if ($result) {
                $_SESSION['success'] = 'You have registered successfully! Redirecting to login page...';
                header("Location: ./login.php"); // Use header function for redirection
                exit(); // Ensure script ends after redirection
              } else {
                echo "<div class='message'><p>There was an error. Please try again!</p></div>";
              }
            } else {
              echo "<div class='message'><p>Password does not match.</p></div>";
            }
          }
        } else {
          ?>

          <div class="input-container">
            <input class="input-field" type="text" placeholder="Username" name="username" required>
            <i class="fa fa-user icon"></i>
          </div>

          <div class="input-container">
            <input class="input-field" type="email" placeholder="Email Address" name="email" required>
            <i class="fa fa-envelope icon"></i>
          </div>

          <div class="input-container">
            <input class="input-field password" type="password" placeholder="Password" name="password" required>
            <i class="fa fa-eye icon toggle"></i>
          </div>

          <div class="input-container">
            <input class="input-field" type="password" placeholder="Confirm Password" name="cpass" required>
            <i class="fa fa-eye icon toggle"></i>
          </div>

          <input type="submit" name="register" id="submit" value="Signup" class="btn">

          <div class="links">
            Already have an account? <a href="login.php">Login Now</a>
          </div>
        </form>
      </div>
      <?php
        }
      ?>
  </div>

  <script>
    const toggles = document.querySelectorAll(".toggle"),
          inputs = document.querySelectorAll(".password");

    toggles.forEach((toggle, index) => {
      toggle.addEventListener("click", () => {
        const input = inputs[index];
        if (input.type === "password") {
          input.type = "text";
          toggle.classList.replace("fa-eye", "fa-eye-slash");
        } else {
          input.type = "password";
          toggle.classList.replace("fa-eye-slash", "fa-eye");
        }
      });
    });
  </script>
</body>

</html>

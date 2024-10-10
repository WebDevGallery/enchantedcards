<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    /* Basic Reset */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    /* Main Container Styling */
    .container {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background: linear-gradient(135deg, white, black);
      padding: 20px;
    }

    /* Form Box Styling */
    .form-box {
      background-color: #ffffff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
      width: 100%;
      max-width: 450px;
    }

    /* Header Styling */
    header {
      font-size: 28px;
      font-weight: bold;
      text-align: center;
      margin-bottom: 20px;
      color: #333;
    }

    /* Input Field Styling */
    .input-container {
      position: relative;
      margin-bottom: 20px;
    }

    .input-container i {
      position: absolute;
      right: 15px;
      top: 12px;
      color: #333;
    }

    .input-field {
      width: 100%;
      padding: 14px 15px;
      border: 1px solid #ddd;
      border-radius: 8px;
      font-size: 16px;
      transition: 0.3s;
    }

    .input-field:focus {
      border-color: #3ca4ff;
      box-shadow: 0 0 8px rgba(60, 164, 255, 0.3);
    }

    /* Toggle Eye Icon */
    .toggle {
      cursor: pointer;
    }

    /* Button Styling */
    .button {
      width: 100%;
      padding: 14px;
      background: linear-gradient(135deg, #3ca4ff, #007bff);
      color: #fff;
      font-size: 18px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: 0.3s;
      font-weight: bold;
    }

    .button:hover {
      background: linear-gradient(135deg, #007bff, #3ca4ff);
      box-shadow: 0 5px 15px rgba(0, 123, 255, 0.4);
    }

    /* Message Container */
    .message {
      background-color: #ffcccc;
      color: #e60000;
      padding: 10px;
      border-left: 4px solid #ff1a1a;
      margin-bottom: 20px;
      text-align: center;
      border-radius: 8px;
    }

    /* Remember Me & Forgot Password Section */
    .remember {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
      font-size: 14px;
      color: #333;
    }

    .remember input {
      margin-right: 5px;
    }

    .remember a {
      text-decoration: none;
      color: #3ca4ff;
      font-weight: bold;
    }

    .remember a:hover {
      text-decoration: underline;
    }

    /* Links Section */
    .links {
      text-align: center;
      margin-top: 20px;
      font-size: 16px;
    }

    .links a {
      color: #3ca4ff;
      text-decoration: none;
      font-weight: bold;
    }

    .links a:hover {
      text-decoration: underline;
    }

    /* Responsive Design */
    @media (max-width: 600px) {
      .form-box {
        padding: 20px;
      }

      header {
        font-size: 24px;
      }

      .button {
        font-size: 16px;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="form-box box">

      <?php
      include "connection.php";

      if (isset($_POST['login'])) {

        $email = $_POST['email'];
        $pass = $_POST['password'];

        $sql = "select * from users where email='$email'";

        $res = mysqli_query($conn, $sql);

        if (mysqli_num_rows($res) > 0) {

          $row = mysqli_fetch_assoc($res);

          $password = $row['password'];

          $decrypt = password_verify($pass, $password);


          if ($decrypt) {
            $_SESSION['id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            header("location: home.php");
          } else {
            echo "<div class='message'>
                    <p>Wrong Password</p>
                    </div><br>";

            echo "<a href='login.php'><button class='button'>Go Back</button></a>";
          }
        } else {
          echo "<div class='message'>
                    <p>Wrong Email or Password</p>
                    </div><br>";

          echo "<a href='login.php'><button class='button'>Go Back</button></a>";
        }
      } else {
      ?>

        <header>Login</header>
        <hr>
        <form action="#" method="POST">

          <div class="form-box">
            <div class="input-container">
              <i class="fa fa-envelope icon"></i>
              <input class="input-field" type="email" placeholder="Email Address" name="email">
            </div>

            <div class="input-container">
              <i class="fa fa-lock icon"></i>
              <input class="input-field password" type="password" placeholder="Password" name="password">
              <i class="fa fa-eye toggle icon"></i>
            </div>

            <div class="remember">
              <div>
                <input type="checkbox" class="check" name="remember_me">
                <label for="remember">Remember me</label>
              </div>
              <span><a href="forgot.php">Forgot password</a></span>
            </div>

          </div>

          <input type="submit" name="login" id="submit" value="Login" class="button">

          <div class="links">
            Don't have an account? <a href="signup.php">Signup Now</a>
          </div>

        </form>
      </div>
      <?php
      }
      ?>
  </div>
  <script>
    const toggle = document.querySelector(".toggle"),
      input = document.querySelector(".password");
    toggle.addEventListener("click", () => {
      if (input.type === "password") {
        input.type = "text";
        toggle.classList.replace("fa-eye-slash", "fa-eye");
      } else {
        input.type = "password";
      }
    });
  </script>
</body>

</html>

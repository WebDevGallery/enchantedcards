<?php
function renderCard($conn) {
    // Check if the user session is set and retrieve user data
    if (isset($_SESSION['id'])) {
        $id = $_SESSION['id'];
        // Execute query to fetch user data
        $query = mysqli_query($conn, "SELECT * FROM users WHERE id = $id");
        if ($result = mysqli_fetch_assoc($query)) {
            $res_username = $result['username'];
        }
    }

    echo '
    <!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Flipping Card UI Design</title>
    <style>
    /* Import Google Font - Poppins */
@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap");

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Poppins", sans-serif;
}

section {
  position: relative;
  min-height: 100vh;
  width: 100%;
  background:#333;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  perspective: 1000px;
  padding-top: 10px;
  padding-bottom: 10px;
}

.container1 {
  position: relative;
  height: 50vw; /* Makes the height responsive */
  width: 80vw;  /* Makes the width responsive */
  max-width: 600px;  /* Limits the maximum width */
  max-height: 400px; /* Limits the maximum height */
  z-index: 100;
  transition: 0.6s;
  transform-style: preserve-3d;
  display: flex;
  justify-content: center;
  align-items: center;
}
.container1:hover {
  transform: rotateY(180deg);
}
.container1 .card {
  position: absolute;
  height: 100%;
  width: 100%;
  padding: 25px;
  border-radius: 25px;
  backdrop-filter: blur(25px);
  background: #0f2862 ;
  box-shadow: 0 25px 45px rgba(0, 0, 0, 0.25);
  border: 3px solid white;
  backface-visibility: hidden;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  text-align: center;
}
.front-face header,
.front-face .logo {
  display: flex;
  align-items: center;
  justify-content: center;
}
.front-face header {
  justify-content: space-between;
}
.front-face .logo img {
  width: 48px;
  margin-right: 10px;
}
h5 {
  font-size: 4vw; /* Makes font size responsive */
  font-weight: 400;
}
.front-face .chip {
  width: 50px;
}
.front-face .card-details {
  display: flex;
  margin-top: 20px; /* Reduced margin */
  align-items: flex-end;
  justify-content: space-between;
}
h6 {
  font-size: 12px;
  font-weight: 400;
}
h5.number {
  font-size: 4vw; /* Makes font size responsive */
  letter-spacing: 1px;
}
h5.name {
  margin-top: 10px; /* Reduced margin */
}
.card.back-face {
  border: 2px solid white;
  padding: 15px 25px 25px 25px;
  transform: rotateY(180deg);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}
.card.back-face h6 {
  font-size: 10px;
}
.card.back-face .magnetic-strip {
  position: absolute;
  top: 40px;
  left: 0;
  height: 45px;
  width: 100%;
  background: #000;
}
.card.back-face .signature {
  display: flex;
  justify-content: flex-end;
  align-items: center;
  margin-top: 80px;
  height: 40px;
  width: 85%;
  border-radius: 6px;
  background: repeating-linear-gradient(
    #fff,
    #fff 3px,
    #efefef 0px,
    #efefef 9px
  );
}
.signature i {
  color: #000;
  font-size: 12px;
  padding: 4px 6px;
  border-radius: 4px;
  background-color: #fff;
  margin-right: -30px;
  z-index: -1;
}
.card.back-face h5 {
  font-size: 10px;
  margin-top: 15px;
}

    </style>
  </head>
  <body>
  
    <section style="display:flex;flex-direction:column;justify-content:center;align-items:center;background-color:black">
    
    
      <div class="container1">
        <div class="card front-face">
          <header>
            <span class="logo">
              <img src="" alt="logo">
              <h5 style="color:white; font-weight:900">Enchanted &nbsp;&nbsp; 
              <img width="50" height="50" src="https://img.icons8.com/ios/50/nfc-sign.png" alt="nfc-sign"/> 
              <br> Cards</h5>
            </span>
          </header>
          <div class="card-details" style="color:black">
            <a href="https://bizvizcards.com" style="color:white">BizVizCards</a>
          </div>
        </div>

        <div class="card back-face" style="display:flex;flex-direction:row;gap:20px">
          <div>
            <img src="./images/bizvizcards_qr.png" alt="qr" style="width: 80%; height: auto;">
          </div>
          <div>
            <h1 style="color:white;">' . (isset($res_username) ? $res_username : 'Name') . ' 
            <img width="50" height="50" src="https://img.icons8.com/ios/50/nfc-sign.png" alt="nfc-sign"/> 
            </h1> 
            <p style="color:white;">Your Role</p>
          </div>
        </div>
      </div>
        
    </section>
  </body>
</html>
    ';
}
?>

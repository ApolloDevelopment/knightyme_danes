<?php
  session_start();
  if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit();
  }
  date_default_timezone_set("America/New_York");
  $today = (date("M") == "May" || date("M") == "June" || date("M") == "July") ? date("M j, Y") : date("M. j, Y");
  $time = date("H") > 12 ? (date("H")-12).":".date("i A") : date("H:i A");
?>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Knightyme Admin | Home</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="../css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="icon" href="../img/favicon.ico">
  </head>
  <body>
    <!-- navigation -->
    <div class="navigation">
      <ul class="navigation-items">
        <center>
          <li class="navigation-item active">
            <i class="fas fa-home "></i>
            <p>Home</p>
          </li>
          <li class="navigation-item" onclick="window.location='all.php'">
            <i class="fas fa-paw "></i>
            <p>Danes</p>
          </li>
          <li class="navigation-item" onclick="window.location='account.php'">
            <i class="fas fa-user-cog "></i>
            <p>My Account</p>
          </li>
          <li class="navigation-item" onclick="window.location='../inc/logout.php'">
            <i class="fas fa-sign-out-alt "></i>
            <p>Logout</p>
          </li>
        </center>
      </ul>
    </div>

    <!-- main content -->
    <div class="content home">
      <div class="container">
      <center>
        <h1 class="welcome">Welcome back <?= $_SESSION['firstName'] ?></h1>
        <div class="dateTime">
          <span class="date"><?= $today ?></span>
          <span class="time"><?= $time ?></span>
        </div>
      </center>
      </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  </body>
</html>

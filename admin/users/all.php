<?php
  session_start();
  if(!isset($_SESSION['id'])){
    header("Location: ../login.php");
    exit();
  }
?>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content=""> <!-- TODO: Add SEO keywords -->
    <title>Knightyme Admin | Users</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../../css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="icon" href="../../img/favicon.ico">
  </head>
  <body>
    <!-- navigation -->
    <div class="navigation">
      <ul class="navigation-items">
        <center>
          <li class="navigation-item" onclick="window.location='../home.php'">
            <i class="fas fa-home"></i>
            <p>Home</p>
          </li>
          <li class="navigation-item" onclick="window.location='../danes/all.php'">
            <i class="fas fa-paw"></i>
            <p>Danes</p>
          </li>
          <li class="navigation-item active">
            <i class="fas fa-users"></i>
            <p>Users</p>
          </li>
          <li class="navigation-item" onclick="window.location='../account.php'">
            <i class="fas fa-user-cog"></i>
            <p>My Account</p>
          </li>
          <li class="navigation-item" onclick="window.location='../../inc/logout.php'">
            <i class="fas fa-sign-out-alt"></i>
            <p>Logout</p>
          </li>
        </center>
      </ul>
    </div>

    <!-- main content -->
    <div class="content">
      <div class="container">
        




      </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  </body>
</html>

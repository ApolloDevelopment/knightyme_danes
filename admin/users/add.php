<?php
  session_start();
  if(!isset($_SESSION['id'])){
    header("Location: ../login.php");
    exit();
  }
  $err = isset($_GET['error']) ? $_GET['error'] : "";
  $firstName = isset($_GET['first']) ? $_GET['first'] : "";
  $middleInit = isset($_GET['middle']) ? $_GET['middle'] : "";
  $lastName = isset($_GET['last']) ? $_GET['last'] : "";
  $uid = isset($_GET['uid']) ? $_GET['uid'] : "";
?>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="icon" href="../../img/favicon.ico">
  <link rel="stylesheet" href="../../css/all.min.css">
  <link rel="stylesheet" href="../css/main.css"> <!-- admin main.css -->
  <link rel="stylesheet" href="../css/forms.css">
  <title>Knightyme Admin | Add User</title>
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
    <h1 class="page-header navbar-brand login-header">Add User</h1>

    <br>

    <div class="container">
    <?php if($err == "emptyfields"): ?>
      <div class="alert alert-danger" role="alert">
        Be sure to fill in all fields!
      </div>
    <?php elseif($err == "passlen"): ?>
      <div class="alert alert-danger" role="alert">
        Please make sure your password is between 8 - 16 characters long!
      </div>
    <?php elseif($err == "passwordcheck"): ?>
      <div class="alert alert-danger" role="alert">
        Your passwords did not match.
      </div>
    <?php elseif($err == "server"): ?>
      <div class="alert alert-warning" role="alert">
        There was an error on the server. Please try again. If this problem continues to arise, please contact me (Dalton).
      </div>
    <?php elseif($err == "usertaken"): ?>
      <div class="alert alert-danger" role="alert">
        Sorry, that username is taken. Please try another.
      </div>
    <?php elseif(isset($_GET['success'])): ?>
      <div class="alert alert-success" role="alert">
        User added to the database successfully
      </div>
    <?php endif; ?>

    <br>

      <form class="form-group" method="POST" autocomplete="off" action="../../inc/add.inc.php">
        <div class="row">
          <span class="col-md-5">
            <input class="form-control" id="first" name="firstname" placeholder="John" value="<?= $firstName ?>">
          </span>
          <span class="col-sm-2">
            <input class="form-control" id="middle" name="middleinit" placeholder="B" maxlength="1" value="<?= $middleInit ?>">
          </span>
          <span class="col-md-5">
            <input class="form-control" id="last" name="lastname" placeholder="Doe" value="<?= $lastName ?>">
          </span>
        </div>
        <input class="form-control" name="username" placeholder="Username" value="<?= $uid ?>">
        <input class="form-control" name="pass" placeholder="Password (8 - 16 characters)" type="password">
        <input class="form-control" name="pass_confirm" placeholder="Confirm Password" type="password">
        <center>
          <button class="btn btn-success" type="submit" name="add_user" style="padding: 15px 30px;">Add</button>
          <button class="btn btn-light" type="button" onclick="window.location='all.php'" style="padding: 15px 30px;">Back</button>
        </center>
      </form>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>

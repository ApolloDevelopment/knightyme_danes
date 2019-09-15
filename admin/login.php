<?php
  session_start();
  if(isset($_SESSION['id'])){
    header("Location: home.php");
    exit();
  }
  $err = isset($_GET['error']) ? $_GET['error'] : "";
?>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/main.css">
  <link rel="stylesheet" href="../css/all.min.css">
  <link rel="stylesheet" href="css/forms.css">
  <link rel="icon" href="../img/favicon.ico">
  <title>Knightyme Admin | Login</title>
</head>
<body>
  <h1 class="page-header navbar-brand login-header">Login</h1>
  <div class="container">
    <?php if($err == "emptyfields"): ?>
      <div class="alert alert-danger" role="alert">
        Must fill in both fields
      </div>
    <?php elseif($err == "server"): ?>
      <div class="alert alert-warning" role="alert">
        There was an error on the server. If this problem continues to arise, please contact me (Dalton) and I will do my best to fix it.
      </div>
    <?php elseif($err == "nouser"): ?>
      <div class="alert alert-danger" role="alert">
        Unable to find user. Please make sure your username is correct.
      </div>
    <?php elseif($err == "password"): ?>
      <div class="alert alert-danger" role="alert">
        Incorrect password
      </div>
    <?php endif; ?>
    <form class="form-group" method="POST" autocomplete="off" action="../inc/login.inc.php">
      <label for="username" class="label">Username:</label>
      <input class="form-control" id="username" name="userName" autofocus>
      <label for="pass" class="label">Password:</label>
      <input class="form-control" id="pass" name="password" type="password">
      <center>
        <button class="btn btn-success" type="submit" name="login" style="padding: 15px 30px">Login</button>
        <button class="btn btn-light" type="button" style="padding: 15px 30px" onclick="window.location='../'">Back</button>
      </center>
    </form>
  </div>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>

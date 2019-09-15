<?php
  session_start();
  if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit();
  }
  $err = isset($_GET['error']) ? $_GET['error'] : "";
?>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Knightyme Admin | My Account</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/forms.css">
    <link rel="stylesheet" href="../css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="icon" href="../img/favicon.ico">
  </head>
  <body>
    <!-- navigation -->
    <div class="navigation">
      <ul class="navigation-items">
        <center>
          <li class="navigation-item" onclick="window.location='home.php'">
            <i class="fas fa-home "></i>
            <p>Home</p>
          </li>
          <li class="navigation-item" onclick="window.location='all.php'">
            <i class="fas fa-paw "></i>
            <p>Danes</p>
          </li>
          <li class="navigation-item active">
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

    <!-- Modals need to stay outside container and content divs to display properly -->
    <div class="modal-filter" id="hidden"></div>

    <div class="modal-box" id="changeNameModal">
      <h2 class="modal-header">Change Name</h2>
      <div class="modal-body">
        <form class="form-group" method="POST" autocomplete="off" action="inc/changeName.php">
          <div class="row">
            <span class="col-md-5">
              <input class="form-control" id="first" name="firstname" placeholder="John" value="<?= $_SESSION['firstName'] ?>" autofocus>
            </span>
            <span class="col-sm-2">
              <input class="form-control" id="middle" name="middleinit" placeholder="B" maxlength="1" value="<?= $_SESSION['middle'] ?>">
            </span>
            <span class="col-md-5">
              <input class="form-control" id="last" name="lastname" placeholder="Doe" value="<?= $_SESSION['lastName'] ?>">
            </span>
          </div>
          <br>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success" name="saveBtn">Save</button>
            <button type="button" class="btn btn-outline-secondary" onclick="closeModal()">Cancel</button>
          </div>
        </form>
      </div>
    </div>
    <div class="modal-box" id="changeUsernameModal">
      <h2 class="modal-header">Change Username</h2>
      <div class="modal-body">
        <form class="form-group" autocomplete="off" action="inc/changeUsername.php" method="POST">
          <input class="form-control" name="username" placeholder="Username" value="<?= $_SESSION['username'] ?>" autofocus>
          <br>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success" name="saveBtn">Save</button>
            <button type="button" class="btn btn-outline-secondary" onclick="closeModal()">Cancel</button>
          </div>
        </form>
      </div>
    </div>
    <div class="modal-box" id="changePasswordModal">
      <h2 class="modal-header">Change Password</h2>
      <div class="modal-body">
        <form class="form-group" autocomplete="off" action="inc/changePassword.php" method="POST">
          <input class="form-control" placeholder="Current Password" name="currentPassword" type="password" autofocus>
          <br>
          <input class="form-control" placeholder="New Password" name="newPassword" type="password">
          <br>
          <input class="form-control" placeholder="Confirm Password" name="confirmPassword" type="password">
          <br>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success" name="saveBtn">Save</button>
            <button type="button" class="btn btn-outline-secondary" onclick="closeModal()">Cancel</button>
          </div>
        </form>
      </div>
    </div>
    <div class="modal-box" id="resetPasswordModal">
      <h2 class="modal-header">Are you sure?</h2>
      <div class="modal-body">
        Resetting your password will log you out and require you to sign back in with a new password. Do you wish to continue?
        <br><br>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" onclick="window.location='inc/resetPassword.php?r=true'">Yes, I'm sure</button>
          <button type="button" class="btn btn-outline-secondary" onclick="closeModal()">Cancel</button>
        </div>
      </div>
    </div>

    <!-- main content -->
    <div class="content">
      <div class="container">
      <?php
        if($err == "emptyfields") {
          echo '<div class="alert alert-danger">Be sure to fill in all fields</div>';
        } else if($err == 'server'){
          echo '<div class="alert alert-warning">There was an error on the server</div>';
        } else if($err == 'strlen') {
          echo '<div class="alert alert-danger">Make sure you are using the correct amount of characters.</div>';
        } else if($err == 'matchpass'){
          echo '<div class="alert alert-danger">Your passwords must match exactly! Try again.</div>';
        } else if($err == 'password'){
          echo '<div class="alert alert-danger">Incorrect password. Be sure to enter your current password that you use to login first.</div>';
        } else if(isset($_GET['success'])){
          if(isset($_GET['u']) && $_GET['u'] == 'name'){
            echo '<div class="alert alert-success">Name was updated successfully</div>';
          } else if(isset($_GET['u']) && $_GET['u'] == 'username'){
            echo '<div class="alert alert-success">Username was updated successfully</div>';
          } else if(isset($_GET['u']) && $_GET['u'] == 'password'){
            echo '<div class="alert alert-success">Password was updated successfully</div>';
          }
        }
      ?>
        <div class="section">
          <h1>Information</h1>

          <div class="card option" onclick="displayModal('name')">
            <div class="card-body">
              <h5 class="card-title">Change Name</h5>
              <p class="card-text">Edit the first and last name on your account.</p>
            </div>
          </div>
          <div class="card option" onclick="displayModal('username')">
            <div class="card-body">
              <h5 class="card-title">Change Username</h5>
              <p class="card-text">Edit the username on your account for logging into this admin panel.</p>
            </div>
          </div>
        </div>

        <div class="section">
          <h1>Security</h1>

          <div class="card option" onclick="displayModal('password')">
            <div class="card-body">
              <h5 class="card-title">Change Password</h5>
              <p class="card-text">A quick and simple password change for your account. Requires current password to complete.</p>
            </div>
          </div>
          <div class="card option" onclick="displayModal('rPassword')">
            <div class="card-body">
              <h5 class="card-title">Reset Password</h5>
              <p class="card-text">Reset and update the password for your account. This requires permission from Rick, as the email with your new temporary password will be sent to him.</p>
            </div>
          </div>
        </div>

      </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="js/modal.js"></script>
  </body>
</html>

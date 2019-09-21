<?php
  session_start();
  if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit();
  }
  $description = isset($_GET['d']) ? $_GET['d'] : "";
  $err = isset($_GET['error']) ? $_GET['error'] : "";
  $type = isset($_GET['type']) ? $_GET['type'] : "";
?>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/forms.css">
    <link rel="stylesheet" href="../css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="icon" href="../img/favicon.ico">
    <title>Kightyme Admin | Add Dane</title>
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
          <li class="navigation-item active">
            <i class="fas fa-paw "></i>
            <p>Danes</p>
          </li>
          <li class="navigation-item" onclick="window.location='account.php'">
            <i class="fas fa-user-cog "></i>
            <p>My Account</p>
          </li>
          <li class="navigation-item" onclick="window.location='inc/logout.php'">
            <i class="fas fa-sign-out-alt "></i>
            <p>Logout</p>
          </li>
        </center>
      </ul>
    </div>

    <!-- main content -->
    <div class="content">
      <div class="container">
        <h1 class="page-header navbar-brand login-header">Add <?= ucwords($type) ?></h1>

        <?php if($err == "emptyfields"): ?>
          <div class="alert alert-danger" role="alert">
            Be sure to fill in all fields!
          </div>
        <?php elseif($err == "invalidOptions"): ?>
          <div class="alert alert-danger" role="alert">
            Can not add availability of a puppy that is already sold. Uncheck the "Sold" checkbox if you want to make a puppy Future or Available.
          </div>
        <?php elseif($err == "server"): ?>
          <div class="alert alert-warning" role="alert">
            There was an error on the server. Please try again. If this problem continues to arise, please contact me (Dalton).
          </div>
        <?php elseif($err == "inputlen"): ?>
          <div class="alert alert-danger" role="alert">
            Make sure that the Name is LESS than 60 characters, as well as your image name being less than 252 characters.
          </div>
        <?php elseif($err == "invalidfiletype"): ?>
          <div class="alert alert-danger" role="alert">
            Error: You may only upload files of the type PNG, JPG, JPEG, IMG, and PDF.
          </div>
        <?php elseif(isset($_GET['success'])): ?>
          <div class="alert alert-success" role="alert">
            The dane was succesfully added to the database
          </div>
        <?php endif; ?>


        <br>
        
        <!-- Add Puppy Form -->
        <?php if($type == 'puppy'): ?>
          <form class="form-group" method="POST" autocomplete="off" action="inc/add.inc.php?type=puppy" enctype="multipart/form-data">
            <input type="file" name="images[]" accept=".png,.jpg,.jpeg,.img,.pdf" multiple>
            <br><br>
            <span class="col-md-9">
              <label for="name" style="margin-left:-15px;">Name</label>
              <input class="form-control" id="name" name="name" maxlength="60">
            </span>
            <div class="form-check form-check-inline" style="margin-left:-15px;">
              <input class="form-check-input" type="radio" name="sex" id="inlineRadio1" value="Male">
              <label class="form-check-label" for="inlineRadio1">Male</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="sex" id="inlineRadio2" value="Female">
              <label class="form-check-label" for="inlineRadio2">Female</label>
            </div>
            <div style="margin-top:10px;"></div>
            <label for="litter">Litter</label>
            <select class="form-control" id="litter" name="litter_id">
              <option>-None-</option>
              <?php include '../inc/conn.php';
                $sql = "SELECT * FROM litters";
                $result = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_assoc($result)):
              ?>
                <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
              <?php endwhile; ?>
            </select>
            <div style="margin-top:10px;"></div>
            <div class="form-inline">
              <div class="col-sm-3" style="margin-left:-15px;">
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text">$</div>
                  </div>
                  <input type="text" class="form-control" id="price" placeholder="Price" name="price">
                </div>
              </div>
              <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="isSold" name="isSold">
                <label class="form-check-label" for="isSold" style="margin-right: 15px;">Sold</label>
              </div>
              <input class="form-control" id="buyer" name="buyer" style="width:100%;" placeholder="Buyer (i.e. Rick and Family)">
            </div>
            <div style="margin-top: 10px;"></div>
            <label for="description">Description</label>
            <textarea class="form-control" rows="3" id="description" placeholder="Description" name="description"><?php echo $description; ?></textarea>
            <div style="margin-top: 10px;"></div>
            <label for="availabililty">Availability</label>
            <select class="form-control" id="availability" name="availability">
              <option></option>
              <option>Available</option>
              <option>Future</option>
            </select>
            <center>
              <br>
              <button class="btn btn-success" type="submit" name="add_dane" style="padding: 15px 30px;">Add</button>
              <button class="btn btn-light" type="button" onclick="window.location='all.php'" style="padding: 15px 30px;">Cancel</button>
            </center>
          </form>
          

          
        <!-- Add Parent Form -->
        <?php elseif($type =='parent'): ?>
        <form class="form-group" method="POST" autocomplete="off" action="inc/add.inc.php?type=parent" enctype="multipart/form-data">
          <input type="file" name="image" accept=".png,.jpg,.jpeg,.img,.pdf">
          <br><br>
          <span class="col-md-9">
            <label for="name" style="margin-left:-15px;">Name</label>
            <input class="form-control" id="name" name="name" maxlength="60">
          </span>
          <div class="form-check form-check-inline" style="margin-left:-15px;">
            <input class="form-check-input" type="radio" name="sex" id="inlineRadio1" value="Male">
            <label class="form-check-label" for="inlineRadio1">Father</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="sex" id="inlineRadio2" value="Female">
            <label class="form-check-label" for="inlineRadio2">Mother</label>
          </div>
          <div style="margin-top:10px;"></div>
          <label for="description">Description</label>
          <textarea class="form-control" rows="3" name="description" id="description"><?php echo $description; ?></textarea>
          <center>
            <br>
            <button class="btn btn-success" type="submit" name="add_dane" style="padding: 15px 30px;">Add</button>
            <button class="btn btn-light" type="button" onclick="window.location='all.php'" style="padding: 15px 30px;">Cancel</button>
          </center>
        </form>



        <!-- Add Litter Form -->
        <?php elseif($type == 'litter'): ?>
        <form class="form-group" method="POST" autocomplete="off" action="inc/add.inc.php?type=litter" enctype="multipart/form-data">
          <input type="file" name="image" accept=".png,.jpg,.jpeg,.img,.pdf">
          <br><br>
          <label for="name">Litter Name</label>
          <input class="form-control" id="name" name="name">
          <div style="margin-top:10px;"></div>
          <label for="description">Description</label>
          <textarea class="form-control" rows="3" name="description" id="description"><?php echo $description; ?></textarea>
          <div style="margin-top:10px;"></div>
          <div class="row">
            <div class="col">
              <label for="mother">Mother</label>
              <select class="form-control" id="mother" name="mother_id">
                <option>-None-</option>
                <?php include '../inc/conn.php';
                  $sql = "SELECT * FROM parents WHERE sex='F'";
                  $result = mysqli_query($conn, $sql);
                  while($row = mysqli_fetch_assoc($result)):
                ?>
                  <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                <?php endwhile; ?>
              </select>
            </div>
            <div class="col">
              <label for="father">Father</label>
              <select class="form-control" id="father" name="father_id">
                <option>-None-</option>
                <?php include '../inc/conn.php';
                  $sql2 = "SELECT * FROM parents WHERE sex='M'";
                  $result = mysqli_query($conn, $sql2);
                  while($row = mysqli_fetch_assoc($result)):
                ?>
                  <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                <?php endwhile; ?>
              </select>
            </div>
          </div>
          <center>
            <br>
            <button class="btn btn-success" type="submit" name="add_dane" style="padding: 15px 30px;">Add</button>
            <button class="btn btn-light" type="button" onclick="window.location='all.php'" style="padding: 15px 30px;">Cancel</button>
          </center>
        </form>

        <?php endif; ?>
      </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  </body>
</html>

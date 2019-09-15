<?php
  session_start();
  if(!isset($_SESSION['id'])){
    header("Location: ../login.php");
    exit();
  }
  $err = isset($_GET['editError']) ? $_GET['editError'] : "";
  $type = isset($_GET['type']) ? $_GET['type'] : "";
  include '../inc/conn.php';
?>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="">
    <title>Knightyme Admin | Danes</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="../css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="icon" href="../img/favicon.ico">

    <style>
      ::placeholder, 
      option {
        font-weight: normal !important;
      }
    </style>
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
          <li class="navigation-item" onclick="window.location='../inc/logout.php'">
            <i class="fas fa-sign-out-alt "></i>
            <p>Logout</p>
          </li>
        </center>
      </ul>
    </div>

    <!-- Filters for modals need to be outside the content and container divs -->
    <?php if(isset($_GET['edit']) || isset($_GET['delete'])){echo '<div class="modal-filter"></div>';} ?>
    <?php if(isset($_GET['edit'])): ?>
      <!-- editting modal -->
      <div class="modal-box">
        <h2 class="modal-header">Edit Dane</h2>
        <div class="modal-body">
          <?php if(isset($_GET['success'])): ?>
            <div class="alert alert-success" role="alert">
              All changes saved successfully
            </div>
          <?php elseif($err == "emptyfields"): ?>
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
          <?php endif; ?>
          <?php if(isset($_GET['id'])): ?>
            <?php if(preg_match("/[A-Za-z]/", $_GET['id'])): ?>
              <p class='text-danger'>Unidentifiable ID. Please make sure the ID is an integer (ex: 2)</p>
            <?php else: ?>
              <?php
              $id = mysqli_real_escape_string($conn, $_GET['id']);
              if($type == 'puppy'){
                $sqlEditForm = "SELECT * FROM pups WHERE id='$id'";
              } else if($type == 'parent') {
                $sqlEditForm = "SELECT * FROM parents WHERE id='$id'";
              } else if($type == 'litter') {
                $sqlEditForm = "SELECT * FROM litters WHERE id='$id'";
              }
              $resultEditForm = mysqli_query($conn, $sqlEditForm);
              if(mysqli_num_rows($resultEditForm) == 0): ?>
                <p class='text-danger'>Unable to find Dane. Make sure the ID is a correct ID and then refresh.</p>
              <?php elseif(mysqli_num_rows($resultEditForm) > 1): ?>
                <p class='text-warning'>There was an error on the server. Please contact me (Dalton) to resolve this.</p>
              <?php else: ?>
                <?php while($rowEditForm = mysqli_fetch_assoc($resultEditForm)): ?>
                  <?php $description2 = (isset($_GET['desc']) && !empty($_GET['desc'])) ? $_GET['desc'] : $rowEditForm['description']; ?>
                  
                  <!-- Edit Puppy Form -->
                  <?php if($type == 'puppy'): ?>
                    <form class="form-group" method="POST" autocomplete="off" action="inc/edit.inc.php?type=puppy">
                      <input type="hidden" name="id" value="<?= $rowEditForm['id'] ?>">
                      <span class="col-md-9">
                        <label for="name" style="margin-left:-15px;">Name <?php if(!empty($err)): ?><span class="text-danger lead">*</span><?php endif; ?></label>
                        <input class="form-control" id="name" name="name" maxlength="60" value="<?= $rowEditForm['name'] ?>">
                      </span>
                      <div class="form-check form-check-inline" style="margin-left:-15px;">
                        <input class="form-check-input" type="radio" name="sex" id="inlineRadio1" value="Male" <?php if($rowEditForm['sex']=="M"): ?>checked<?php endif; ?>>
                        <label class="form-check-label" for="inlineRadio1">Male</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="sex" id="inlineRadio2" value="Female" <?php if($rowEditForm['sex']=="F"): ?>checked<?php endif; ?>>
                        <label class="form-check-label" for="inlineRadio2">Female</label>
                      </div>
                      <div style="margin-top:10px;"></div>
                      <label for="litter">Litter <?php if(!empty($err)): ?><span class="text-danger lead">*</span><?php endif; ?></label>
                      <select class="form-control" id="litter" name="litter_id">
                        <option>-None-</option>
                        <?php 
                          $sqlEditPuppy = "SELECT * FROM litters";
                          $resultEditPuppy = mysqli_query($conn, $sqlEditPuppy);
                          while($rowEditPuppy = mysqli_fetch_assoc($resultEditPuppy)):
                        ?>
                          <option value="<?= $rowEditPuppy['id'] ?>"><?= $rowEditPuppy['name'] ?></option>
                        <?php endwhile; ?>
                      </select>
                      <div style="margin-top:10px;"></div>
                      <div class="form-inline">
                        <div class="col-sm-3" style="margin-left:-15px;">
                          <div class="input-group mb-2">
                            <div class="input-group-prepend">
                              <div class="input-group-text">$</div>
                            </div>
                            <input type="text" class="form-control" id="price" placeholder="Price" name="price" value="<?= $rowEditForm['price'] ?>">
                            <?php if(!empty($err)): ?><span class="text-danger lead">*</span><?php endif; ?>
                          </div>
                        </div>
                        <div class="form-group form-check">
                          <input type="checkbox" class="form-check-input" id="isSold" name="isSold" <?php if($rowEditForm['isSold']): ?>checked<?php endif; ?>>
                          <label class="form-check-label" for="isSold">Sold</label>
                        </div>
                        <input class="form-control" style="width:100%;" name="buyer" placeholder="Buyer (i.e. Rick and Family)">
                      </div>
                      <div style="margin-top: 10px;"></div>
                      <label for="description">Description <?php if(!empty($err)): ?><span class="text-danger lead">*</span><?php endif; ?></label>
                      <textarea class="form-control" rows="3" id="description" placeholder="Description" name="description"><?= $description2 ?></textarea>
                      <div style="margin-top: 10px;"></div>
                      <label for="availabililty">Availability <?php if(!empty($err)): ?><span class="text-danger lead">*</span><?php endif; ?></label>
                      <select class="form-control" id="availability" name="availability" value="<?= $rowEditForm['availability'] ?>">
                        <option></option>
                        <option>Available</option>
                        <option>Future</option>
                      </select>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="window.location='<?php echo $_SERVER['PHP_SELF']; ?>'">Close</button>
                        <button type="submit" class="btn btn-success" name="save_btn">Save</button>
                      </div>
                    </form>

                  <!-- Edit Parent Form -->
                  <?php elseif($type == 'parent'): ?>
                    <form class="form-group" method="POST" autocomplete="off" action="inc/edit.inc.php?type=parent">
                        <input type="hidden" name="id" value="<?= $rowEditForm['id'] ?>">
                        <span class="col-md-9">
                          <label for="name" style="margin-left:-15px;">Name <?php if(!empty($err)): ?><span class="text-danger lead">*</span><?php endif; ?></label>
                          <input class="form-control" id="name" name="name" maxlength="60" value="<?= $rowEditForm['name'] ?>">
                        </span>
                        <div class="form-check form-check-inline" style="margin-left:-15px;">
                          <input class="form-check-input" type="radio" name="sex" id="inlineRadio1" value="Male" <?php if($rowEditForm['sex']=="M"): ?>checked<?php endif; ?>>
                          <label class="form-check-label" for="inlineRadio1">Male</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="sex" id="inlineRadio2" value="Female" <?php if($rowEditForm['sex']=="F"): ?>checked<?php endif; ?>>
                          <label class="form-check-label" for="inlineRadio2">Female</label>
                        </div>
                        <div style="margin-top: 10px;"></div>
                        <label for="description">Description <?php if(!empty($err)): ?><span class="text-danger lead">*</span><?php endif; ?></label>
                        <textarea class="form-control" rows="3" id="description" placeholder="Description" name="description"><?= $description2 ?></textarea>
                        <div style="margin-top: 10px;"></div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" onclick="window.location='<?php echo $_SERVER['PHP_SELF']; ?>'">Close</button>
                          <button type="submit" class="btn btn-success" name="save_btn">Save</button>
                        </div>
                      </form>

                  <!-- Edit Litter Form -->
                  <?php elseif($type == 'litter'): ?>
                  <form class="form-group" method="POST" autocomplete="off" action="inc/edit.inc.php?type=litter">
                    <input type="hidden" name="id" value="<?= $rowEditForm['id'] ?>">
                    <label for="name">Litter Name <?php if(!empty($err)): ?><span class="text-danger lead">*</span><?php endif; ?></label>
                    <input class="form-control" id="name" name="name" value="<?= $rowEditForm['name'] ?>">
                    <div style="margin-top:10px;"></div>
                    <label for="description">Description <?php if(!empty($err)): ?><span class="text-danger lead">*</span><?php endif; ?></label>
                    <textarea class="form-control" rows="3" name="description" id="description"><?= $description2 ?></textarea>
                    <div style="margin-top:10px;"></div>
                    <div class="row">
                      <div class="col">
                        <label for="mother">Mother <?php if(!empty($err)): ?><span class="text-danger lead">*</span><?php endif; ?></label>
                        <select class="form-control" id="mother" name="mother_id">
                          <option>-None-</option>
                          <?php include '../inc/conn.php';
                            $sqlEditLitterFather = "SELECT * FROM parents WHERE sex='F'";
                            $result = mysqli_query($conn, $sqlEditLitterFather);
                            while($row = mysqli_fetch_assoc($result)):
                          ?>
                            <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                          <?php endwhile; ?>
                        </select>
                      </div>
                      <div class="col">
                        <label for="father">Father <?php if(!empty($err)): ?><span class="text-danger lead">*</span><?php endif; ?></label>
                        <select class="form-control" id="father" name="father_id">
                          <option>-None-</option>
                          <?php include '../inc/conn.php';
                            $sqlEditLitterMother = "SELECT * FROM parents WHERE sex='M'";
                            $result = mysqli_query($conn, $sqlEditLitterMother);
                            while($row = mysqli_fetch_assoc($result)):
                          ?>
                            <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                          <?php endwhile; ?>
                        </select>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" onclick="window.location='<?php echo $_SERVER['PHP_SELF']; ?>'">Close</button>
                      <button type="submit" class="btn btn-success" name="save_btn">Save</button>
                    </div>
                  </form>

                  <?php endif; ?>

                <?php endwhile; ?>
              <?php endif; ?>
            <?php endif; ?>
          <?php endif; ?>
          
        </div>
      </div>
    <?php elseif(isset($_GET['delete']) && isset($_GET['id']) && !preg_match("/[A-Za-z]/", $_GET['id'])): ?>
      <!-- deletion modal -->
      <div class="modal-box">
        <h2 class="modal-header">Permanently Delete Dane</h2>
        <div class="modal-body">
          Are you sure you want to delete this dane? This action cannot be undone.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" onclick="window.location='<?php echo $_SERVER['PHP_SELF']; ?>'">Close</button>
          <button type="button" class="btn btn-danger" onclick="window.location='inc/delete.inc.php?id=<?= $_GET['id'] ?>&type=<?= $type ?>'">Delete</button>
        </div>
      </div>
    <?php endif; ?>



    <!-- main content -->
    <div class="content">
      <div class="container">
      <?php
        //see if any danes are posted in the database at all
        $sql = "SELECT * FROM pups";
        $result = mysqli_query($conn, $sql);
        $sql2 = "SELECT * FROM litters";
        $result2 = mysqli_query($conn, $sql2);
        $sql3 = "SELECT * FROM parents";
        $result3 = mysqli_query($conn, $sql3);
        if(mysqli_num_rows($result) == 0 && mysqli_num_rows($result2) == 0 && mysqli_num_rows($result3) == 0):
      ?>
      <center>
        <h1 class="light">No danes available</h1>
        <a href="add.php?type=parent" class="btn btn-success"><i class="fas fa-plus"></i> Add a Parent</a>
      </center>
      <?php else: ?>
      <center>
        <h1 class="page-header navbar-brand">All Danes</h1>
        <a href="add.php?type=parent" class="btn btn-success"><i class="fas fa-plus"></i> Add a Parent</a>
        <a href="add.php?type=litter" class="btn btn-success"><i class="fas fa-plus"></i> Add a Litter</a>
        <a href="add.php?type=puppy" class="btn btn-success"><i class="fas fa-plus"></i> Add a Puppy</a>
      </center>
      <div style="margin-top:50px;"></div>
      <h2 class="header">Puppies</h2>
      <center>

        <?php
          $sql = "SELECT * FROM pups";
          $result = mysqli_query($conn, $sql);
          if(mysqli_num_rows($result) == 0){
            echo <<<EOT
            <h1 class="light">None Puppies Added</h1>
            </center>
EOT;
          } else {
            echo '</center>';
            $add = 'add.php';
            if(isset($_GET['error']) && $type == 'puppy'){ echo '<div class="alert alert-danger" role="alert">There was an error deleting the dane.</div>'; }
            echo '<br>';

            while($row = mysqli_fetch_assoc($result)) {
              $id = $row['id'];
              $availability = "";

              if($row['availability'] == "Available") {
                $availability = "<span class='text-success'>Available!</span>";
              } else if($row['availability'] == "Future") {
                $availability = "<span class='text-warning'>Coming Soon!</span>";
              } else if(empty($row['availability']) && $row['isSold']) {
                $availability = "<span class='text-danger'>SOLD!</span>";
              }
              echo <<<EOT
              <div class="card mb-3">
                <div class="more-container">
                  <i class="fas fa-ellipsis-v more"></i>
                  <div class="more-options">
                    <div class="edit-option" onclick="window.location='?edit&id={$id}&type=puppy'">Edit</div>
                    <div class="edit-option" onclick="window.location='?delete&id={$id}&type=puppy'">Delete</div>
                  </div>
                </div>
                <div class="row no-gutters">
                  <div class="col-sm-2">
                    <img src="../img/{$row['image_name']}" class="card-img" alt="Picture of {$row['name']}">
                  </div>
                  <div class="col-lg-10">
                    <div class="card-body">
                      <h5 class="card-title">{$row['name']} <span class="text-small text-muted">({$row['sex']})</span> - {$availability}
                      <br><span class="price">\${$row['price']}</span></h5>
                      <p class="card-text">{$row['description']}</p>
                      <p class="card-text"><small class="text-muted">Last updated: {$row['upload_date']}</small></p>
                    </div>
                  </div>
                </div>
              </div>
EOT;
            }
          }
        ?>

<div style="margin-top: 100px;"></div>

<h2 class="header">Litters</h2>
      <center>

        <?php
          $sql = "SELECT * FROM litters";
          $result = mysqli_query($conn, $sql);
          if(mysqli_num_rows($result) == 0){
            echo <<<EOT
              <h1 class="light">None Litters Added</h1>
            </center>
EOT;
          } else {
            echo '</center>';
            if(isset($_GET['error']) && $type == 'litter'){ echo '<div class="alert alert-danger" role="alert">There was an error deleting the dane.</div>'; }
            echo '<br>';

            while($row = mysqli_fetch_assoc($result)) {
              $id = $row['id'];
              echo <<<EOT
              <div class="card mb-3">
                <div class="more-container">
                  <i class="fas fa-ellipsis-v more"></i>
                  <div class="more-options">
                    <div class="edit-option" onclick="window.location='?edit&id={$id}&type=litter'">Edit</div>
                    <div class="edit-option" onclick="window.location='?delete&id={$id}&type=litter'">Delete</div>
                  </div>
                </div>
                <div class="row no-gutters">
                  <div class="col-sm-2">
                    <img src="../img/{$row['image_name']}" class="card-img" alt="Picture of {$row['name']}">
                  </div>
                  <div class="col-lg-10">
                    <div class="card-body">
                      <h5 class="card-title">{$row['name']}</h5>
                      <p class="card-text">{$row['description']}</p>
                      <p class="card-text"><small class="text-muted">Last updated: {$row['upload_date']}</small></p>
                    </div>
                  </div>
                </div>
              </div>
EOT;
            }
          }
        ?>

<div style="margin-top: 100px;"></div>

<h2 class="header">Parents</h2>
      <center>

        <?php
          $sql = "SELECT * FROM parents";
          $result = mysqli_query($conn, $sql);
          if(mysqli_num_rows($result) == 0){
            echo <<<EOT
              <h1 class="light">None Parents Added</h1>
            </center>
EOT;
          } else {
            $add = 'add.php';
            echo '</center>';
            if(isset($_GET['error']) && $type == 'parent'){ echo '<div class="alert alert-danger" role="alert">There was an error deleting the dane.</div>'; }
            echo '<br>';

            while($row = mysqli_fetch_assoc($result)) {
              $id = $row['id'];
              echo <<<EOT
              <div class="card mb-3">
                <div class="more-container">
                  <i class="fas fa-ellipsis-v more"></i>
                  <div class="more-options">
                    <div class="edit-option" onclick="window.location='?edit&id={$id}&type=parent'">Edit</div>
                    <div class="edit-option" onclick="window.location='?delete&id={$id}&type=parent'">Delete</div>
                  </div>
                </div>
                <div class="row no-gutters">
                  <div class="col-sm-2">
                    <img src="../img/{$row['image_name']}" class="card-img" alt="Picture of {$row['name']}">
                  </div>
                  <div class="col-lg-10">
                    <div class="card-body">
                      <h5 class="card-title">{$row['name']} <span class="text-small text-muted">({$row['sex']})</span></h5>
                      <p class="card-text">{$row['description']}</p>
                      <p class="card-text"><small class="text-muted">Last updated: {$row['upload_date']}</small></p>
                    </div>
                  </div>
                </div>
              </div>
EOT;
            }
          }
        ?>
      </div>
    </div>
    <?php endif; ?>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="js/main.js" charset="utf-8"></script>
  </body>
</html>

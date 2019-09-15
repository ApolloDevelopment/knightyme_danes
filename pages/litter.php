<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/main.css">
  <link rel="stylesheet" href="../css/all.min.css">
  <link rel="stylesheet" href="../css/dane.css">
  <link rel="icon" href="../img/favicon.ico">
  <?php
    // Just using this to get the title of the page to make it more dynamic
    include '../inc/conn.php';
    $id = isset($_GET['id']) ? $_GET['id'] : "";
    $sql = "SELECT * FROM litters WHERE id=?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
      header("Location: /");
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "i", $id);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      while($row = mysqli_fetch_assoc($result)){
      ?>
      <title><?= $row['name'] ?> | Knightyme Danes</title>
      <?php
      }
    }
  ?>
</head>
<body>
  <div class="nav2-expand-btn" id="open-nav2" onclick="toggleNav(true)"><i class="fas fa-bars"></i></div>

  <?php include '../inc/secondary_nav-pages.php'; ?>

  <img src="../img/top-left.jpg" class="top-page-img left"></img>
  <img src="../img/top-right.jpg" class="top-page-img right"></img>

  <?php include '../inc/nav-pages.php'; ?>
  <?php
  if(!mysqli_stmt_prepare($stmt, $sql)){
    header("Location: ../index.php?cantprepare");
    exit();
  } else {
    if($id == ""){
      header("Location: ../index.php?id=noid");
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "i", $id);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      while($row = mysqli_fetch_assoc($result)){
        $name = $row['name'];
        $description = $row['description'];
        $date = $row['upload_date'];
        $daneID = $row['id'];
        $image = $row['image_name'];
        ?>
          <center>
            <button type="button" class="btn btn-dark back-btn" onclick="history.back()"><i class="fas fa-arrow-left"></i> Back</button>
          </center>
          <h1 class="litter-page-header"><?= $name ?></h1>

          <div class="container">
            <div class="row">
              <div class="col-md-6">
                <center>
                  <?php
                    $mother = $row['mother_id'];
                    $sqlMother = "SELECT * FROM parents WHERE id='$mother'";
                    $resultMother = mysqli_query($conn, $sqlMother);
                    while($mother_row = mysqli_fetch_assoc($resultMother)){
                    ?>
                      <h1 class="litter-parent-header mother-text"><?= $mother_row['name'] ?></h1>
                      <img src="../img/<?= $mother_row['image_name'] ?>" class="dane-image border-female" />
                      <p class="dane-description"><?= $mother_row['description'] ?></p>
                    <?php
                    }
                  ?>
                </center>
              </div>
              <div class="col-md-6">
                <center>
                  <?php
                    $father = $row['father_id'];
                    $sqlFather = "SELECT * FROM parents WHERE id='$father'";
                    $resultFather = mysqli_query($conn, $sqlFather);
                    while($father_row = mysqli_fetch_assoc($resultFather)){
                    ?>
                      <h1 class="litter-parent-header father-text"><?= $father_row['name'] ?></h1>
                      <img src="../img/<?= $father_row['image_name'] ?>" class="dane-image border-male" />
                      <p class="dane-description"><?= $father_row['description'] ?></p>
                    <?php
                    }
                  ?>
                </center>
              </div>
            </div>
          </div>
          <div style="margin:30px 0px;"></div>
          <center>
          <img src="../img/<?= $image ?>" class="dane-image border-default" />
          <p class="dane-description">
            <?= $description ?>
          </p>
          </center>

          <!-- Begin adding puppies of litter here -->
          <div class="container">
          <center>
          <?php
            $litter = $row['id'];
            $sqlPuppy = "SELECT * FROM pups WHERE litter_id=$litter";
            $resultPuppy = mysqli_query($conn, $sqlPuppy);
            while($puppy_row = mysqli_fetch_assoc($resultPuppy)){
            $puppy_availability = "";
            if($puppy_row['availability'] == "Available" && !$puppy_row['isSold']) {
              $puppy_availability = "<span class='text-success'>\$$puppy_row[price]!</span>";
            } else if($puppy_row['availability'] == "Future" && !$puppy_row['isSold']) {
              $puppy_availability = "<span class='text-warning'>Coming Soon!</span>";
            } else if($puppy_row['isSold']) {
              $puppy_availability = "<span class='text-danger'>SOLD!</span> Thank you to $puppy_row[buyer]!";
            }
          ?>
            <div class="puppy-container">
              <h1 class="litter-parent-header"><?= $puppy_row['name'] ?></h1>
              <img src="../img/<?= $puppy_row['image_name'] ?>" class="puppy-img" alt="Picture of <?= $puppy_row['name'] ?>">
              <p class="dane-availability">This dane is <?= $puppy_availability ?></p>
              <p class="dane-description"><?= $puppy_row['description'] ?></p>
            </div>
          <?php
            }
          ?>
          </center>
          </div>
      <?php
      }
    }
  }
  
?>

  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script src="../js/nav_functions.js"></script>
</body>
</html>

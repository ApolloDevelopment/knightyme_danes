<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/main.css">
  <link rel="stylesheet" href="../css/all.min.css">
  <link rel="stylesheet" href="../css/pages.css">
  <link rel="icon" href="../img/favicon.ico">
  <title>Future Litters | Knightyme Danes</title>
</head>
<body>
  <div class="nav2-expand-btn" id="open-nav2" onclick="toggleNav(true)"><i class="fas fa-bars"></i></div>

  <?php include '../inc/secondary_nav-pages.php'; ?>

  <img src="../img/top-left.jpg" class="top-page-img left"></img>
  <img src="../img/top-right.jpg" class="top-page-img right"></img>

  <?php include '../inc/nav-pages.php'; ?>
  <div class="container">
    <div class="content">
      <div class="row">
      <?php
        include '../inc/conn.php';
        $sql = "SELECT * FROM pups WHERE availability='future'";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) == 0){
          echo <<<EOT
            <h1 class="light">No danes available</h1>
EOT;
        } else {
          while($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $name = $row['name'];
            $sex = $row['sex'];
            $description = $row['description'];
            $availability = $row['availability'];
            $image = $row['image_name'];
            $date = $row['upload_date'];
            $price = $row['price'];
            ?>
              <div class="col-md-4">
                <div class="card mb-4 box-shadow">
                  <div class="card-div-top" style="background-image:url('../img/<?= $image ?>'); background-size:contain;" onclick="slide_show('../img/<?= $image ?>')">
                    <div class="view-opt-contain">
                      <p class="view-txt">View</p>
                    </div>
                  </div>
                  <div class="card-body">
                  <h3 class="card-title">
                      <?= $name ?> <small><span class="text-muted">(<?= $sex ?>)</span>
                      <br>
                      <span class="text-warning">$<?= $price ?></span></small>
                    </h3>
                    <p class="card-text"><?= $description ?></p>
                    <div class="d-flex justify-content-between align-items-center">
                      <a href="litter.php?id=<?= $row['litter_id'] ?>" class="btn btn-outline-secondary">View Litter</a>
                      <small class="text-muted"><?= $date ?></small>
                    </div>
                  </div>
                </div>
              </div>
          <?php
          }
        }
      ?>
      </div>
    </div>
  </div>

  <div id="slideShow">
    <div class="closeSlides" id="close_slides" onclick="close_slides()">&times;</div>
  </div>

  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script src="../js/nav_functions.js"></script>
  <script src="../js/pages.js"></script>
</body>
</html>

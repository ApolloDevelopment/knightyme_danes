<?php
//dane type to upload to database
$type = isset($_GET['type']) ? $_GET['type'] : "";

if(!isset($_POST['add_dane'])) {
  header("Location: ../add.php?type=puppy");
  exit();
} else {
  // PUPPY DANE UPLOAD HANDLER
  if($type == 'puppy'){
    $image = $_FILES['images'];
    //image name
    $imageName = $image['name']; // name provided by users
    //file tmp name///////////////////
    $imageTmpName = $_FILES['image']['tmp_name']; //the actual file
    $imageExt = explode('.', $imageName);
    $imageRealExt = strtolower(end($imageExt));
    $newImgName = $imageExt[0].'-'.uniqid('', true).'.'.$imageRealExt;
    $allowed = array('png', 'jpg', 'jpeg', 'img', 'pdf');
    //upload path////////////////////////
    $target = "../../img/".$newImgName;

    if($image['error'] !== 0 || empty($_POST['name']) || empty($_POST['sex']) || $_POST['litter']=='-None-' || empty($_POST['description']) || empty($_POST['price']) || (empty($_POST['availability']) && !isset($_POST['isSold']))){
      header("Location: ../add.php?type=puppy&error=emptyfields&d=".$_POST['description']);
      exit();
    } else if(!in_array($imageRealExt, $allowed)) {
      header("Location ../add.php?type=puppy&error=invalidfiletype&d=".$_POST['description']);
      exit();
    } else if(!empty($_POST['availability']) && isset($_POST['isSold'])) {
      header("Location: ../add.php?type=puppy&error=invalidOptions&d=".$_POST['description']);
      exit();
    } else if(strlen($_POST['name']) > 60 || strlen(basename($imageName)) > 251) {
      header("Location ../add.php?type=puppy&error=inputlen&d=".$_POST['description']);
      exit();
    } else {
      include '../../inc/conn.php';
      $name = mysqli_real_escape_string($conn, $_POST['name']);
      $description = mysqli_real_escape_string($conn, $_POST['description']);
      $sex = mysqli_real_escape_string($conn, $_POST['sex'][0]);
      $price = mysqli_real_escape_string($conn, $_POST['price']);
      $availablitiy = mysqli_real_escape_string($conn, $_POST['availability']);
      $litter = mysqli_real_escape_string($conn, $_POST['litter_id']);
      $isSold = isset($_POST['isSold']);
      $buyer = mysqli_real_escape_string($conn, $_POST['buyer']);
      $today = (date("M") == "May" || date("M") == "June" || date("M") == "July") ? date("M j, Y") : date("M. j, Y"); //current date
      $sql = "INSERT INTO pups (name, sex, description, availability, image_name, upload_date, litter_id, price, isSold, buyer) VALUES ('$name', '$sex', '$description', '$availablitiy', '$newImgName', '$today', '$litter', '$price', '$isSold', '$buyer')";
      if (mysqli_query($conn, $sql)) {
        move_uploaded_file($imageTmpName, $target);
        header("Location: ../add.php?type=puppy&success");
        exit();
      } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        header("Location: ../add.php?type=puppy&error=server");
        exit();
      }
    }

    // PARENT DANE UPLOAD HANDLER
  } else if($type == 'parent') {
    $image = $_FILES['image'];
    $imageName = $image['name'];
    $imageTmpName = $_FILES['image']['tmp_name'];
    $imageExt = explode('.', $imageName);
    $imageRealExt = strtolower(end($imageExt));
    $newImgName = $imageExt[0].'-'.uniqid('', true).'.'.$imageRealExt;
    $allowed = array('png', 'jpg', 'jpeg', 'img', 'pdf');
    $target = "../../img/".$newImgName;

    if($image['error'] !== 0 || empty($_POST['name']) || empty($_POST['sex']) || empty($_POST['description'])){
      header("Location: ../add.php?type=parent&error=emptyfields&d=".$_POST['description']);
      exit();
    } else if(!in_array($imageRealExt, $allowed)) {
      header("Location ../add.php?type=parent&error=invalidfiletype");
      exit();
    } else if(strlen($_POST['name']) > 60 || strlen(basename($imageName)) > 251) {
      header("Location ../add.php?type=parent&error=inputlen");
      exit();
    } else {
      include '../../inc/conn.php';
      $name = mysqli_real_escape_string($conn, $_POST['name']);
      $description = mysqli_real_escape_string($conn, $_POST['description']);
      $sex = mysqli_real_escape_string($conn, $_POST['sex'][0]);
      $today = (date("M") == "May" || date("M") == "June" || date("M") == "July") ? date("M j, Y") : date("M. j, Y"); //current date
      $sql = "INSERT INTO parents (name, sex, description, image_name, upload_date) VALUES ('$name', '$sex', '$description', '$newImgName', '$today')";
      if (mysqli_query($conn, $sql)) {
        move_uploaded_file($imageTmpName, $target);
        header("Location: ../add.php?type=parent&success");
        exit();
      } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        header("Location: ../add.php?type=parent&error=server");
        exit();
      }
    }

    // LITTER UPLOAD HANDLER
  } else if($type == 'litter') {
    $image = $_FILES['image'];
    $imageName = $image['name'];
    $imageTmpName = $_FILES['image']['tmp_name'];
    $imageExt = explode('.', $imageName);
    $imageRealExt = strtolower(end($imageExt));
    $newImgName = $imageExt[0].'-'.uniqid('', true).'.'.$imageRealExt;
    $allowed = array('png', 'jpg', 'jpeg', 'img', 'pdf');
    $target = "../../img/".$newImgName;

    if($image['error'] !== 0 || empty($_POST['name']) || empty($_POST['description']) || $_POST['mother_id']=="-None-" || $_POST['father_id']=='-None-'){
      header("Location: ../add.php?type=litter&error=emptyfields&d=".$_POST['description']);
      exit();
    } else if(!in_array($imageRealExt, $allowed)) {
      header("Location ../add.php?type=litter&error=invalidfiletype");
      exit();
    } else if(strlen($_POST['name']) > 60 || strlen(basename($imageName)) > 251) {
      header("Location ../add.php?type=litter&error=inputlen");
      exit();
    } else {
      include '../../inc/conn.php';
      $name = mysqli_real_escape_string($conn, $_POST['name']);
      $description = mysqli_real_escape_string($conn, $_POST['description']);
      $sex = mysqli_real_escape_string($conn, $_POST['sex'][0]);
      $today = (date("M") == "May" || date("M") == "June" || date("M") == "July") ? date("M j, Y") : date("M. j, Y"); //current date
      $mother = mysqli_real_escape_string($conn, $_POST['mother_id']);
      $father = mysqli_real_escape_string($conn, $_POST['father_id']);
      $sql = "INSERT INTO litters (name, description, father_id, mother_id, image_name, upload_date) VALUES ('$name', '$description', '$father', '$mother', '$newImgName', '$today')";
      if (mysqli_query($conn, $sql)) {
        move_uploaded_file($imageTmpName, $target);
        header("Location: ../add.php?type=litter&success");
        exit();
      } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        header("Location: ../add.php?type=litter&error=server");
        exit();
      }
    }

  }


}

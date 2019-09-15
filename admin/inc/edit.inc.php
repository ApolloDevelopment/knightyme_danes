<?php

if(!isset($_POST['save_btn'])) {
  header("Location: ../danes/all.php");
  exit();
} else {
  $type = isset($_GET['type']) ? $_GET['type'] : "";

  // PUPPY DANE EDIT HANDLER
  if($type == 'puppy'){
    $id = $_POST['id'];
    if(empty($_POST['name']) || empty($_POST['sex']) || $_POST['litter_id']=='-None-' || empty($_POST['description']) || empty($_POST['price']) || (empty($_POST['availability']) && !isset($_POST['isSold']))){
    header("Location: ../all.php?edit&id=".$id."&type=puppy&editError=emptyfields&d=".$_POST['description']);
    exit();
    } else if(!empty($_POST['availability']) && isset($_POST['isSold'])) {
      header("Location: ../all.php?edit&id=".$id."&type=puppy&editError=invalidOptions");
      exit();
    } else if(strlen($_POST['name']) > 60) {
      header("Location: ../all.php?edit&id=".$id."&type=puppy&editError=inputlen");
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
      $sql = "UPDATE pups SET name='$name', sex='$sex', description='$description', availability='$availablitiy', upload_date='$today', litter_id='$litter', price='$price', isSold='$isSold', buyer='$buyer' WHERE id='$id'";
      if (mysqli_query($conn, $sql)) {
        header("Location: ../all.php?edit&id=".$id."&type=puppy&success");
        exit();
      } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        header("Location: ../all.php?edit&id=".$id."&type=puppy&editError=server");
        exit();
      }
    }
  }

  // PARENT DANE EDIT HANDLER
  if($type == 'parent'){
    $id = $_POST['id'];
    if(empty($_POST['name']) || empty($_POST['sex']) || empty($_POST['description'])){
    header("Location: ../all.php?edit&id=".$id."&type=parent&editError=emptyfields&d=".$_POST['description']);
    exit();
    } else if(strlen($_POST['name']) > 60) {
      header("Location ../all.php?edit&id=".$id."&type=parent&editError=inputlen");
      exit();
    } else {
      include '../../inc/conn.php';
      $name = mysqli_real_escape_string($conn, $_POST['name']);
      $description = mysqli_real_escape_string($conn, $_POST['description']);
      $sex = mysqli_real_escape_string($conn, $_POST['sex'][0]);
      $today = (date("M") == "May" || date("M") == "June" || date("M") == "July") ? date("M j, Y") : date("M. j, Y"); //current date
      $sql = "UPDATE parents SET name='$name', sex='$sex', description='$description', upload_date='$today' WHERE id='$id'";
      if (mysqli_query($conn, $sql)) {
        header("Location: ../all.php?edit&id=".$id."&type=parent&success");
        exit();
      } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        header("Location: ../all.php??edit&id=".$id."&type=parent&editError=server");
        exit();
      }
    }
  }

  // LITTER EDIT HANDLER
  if($type == 'litter'){
    $id = $_POST['id'];
    if(empty($_POST['name']) || empty($_POST['description']) || $_POST['mother_id']=="-None-" || $_POST['father_id']=='-None-'){
      header("Location: ../all.php?edit&id=".$id."&type=litter&editError=emptyfields&desc=".$_POST['description']);
      exit();
    } else if(strlen($_POST['name']) > 60) {
      header("Location ../all.php?edit&id=".$id."&type=litter&editError=inputlen");
      exit();
    } else {
      include '../../inc/conn.php';
      $name = mysqli_real_escape_string($conn, $_POST['name']);
      $description = mysqli_real_escape_string($conn, $_POST['description']);
      $sex = mysqli_real_escape_string($conn, $_POST['sex'][0]);
      $today = (date("M") == "May" || date("M") == "June" || date("M") == "July") ? date("M j, Y") : date("M. j, Y"); //current date
      $mother = mysqli_real_escape_string($conn, $_POST['mother_id']);
      $father = mysqli_real_escape_string($conn, $_POST['father_id']);
      $sql = "UPDATE litters SET name='$name', description='$description', father_id='$father', mother_id='$mother', upload_date='$today' WHERE id='$id'";
      if (mysqli_query($conn, $sql)) {
        header("Location: ../all.php?edit&id=".$id."&type=litter&success");
        exit();
      } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        header("Location: ../all.php?edit&id=".$id."&type=litter&editError=server");
        exit();
      }
    }
  }
}
<?php

if(isset($_GET['id']) && !preg_match("/[A-Za-z]/", $_GET['id'])) {
  $type = isset($_GET['type']) ? $_GET['type'] : "";
  include '../../inc/conn.php';
  $id = mysqli_real_escape_string($conn, $_GET['id']);
  if($type == 'puppy') {
    $sql = "SELECT * FROM pups WHERE id=$id";
  } else if($type == 'litter') {
    $sql = "SELECT * FROM litters WHERE id=$id";
  } else if($type == 'parent') {
    $sql = "SELECT * FROM parents WHERE id=$id";
  } else {
    header("Location: ../all.php?error");
    exit();
  }
  $result = mysqli_query($conn, $sql);
  while($row = mysqli_fetch_assoc($result)){
    unlink("../../img/{$row['image_name']}") or die("Couldn't delete file");
    if($type == 'puppy') {
      $sql = "DELETE FROM pups WHERE id=$id";
    } else if($type == 'litter') {
      $sql = "DELETE FROM litters WHERE id=$id";
    } else if($type == 'parent') {
      $sql = "DELETE FROM parents WHERE id=$id";
    } else {
      header("Location: ../all.php?error");
      exit();
    }

    if(mysqli_query($conn, $sql)){
      header("Location: ../all.php");
      exit();
    } else {
      header("Location: ../all.php?error&type={$type}");
      exit();
    }
  }
} else {
  header("Location: ../all.php");
  exit();
}
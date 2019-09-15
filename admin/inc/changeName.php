<?php

if(isset($_POST['saveBtn'])){
  session_start();
  $first = htmlentities($_POST['firstname']);
  $middle = htmlentities($_POST['middleinit']);
  $last = htmlentities($_POST['lastname']);
  if(empty($first) || empty($middle) || empty($last)) {
    header("Location: ../account.php?error=emptyfields");
    exit();
  } else if(strlen($middle) > 1) {
    header("Location: ../account.php?error=strlen");
    exit();
  } else {
    include '../../inc/conn.php';
    $id = $_SESSION['id'];
    $sql = "UPDATE admin SET firstName=?, middle=?, lastName=? WHERE id='$id'";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
      header("Location: ../account.php?error=server");
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "sss", $first, $middle, $last);
      mysqli_stmt_execute($stmt);
      // "u" in the url parameter stands for "update"
      $_SESSION['firstName'] = $first;
      $_SESSION['middle'] = $middle;
      $_SESSION['lastName'] = $last;
      header("Location: ../account.php?success&u=name");
      exit();
    }
  }
} else {
  header("Location: ../account.php");
  exit();
}
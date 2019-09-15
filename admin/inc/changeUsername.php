<?php

if(isset($_POST['saveBtn'])){
  session_start();
  $username = htmlentities($_POST['username']);
  if(empty($username)) {
    header("Location: ../account.php?error=emptyfields");
    exit();
  } else if(strlen($username) < 4) {
    header("Location: ../account.php?error=strlen");
    exit();
  } else {
    include '../../inc/conn.php';
    $id = $_SESSION['id'];
    $sql = "UPDATE admin SET username=? WHERE id='$id'";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
      header("Location: ../account.php?error=server");
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "s", $username);
      mysqli_stmt_execute($stmt);
      // "u" in the url parameter stands for "update"
      $_SESSION['username'] = $username;
      header("Location: ../account.php?success&u=username");
      exit();
    }
  }
} else {
  header("Location: ../account.php");
  exit();
}
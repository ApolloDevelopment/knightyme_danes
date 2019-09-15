<?php

if(isset($_POST['saveBtn'])){
  session_start();
  $currPassword = htmlentities($_POST['currentPassword']);
  $newPassword = htmlentities($_POST['newPassword']);
  $confirmPassword = htmlentities($_POST['confirmPassword']);
  $encrypted = password_hash($confirmPassword, PASSWORD_DEFAULT);
  if(empty($currPassword) || empty($newPassword) || empty($confirmPassword)) {
    header("Location: ../account.php?error=emptyfields");
    exit();
  } else if(strlen($newPassword) < 4) {
    header("Location: ../account.php?error=strlen");
    exit();
  } else if($newPassword !== $confirmPassword) {
    header("Location: ../account.php?error=matchpass");
    exit();
  } else {
    include '../../inc/conn.php';
    $id = $_SESSION['id'];
    $sql = "SELECT * FROM admin WHERE id=?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
      //server error
      header("Location: ../account.php?error=server");
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "i", $id);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      while($row = mysqli_fetch_assoc($result)){
        $pwdVerify = password_verify($currPassword, $row['pwd']);
        //incorrect password
        if(!$pwdVerify){
          header("Location: ../account.php?error=password");
          exit();
        } else {
          mysqli_stmt_close($stmt);
          $sql2 = "UPDATE admin SET pwd=? WHERE id=$id";
          $stmt2 = mysqli_stmt_init($conn);
          if(!mysqli_stmt_prepare($stmt2, $sql2)){
            header("Location: ../account.php?error=server");
            exit();
          } else {
            mysqli_stmt_bind_param($stmt2, "s", $encrypted);
            mysqli_stmt_execute($stmt2);
            header("Location: ../account.php?success&u=password");
            exit();
          }
        }
      }
    }
  }
} else {
  header("Location: ../account.php");
  exit();
}
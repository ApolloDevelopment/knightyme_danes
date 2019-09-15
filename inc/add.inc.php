<?php

if(isset($_POST['add_user'])){
  $first = htmlentities($_POST['firstname']);
  $middle = htmlentities($_POST['middleinit']);
  $last = htmlentities($_POST['lastname']);
  $username = htmlentities($_POST['username']);
  $pwd = htmlentities($_POST['pass']);
  $pwdCheck = htmlentities($_POST['pass_confirm']);
  //check if any fields are empty
  if(empty($first) || empty($middle) || empty($last) || empty($username) || empty($pwd) || empty($pwdCheck)){
    header("Location: ../admin/users/add.php?error=emptyfields&first=".$first."&middle=".$middle."&last=".$last."&uid=".$username);
    exit();
    //check password length
  } else if(strlen($pwd) < 8 || strlen($pwd) > 16) {
    header("Location: ../admin/users/add.php?error=passlen&first=".$first."&middle=".$middle."&last=".$last."&uid=".$username);
    exit();
    //check password match
  } else if($pwdCheck != $pwd){
    header("Location: ../admin/users/add.php?error=passwordcheck&first=".$first."&middle=".$middle."&last=".$last."&uid=".$username);
    exit();
  } else {
    include 'conn.php';
    $password_encrypt = password_hash($pwd, PASSWORD_DEFAULT);
    $sql = "SELECT * FROM admin WHERE userName=?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
      //server error
      header("Location: ../admin/users/add.php?error=server&first=".$first."&middle=".$middle."&last=".$last."&uid=".$username);
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "s", $username);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      //username taken
      if(mysqli_num_rows($result) > 0){
        header("Location: ../admin/users/add.php?error=usertaken&first=".$first."&middle=".$middle."&last=".$last);
        exit();
      } else {
        $sql = "INSERT INTO admin (firstName, middle, lastName, userName, pwd) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
          //server error
          header("Location: ../admin/users/add.php?error=server&first=".$first."&middle=".$middle."&last=".$last."&uid=".$username);
          exit();
        } else {
          mysqli_stmt_bind_param($stmt, "sssss", $first, $middle, $last, $username, $password_encrypt);
          mysqli_stmt_execute($stmt);
          header("Location: ../admin/users/add.php?success");
          exit();
        }
      }
    }
  }
} else {
  header("Location: ../admin/login.php");
  exit();
}

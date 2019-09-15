<?php

if(isset($_POST['login'])){
  $user = htmlentities($_POST['userName']);
  $pwd = htmlentities($_POST['password']);
  if(empty($user) || empty($pwd)){
    // make sure both fields are filled
    header("Location: ../admin/login.php?error=emptyfields");
    exit();
  } else {
    include 'conn.php';
    $sql = "SELECT * FROM admin WHERE userName=?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
      //server error
      header("Location: ../admin/login.php?error=server");
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "s", $user);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      //no user found
      if(mysqli_num_rows($result) == 0){
        header("Location: ../admin/login.php?error=nouser");
        exit();
      } else {
        while($row = mysqli_fetch_assoc($result)){
          $pwdVerify = password_verify($pwd, $row['pwd']);
          //incorrect password
          if(!$pwdVerify){
            header("Location: ../admin/login.php?error=password");
            exit();
          } else {
            //login
            session_start();
            $_SESSION['id'] = $row['id'];
            $_SESSION['firstName'] = $row['firstName'];
            $_SESSION['middle'] = $row['middle'];
            $_SESSION['lastName'] = $row['lastName'];
            $_SESSION['username'] = $row['userName'];
            header("Location: ../admin/home.php");
            exit();
          }
        }
      }
    }
  }
} else {
  header("Location: ../admin/login.php");
  exit();
}

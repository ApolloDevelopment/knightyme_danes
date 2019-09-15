<?php
$verified = false;
if(!isset($_POST['key_submit'])) {
  header("Location: ../verify.php");
  exit();
}
else {
  if($_POST['key'] == 'Dalton2522') {
    $verified = true;
    header("Location: ../phpinfo.php");
    exit();
  }
}
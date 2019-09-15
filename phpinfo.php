<?php
include 'inc/verify.inc.php';
if(!$verified){
  header("Location: verify.php");
  exit();
}

phpinfo(); 

?>
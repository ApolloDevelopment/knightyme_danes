<?php

// Production Use
// $server_name = "localhost";
// $server_user = "rickgkni_dalton";
// $server_pass = "Dalton2522";
// $server_db = "rickgkni_knightymedanes";

//Development Use
$server_name = "localhost";
$server_user = "root";
$server_pass = "";
$server_db = "danes";

$conn = mysqli_connect($server_name, $server_user, $server_pass, $server_db);
if(!$conn){
  die("Error connecting: ".mysqli_connect_error());
}

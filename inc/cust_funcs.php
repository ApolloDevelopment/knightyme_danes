<?php

// key generator with specified key length
function generate_key($length){
  $key = "";
  $possible_chars = "abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ!@$&";
  for($i = 0; $i < $length; $i++){
    $key .= $possible_chars[mt_rand(0, strlen($possible_chars)-1)];
  }
  return $key;
} // generate_key(55); -> du!OnbwFRFBkjiJK6cv2c$IJhngTuYYhP1@7CoI6YX8hkHvveW8jSlO


function first_letter($str){
  return $str[0];
}
echo first_letter("Dalton Hatter");

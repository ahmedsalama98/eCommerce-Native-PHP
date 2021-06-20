<?php

function lang($phrase){

  static $lang = array(
// home page
   "messege"=>"مرحبا",
   "admin"=> "ادمن"
   );


   return $lang[$phrase];
}

?>
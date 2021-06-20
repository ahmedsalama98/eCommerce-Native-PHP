<?php


function lang($phrase){


   static $lang = array(
"application_name"=>"eCommerce",
// nav bar
  "home_admin"=>"admin area",
  "categories"=>"categories",
  "items"=>"items",
  "members"=>"members",
  "comments"=>"comments",
  "logs"=>"logs",
  "statistcs"=>"",
  "edit_profile"=>"edit profile",
  "settings"=>"settings",
  "logout"=>"logout",
  ""=>"",
  ""=>"",
  ""=>"",
  ""=>"",
  ""=>"",
   );


   return $lang[$phrase];
}

?>
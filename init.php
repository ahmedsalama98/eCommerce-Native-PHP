<?php
include 'admin/connect.php';

$tmp= 'includes/templetes/';
$js ='layout/js/';
$css= 'layout/css/';
$lan ='includes/languages/';
$fun ="includes/functions/";



//important files
include $fun. "functions.php";
include $lan ."english.php" ;
include $tmp ."header.php" ;
if(!isset($NoNav)){
    include $tmp ."nav.php" ;
}






?>
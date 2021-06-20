<?php
$dns ='mysql:host=localhost;dbname=shop';
$user='root';
$pass='';
$options=array(

PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8"
);

try{
$conn = new PDO($dns , $user ,$pass ,$options);
$conn ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    echo "failed to connect";
}
?>
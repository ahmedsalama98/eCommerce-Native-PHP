<?php 
ob_start();
session_start();
$pageTitle ="My Profile";
include "init.php";
if(isset($_SESSION["user_name"])  && isset($_SESSION["user_id"])){
    $user=array();
    $user = get_all("*" ,"users" , "WHERE user_id = {$_SESSION["user_id"]}")[0];
    $action =isset($_GET["action"])&&!empty($_GET["action"])?$_GET["action"]:"manage";

        //mange page

        if($action == "manage"){

        ?>
        <div class="edit_profile_page">
        <div class="container">
        <div class="avatar">
            <img src="<?=!empty($user["avatar"])?"data\uploads\users_avatar\\".$user["avatar"]:"layout/images/avatar.png"?>">
            <a href="?action=avatar" class="btn btn-primary">Edit</a>
        </div>
        <ul>
        
                <li>
                <span>First Name :  <strong><?=$user["first_name"]?> </strong> </span> <a href="?action=first_name" class="btn btn-primary">Edit</a>
                </li>
            <li>
                <span> Last Name : <strong> <?=$user["last_name"]?></strong></span> <a href="?action=last_name" class="btn btn-primary">Edit</a>
            </li>
            <li>
            <span> Username:   <strong><?=$user["user_name"]?>  </strong> </span><a href="?action=user_name" class="btn btn-primary">Edit</a>
            </li>
            <li>
            <span> Email:  <strong> <?=$user["email"]?></strong> </span> <a href="?action=email" class="btn btn-primary">Edit</a>
            </li>

            <li>
            <span>   Gender :  <strong>  <?=$user["gender"]?></strong></span> <a href="?action=gender" class="btn btn-primary">Edit</a>
            </li>

            <li>
            <span>Date:  <strong><?=$user["birth_date"]?>  </strong> </span><a href="?action=birth_date" class="btn btn-primary">Edit</a>
            </li>

            <li >
            <span><a href="?action=password" class="btn btn-danger">Edit Password</a>
            </li>
        </ul>
        </div>
        </div>
        <?php
        //first_name edit
        }if($action =="first_name"){
            
            $user=get_all("first_name" , "users" , "WHERE user_id = {$_SESSION["user_id"]}")[0];


            if($_SERVER["REQUEST_METHOD"]=="POST"){
            
                $first_name= clean_string_val($_POST["first_name"]);
                $validat_error=array();
                if(empty($first_name) || strlen($first_name) < 2){
                    array_push($validat_error , "first_name cannot be less than 2 characters");
                }

                if(!$validat_error){
                  $stm = $conn->prepare("UPDATE users SET first_name =? WHERE user_id =?");
                  $stm->execute(array($first_name ,$_SESSION["user_id"]));
                  $count =$stm->rowCount();
                  if($count > 0){
                    echo "<div class='container'>";
                    $msg ="<div class='alert alert-primary'>Done</div>";
                    redirectHome($msg ,"edit_profile.php");
                    echo "</div>";
                  }

                }else{

                    echo "<div class='container'>";
                    foreach($validat_error as $error){
                        echo "<div class='alert alert-danger'>".$error."</div>";
                    }
                    echo "</div>";
                }
              

            }
        ?>
       
             <div class="edit_profile_page">
             <div class="container">
                <form method="POST"  action="<?=$_SERVER["PHP_SELF"]."?action=first_name"?>">
                    <div class="row">
                    <div class="col-xs-12 col-sm-2">
                    <label for="first_name" class="form-control-bg"> First Name</label>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                    <input type="text" id="first_name" value="<?= isset($user["first_name"])?$user["first_name"]:""?>"name="first_name"  class="form-control form-control-lg" required >
                    </div>
                    </div>
               
                   </div>
                    <div class="row input-group">
                    <div class="offset-sm-2 col-xs-12 col-sm-6 submit">
                        <input type="submit" value="Sava" class="btn btn-primary submit">
                    </div>
                    </div>
                        </form>


             
                    </div>


        <?php


        //last_name edit
        }if($action =="last_name"){
           
            $user=get_all("last_name" , "users" , "WHERE user_id = {$_SESSION["user_id"]}")[0];


            if($_SERVER["REQUEST_METHOD"]=="POST"){
            
                $last_name= clean_string_val($_POST["last_name"]);
                $validat_error=array();
                if(empty($last_name) || strlen($last_name) < 2){
                    array_push($validat_error , "last_name cannot be less than 2 characters");
                }

                if(!$validat_error){
                  $stm = $conn->prepare("UPDATE users SET last_name =? WHERE user_id =?");
                  $stm->execute(array($last_name ,$_SESSION["user_id"]));
                  $count =$stm->rowCount();
                  if($count > 0){
                    echo "<div class='container'>";
                    $msg ="<div class='alert alert-primary'>Done</div>";
                    redirectHome($msg ,"edit_profile.php");
                    echo "</div>";
                  }

                }else{

                    echo "<div class='container'>";
                    foreach($validat_error as $error){
                        echo "<div class='alert alert-danger'>".$error."</div>";
                    }
                    echo "</div>";
                }
              

            }
        ?>
       
             <div class="edit_profile_page">
             <div class="container">
                <form method="POST"  action="<?=$_SERVER["PHP_SELF"]."?action=last_name"?>">
                    <div class="row">
                    <div class="col-xs-12 col-sm-2">
                    <label for="last_name" class="form-control-bg"> Last Name</label>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                    <input type="text" id="last_name" value="<?= isset($user["last_name"])?$user["last_name"]:""?>"name="last_name"  class="form-control form-control-lg" required >
                    </div>
                    </div>
               
                   </div>
                    <div class="row input-group">
                    <div class="offset-sm-2 col-xs-12 col-sm-6 submit">
                        <input type="submit" value="Sava" class="btn btn-primary submit">
                    </div>
                    </div>
                        </form>


             
                    </div>


        <?php
        //username edit 
        }elseif($action =="user_name"){
            $user=get_all("user_name" , "users" , "WHERE user_id = {$_SESSION["user_id"]}")[0];


            if($_SERVER["REQUEST_METHOD"]=="POST"){
            
                $user_name= clean_string_val($_POST["user_name"]);
                $validat_error=array();
                $check=checkItemDb("user_name" ,"users" ,$user_name);
                if(empty($user_name) || strlen($user_name) < 2){
                    array_push($validat_error , "last_name cannot be less than 2 characters");
                }
                if($check >0){
                    array_push($validat_error , "this username is already taken");
  
                }

                if(!$validat_error){
                  $stm = $conn->prepare("UPDATE users SET user_name =? WHERE user_id =?");
                  $stm->execute(array($user_name ,$_SESSION["user_id"]));
                  $count =$stm->rowCount();
                  if($count > 0){
                    echo "<div class='container'>";
                    $msg ="<div class='alert alert-primary'>Done</div>";
                    redirectHome($msg ,"edit_profile.php");
                    echo "</div>";
                  }

                }else{

                    echo "<div class='container'>";
                    foreach($validat_error as $error){
                        echo "<div class='alert alert-danger'>".$error."</div>";
                    }
                    echo "</div>";
                }
              

            }
        ?>
       
             <div class="edit_profile_page">
             <div class="container">
                <form method="POST"  action="<?=$_SERVER["PHP_SELF"]."?action=user_name"?>">
                    <div class="row">
                    <div class="col-xs-12 col-sm-2">
                    <label for="user_name" class="form-control-bg"> UserName</label>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                    <input type="text" id="user_name" value="<?= isset($user["user_name"])?$user["user_name"]:""?>"name="user_name"  class="form-control form-control-lg" required >
                    </div>
                    </div>
               
                   </div>
                    <div class="row input-group">
                    <div class="offset-sm-2 col-xs-12 col-sm-6 submit">
                        <input type="submit" value="Sava" class="btn btn-primary submit">
                    </div>
                    </div>
                        </form>


             
                    </div>


        <?php
        //email edit
        }elseif($action =="email"){
            $user=get_all("email" , "users" , "WHERE user_id = {$_SESSION["user_id"]}")[0];


            if($_SERVER["REQUEST_METHOD"]=="POST"){
            
                $email= clean_string_val($_POST["email"]);
                $validat_error=array();
                $check=checkItemDb("email" ,"users" ,$email);
                if(empty($email) || filter_var($email , FILTER_VALIDATE_EMAIL) == false){
                    array_push($validat_error , "unvaliid Email");
                }
                if($check >0){
                    array_push($validat_error , "this Email is already taken");
  
                }

                if(!$validat_error){
                  $stm = $conn->prepare("UPDATE users SET email =? WHERE user_id =?");
                  $stm->execute(array($email ,$_SESSION["user_id"]));
                  $count =$stm->rowCount();
                  if($count > 0){
                    echo "<div class='container'>";
                    $msg ="<div class='alert alert-primary'>Done</div>";
                    redirectHome($msg ,"edit_profile.php");
                    echo "</div>";
                  }

                }else{

                    echo "<div class='container'>";
                    foreach($validat_error as $error){
                        echo "<div class='alert alert-danger'>".$error."</div>";
                    }
                    echo "</div>";
                }
              

            }
        ?>
       
             <div class="edit_profile_page">
             <div class="container">
                <form method="POST"  action="<?=$_SERVER["PHP_SELF"]."?action=email"?>">
                    <div class="row">
                    <div class="col-xs-12 col-sm-2">
                    <label for="email" class="form-control-bg"> Email</label>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                    <input type="email" id="email" value="<?= isset($user["email"])?$user["email"]:""?>"name="email"  class="form-control form-control-lg" required >
                    </div>
                    </div>
               
                   </div>
                    <div class="row input-group">
                    <div class="offset-sm-2 col-xs-12 col-sm-6 submit">
                        <input type="submit" value="Sava" class="btn btn-primary submit">
                    </div>
                    </div>
                        </form>


             
                    </div>


        <?php
        //gender edit
        }elseif($action =="gender"){
            $user=get_all("gender" , "users" , "WHERE user_id = {$_SESSION["user_id"]}")[0];


            if($_SERVER["REQUEST_METHOD"]=="POST"){
            
                $gender= clean_string_val($_POST["gender"]);
                $validat_error=array();
                if(empty($gender) || strlen($gender) < 2){
                    array_push($validat_error , "gender not Selected");
                }

                if(!$validat_error){
                  $stm = $conn->prepare("UPDATE users SET gender =? WHERE user_id =?");
                  $stm->execute(array($gender ,$_SESSION["user_id"]));
                  $count =$stm->rowCount();
                  if($count > 0){
                    echo "<div class='container'>";
                    $msg ="<div class='alert alert-primary'>Done</div>";
                    redirectHome($msg ,"edit_profile.php");
                    echo "</div>";
                  }

                }else{

                    echo "<div class='container'>";
                    foreach($validat_error as $error){
                        echo "<div class='alert alert-danger'>".$error."</div>";
                    }
                    echo "</div>";
                }
              

            }
        ?>
       
             <div class="edit_profile_page">
             <div class="container">
                <form method="POST"  action="<?=$_SERVER["PHP_SELF"]."?action=gender"?>">
                    <div class="row">
                    <div class="col-xs-12 col-sm-2">
                    <label for="gender" class="form-control-bg"> gender </label>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                    <select id="gender"  name="gender"  class="form-select form-select-lg" required >

                     <option value="male" <?= isset($user["gender"]) && $user["gender"]=="male"?"selected":""?>>male</option>
                     <option value="female" <?= isset($user["gender"]) && $user["gender"]=="female"?"selected":""?>>female</option>
                     <option value="other" <?= isset($user["gender"]) && $user["gender"]=="other"?"selected":""?>>other</option>
                    </select>
                    </div>
                    </div>
               
                   </div>
                    <div class="row input-group">
                    <div class="offset-sm-2 col-xs-12 col-sm-6 submit">
                        <input type="submit" value="Sava" class="btn btn-primary submit">
                    </div>
                    </div>
                        </form>


             
                    </div>


        <?php
        //birth_date edit
        }elseif($action =="birth_date"){
            $user=get_all("birth_date" , "users" , "WHERE user_id = {$_SESSION["user_id"]}")[0];


            if($_SERVER["REQUEST_METHOD"]=="POST"){
            
                $birth_date= clean_string_val($_POST["birth_date"]);
                $validat_error=array();
                if(empty($birth_date) ){
                    array_push($validat_error , "Empty Birth Date");
                }

                if(!$validat_error){
                  $stm = $conn->prepare("UPDATE users SET birth_date =? WHERE user_id =?");
                  $stm->execute(array($birth_date ,$_SESSION["user_id"]));
                  $count =$stm->rowCount();
                  if($count > 0){
                    echo "<div class='container'>";
                    $msg ="<div class='alert alert-primary'>Done</div>";
                    redirectHome($msg ,"edit_profile.php");
                    echo "</div>";
                  }

                }else{

                    echo "<div class='container'>";
                    foreach($validat_error as $error){
                        echo "<div class='alert alert-danger'>".$error."</div>";
                    }
                    echo "</div>";
                }
              

            }
        ?>
       
             <div class="edit_profile_page">
             <div class="container">
                <form method="POST"  action="<?=$_SERVER["PHP_SELF"]."?action=birth_date"?>">
                    <div class="row">
                    <div class="col-xs-12 col-sm-2">
                    <label for="birth_date" class="form-control-bg">birth date</label>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                    <input type="date" id="birth_date" value="<?= isset($user["birth_date"])?$user["birth_date"]:""?>"name="birth_date"  class="form-control form-control-lg" required >
                    </div>
                    </div>
               
                   </div>
                    <div class="row input-group">
                    <div class="offset-sm-2 col-xs-12 col-sm-6 submit">
                        <input type="submit" value="Sava" class="btn btn-primary submit">
                    </div>
                    </div>
                        </form>


             
                    </div>


        <?php

        //avatar edit
        }elseif($action =="avatar"){

            if($_SERVER["REQUEST_METHOD"]=="POST"){
            
                $avatar= $_FILES["avatar"];
                $avatar_name=trim($avatar["name"]);
                $avatar_tmp=$avatar["tmp_name"];
                $extension =explode(".",$avatar_name);
                $avatar_extension=strtolower(end($extension));
                $allowed_extensions =array("png" , "jpg" , "jfif","jpej");
                $validat_error=array();
                if(empty($avatar_name) ){
                    array_push($validat_error , "NO image Chosen");
                }elseif(!in_array($avatar_extension , $allowed_extensions)){
                    array_push($validat_error , "Please choose a valid image");
                }

                if(!$validat_error){
  
                  $rand1=rand(0 ,99999999999);
                  $rand2=rand(0 ,99999999999);
                  $link =$rand1."_".$rand2.".".$avatar_extension;
                
                  
                if($avatar["error"] ==UPLOAD_ERR_OK){
                    move_uploaded_file($avatar_tmp ,"data\uploads\users_avatar\\".$link );
                }
                    
                  $stm = $conn->prepare("UPDATE users SET avatar =? WHERE user_id =?");
                  $stm->execute(array($link,$_SESSION["user_id"]));
                  $count =$stm->rowCount();
                  if($count > 0){
                    echo "<div class='container'>";
                    $msg ="<div class='alert alert-primary'>Done</div>";
                    redirectHome($msg ,"edit_profile.php");
                    echo "</div>";
                  }
                   
                }else{

                    echo "<div class='container'>";
                    foreach($validat_error as $error){
                        echo "<div class='alert alert-danger'>".$error."</div>";
                    }
                    echo "</div>";
                }
              

            }
        ?>
       
             <div class="edit_profile_page">
             <div class="container">
                <form method="POST"  action="<?=$_SERVER["PHP_SELF"]."?action=avatar"?>" enctype="multipart/form-data">
                    <div class="row">
                            <div class="col-xs-12 col-sm-2">
                            <label for="avatar" class="form-control-bg"> avatar </label>
                            </div>
                    


                            <div class="col-xs-12 col-sm-6">
                            <input type="file" id="avatar" name="avatar"  class="form-control form-control-lg"  >
                            </div>
                     </div>


                    <div class="row input-group">
                    <div class="offset-sm-2 col-xs-12 col-sm-6 submit">
                        <input type="submit" value="Sava" class="btn btn-primary submit">
                    </div>
                    </div>
                        </form>


             
                    </div>


        <?php
        }
        //password edit
        elseif($action =="password"){
          


            if($_SERVER["REQUEST_METHOD"]=="POST"){
                
                $old_password= clean_string_val($_POST["old_password"]);
                $new_password= clean_string_val($_POST["new_password"]);
                $rightpass=get_all("password" , "users" , "WHERE user_id = {$_SESSION["user_id"]}")[0]["password"];

                $validat_error=array();


                if(empty($new_password) || strlen($new_password) < 5){
                    array_push($validat_error , "password cannot be less than 5 characters");
                }
                if($rightpass !== sha1($old_password)){
                    array_push($validat_error , " old password is not true"); 
                }

                if(!$validat_error){

                    
                  $stm = $conn->prepare("UPDATE users SET password =? WHERE user_id =?");
                  $stm->execute(array(sha1($new_password) ,$_SESSION["user_id"]));
                  $count =$stm->rowCount();
                  if($count > 0){
                    echo "<div class='container'>";
                    $msg ="<div class='alert alert-primary'>Done</div>";
                    redirectHome($msg ,"edit_profile.php");
                    echo "</div>";
                  }

                }else{

                    echo "<div class='container'>";
                    foreach($validat_error as $error){
                        echo "<div class='alert alert-danger'>".$error."</div>";
                    }
                    echo "</div>";
                }
              

            }
        ?>
       
             <div class="edit_profile_page">
             <div class="container">
                <form method="POST"  action="<?=$_SERVER["PHP_SELF"]."?action=password"?>" id="edit_password">
                <div class="row">
                    <div class="col-xs-12 col-sm-2">
                    <label for="old_password" class="form-control-bg"> Old Password</label>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                    <input type="password" id="old_password" name="old_password" placeholder="Old Password" class="form-control form-control-lg" required >
                    </div>
                    </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-2">
                    <label for="new_password_1" class="form-control-bg"> New Password</label>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                    <input   type="password" id="new_password_1" name="new_password"  placeholder="New Password"  class="form-control form-control-lg" required >
                    </div>
               </div>


               <div class="row">
                    <div class="col-xs-12 col-sm-2">
                    <label for="new_password_2" class="form-control-bg">  New Password AGain</label>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                    <input type="password" id="new_password_2" name="new_password"  placeholder="New Password"  class="form-control form-control-lg" required >
                    </div>
               </div>

               <div class="error_messege">

               </div>
                


            <div class="row input-group">
                    <div class="offset-sm-2 col-xs-12 col-sm-6 submit">
                        <input type="submit" value="Sava" class="btn btn-primary submit">
                    </div>
                    </div>
                        </form>


             
                    </div>


        <?php
        }




//if not login   
}else{

    header("location:login.php");
    exit();
}


 include  $tmp."footer.php" ;
ob_flush();
?>

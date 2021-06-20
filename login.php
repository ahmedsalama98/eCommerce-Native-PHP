<?php
ob_start();
session_start();

$NoNav=true;

include "init.php";
//if user is logged in
if(isset($_SESSION["user_name"])  && isset($_SESSION["user_id"])){
    header("Location:index.php");
    exit;
//if user not logged in
}else{

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        //start login
          if(isset($_POST["login"])){
              
            $username= clean_string_val($_POST["username"]);
            $password= clean_string_val($_POST["password"]);
            $check_user=checkItemDb("user_name" ,"users",$username);
            $validate_errors=array();
        
            if($check_user <1){
                array_push($validate_errors ,"user name is not true");
        
            }
            if(empty($username)|| strlen($username) < 4){
                array_push($validate_errors ,"unvalid username");
            }elseif(empty($password)|| strlen($password) < 4){
                array_push($validate_errors ,"unvalid password"); 
            }
          
            if(!$validate_errors){
                
              $stm =$conn->prepare("SELECT user_name , user_id FROM users WHERE user_name =? AND password =? LIMIT 1");
              $stm->execute(array($username ,sha1($password)));
              $user= $stm->fetch();
              $done =$stm->rowCount();
              if($done >0){
                  $_SESSION["user_name"]=$user["user_name"];
                  $_SESSION["user_id"]=$user["user_id"];                  
                        header("Location:index.php");
                        exit;

              }else{
                array_push($validate_errors ,"wrong password"); 
        
              }
        
            }
        
           //start sign-up
          }else{
        $first_name = clean_string_val($_POST["first_name"]);
        $last_name = clean_string_val($_POST["last_name"]); 
          $username= clean_string_val($_POST["username"]);
          $password= clean_string_val($_POST["password"]);
          $email= clean_string_val($_POST["email"]);
          $date= clean_string_val($_POST["date"]);
          $gender=  clean_string_val($_POST["gender"]);
          $check_user=checkItemDb("user_name" ,"users",$username);
          $check_email=checkItemDb("email" ,"users",$email);
          $validate_sign_up_errors=array();
          if(empty($first_name)||strlen($first_name )< 2 ){
            array_push($validate_sign_up_errors ,"first name cant be less than 2 carachters");
          }
          if(empty($last_name)||strlen($last_name )< 2 ){
            array_push($validate_sign_up_errors ,"last name cant be less than 2 carachters");
          }
          if($check_user > 0){
            array_push($validate_sign_up_errors ,"username is already exit");
          }
          elseif(empty($username)||strlen($username )< 4 ){
            array_push($validate_sign_up_errors ,"username cant be less than 4 carachters");
          }

          if($check_email > 0){
            array_push($validate_sign_up_errors ,"Email is already exit");
          }
          elseif(empty($email)||!filter_var($email , FILTER_VALIDATE_EMAIL)=="false"){
            array_push($validate_sign_up_errors ,"unvalid Email");
          }
          if(empty($password)||strlen($password )< 4 ){
            array_push($validate_sign_up_errors ,"password cant be less than 4 carachters");
          }
        
          if(empty($date)||strlen($date )< 2 ){
            array_push($validate_sign_up_errors ,"unvalid date");
          }
          if(empty($gender)||strlen($gender )< 2 ){
            array_push($validate_sign_up_errors ,"unvalid gender");
          }
          
          

          if(!$validate_sign_up_errors){
          $stm=$conn->prepare("INSERT INTO users(user_name , email, password ,first_name, last_name ,gender ,birth_date) VALUES(? , ? ,? ,? ,?,?,?)");
          $stm->execute(array($username ,$email , sha1($password) , $first_name ,$last_name ,$gender ,$date));
          $count=$stm->rowCount();
                    if($count >0){
                    
                        $stm2=$conn->prepare("SELECT user_id FROM users WHERE user_name =? LIMIT 1");
                        $stm2->execute(array($username));
                        $count2=$stm2->rowCount();
                        
                        if($count2 >0){
                        $id = $stm2->fetch();
                        $_SESSION["user_name"]=$username;
                        $_SESSION["user_id"]=$id["user_id"];                  
                        echo "<div class='container'>";
                        $msg ="<div class='alert alert-primary'>Done</div>";
                        redirectHome($msg ,"my_profile.php");
                        echo "</div>";
                        }

                      
                    }else{
                        array_push($validate_sign_up_errors ,"last name cant be less than 2 carachters");
                    }

          }


          }
        //
        }


}




?>
<div class="login-sign-up-page <?=isset($_GET["action"])&& $_GET["action"] =='sign-up'?"sign-up":""?>">
<div class="container-fluid">
<div class="content-wrapper">
     <div class="toggle-to-login">
         <p>you already have an acount ?</p>
         <button>Login</button>
     </div>


     <div class="toggle-to-sign-up">
          <p>you dont have an acount ?</p>
          <button>Sign Up</button>
      </div>


  <div class="login">

  <form method="POST" action="<?=$_SERVER["PHP_SELF"]?>">
     
      <h1>Login</h1>
      <div class="input-wrap">
          <span class="icon"><i class="fas fa-user"></i></span>
          <input type="text" name="username" placeholder="type your username" required>
      </div>

      <div class="input-wrap">
          <span class="icon">      <i class="fas fa-unlock"></i></span>

          <input type="password" name="password" placeholder="type your password" required autocomplete="new-password">
      </div>
    <?php 

    if(isset($validate_errors)){
        foreach($validate_errors as $error){
            echo ' <span class="error_messege">'.$error.'</span>';
        }
    }
    
    ?>
      <button type="submit" name="login">Login</button>
    
  </form>


  </div>

  <div class="sign-up">

  <form  id="sign-up-form" method="POST" action="<?=$_SERVER["PHP_SELF"]?>?action=sign-up">
     
     <h1>Sign Up</h1>
     <div class="input-wrap">
         <span class="icon"><i class="fas fa-user"></i></span>
         <input type="text" name="first_name" placeholder="type your first name" required>
     </div>

     <div class="input-wrap">
         <span class="icon"><i class="fas fa-user"></i></span>
         <input type="text" name="last_name" placeholder="type your last name" required>
     </div>


     <div class="input-wrap">
         <span class="icon"><i class="fas fa-user"></i></span>
         <input type="text" name="username" placeholder="type your username"id="username" required>
     </div>
     <div class="input-wrap">
         <span class="icon"><i class="fas fa-envelope-open-text"></i></span>
         <input type="email" name="email" placeholder="type your email" required >
     </div>

     <div class="input-wrap">
         <span class="icon"> <i class="fas fa-unlock"></i></span>

         <input type="password" name="password" placeholder="type your password"  autocomplete="new-password" id="pass-1"required >
     </div>
     <div class="input-wrap">
         <span class="icon"> <i class="fas fa-unlock"></i></span>

         <input type="password" name="password" placeholder="type your password again"  autocomplete="new-password" id="pass-2" required>
     </div>

     <div class="date">
         <label for="date">Birth date</label>
         <input type="date" name="date" required>
     </div>
     <div class="gender">
         <span>Gender</span>
        <span>
        <label for="male">male</label>
         <input type="radio" name="gender" value="male" id="male"  >
        </span>
    
        <span>
        <label for="female">femal</label>
         <input type="radio" name="gender" value="female" id="female"  required>
        </span>
     </div>
     <span class="error_messege"></span>
     <?php
     if(isset($validate_sign_up_errors)){
         foreach($validate_sign_up_errors as $error){

            echo '<span class="error_messege">'.$error.'</span>';
       
         }
     }
     
     ?>
    
     <button type="submit" name="sign-up">Sign Up</button>
   
 </form>

  

  </div>

</div>
</div>
</div>








<?php
include $tmp ."footer.php";
ob_flush();

?>
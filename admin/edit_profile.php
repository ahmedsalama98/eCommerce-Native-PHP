<?php 
session_start();

if(isset($_SESSION["admin_username"]) &&$_SESSION["is_admin"] ==="admin"){
    $action =isset($_GET["action"]) ? $_GET["action"] :"edit";


    if($action=="edit"){
        //edite page
        $pageTitle ="Edit Profile";
        include "init.php";
    
    
      $userid= intval($_SESSION["admin_id"]);
    
    
    
    $stm = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
    $stm ->execute(array($userid));
    $count = $stm->rowCount();
    $row =$stm->fetch();
    
    
    if($count >0 ){?>
    
    <!-- start edit-prfile-page-->
    <div class="edit-prfile-page">
    
    
    <div class="container">
    <h1>Edit Profile</h1>
      <form method="POST" action="?action=update">
            <input type="hidden" name="user_id" value="<?=$row["user_id"]?>">

<!--first name-->
            <?php    
            if(isset($_GET["first_name"])){
               echo "<div class='erorr'>".$_GET["first_name"]."</div>";
            }
            ?>

            <div class="row input-group">
                <div class="col-sm-12 col-lg-2">
                <label  class=" form-control-lg" for="first_name">first name</label>
                </div>
                
                <div class="col-sm-12 col-lg-5">
                <input type="text" name="first_name" value="<?=$row["first_name"];?>" required  class="form-control form-control-lg " id="first_name" autocomplete="off">  
                </div>
            </div>
            

<!--last name-->
            <?php    
            if(isset($_GET["last_name"])){
               echo "<div class='erorr'>".$_GET["last_name"]."</div>";
            }
            ?>



            <div class="row input-group">
                <div class="col-sm-12 col-lg-2">
                <label  class=" form-control-lg" for="last_name">last name</label>
                </div>
                
                <div class="col-sm-12 col-lg-5">
                <input type="text" name="last_name" value="<?=$row["last_name"];?>" required class="form-control form-control-lg " id="last_name" autocomplete="off">  
                </div>
            </div>
    
    
<!--username-->
            <?php    
            if(isset($_GET["username"])){
               echo "<div class='erorr'>".$_GET["username"]."</div>";
            }
            ?>



            <div class="row input-group">
                <div class="col-sm-12 col-lg-2">
                <label  class=" form-control-lg" for="username">username</label>
                </div>
                
                <div class="col-sm-12 col-lg-5">
                <input type="text" name="username" value="<?=$row["user_name"];?>" required class="form-control form-control-lg " id="username" autocomplete="off">  
                </div>
            </div>
    
    

<!--email-->


            <?php    
            if(isset($_GET["email"])){
               echo "<div class='erorr'>".$_GET["email"]."</div>";
            }
            ?>


            <div class="row input-group">
                <div class="col-sm-12 col-lg-2">
                <label  class=" form-control-lg" for="email">email</label>
                </div>
                
                <div class="col-sm-12 col-lg-5">
                <input type="email" name="email" value="<?=$row["email"];?>"  required class="form-control form-control-lg " id="email" autocomplete="off">  
                </div>
            </div>
    
    
           <!--password-->
            <?php    
            if(isset($_GET["password"])){
               echo "<div class='erorr'>".$_GET["password"]."</div>";
            }
            ?>


            <div class="row input-group">
                <div class="col-sm-12 col-lg-2">
                <label  class=" form-control-lg" for="password">password</label>
                </div>
                
                <div class="col-sm-12 col-lg-5">
                <input type="hidden" name="old_password"   value="<?=$row["password"];?>">  
                <input type="password" name="new_password"  placeholder="if didnt want to change password leave it blank"  class="form-control form-control-lg " id="password" autocomplete="off">  
                </div>
            </div>
    
            <div class="row input-group">
                
                <div class="col-sm-12 col-lg-2 offset-lg-2 d-grid gap-2">
                <input type="submit"   class="btn btn-primary btn-block" value="save">  
                </div>
            </div>
    
    
    
       
      </form>
    
    
    
    </div>
    
    </div>
    <!-- end edit-prfile-page-->
    
    
    <?php
    }
     
    else{
       
        echo "<h3>something wrong</h3>";
    }
    
    
    
    
    
    }
// end edite page
    elseif($action=="update"){
        //start update page
        $pageTitle ="update Profile";
        include "init.php";
            if($_SERVER["REQUEST_METHOD"]=="POST"){
                    $user_id    =$_POST["user_id"];
                    $first_name = clean_string_val($_POST["first_name"]);
                    $last_name  = clean_string_val($_POST["last_name"]);
                    $user_name  = clean_string_val($_POST["username"]);
                    $email      =clean_string_val($_POST["email"]);
                    $password   =empty($_POST["new_password"]) ?$_POST["old_password"]:sha1($_POST["new_password"]);
                    $validate_errors=array();


                    if(empty($user_name)){
                        $validate_errors["username"]  ="username cant be empty";
                    }
                    if(strlen($user_name) < 5){
                        $validate_errors["username"]  ="username cant be less than 5 caracters";
                    }
                    if(empty($email)){
                        $validate_errors["email"]  ="email cant be empty";
                    }
                    if(empty($first_name)){
                        $validate_errors["first_name"]  ="first_name cant be empty";
                    }
                    if(empty($last_name)){
                        $validate_errors["last_name"]  ="last_name cant be empty";
                    }
                    if(isset($_POST["new_password"]) &&!empty($_POST["new_password"])){
                        if(strlen($_POST["new_password"])< 5){
                            $validate_errors["password"] =  "password cant be less than 5 caracters"; 
                        }
                    }
                    
                    //if not have errors
                    if(!$validate_errors){
                        $stm = $conn->prepare("UPDATE users SET first_name = ? , last_name = ?,user_name= ? , email=?  , password = ? WHERE user_id =? ");
                        $stm ->execute(array($first_name, $last_name, $user_name ,$email ,$password ,$user_id));
                        $conn = null;
                        echo  "<div class='container'><h3>information updated</h3> <a href='dashboard.php'>return to dashboard</a></div>";
                    }
                    if($validate_errors){
                       echo "<div class='container'>";

                       foreach($validate_errors as $key => $val){
                         $q="?";
                         foreach($validate_errors as $key => $val){
                             $q .= $key ."=".$validate_errors[$key]."&";
                         }
                         echo $q;
                         header("Location:edit_profile.php".$q);
                         exit;
                       }


                       echo "</div>";

                      
                    }
            
          
            }else{
                //if browse from anather page
                echo  "<div class='container'>";
                $msg = "<div class='alert alert-danger'>you cant browse this page</div>";
                redirectHome($msg);
                echo "</div>";
            
            }
    
        
    }
    //end update
    else{
        header("Location:edit_profile.php");
        exit;
     }
     


//if not login or admin
}else{
    header("Location:index.php");
    exit;
}

?>



<?php 


include "includes/templetes/footer.php";
?>
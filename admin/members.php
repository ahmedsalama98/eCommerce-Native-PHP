<?php
ob_start();
session_start();

if(isset($_SESSION["admin_username"]) &&$_SESSION["is_admin"] ==="admin"){
    $action = !isset($_GET['action'])?"manage":$_GET["action"];

//start manage 
    if($action ==="manage"){
       $pageTitle="Members";
       include "init.php";
     $filter='';
       if(isset($_GET["filter"])&&$_GET["filter"]=="pendening"){
         $filter="AND reg_stutus = 0";
       }
       $stm =$conn->prepare("SELECT * FROM users WHERE group_id !=1 $filter ORDER BY user_id DESC");
       $stm->execute();
       $row =$stm->fetchAll();
       $count =$stm->rowCount(); 
       ?>

<div class="members_page">
      <div class="container">
<h1 class="text-center "> Manage Members</h1>
         <div class="table-responsive ">

            <table class="table table-bordered text-center table-hover">
               <thead>
                  <tr>
                     <th>ID</th>
                     <th>Full Name</th>
                     <th>Username</th>
                     <th>Email</th>
                     <th>Registered Date</th>
                     <th>Actions</th>
                  </tr>
               </thead>
               <tbody>
                     <?php


                       if($count >0){

                         foreach($row as $key ){?>

                         <tr>
                            <td><?=$key["user_id"]?></td>
                            <td><?=$key["first_name"]." ".$key["last_name"]?></td>
                            <td><?=$key["user_name"]?></td>
                            <td><?=$key["email"]?></td>
                            <td><?=$key["reg_date"]?></td>
                            <td>
                            <a href="?action=edit&id=<?=$key["user_id"]?>" class="btn btn-success"> <i class="far fa-edit"></i> Edit</a>
                            <?php 

                                 if($key["reg_stutus"]==0){
                                 echo '<a href="?action=activate&id='.$key["user_id"].'"class="btn btn-primary"> <i class="fas fa-check"></i>  Activate</a>';
                                 }
                                 ?>

                            <a href="members.php?action=delete&id=<?=$key["user_id"]?>" class="btn btn-danger remove_member"> <i class="far fa-trash-alt"></i>  Delete</a>

                           </td>
                         </tr>

                     <?php
                         }

                       }


                     ?>
               </tbody>
               <tfoot>
                  <tr>
                     <td colspan="3"><a href="?action=add" class="btn btn-primary"> <i class="fas fa-plus"></i> Add New Member</a></td>
                     <td colspan="3">Members Count : <strong><?=$count?></strong> </td>
                  </tr>
               </tfoot>
            </table>
            
         </div>
 
      </div>
      </div>  
</div>  
    
 <?php
    //add
    }elseif($action==="add"){
      $pageTitle="Add Member";
      include "init.php";
      
      ?>
 <!-- start add member-->
 <div class="add-member">
    
    
    <div class="container">
    <h1>Add New Member</h1>
      <form method="POST" action="?action=insert">
      

<!--first name-->


            <div class="row input-group">
                <div class="col-sm-12 col-lg-2">
                <label  class=" form-control-lg" for="first_name">first name</label>
                </div>
                
                <div class="col-sm-12 col-lg-5">
                <input type="text" name="first_name"  required  class="form-control form-control-lg " id="first_name" autocomplete="off">  
                </div>
            </div>
         
<!--last name-->
            <div class="row input-group">
                <div class="col-sm-12 col-lg-2">
                <label  class=" form-control-lg" for="last_name">last name</label>
                </div>
                
                <div class="col-sm-12 col-lg-5">
                <input type="text" name="last_name" required class="form-control form-control-lg " id="last_name" autocomplete="off">  
                </div>
            </div>
    
    
<!--username-->
            <div class="row input-group">
                <div class="col-sm-12 col-lg-2">
                <label  class=" form-control-lg" for="username">username</label>
                </div>
                
                <div class="col-sm-12 col-lg-5">
                <input type="text" name="username"  required class="form-control form-control-lg " id="username" autocomplete="off">  
                </div>
            </div>
<!--email-->  

            <div class="row input-group">
                <div class="col-sm-12 col-lg-2">
                <label  class=" form-control-lg" for="email">email</label>
                </div>
                
                <div class="col-sm-12 col-lg-5">
                <input type="email" name="email"   required class="form-control form-control-lg " id="email" autocomplete="off">  
                </div>
            </div>
    
    
           <!--password-->

            <div class="row input-group">
                <div class="col-sm-12 col-lg-2">
                <label  class=" form-control-lg" for="password">password</label>
                </div>
                
                <div class="col-sm-12 col-lg-5">
                <input type="password" name="password"  required  class="form-control form-control-lg " id="password" autocomplete="off">  
                </div>
            </div>
            <div class="row input-group">
                <div class="col-sm-12 col-lg-2">
                <label  class=" form-control-lg" >Geder</label>
                </div>
                
                <div class="col-sm-12 col-lg-5">

                <div class="row radio">
                   <div class="col">
                     <label for="male">male</label><input type="radio" checked name="gender" value="male" id="male" required  >  
                   </div>
                   <div class="col">
                      <label for="female">female</label><input type="radio" name="gender" value="female" id="female" required  >  
                      </div>
                   <div class="col">
                       <label for="other">other</label><input type="radio" name="gender" value="ather" id="other" required  >  
                      </div>
                </div>
                
                 
                
                </div>
            </div>
    
            <div class="row input-group">
                
                <div class="col-sm-12 col-lg-2 offset-lg-2 d-grid gap-2">
                <input type="submit"   class="btn btn-primary btn-block" value="Add Member">  
                </div>
            </div>
    
    
    
       
      </form>
    
    
    
    </div>
    
    </div>
    <!-- end add member-->




      

<?php
    }//insert page
    elseif($action==="insert"){
      $pageTitle="Add Member";
      include "init.php";
       if($_SERVER["REQUEST_METHOD"]=="POST"){

               $first_name=clean_string_val($_POST["first_name"]);
               $last_name=clean_string_val($_POST["last_name"]);
               $username=clean_string_val($_POST["username"]);
               $email=filter_var(clean_string_val($_POST["email"]) , FILTER_SANITIZE_EMAIL);
               $password=clean_string_val($_POST["password"]) ;
               $gender=clean_string_val($_POST["gender"]);

               $validate_error=array();
               if(empty($first_name)|| strlen($first_name)<2 ){
                  $validate_error[]="first name cant be less than 2 characters";
               }
               if(empty($last_name)|| strlen($last_name)<2 ){
                  $validate_error[]="last_name cant be less than 2 characters";
               }
               if(empty($username)|| strlen($username)<4 ){
                  $validate_error[]="username cant be less than 4 characters";
               }
               if(empty($email)){
                  $validate_error[]="unvalide Email";
               }
               if(empty($password)|| strlen($password)<4 ){
                  $validate_error[]="password cant be less than 4 characters";
               }
               if($validate_error){
                  foreach($validate_error as $val){
                    echo " <div class='container'><div class='alert alert-danger'>" .$val."</div></div>";
                  }
               }
               if(!$validate_error){
                  try{
                     $check_user= checkItemDb("user_name","users",$username);
                     $check_email= checkItemDb("email","users",$email);
                     if($check_email!=1 && $check_user !=1){
                        $stm=$conn->prepare("INSERT INTO users(`first_name` , `last_name`,`user_name` ,`email`,`password`,`gender`,`reg_stutus`)
                        VALUES(:fname, :lname ,:user,:email,:pass,:gender , 1)");
                       $stm->execute(array(
                          "fname"=>$first_name,
                          "lname"=>$last_name,
                          "user"=>$username,
                          "email"=>$email,
                          "pass"=>sha1($password),
                          "gender"=>$gender
                       ));

                       echo  "<div class='container'>";
                       $msg = "<div class='alert alert-primary'>1 User Added</div>";
                       redirectHome($msg ,"members.php");
                       echo "</div>";
                     }else{
                        echo  "<div class='container'>";
                        $msg = "<div class='alert alert-danger'>this User already exit</div>";
                        redirectHome($msg ,"back");
                        echo "</div>";
                     }
            
                  }catch(Exception $e){
                     echo " <div class='container'><div class='alert alert-danger'>this User already exit</div></div>";
                  }
               }



       }else{
          header("Location:members.php?action=add");
          exit;
       }
   }
    //member delete
    elseif($action==="delete"){
      $pageTitle="Delete Members";
      include "init.php";
      $id =intval($_GET['id']);
      try{
      $stm = $conn->prepare("DELETE FROM users WHERE user_id = ?");
      $stm->execute(array($id));
         header("Location:members.php");
         exit;
   
      }catch(Exception $e){
         header("Location:members.php");
         exit;
      }
   }
   //edit member
   elseif($action==="edit"){
      $pageTitle="Edit Member";
      include "init.php";
      $userid= intval($_GET["id"]);
    
    
    
      $stm = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
      $stm ->execute(array($userid));
      $count = $stm->rowCount();
      $row =$stm->fetch();
        

      if($row >0){?>
          <!-- start edit-prfile-page-->
    <div class="edit-prfile-page">
    
    
    <div class="container">
    <h1>Edit Member</h1>
      <form method="POST" action="?action=update">
            <input type="hidden" name="user_id" value="<?=$row["user_id"]?>">

<!--first name-->
  

            <div class="row input-group">
                <div class="col-sm-12 col-lg-2">
                <label  class=" form-control-lg" for="first_name">first name</label>
                </div>
                
                <div class="col-sm-12 col-lg-5">
                <input type="text" name="first_name" value="<?=$row["first_name"];?>" required  class="form-control form-control-lg " id="first_name" autocomplete="off">  
                </div>
            </div>
            

<!--last name-->



            <div class="row input-group">
                <div class="col-sm-12 col-lg-2">
                <label  class=" form-control-lg" for="last_name">last name</label>
                </div>
                
                <div class="col-sm-12 col-lg-5">
                <input type="text" name="last_name" value="<?=$row["last_name"];?>" required class="form-control form-control-lg " id="last_name" autocomplete="off">  
                </div>
            </div>
    
    
<!--username-->



            <div class="row input-group">
                <div class="col-sm-12 col-lg-2">
                <label  class=" form-control-lg" for="username">username</label>
                </div>
                
                <div class="col-sm-12 col-lg-5">
                <input type="text" name="username" value="<?=$row["user_name"];?>" required class="form-control form-control-lg " id="username" autocomplete="off">  
                </div>
            </div>
    
    

<!--email-->

            <div class="row input-group">
                <div class="col-sm-12 col-lg-2">
                <label  class=" form-control-lg" for="email">email</label>
                </div>
                
                <div class="col-sm-12 col-lg-5">
                <input type="email" name="email" value="<?=$row["email"];?>"  required class="form-control form-control-lg " id="email" autocomplete="off">  
                </div>
            </div>
    
    
           <!--password-->
 

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
      }else{
          header("Location:members.php");
          exit;
      }

   }
   elseif($action==="update"){
         $pageTitle="Edit Member";
         include "init.php";

         if($_SERVER['REQUEST_METHOD']=="POST"){

            $first_name=clean_string_val($_POST["first_name"]);
            $last_name=clean_string_val($_POST["last_name"]);
            $username=clean_string_val($_POST["username"]);
            $email=filter_var(clean_string_val($_POST["email"]) , FILTER_SANITIZE_EMAIL);
            $password   =empty($_POST["new_password"]) ?$_POST["old_password"]:sha1(clean_string_val($_POST["new_password"])); 
            $id =intval($_POST["user_id"]);

           

            $validate_error=array();
            if(empty($first_name)|| strlen($first_name)<2 ){
               $validate_error[]="first name cant be less than 2 characters";
            }
            if(empty($last_name)|| strlen($last_name)<2 ){
               $validate_error[]="last_name cant be less than 2 characters";
            }
            if(empty($username)|| strlen($username)<4 ){
               $validate_error[]="username cant be less than 4 characters";
            }
            if(empty($email)){
               $validate_error[]="unvalide Email";
            }
            if(empty($password)|| strlen($password)<4 ){
               $validate_error[]="password cant be less than 4 characters";
            }
            if($validate_error){
               foreach($validate_error as $val){
                 echo " <div class='container'><div class='alert alert-danger'>" .$val."</div></div>";
               }
            }
            if(!$validate_error){
               try{
                  $stm=$conn->prepare("UPDATE  users SET `first_name` =? , `last_name`=?,`user_name`=? ,`email`=?,`password`=?
                  WHERE user_id=?
                  ");
                 $stm->execute(array(
                    $first_name,
                    $last_name,
                    $username,
                    $email,
                    $password,
                    $id
                 ));
                 $count =$stm->rowCount();
                  if($count>0){
         
                    echo  "<div class='container'>";
                    $msg = "<div class='alert alert-primary'>1 User Updated</div>";
                    redirectHome($msg ,"members.php");
                    echo "</div>";
                  }else{
                     echo  "<div class='container'>";
                     $msg = "<div class='alert alert-danger'>this User already exit</div>";
                     redirectHome($msg ,"back");
                     echo "</div>";

                  }
               
               }catch(Exception $e){
                  echo  "<div class='container'>";
                  $msg = "<div class='alert alert-danger'>this User already exit</div>";
                  redirectHome($msg ,"back");
                  echo "</div>";

               }
            }
        
            }
      
   }elseif($action==="activate"){
      $pageTitle ="activate Member";
      include "init.php";
      $id=isset($_GET["id"]) && is_numeric($_GET["id"])?intval($_GET["id"]):0;

     
      $check= checkItemDb("user_id","users",$id);
    
      echo "<div class='container'>";
      if($check > 0){
         $stm =$conn->prepare("UPDATE users SET reg_stutus =1 WHERE user_id = ?");
         $stm->execute(array($id));
         $count= $stm->rowCount();
      
         if($count >0){
            $msg ='<div class="alert alert-primary">1 member activated</div>';
            redirectHome($msg ,"back");
         }else{
            $msg ='<div class="alert alert-danger">this member activated already</div>';
            redirectHome($msg ,"back");
         }
      }else{
         $msg ='<div class="alert alert-danger"> wrong id</div>';
         redirectHome($msg ,"back");
      }
 

      echo " </div";
   }

//if not valide action
   else{
      include "init.php";
      header("Location:members.php");
      exit;}
 //if not admin     
}else{
   include "init.php";
   header("Location:index.php");
   exit;
}

include $tmp. "footer.php";

ob_flush();
?>
<?php 
ob_start();
session_start();

if(isset($_SESSION["admin_username"]) &&$_SESSION["is_admin"] ==="admin"){

$action = isset($_GET["action"])&&!empty($_GET["action"])?$_GET["action"]:"manage";


//manage items
if($action ==="manage"){

    $pageTitle ="Manage Items";
    include "init.php";

    $stm = $conn->prepare("SELECT comments.* , users.user_name AS username, items.name AS item

    FROM comments INNER JOIN users ON comments.user_id = users.user_id

    INNER JOIN items ON comments.item_id = items.item_id

    ORDER BY comments.comment_id DESC
    ");
   $stm->execute();
   $row = $stm->fetchAll();
   $count =$stm->rowCount();

 

 ?>


<div class="items_page">
   <div class="container">
<h1 class="text-center "> Manage Comments</h1>
      <div class="table-responsive ">

         <table class="table table-bordered text-center table-hover">
            <thead>
               <tr>
                  <th>ID</th>
                  <th>Comment</th>
                  <th>User name</th>
                  <th>Item Name</th>
                  <th>Added Date</th> 
                 <th>Actions</th>
               </tr>
            </thead>
            <tbody>
                  <?php


                    if($count >0){

                      foreach($row as $key ){?>

                      <tr>
                         <td><?=$key["comment_id"]?></td>
                         <td><?=$key["comment"]?></td>
                         <td><?=$key["username"]?></td>
                         <td><?=$key["item"]?></td>
                         <td><?=$key["comment_date"]?></td>
                       

                         <td>
                         <a href="?action=edit&id=<?=$key["comment_id"]?>" class="btn btn-primary"> <i class="far fa-edit"></i> Edit</a>

                          <?php
                          if($key["status"]==0){
                              echo '<a href="?action=approve&id='.$key["comment_id"].'"class="btn btn-success"> <i class="fas fa-check"></i> Approved</a>';

                          }
                          
                          ?>
                         <a href="comments.php?action=delete&id=<?=$key["comment_id"]?>" class="btn btn-danger remove_member"> <i class="far fa-trash-alt"></i>  Delete</a>

                        </td>
                      </tr>

                  <?php
                      }

                    }


                  ?>
            </tbody>
            <tfoot>
               <tr>
                  <td colspan="3"></td>
                  <td colspan="3">COMMENTS Count : <strong><?=$count?></strong> </td>
               </tr>
            </tfoot>
         </table>
         
      </div>

   </div>
   </div>  
</div>  
<?php

}

//Edite items 
else if($action ==="edit"){
    $pageTitle ="   Edit Comment";
    include "init.php";

 
    $id = isset($_GET["id"])&& !empty($_GET["id"]) &&is_numeric($_GET["id"])?intval($_GET["id"]):0;
    $checkid=checkItemDb("comment_id" ,"comments",$id);


    if($id >0 && $checkid >0){
    $stm =$conn->prepare("SELECT comment FROM `comments` WHERE comment_id =? LIMIT 1");
    $stm->execute(array($id));
    $comment = $stm->fetch();
    ?>


<div class="add_item_page">
    <div class="container">
        <h3 class="text-center"> Edit the  Comment</h3>
        <form action="?action=update" method="POST">
        <input type="hidden" name="id" value="<?=$id?>">

        <div class="row">
         <div class="col-xs-12 col-sm-2">
           <label for="comment" class="form-control-bg">Comment </label>
         </div>
         <div class="col-xs-12 col-sm-6">
         <input type="text" id="comment" name="comment" value="<?=isset($comment["comment"])?$comment["comment"]:''?>" placeholder="" class="form-control form-control-bg" required>
         </div>
        </div>
        <div class="row input-group">
             <div class="offset-sm-2 col-xs-12 col-sm-6 submit">
                <input type="submit" value="Edit" class="btn btn-primary ">
             </div>
         </div>

        </form>
        </div>
</div>
<?php
    }else{
        $msg="<div class='alert alert-danger'>wrong ID</div>";
        echo "<div class='container'>";
        redirectHome($msg ,"comments.php");
        echo "</div>";
    }
  
  
}
//update items 
else if($action ==="update"){
    $pageTitle ="update Comment";
    include "init.php";
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $id =intval($_POST["id"]);
        $comment =  clean_string_val($_POST["comment"]);
      
        $validate_errors=array();
    
        if(!isset($comment) || empty($comment) || strlen($comment)< 2) {
            $validate_errors[]="the comment must be more than 2 characters";
        }
       
    
        if(!$validate_errors){
           $stm =$conn->prepare("UPDATE `comments` SET comment=?  WHERE comment_id =? ");
           $stm->execute(array($comment ,$id));
           $count=$stm->rowCount();
    
           if($count >0){
            $msg ="<div class='alert alert-primary'>1 comment Updated</div>";
            echo "<div class='container'>";
            redirectHome($msg ,"comments.php");
            echo "</div>";
           }else{
            $msg ="<div class='alert alert-danger'>0 comment Updated</div>";
            echo "<div class='container'>";
            redirectHome($msg ,"back");
            echo "</div>";
           }
        
        }else{
    
            echo "<div class='container'>";
            $msg='';
            foreach($validate_errors as $error){
            $msg .="<div class='alert alert-danger'>".$error."</div>";} 
            redirectHome($msg ,"back");
            echo "</div>";
        }
    
    }else{
        $msg="<div class='alert alert-danger'>you cant browse this page directly.</div>";
        echo "<div class='container'>";
        redirectHome($msg ,"comments.php");
        echo "</div>"; 
    }
}

//approved items 
else if($action ==="approve"){
    $pageTitle ="approved comment";
    include "init.php";
    $id= isset($_GET["id"])&&is_numeric($_GET["id"]) && !empty($_GET["id"])?intval($_GET["id"]):0;
    $checkid=checkItemDb('comment_id','comments',$id);
    if($id >0 && $checkid >0){
       
      $stm =$conn->prepare("UPDATE  comments SET status = 1 WHERE comment_id = ? ");
      $stm->execute(array($id));
      $count = $stm->rowCount();
      if($count >0){

          echo "<div class='container'>";

          $msg ="<div class='alert alert-primary'> 1 comment Approved</div>";

          redirectHome($msg ,"comments.php");

          echo "</div>";

      }else{

          echo "<div class='container'>";

          $msg ="<div class='alert alert-danger'>0 comment Approved</div>";
  
          redirectHome($msg ,"comments.php");
  
          echo "</div>";

      }
    }else{
       
        header("location:comments.php");
        exit();
    }
}
//delete items
else if($action ==="delete"){
    $pageTitle ="Delete comment";
    include "init.php";
    $id= isset($_GET["id"])&&is_numeric($_GET["id"]) && !empty($_GET["id"])?intval($_GET["id"]):0;
    $checkid=checkItemDb('comment_id','comments',$id);
    if($id >0 && $checkid >0){
       
      $stm =$conn->prepare("DELETE FROM  comments  WHERE comment_id = ? ");
      $stm->execute(array($id));
      $count = $stm->rowCount();
      if($count >0){

          echo "<div class='container'>";

          $msg ="<div class='alert alert-primary'> 1 comment Deleted</div>";

          redirectHome($msg ,"comments.php");

          echo "</div>";

      }else{

          echo "<div class='container'>";

          $msg ="<div class='alert alert-danger'>0 comment Deleted</div>";
  
          redirectHome($msg ,"comments.php");
  
          echo "</div>";

      }
    }else{
       
        header("location:comments.php");
        exit();
    }
}
//if wrong action
else{
    header("Location:items.php");
    exit;  
}





include $tmp ."footer.php";
//if not admin
}else{
header("Location:index.php");
exit;
}

ob_flush();
?>
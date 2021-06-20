<?php 
ob_start();
session_start();

if(isset($_SESSION["admin_username"]) &&$_SESSION["is_admin"] ==="admin"){

$action = isset($_GET["action"])&&!empty($_GET["action"])?$_GET["action"]:"manage";


//manage items
if($action ==="manage"){

    $pageTitle ="Manage Items";
    include "init.php";

    $stm =$conn->prepare("SELECT 

    items.* ,
    users.user_name AS user_name,
    categories.name AS category_name
    FROM items INNER JOIN  users ON items.member_id  = users.user_id
    INNER JOIN categories ON items.catigory_id = categories.id
    ORDER BY item_id DESC
     
     ");
    $stm->execute();
    $row =$stm->fetchAll();
    $count =$stm->rowCount(); 
 
    ?>

<div class="items_page">
   <div class="container">
<h1 class="text-center "> Manage Items</h1>
      <div class="table-responsive ">

         <table class="table table-bordered text-center table-hover">
            <thead>
               <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Description</th>
                  <th>User</th>
                  <th>Category</th>
                  <th>Price</th>
                  <th>Added Date</th>
                  <th>Actions</th>
               </tr>
            </thead>
            <tbody>
                  <?php


                    if($count >0){

                      foreach($row as $key ){?>

                      <tr>
                         <td><?=$key["item_id"]?></td>
                         <td><?=$key["name"]?></td>
                         <td><?=$key["description"]?></td>
                         <td><?=$key["user_name"]?></td>
                         <td><?=$key["category_name"]?></td>
                         <td><?=$key["price"]?></td>
                         <td><?=$key["add_date"]?></td>

                         <td>
                         <a href="?action=edit&id=<?=$key["item_id"]?>" class="btn btn-primary"> <i class="far fa-edit"></i> Edit</a>

                          <?php
                          if($key["approve"]==0){
                              echo '<a href="?action=approve&id='.$key["item_id"].'"class="btn btn-success"> <i class="fas fa-check"></i> Approved</a>';

                          }
                          
                          ?>
                         <a href="items.php?action=delete&id=<?=$key["item_id"]?>" class="btn btn-danger remove_member"> <i class="far fa-trash-alt"></i>  Delete</a>

                        </td>
                      </tr>

                  <?php
                      }

                    }


                  ?>
            </tbody>
            <tfoot>
               <tr>
                  <td colspan="3"><a href="?action=add" class="btn btn-primary"> <i class="fas fa-plus"></i> Add New Item</a></td>
                  <td colspan="3">Items Count : <strong><?=$count?></strong> </td>
               </tr>
            </tfoot>
         </table>
         
      </div>

   </div>
   </div>  
</div>  
 
<?php

}
//Add items 
else if($action ==="add"){
    $pageTitle ="Add Items";
    include "init.php";
  
    $categories = get_all("*" ,"categories" ,"WHERE parent = 0");


    $stm2=   $stm =$conn->prepare("SELECT `user_id` , `user_name` FROM `users` ");
    $stm2->execute();
    $users = $stm2->fetchall();

    
    ?>



<div class="add_item_page">
    <div class="container">
        <form action="?action=insert" method="POST">
        <div class="row">
         <div class="col-xs-12 col-sm-2">
           <label for="name" class="form-control-bg">Name</label>
         </div>
         <div class="col-xs-12 col-sm-6">
         <input type="text" id="name" name="name" placeholder="Item Name" class="form-control form-control-bg" required>
         </div>
        </div>


        <div class="row">
         <div class="col-xs-12 col-sm-2">
           <label for="description" class="form-control-bg">Description</label>
         </div>
         <div class="col-xs-12 col-sm-6">
         <input type="text" id="description" name="description" placeholder="description of the item" class="form-control form-control-bg" required>
         </div>
        </div>

        <div class="row">
         <div class="col-xs-12 col-sm-2">
           <label for="price" class="form-control-bg">Price</label>
         </div>
         <div class="col-xs-12 col-sm-6">
         <input type="text" id="price" name="price" placeholder="Price of the item" class="form-control form-control-bg" required>
         </div>
        </div>




        <div class="row">
         <div class="col-xs-12 col-sm-2">
           <label for="user" class="form-control-bg">User</label>
         </div>
         <div class="col-xs-12 col-sm-6">
         <select id="user" name="user"  class="form-select form-select-lg mb-3" required>
           <option value="0">...</option>
           <?php
           foreach($users as $user){
               echo "<option value=".$user["user_id"].">".$user["user_name"]."</option>";
           }
           
           ?>
         </select>

         </div>
        </div>



        <div class="row">
         <div class="col-xs-12 col-sm-2">
           <label for="country" class="form-control-bg">Country</label>
         </div>
         <div class="col-xs-12 col-sm-6">
         <select id="country" name="country" placeholder="Country of made" class="form-select form-select-lg mb-3" required>
           <option value="0">...</option>
           <?php
           foreach($country_array as $country){
               echo "<option value=".$country.">".$country."</option>";
           }
           
           ?>
         </select>

         </div>
        </div>

        
        <div class="row">
         <div class="col-xs-12 col-sm-2">
           <label for="category" class="form-control-bg">Category</label>
         </div>
         <div class="col-xs-12 col-sm-6">
          <select id="category" name="category" placeholder="category of the item" class="form-select form-select-lg mb-3" >
           <option value="0">...</option>
           <?php
           foreach($categories as $category){
            $childs =get_all("*" , "categories" ,"WHERE parent = {$category["id"]}");
            if(count($childs)> 0){
               echo "<optgroup label='".$category["name"]."'>";
                foreach($childs as $child){
                  echo "<option value=".$child["id"].">".$child["name"]."</option>";
                }
               echo   "</optgroup>";
            }else{
              echo "<option value=".$category["id"].">".$category["name"]."</option>";
            }
              
           }
           
           ?>
         </select>
         </div>
        </div>

        <div class="row">
         <div class="col-xs-12 col-sm-2">
           <label for="tags" class="form-control-bg">tags</label>
         </div>
         <div class="col-xs-12 col-sm-6">
         <input type="text" id="tags" name="tags" placeholder="type item tags and separated by ',' " class="form-control form-control-bg" >
         </div>
        </div>



        <div class="row">
         <div class="col-xs-12 col-sm-2">
           <label for="status" class="form-control-bg">status</label>
         </div>
         <div class="col-xs-12 col-sm-6">
          <select id="status" name="status" placeholder="status of the item" class="form-select form-select-lg mb-3" required>
          <option value="0">...</option>
          <option value="1">New</option>
          <option value="2">Like New</option>
          <option value="3">Used</option>
          <option value="4">Very Old</option>
         </select>
         </div>
        </div>

        <div class="row input-group">
             <div class="offset-sm-2 col-xs-12 col-sm-6 submit">
                <input type="submit" value="Add" class="btn btn-primary ">
             </div>
         </div>



        </form>
    </div>
</div>
<?php
}
//Insert items 
else if($action ==="insert"){
    $pageTitle ="Add Items";
    include "init.php";

    if($_SERVER["REQUEST_METHOD"]==="POST"){

    $name =  clean_string_val($_POST["name"]);
    $description = clean_string_val($_POST["description"]);
    $price = clean_string_val($_POST["price"]);
    $user = clean_string_val($_POST["user"]);
    $country = clean_string_val($_POST["country"]);
    $category = clean_string_val($_POST["category"]);
    $status = clean_string_val($_POST["status"]);
    $tags=clean_string_val($_POST["tags"]);

    $validate_errors=array();

    if(!isset($name) || empty($name) || strlen($name)< 2) {
        $validate_errors[]="the name must be more than 2 characters";
    }
    if(!isset($description) || empty($description) || strlen($description)< 2) {
        $validate_errors[]="the description must be more than 2 characters";
    }
    if(!isset($country) || empty($country) || strlen($country)< 2) {
        $validate_errors[]="the country must be choosen";
    }
    if(!isset($price) ) {
        $validate_errors[]="the price must be set";
    }
    if(!isset($user) || intval($user) <1) {
        $validate_errors[]="wrong user";
    }
    if(!isset($category) || intval($category) <1) {
        $validate_errors[]="wrong category";
    }
    if(!isset($status) || intval($status) <1) {
        $validate_errors[]="wrong status";
    }


    if(!$validate_errors){
       $stm =$conn->prepare("INSERT INTO `items`(name , description , 	price , country_made, status , catigory_id ,member_id ,tags ,add_date) VALUES (?, ? , ? ,? ,? ,?,?,?,NOW())");
       $stm->execute(array($name ,$description ,$price ,$country ,$status ,$category ,$user ,$tags ));
       $count=$stm->rowCount();

       if($count >0){
        $msg ="<div class='alert alert-primary'>1 Item Added</div>";
        echo "<div class='container'>";
        redirectHome($msg ,"items.php");
        echo "</div>";
       }else{
        $msg ="<div class='alert alert-danger'>0 Item Added</div>";
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





//
    }else{
                    $msg ="<div class='alert alert-danger'>you cant browes this page directly</div>";
                    echo "<div class='container'>";
                    redirectHome($msg );
                    echo "</div>";
    }


}
//Edite items 
else if($action ==="edit"){
    $pageTitle ="   Edit Items";
    include "init.php";

    $id = isset($_GET["id"])&& !empty($_GET["id"]) &&is_numeric($_GET["id"])?intval($_GET["id"]):0;
    $checkid=checkItemDb("item_id" ,"items",$id);


    if($id >0 && $checkid >0){
   
    $categories = get_all("*" , "categories" ,"WHERE parent = 0");
    $users = get_all("*" , "users" ); 
    $item = get_all("*" ,"items" , "WHERE item_id = {$id}")[0];
 
  
        
        ?>

<div class="add_item_page">
    <div class="container">
        <form action="?action=update" method="POST">
        <input type="hidden" name="id" value="<?=$id?>">
        <div class="row">
         <div class="col-xs-12 col-sm-2">
           <label for="name" class="form-control-bg">Name</label>
         </div>
         <div class="col-xs-12 col-sm-6">
         <input type="text" id="name" name="name" value="<?=isset($item["name"])?$item["name"]:''?>" placeholder="Item Name" class="form-control form-control-bg" required>
         </div>
        </div>


        <div class="row">
         <div class="col-xs-12 col-sm-2">
           <label for="description" class="form-control-bg">Description</label>
         </div>
         <div class="col-xs-12 col-sm-6">
         <input type="text" id="description" name="description"value="<?=isset($item["description"])?$item["description"]:''?>" placeholder="description of the item" class="form-control form-control-bg" required>
         </div>
        </div>

        <div class="row">
         <div class="col-xs-12 col-sm-2">
           <label for="price" class="form-control-bg">Price</label>
         </div>
         <div class="col-xs-12 col-sm-6">
         <input type="text" id="price" name="price" value="<?=isset($item["price"])?$item["price"]:''?>" placeholder="Price of the item" class="form-control form-control-bg" required>
         </div>
        </div>




        <div class="row">
         <div class="col-xs-12 col-sm-2">
           <label for="user" class="form-control-bg">User</label>
         </div>
         <div class="col-xs-12 col-sm-6">
         <select id="user" name="user"  class="form-select form-select-lg mb-3" required>
           <option value="0">...</option>
           <?php
           $check='';
           foreach($users as $user){
               if(intval($user["user_id"])===intval($item["member_id"])){
                $check="selected";
               }else{
                   $check="";
               }
               echo "<option value='".$user["user_id"]."'".$check.">".$user["user_name"]."</option>";
           }
           
           ?>
         </select>

         </div>
        </div>



        <div class="row">
         <div class="col-xs-12 col-sm-2">
           <label for="country" class="form-control-bg">Country</label>
         </div>
         <div class="col-xs-12 col-sm-6">
         <select id="country" name="country" placeholder="Country of made" class="form-select form-select-lg mb-3" required>
           <option value="0">...</option>
           <?php
           foreach($country_array as $country){
            $check='';
            if($country==$item["country_made"]){
                $check="selected";
               }else{
                   $check="";
               }
               echo "<option value='".$country."'".$check.">".$country."</option>";
           }
           
           ?>
         </select>

         </div>
        </div>

        
        <div class="row">
         <div class="col-xs-12 col-sm-2">
           <label for="category" class="form-control-bg">Category</label>
         </div>
         <div class="col-xs-12 col-sm-6">
          <select id="category" name="category" placeholder="category of the item" class="form-select form-select-lg mb-3" >
           <option value="0">...</option>
           <?php
           foreach($categories as $category){
            $childs =get_all("*" , "categories" ,"WHERE parent = {$category["id"]}");
            if(count($childs)> 0){
               echo "<optgroup label='".$category["name"]."'>";
                foreach($childs as $child){
                   $check =$item["catigory_id"] ==$child["id"]?"selected":"";
                  echo '<option value="'.$child["id"].'"' .$check.'>'.$child["name"].'</option>';
                }
               echo   "</optgroup>";
            }else{
                $check =$item["catigory_id"] ==$category["id"]?"selected":"";
              echo "<option value='".$category['id']."'" .$check .">".$category["name"]."</option>";
            }
              
           }
           
           ?>
         </select>
         </div>
        </div>

        <div class="row">
         <div class="col-xs-12 col-sm-2">
           <label for="tags" class="form-control-bg">tags</label>
         </div>
         <div class="col-xs-12 col-sm-6">
         <input <?= isset($item["tags"])? "value ='" .$item["tags"] ."'":""?> type="text" id="tags" name="tags" placeholder="type item tags and separated by ',' " class="form-control form-control-bg" >
         </div>
        </div>

        <div class="row">
         <div class="col-xs-12 col-sm-2">
           <label for="status" class="form-control-bg">status</label>
         </div>
         <div class="col-xs-12 col-sm-6">
          <select id="status" name="status" placeholder="status of the item" class="form-select form-select-lg mb-3" required>
          <option value="0">...</option>
          <option value="1" <?=isset($item["status"]) && $item["status"] ==1 ?'selected' :''?>>New</option>
          <option value="2" <?=isset($item["status"]) && $item["status"] ==2 ?'selected' :''?>>Like New</option>
          <option value="3" <?=isset($item["status"]) && $item["status"] ==3 ?'selected' :''?>>Used</option>
          <option value="4" <?=isset($item["status"]) && $item["status"] ==4 ?'selected' :''?>>Very Old</option>
         </select>
         </div>
        </div>

        <div class="row input-group">
             <div class="offset-sm-2 col-xs-12 col-sm-6 submit">
                <input type="submit" value="Update" class="btn btn-primary ">
             </div>
         </div>



        </form>
    </div>
</div>




      <?php 
    }else{
        $msg="<div class='alert alert-danger'>wrong ID</div>";
        echo "<div class='container'>";
        redirectHome($msg ,"items.php");
        echo "</div>";
    }

   
}
//update items 
else if($action ==="update"){
    $pageTitle ="update Items";
    include "init.php";
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $id =intval($_POST["id"]);
        $name =  clean_string_val($_POST["name"]);
        $description = clean_string_val($_POST["description"]);
        $price = clean_string_val($_POST["price"]);
        $user = clean_string_val($_POST["user"]);
        $country = clean_string_val($_POST["country"]);
        $category = clean_string_val($_POST["category"]);
        $status = clean_string_val($_POST["status"]);
        $tags = clean_string_val($_POST["tags"]);
    
        $validate_errors=array();
    
        if(!isset($name) || empty($name) || strlen($name)< 2) {
            $validate_errors[]="the name must be more than 2 characters";
        }
        if(!isset($description) || empty($description) || strlen($description)< 2) {
            $validate_errors[]="the description must be more than 2 characters";
        }
        if(!isset($country) || empty($country) || strlen($country)< 2) {
            $validate_errors[]="the country must be choosen";
        }
        if(!isset($price) ) {
            $validate_errors[]="the price must be set";
        }
        if(!isset($user) || intval($user) <1) {
            $validate_errors[]="wrong user";
        }
        if(!isset($category) || intval($category) <1) {
            $validate_errors[]="wrong category";
        }
        if(!isset($status) || intval($status) <1) {
            $validate_errors[]="wrong status";
        }
    
    
        if(!$validate_errors){
           $stm =$conn->prepare("UPDATE `items` SET
           name = ? ,
            description =?, 
            price =?,
            country_made =?,
            status =?,
            catigory_id=? ,
            member_id =? ,
            tags = ? WHERE item_id =?
            ");
           $stm->execute(array($name ,$description ,$price ,$country ,$status ,$category ,$user , $tags,$id));
           $count=$stm->rowCount();
    
           if($count >0){
            $msg ="<div class='alert alert-primary'>1 Item Updated</div>";
            echo "<div class='container'>";
            redirectHome($msg ,"items.php");
            echo "</div>";
           }else{
            $msg ="<div class='alert alert-danger'>0 Item Updated</div>";
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
        redirectHome($msg ,"items.php");
        echo "</div>"; 
    }
}

//approved items 
else if($action ==="approve"){
    $pageTitle ="approved Items";
    include "init.php";
    $id= isset($_GET["id"])&&is_numeric($_GET["id"]) && !empty($_GET["id"])?intval($_GET["id"]):0;
    $checkid=checkItemDb('item_id','items',$id);
    if($id >0 && $checkid >0){
       
      $stm =$conn->prepare("UPDATE  items SET approve = 1 WHERE item_id = ? ");
      $stm->execute(array($id));
      $count = $stm->rowCount();
      if($count >0){

          echo "<div class='container'>";

          $msg ="<div class='alert alert-primary'> 1 Item Approved</div>";

          redirectHome($msg ,"items.php");

          echo "</div>";

      }else{

          echo "<div class='container'>";

          $msg ="<div class='alert alert-danger'>0 Item Approved</div>";
  
          redirectHome($msg ,"items.php");
  
          echo "</div>";

      }
    }else{
       
        header("location:items.php");
        exit();
    }
}
//delete items
else if($action ==="delete"){
    $pageTitle ="Delete Items";
    include "init.php";
    $id= isset($_GET["id"])&&is_numeric($_GET["id"]) && !empty($_GET["id"])?intval($_GET["id"]):0;
    $checkid=checkItemDb('item_id','items',$id);
    if($id >0 && $checkid >0){
       
      $stm =$conn->prepare("DELETE FROM items WHERE item_id = ? ");
      $stm->execute(array($id));
      $count = $stm->rowCount();
      if($count >0){

          echo "<div class='container'>";

          $msg ="<div class='alert alert-primary'> 1 Item Deleted</div>";

          redirectHome($msg ,"items.php");

          echo "</div>";

      }else{

          echo "<div class='container'>";

          $msg ="<div class='alert alert-danger'>0 Item Deleted</div>";
  
          redirectHome($msg ,"items.php");
  
          echo "</div>";

      }
    }else{
       
        header("location:items.php");
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
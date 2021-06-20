<?php 
ob_start();
session_start();
$pageTitle ="Edit AD";
include "init.php";
if(isset($_SESSION["user_name"])  && isset($_SESSION["user_id"])){
$item_id=isset($_GET["item_id"])&&is_numeric($_GET["item_id"])?intval($_GET["item_id"]):0;
if($item_id < 1){
  header("Location:not_found.php");
  exit();
}
$item =get_all("*","items","WHERE item_id = {$item_id} AND member_id ={$_SESSION['user_id']}");
 if(count($item)<1){
    header("Location:not_found.php");
    exit();
 }
 $item=$item[0];
$categories =get_all("*","categories" ,"WHERE parent = 0");


if($_SERVER["REQUEST_METHOD"] =="POST"){
 $ad_name=clean_string_val($_POST["name"]);
 $ad_description=clean_string_val($_POST["description"]);
 $ad_country=clean_string_val($_POST["country"]);
 $ad_price=filter_var($_POST["price"] ,FILTER_SANITIZE_NUMBER_INT);
 $ad_category=filter_var($_POST["category"] ,FILTER_SANITIZE_NUMBER_INT);
 $ad_status=filter_var($_POST["status"] ,FILTER_SANITIZE_NUMBER_INT);
 $tags =clean_string_val($_POST["tags"]);
 //uploads area
 $avatar=$_FILES["picture"];

 //print_r($avatar);
 $path=$_SERVER["DOCUMENT_ROOT"]."\data\uploads\products_img\\";
 $avatar_tmp=$avatar["tmp_name"];
 $avatar_name=trim($avatar["name"]);
 $avatar_size=$avatar["size"];
 $allowed_extensions =array("png" , "jpg" , "jfif","jpej");
 $extension=explode("." ,  $avatar_name);
 $avatar_extension =strtolower(end($extension));







 $validat_errors=array();
  if (!empty($avatar_name) && !in_array($avatar_extension ,$allowed_extensions)){
    array_push($validat_errors , "you must choose a image file");
    
  }
  if(empty( $ad_name) || strlen( $ad_name) < 2){
    array_push($validat_errors , "the ad name cant be less than 2 characters");
  }
  if(empty( $ad_description) || strlen( $ad_description) < 2){
    array_push($validat_errors , "the ad description cant be less than 2 characters");
  }
  if(empty( $ad_country) || strlen( $ad_country) < 2){
    array_push($validat_errors , "wrong  country");
  }
  if(empty( $ad_price) || $ad_price < 1){
    array_push($validat_errors , "unvalid price");
  }
  if(empty( $ad_category) || $ad_category < 1){
    array_push($validat_errors , "unvalid category");
  }
  if(empty( $ad_status) || $ad_status < 1){
    array_push($validat_errors , "unvalid status");
  }
  
 
  if(!$validat_errors){
        if(!empty($avatar_name) ){
            $rand1=rand(0 ,99999999999);
            $rand2=rand(0 ,99999999999);
            $link =$rand1."_".$rand2.".".$avatar_extension;
            if( $avatar["error"]==UPLOAD_ERR_OK){
            move_uploaded_file($avatar_tmp , "data\uploads\products_img\\".$link);
            }    
            $stm =$conn->prepare("UPDATE  items SET name =? ,description=? ,price=? ,country_made=? ,status =?,catigory_id=? ,tags=? ,image=?
            WHERE item_id= ? AND member_id =?
            ");
            $stm->execute(array($ad_name ,$ad_description,$ad_price , $ad_country ,$ad_status ,$ad_category , $tags, $link ,$item_id,intval($_SESSION["user_id"]),));
        }else{
            $stm =$conn->prepare("UPDATE  items SET name =? ,description=? ,price=? ,country_made=? ,status =?,catigory_id=? ,tags=? 
            WHERE item_id= ? AND member_id =?
            ");
            $stm->execute(array($ad_name ,$ad_description,$ad_price , $ad_country ,$ad_status ,$ad_category , $tags, $item_id,intval($_SESSION["user_id"]),));
        }
       $done=$stm->rowCount();
     if(isset($done)&& $done >0 ){
      echo "<div class='container'>";
      $msg = '<div class="alert alert-success"> 1 item Updated</div>';
        redirectHome($msg ,"my_profile.php#my-ads");
        echo "</div>";
    }else{
    array_push($validat_errors , "faild");
    } 
  }

}




?>
<div class="create_add_page">
<div class="container">
<h1>Create New Ad</h1>


<form method="POST" action="<?=$_SERVER["PHP_SELF"]."?item_id=".$item_id?>" enctype="multipart/form-data">
  
        <div class="row">
         <div class="col-xs-12 col-sm-2">
           <label for="name" class="form-control-bg">Name</label>
         </div>
         <div class="col-xs-12 col-sm-6">
         <input type="text" id="name" name="name" placeholder="Item Name" class="form-control form-control-lg" 
          value="<?=isset($item["name"])?$item["name"]:"" ?>"
         
         required >
         </div>
        </div>


        <div class="row">
         <div class="col-xs-12 col-sm-2">
           <label for="description" class="form-control-bg">Description</label>
         </div>
         <div class="col-xs-12 col-sm-6">
         <input type="text" id="description" name="description" placeholder="description of the item" 
         class="form-control form-control-lg" required value="<?=isset($item["description"])?$item["description"]:"" ?>">
         </div>
        </div>

        <div class="row">
         <div class="col-xs-12 col-sm-2">
           <label for="price" class="form-control-bg">Price</label>
         </div>
         <div class="col-xs-12 col-sm-6">
         <input type="text" id="price" name="price" placeholder="Price of the item" class="form-control form-control-lg" 
          value="<?=isset($item["price"])?$item["price"]:"" ?>">
         </div>
        </div>




        <div class="row">
         <div class="col-xs-12 col-sm-2">
           <label for="picture" class="form-control-bg"> Ad picture</label>
         </div>
         <div class="col-xs-12 col-sm-6">
         <input type="file" id="picture" name="picture" placeholder="picture of the item" class="form-control form-control-lg" >
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
               $check=isset($item["country_made"])&&$item["country_made"]==$country?"selected":"";
            
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
          <select id="category" name="category" placeholder="category of the item" class="form-select form-select-lg mb-3" required>
           <option value="0">...</option>
           <?php
           foreach($categories as $category){
            $childs =get_all("*" , "categories" ,"WHERE parent = {$category["id"]}");
            if(count($childs)> 0){
               echo "<optgroup label='".$category["name"]."'>";
                foreach($childs as $child){
                    $check=isset($item["catigory_id"])&&$item["catigory_id"]==$child["id"]?"selected":"";
                    echo "<option value='".$child["id"]."'".$check.">".$child["name"]."</option>";
                }
               echo   "</optgroup>";
            }else{
                $check=isset($item["catigory_id"])&&$item["catigory_id"]==$category["id"]?"selected":"";
              echo "<option value='".$category["id"]."'".$check.">".$category["name"]."</option>";
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
         <input type="text" id="tags" name="tags" placeholder="type item tags and separated by ',' "
          class="form-control form-control-lg"  value="<?=isset($item["tags"])?$item["tags"]:"" ?>">
         </div>
        </div>


        <div class="row">
         <div class="col-xs-12 col-sm-2">
           <label for="status" class="form-control-bg">status</label>
         </div>
         <div class="col-xs-12 col-sm-6">
          <select id="status" name="status" placeholder="status of the item" class="form-select form-select-lg mb-3"required >
          <option value="0" <?=isset($item["status"])&&$item["status"]==0?"selected":""?>>...</option>
          <option value="1" <?=isset($item["status"])&&$item["status"]==1?"selected":""?>>New</option>
          <option value="2" <?=isset($item["status"])&&$item["status"]==2?"selected":""?>>Like New</option>
          <option value="3" <?=isset($item["status"])&&$item["status"]==3?"selected":""?>>Used</option>
          <option value="4" <?=isset($item["status"])&&$item["status"]==4?"selected":""?>>Very Old</option>
         </select>
         </div>
        </div>
        <div class=" offset-sm-2 col-xs-12 col-sm-8">
         <?php

     
         if(!empty($validat_errors)){
              foreach($validat_errors as $error){
                echo '<div class="alert alert-danger">'.$error.'</div>';
              }
         }

    
         ?>
        
        





        <div class="row input-group">
             <div class="offset-sm-2 col-xs-12 col-sm-6 submit">
                <input type="submit" value="Add" class="btn btn-primary submit">
             </div>
         </div>

</form>
</div>
</div>

<?php

}else{

    header("location:login.php");
    exit();
}


 include  $tmp."footer.php" ;
ob_flush();
?>

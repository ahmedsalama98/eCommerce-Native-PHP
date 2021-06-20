<?php 
ob_start();
session_start();
$pageTitle ="My Profile";
include "init.php";

$id =isset($_GET['user_id'])&& is_numeric($_GET['user_id'])?intval($_GET['user_id']):0;
$checkid=checkItemDb("user_id" , "users", $id);
if(isset($_SESSION["user_name"])  && isset($_SESSION["user_id"])){
   
    if($id == $_SESSION["user_id"]){
        header("location:my_profile.php");
        exit();
    }

}
if($checkid < 1){
    header("location:not_found.php");
    exit();
}

$user=get_all("*" ,"users" ,"WHERE user_id ={$id} ")[0];

$adds=get_all("*" ,"items" ,"WHERE member_id ={$id}" , "ORDER BY item_id DESC");

$username =isset($user["user_name"])?$user["user_name"]:"----";
$email =isset($user["email"])?$user["email"]:"----";
$first_name=isset($user["first_name"])?$user["first_name"]:"----";
$last_name=isset($user["last_name"])?$user["last_name"]:"----";
$gender = isset($user["gender"])?$user["gender"]:"other";
$birth_date=isset($user["birth_date"])?$user["birth_date"]:"----";

?>
<div class="my_profile_page">

<div class="container">
   

  <div class="user">
     
      <div class="content">
      <img src="<?=!empty($user["avatar"])?"data\uploads\users_avatar\\".$user["avatar"]:"layout/images/avatar.png"?>"alt="user-avatar" class="avatar">
        <div>
              <h3><?=$first_name ." ".$last_name?></h3>
             <span>@<?=$username?></span>
        </div>

      </div>
      
  </div>
    <div class="panel">
        <div class="panel_head">
            <h3> Info</h3>
        </div>

        <div class="panel_body">
            <div class="info">
               <span>  <i class="fas fa-user-check"></i>  UserName </span> :
               <span><?=$username?></span>
            </div>
            <div class="info">
               <span><i class="fas fa-user-alt"></i>  first name </span> :
               <span><?=$first_name?></span>
            </div>

            <div class="info">
               <span>  <i class="fas fa-user-alt"></i> Last name </span> :
               <span><?=$last_name?></span>
            </div>

            <div class="info">
               <span><i class="fas fa-envelope-open-text"></i> Email </span> :
               <span><?=$email?></span>
            </div>

            <div class="info">
               <span> <i class="fas fa-mars-stroke"></i>  Gender </span> :
               <span><?=$gender?></span>
            </div>

            <div class="info">
               <span>  <i class="fas fa-birthday-cake"></i> BirthDate </span> :
               <span><?=$birth_date?></span>
            </div>


        </div>
    </div>




    <div class="panel" id="my-ads">
        <div class="panel_head"><h3> Adds</h3>
        </div>

        <div class="panel_body">
        <div class="row">
        <?php 
        if(count($adds) > 0){
        foreach($adds as $add){?>

        <div class="col-sm-6 col-lg-4 col-xl-3">
              <div class="product">
                  <div class="head">    
                      <img src="<?=!empty($add["image"])?"data\uploads\products_img\\".$add["image"]:"layout/images/product.jfif"?>"  alt="">

                  </div>
                   <div class="body">
                        <?php
                          if($add["approve"]==0){
                              echo '<h3 class="name">'.$add["name"].'</h3>';
                              echo ' <div class="wating_approved">Waiting Approved</div>';
                          }else{
                             echo '<a href="item.php?item_id='.$add["item_id"].'"> <h3 class="name">'.$add["name"].'</h3></a>';
                           
                          }
                         
                        ?>
                       
                         <p class="description"><?=$add["description"]?></p>
                          <span class="price">$<?=filter_var($add["price"], FILTER_SANITIZE_NUMBER_INT)?></span>
                          <span class="date"><?=$add["add_date"]?></span>
                   </div>
              </div>
           </div>


     <?php
        } 
     
    
    }else{


          echo "<div class='info'>No Adds to show</div>";


        }
        ?>
   
 </div>
        </div>
    </div>




  </div>

</div>

<?php



 include  $tmp."footer.php" ;
ob_flush();
?>

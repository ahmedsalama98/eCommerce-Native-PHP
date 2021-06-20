<?php 
ob_start();
session_start();
$pageTitle ="item";
include "init.php";
$item_id= isset($_GET["item_id"])&&!empty($_GET["item_id"])?filter_var($_GET["item_id"] , FILTER_SANITIZE_NUMBER_INT):0;


//insert comment
if($_SERVER["REQUEST_METHOD"]=="POST"){

  if(isset($_POST["comment_submit"])){
      $comment =clean_string_val($_POST["comment"]) ;
      $user_id=filter_var($_SESSION["user_id"]  , FILTER_SANITIZE_NUMBER_INT);
     
      $stm3=$conn->prepare("INSERT INTO comments(comment ,user_id ,	item_id) VALUES (?,?,?)");
      $stm3->execute(array($comment ,$user_id, $item_id));
      
  }


  //add to cart
  if(isset($_POST["cart_submit"])){
   
    if(isset($_SESSION["user_name"])  && isset($_SESSION["user_id"])){

       $quantity = isset($_POST["quantity"])&&!empty($_POST["quantity"])?intval($_POST["quantity"]):1;
       $user_id=$_SESSION["user_id"];
       $item_id=$item_id;

      $stment=$conn->prepare("INSERT INTO orders( order_date ,item_id , user_id , quantity ) 
      VALUES (NOW() , ? ,? ,?)");
      $stment->execute(array($item_id,$user_id ,$quantity));
      $done = $stment->rowCount();
      if($done > 0){
        echo "<div class='container'>";
        $msg ="<div class='alert alert-primary'>Added</div>";
        redirectHome($msg ,"cart.php");
        echo "</div>";
      }else{
        echo "<div class='container'>";
        $msg ="<div class='alert alert-danger'>Failed</div>";
        redirectHome($msg ,"back");
        echo "</div>";
      }



   //if not logged in
    }else{
        header("location:login.php");
        exit();
    }
    
  }
}

//fetch item
$stm = $conn->prepare("SELECT items.* , categories.name  AS cat_name , users.user_name  AS user , users.avatar FROM items
                        INNER JOIN categories ON items.catigory_id = categories.id
                        INNER JOIN users ON items.member_id = users.user_id
                              WHERE  item_id = ? AND approve = 1");
$stm->execute(array($item_id));
$count=$stm->rowCount();
 
if($count >0){
    $item=$stm->fetch();
   
//fetch comments
    $comments=array();
    $stm2=$conn->prepare("SELECT comments.* , users.user_name AS user , users.avatar  from comments INNER JOIN users ON 
    comments.user_id = users.user_id WHERE comments.item_id =? AND comments.status = 1 ORDER BY comment_id DESC ");
    $stm2->execute(array($item_id));
    $comments=$stm2->fetchAll();

   ?>
<div class="item_page">
 <div class="container">
   <h2> <?=$item['name']?></h2>
     <div class="the_ad">
     <div class="row">
         
         <div class="col-md-3 col-sm-12">
         <img src="<?=!empty($item["image"])?"data\uploads\products_img\\".$item["image"]:"layout/images/product.jfif"?>"  alt="">

         </div>

         <div class="col-md-9 col-sm-12">

         <div class="data">
             <h3><?=$item['name']?></h3>
             <p><?=$item['description']?></p>

             <ul>
                 <li> Added Date : <?=$item['add_date']?></li>
                 <li> price : $<?=filter_var($item['price'] ,FILTER_SANITIZE_NUMBER_INT)?></li>
                 <li> Made In  :  <?=$item['country_made']?></li>
                 <li> Category : <a href="categories.php?categoryname=<?=$item['cat_name']?>&categoryid=<?=$item['catigory_id']?>"><?=$item['cat_name']?></a></li>
                 <li> User : <a href="user.php?user_id=<?=$item['member_id']?>"><?=$item['user']?></a></li>
                 <li> tags : 

                 <?php
                 $tags =trim($item['tags']);
                  if(strlen($tags)> 0){
                    $tags = explode(',', $item['tags']);
                    foreach($tags as $tag){
                      $tag =trim($tag);
                      echo '<a href="tags.php?tag='.$tag.'" class="btn btn-primary">'.$tag.'</a>';
                    }
                  }
                 ?>
                 </li>
             </ul>
         </div>
            
        </div>

     </div>

        <div class="add_to_cart">
         
         <?php 
         if(isset($_SESSION["user_name"])  && isset($_SESSION["user_id"])){?>


         <form method="post" action="<?= $_SERVER["PHP_SELF"]."?item_id=".$item['item_id'];?>">
                 <label for="quantity">  Quantity </label>
                <select name="quantity"  id="quantity" required  class="form-control select-control">
                 <option value="1">1</option>
                 <option value="2">2</option>
                 <option value="3">3</option>
                 <option value="4">4</option>
                 <option value="5">5</option>
                 <option value="6">6</option>
                 <option value="7">7</option>
                 <option value="8">8</option>
                 <option value="9">9</option>
                 <option value="10">10</option>
                </select>
                <button type="submit" class="submit" name="cart_submit">Add To Cart</button>
             </form>



     <?php
         }else{
              echo "<a hreF='login.php'>login</a> <span>TO can Add To Cart</span>" ;
         }
         
         
         ?>
     
        
          
        
        </div>
     
     </div>
     <div class="add_comment">
     <?php
     
     if(isset($_SESSION["user_name"])  && isset($_SESSION["user_id"])){
       
        $user_avatar =get_all("avatar" ,"users","WHERE user_id = {$_SESSION["user_id"]} ")[0];
       ?>
    
       
       <div class="row">
       <div class=" col-xs-2 col-lg-1 ">
       <img src="<?=!empty($user_avatar["avatar"])?"data\uploads\users_avatar\\".$user_avatar["avatar"]:"layout/images/avatar.png"?>"alt="user-avatar" class="avatar">

         </div>

         <div class=" col-xs-10 col-lg-6 ">
             <form method="post" action="<?= $_SERVER["PHP_SELF"]."?item_id=".$item['item_id'];?>">
                
                <input type="text" name="comment"  placeholder="Type your comment" required>
         
                <button type="submit" class="submit" name="comment_submit"><i class="fas fa-paper-plane"></i></button>
             </form>
         </div>
       </div>




<?php
     }else{

       echo '<div class="alert alert-danger">you cant add comment  <a href="login.php">login</a>  
       or <a href="login.php?action=sign-up"> sign up</a>
       </div>';


     }
     
     
     
     
     ?>
 </div>
   


 <div class="comments">
    
       <?php
          if(!empty($comments)){
          foreach($comments as $comment){?>

        <div class="comment">
     

         <div>
         <img src="<?=!empty($comment["avatar"])?"data\uploads\users_avatar\\".$comment["avatar"]:"layout/images/avatar.png"?>"alt="user-avatar" class="avatar">

            <a href="user.php?user_id=<?=$comment["user_id"]?>"> <h4><?=$comment["user"]?></h4> </a>
         </div>

         <div >
           <p><?=$comment["comment"]?></p>
         </div>


     
        </div>
      <?php
          }
          }
       ?>

 
 </div>




 </div>
</div>

<?php
}else{

   echo '<div class="container">';
   echo '<div class="alert alert-danger">Ops there is no item available</div>';
   echo '</div>';

}


include  $tmp."footer.php" ;
ob_flush();
?>
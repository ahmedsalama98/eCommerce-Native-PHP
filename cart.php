<?php 
ob_start();
session_start();
$pageTitle ="Cart";
include "init.php";
if(isset($_SESSION["user_name"])  && isset($_SESSION["user_id"])){
    $stm =$conn->prepare("SELECT orders.*,DATEDIFF(NOW(),orders.order_date ) AS since  , items.* FROM orders INNER JOIN items ON orders.item_id = items.item_id WHERE orders.user_id = ? AND orders.status = 0  ");
    $stm->execute(array($_SESSION["user_id"]));
    $orders = $stm->fetchAll();



    //delete from cart

    if(isset($_GET["action"])&&$_GET["action"] =="delete_item_from_cart"){

       $id= isset($_GET["id"])&&!empty($_GET["id"])?filter_var($_GET["id"], FILTER_VALIDATE_INT):0;
       $stm2=$conn->prepare("DELETE FROM orders WHERE order_id =? AND user_id =?");
       $stm2->execute(array($id, intval($_SESSION["user_id"])));
       $count=$stm2->rowCount();
       if($count >0){
        echo "<div class='container'>";
        $msg = '<div class="alert alert-success"> Done</div>';
          redirectHome($msg ,"back");
          echo "</div>";
       }else{
        echo "<div class='container'>";
        $msg = '<div class="alert alert-danger"> Failed</div>';
          redirectHome($msg ,"back");
          echo "</div>";
       }



    }


?>

<div class="cart_page">

  <div class="container">

 <h1>Cart </h1>
   
 <div class="orders">

 <div class="row">
        <?php 
        foreach($orders as $order){?>


            <div class="col-sm-6 col-lg-4 col-xl-3">
              <div class="cart_product">
                  <div class="head">
                      <img src="<?=!empty($order["image"])?"data\uploads\products_img\\".$order["image"]:"layout/images/product.jfif"?>"  alt="">
                  </div>
                   <div class="body">
                        <a href="item.php?item_id=<?=$order["item_id"]?>"> <h3 class="name"><?=$order["name"]?></h3></a>
                         <p class="description"><?=$order["description"]?></p>
                         <p class="quantity"> Quantity : <?=$order["quantity"]?></p>
                          <p class="price">  price : $<?=filter_var($order["price"] ,FILTER_SANITIZE_NUMBER_INT) * filter_var($order["quantity"] ,FILTER_SANITIZE_NUMBER_INT)?></p>
                          <p class="date"> added : <?=$order["order_date"]?></p> 
                          
                          <?php

                          if($order["since"] >0){
                           echo '<span class="since">'.$order["since"].'d</span>';
                          } 
                          ?>
                          <a class="delete_item_from_cart delete" href="cart.php?action=delete_item_from_cart&id=<?=intval($order["order_id"])?>"><i class="far fa-trash-alt"></i></a>
                   </div>
              </div>
           </div>





     <?php
        }
        
        ?>

 </div>

  </div>

</div>


<?php
//if not logged in
}else{

    header("location:login.php");
    exit();
}


 include  $tmp."footer.php" ;
ob_flush();
?>

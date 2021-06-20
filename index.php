<?php 
ob_start();
session_start();
$pageTitle ="Home";
include "init.php";

$Ads =getTableItems('items' , 'WHERE approve = 1' , 'ORDER BY item_id DESC');









?>

<div class="home_page">
<div class="container">
<div class="row">
<?php 
foreach ($Ads as $Ad){?>

<div class="col-sm-6 col-lg-4 col-xl-3">
              <div class="product">
                  <div class="head">
                  <img src="<?=!empty($Ad["image"])?"data\uploads\products_img\\".$Ad["image"]:"layout/images/product.jfif"?>"  alt="">
                  </div>
                   <div class="body">
                        <a href="item.php?item_id=<?=$Ad["item_id"]?>"> <h3 class="name"><?=$Ad["name"]?></h3></a>
                         <p class="description"><?=$Ad["description"]?></p>
                          <span class="price">$<?=filter_var($Ad["price"] ,FILTER_SANITIZE_NUMBER_INT)?></span>
                          <span class="date"><?=$Ad["add_date"]?></span>
                          <a href="item.php?item_id=<?=$Ad["item_id"]?>" class="add_to_cart"> Add To Cart</a>
                   </div>
              </div>
           </div>
<?php
}
?>
</div>
</div>
</div>


<?php include  $tmp."footer.php" ;
ob_flush();
?>

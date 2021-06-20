<?php
ob_start();
session_start();

$tag_name =isset($_GET['tag']) && is_string($_GET['tag'])?$_GET['tag']:null;
$pageTitle=  !empty($tag_name)? $tag_name:"tag";
include "init.php";
$items = array();

$items =get_all("*" , "items" , "WHERE tags LIKE '%{$tag_name}%'  AND approve = 1");


?>


<div class="category_page">
<div class="container">
          <h1><?=$pageTitle?></h1>
       <div class="row">
        <?php 
        foreach($items as $item){?>


            <div class="col-sm-6 col-lg-4 col-xl-3">
              <div class="product">
                  <div class="head">
                      <img src="layout/images/product.jfif" alt="">
                  </div>
                   <div class="body">
                        <a href="item.php?item_id=<?=$item["item_id"]?>"> <h3 class="name"><?=$item["name"]?></h3></a>
                         <p class="description"><?=$item["description"]?></p>
                          <span class="price">$<?=filter_var($item["price"] ,FILTER_SANITIZE_NUMBER_INT)?></span>
                          <span class="date"><?=$item["add_date"]?></span>
                         <a href="item.php?item_id=<?=$item["item_id"]?>" class="add_to_cart"> Add To Cart</a>

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

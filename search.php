<?php
ob_start();
session_start();

$serch_word =isset($_GET['key']) && is_string($_GET['key'])?$_GET['key'] :null;
$pageTitle=  !empty($serch_word )? $serch_word :"tag";
include "init.php";
$serch_word =clean_string_val($serch_word);
$items = array();

$items =get_all("*" , "items" , "WHERE tags LIKE '%{$serch_word}%'  OR name  LIKE '%{$serch_word}%'  OR description  LIKE '%{$serch_word}%'  AND approve = 1");

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
                  <img src="<?=!empty($item["image"])?"data\uploads\products_img\\".$item["image"]:"layout/images/product.jfif"?>"  alt="">
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

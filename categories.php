<?php
ob_start();
session_start();
$id = isset($_GET['categoryid'])&&is_numeric($_GET['categoryid'])?intval($_GET['categoryid']):0;
$catname=isset($_GET['categoryname'])&&is_string($_GET['categoryname'])?$_GET['categoryname']:"catigories";
$parentcategory =isset($_GET['parentcategory']) && is_numeric($_GET['parentcategory'])?intval($_GET['parentcategory']):null;
$pageTitle= $id >0  && !empty($catname)? $catname:"catigories";
include "init.php";
$items = array();

if($parentcategory != null){
    $prands = get_all("id" , "categories" , "WHERE parent = {$parentcategory }");
    $prands_id = "";
    foreach($prands as $prand){
        $prands_id .= "catigory_id= ".  $prand["id"]." OR ";
    }
    $items =get_all("*" , "items" , "WHERE $prands_id NOT NULL  HAVING approve = 1" ,"ORDER BY item_id DESC");   
}
else{
    $items =get_all("*" , "items" , "WHERE catigory_id = $id AND approve = 1" , "ORDER BY item_id DESC");   
}

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

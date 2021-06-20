<?php 
ob_start();
session_start();
if(isset($_SESSION["admin_username"]) &&$_SESSION["is_admin"] ==="admin"){
$action = isset($_GET["action"]) && !empty($_GET["action"])?$_GET["action"]:"manage";


//mange page
if($action ==="manage"){
    $pageTitle ="Categories";
    include "init.php";
    $sort = 'ASC';
    $sort_arr= array('ASC', 'DESC');
    if(isset($_GET["sort"]) && in_array($_GET["sort"] ,$sort_arr)){
        $sort =$_GET["sort"];
    }
    $stm =$conn->prepare("SELECT * FROM `categories` WHERE  `parent` = 0  ORDER BY ordering $sort ");
    $stm->execute();
    $categories = $stm->fetchAll();
   
    ?>

    <div class="category-page">
    <div class="container">
       <h1> Manage Categories</h1>
            <div class="head">
           <div>  <i class="fas fa-sort"></i>  Ordering  
               <a href="?sort=ASC" class="<?=$sort ==="ASC"?"active":""?>">ASC</a> |
               <a href="?sort=DESC" class="<?=$sort ==="DESC"?"active":""?>">DESC</a></div>
           <div> 
             
               Full view : 
               <div class="full-view-toggle">
                   <span></span>
               </div>
           </div>
            </div>

            <div class="body">  
             <?php
            if(!empty($categories)){
                foreach($categories as $category){
                
                   $child_cats=get_all("*" , "categories" , "WHERE parent =". $category['id']);
                    echo '<div class="item">';
                    echo ' <h3> '.(array_search($category, $categories))+1 ." - ".$category["name"]. ' </h3>';
  
                    echo "<div class='full_view'>";
                    echo isset($category["description"]) &&!empty($category["description"]) ? '<p>'.$category["description"].'</p>':"<p>No description </p>";
                    if($category["visibility"]==0){
                        echo '<span class="hidden"> <i class="fas fa-eye-slash"></i> Hidden</span>';
                    }
                    if($category["allow_comments"]==0){
                      echo '<span class="comments"> <i class="fas fa-comment-slash"></i> Comments Disabled</span>';
                    }
                    if($category["allow_adds"]==0){
                      echo '<span class="adds"> <i class="fas fa-times"></i> Adds Disabled</span>';
                    }
                    if(!empty( $child_cats)){
                        echo "<h4>Sub Categories</h4>";
                        foreach($child_cats as $child){
                            echo "<div class='child_cat'>";
                            echo '<a href="?action=edit&id='.$child['id'].'">'.$child["name"].'</a>';
                            echo '<a href="?action=delete&id='.$child['id'].'" class="btn btn-danger remove_item">Delete</a>';
                            echo '</div>';

                        }
                    }
                   
                    echo '</div>';
  
                  echo '<div class="links">';
                  echo '<a class="btn btn-primary" href="?action=edit&id='.$category['id'].'"> <i class="far fa-edit"></i> EDIT</a>';
                  echo '<a class="btn btn-danger remove_item" href="categories.php?action=delete&id='.$category['id'].'"> <i class="far fa-trash-alt"></i> Delete</a>';
                  echo '</div>';
  
                  
  
                    echo '</div>';
                }
            }
             
             ?>
            </div>

            <a class="btn btn-primary add-cat" href="?action=add">ADD category</a>
    </div>
    </div>


<?php
}
//add category
else if($action ==="add"){
    $pageTitle =" Add Category";
    include "init.php";
    
    $categories = get_all("*" ,"categories" ,"WHERE parent = 0");
  
    
    ?>


<div class="add_categories_page">
<div class="container">
        <form action="?action=insert" method="POST">
        <div class="row">
         <div class="col-xs-12 col-sm-2">
           <label for="name" class="form-control-bg">Name</label>
         </div>
         <div class="col-xs-12 col-sm-6">
         <input type="text" id="name" name="name" placeholder="Category Name" class="form-control form-control-bg" required>
         </div>
        </div>


        <div class="row">
         <div class="col-xs-12 col-sm-2">
           <label for="description" class="form-control-bg">Description</label>
         </div>
         <div class="col-xs-12 col-sm-6">
         <textarea id="description" name="description" placeholder="descripe The Category" class="form-control form-control-bg"></textarea>
         </div>
        </div>



        
        <div class="row">
         <div class="col-xs-12 col-sm-2">
           <label for="Parent" class="form-control-bg">Parent</label>
         </div>
         <div class="col-xs-12 col-sm-6">
         <select id="Parent" name="parent" class="form-select form-select-lg mb-3">
          <option value="0">Parent Category</option>
          <?php
         
           foreach ($categories as $cat){
               echo '<option value="'.$cat["id"].'">'.$cat["name"].'</option>';
           }
          ?>

         </select>
         </div>
        </div>



        <div class="row">
         <div class="col-xs-12 col-sm-2">
           <label for="order" class="form-control-bg">Order</label>
         </div>
         <div class="col-xs-12 col-sm-6">
         <input type="number" id="order" name="order" placeholder="Category order" class="form-control form-control-bg" autocomplete="off">
         </div>
        </div>



        <div class="row">
            <div class="col-xs-12 col-sm-2">
            <label  class="form-control-bg">Visible</label>
            </div>
            <div class="col-xs-12 col-sm-6">
                    <div class="form-check">
                    <input class="form-check-input" type="radio" name="visible" id="yes" value="1" checked>
                    <label class="form-check-label" for="yes">yes</label>
                    </div>
                    <div class="form-check">
                    <input class="form-check-input" type="radio" name="visible" id="no"  value="0">
                    <label class="form-check-label" for="visible">no</label>
                    </div>
            </div>
        </div>


        <div class="row">
            <div class="col-xs-12 col-sm-2">
            <label  class="form-control-bg">Allow Comments</label>
            </div>
            <div class="col-xs-12 col-sm-6">
                    <div class="form-check">
                    <input class="form-check-input" type="radio" name="comments" id="yes" value="1" checked>
                    <label class="form-check-label" for="yes">yes</label>
                    </div>
                    <div class="form-check">
                    <input class="form-check-input" type="radio" name="comments" id="no"  value="0">
                    <label class="form-check-label" for="visible">no</label>
                    </div>
            </div>
        </div>



        
        <div class="row">
            <div class="col-xs-12 col-sm-2">
            <label  class="form-control-bg">Allow Adds</label>
            </div>
            <div class="col-xs-12 col-sm-6">
                    <div class="form-check">
                    <input class="form-check-input" type="radio" name="adds" id="yes" value="1" checked>
                    <label class="form-check-label" for="yes">yes</label>
                    </div>
                    <div class="form-check">
                    <input class="form-check-input" type="radio" name="adds" id="no"  value="0">
                    <label class="form-check-label" for="visible">no</label>
                    </div>
            </div>
        </div>

         <div class="row input-group">
             <div class="offset-sm-2 col-xs-12 col-sm-6 d-grid">
                <input type="submit" value="Add" class="btn btn-primary ">
             </div>
         </div>




        </form>
</div>
</div>


<?php
}
//insrt category
else if($action ==="insert"){
    $pageTitle =" Isert Category";
    include "init.php";


    if($_SERVER["REQUEST_METHOD"]==="POST"){

        $name =clean_string_val($_POST["name"]);
        $description =clean_string_val($_POST["description"]);
        $parent =intval($_POST["parent"]);
        $order =intval($_POST["order"]);
        $visible=intval($_POST["visible"]);
        $comments=intval($_POST["comments"]);
        $adds=intval($_POST["adds"]);
        $validathion_errors=array();
        if(strlen($name)<2 || empty($name) ){
          $validathion_errors[]="the name cant be less than 2 caracters";
        }

        if(!$validathion_errors){
            $check =checkItemDb("name","categories",$name);
        
            if($check <1){
                $stm = $conn->prepare('INSERT INTO categories(name ,description ,ordering ,visibility,allow_comments,allow_adds , parent) VALUES(? ,? ,?,?,?,?,?)');
                $stm->execute(array($name , $description , $order , $visible,$comments ,$adds, $parent));
                $count =$stm->rowCount();
                if($count >0){

                    $msg ="<div class='alert alert-info'>1 category added</div>";
                    echo "<div class='container'>";
                    redirectHome($msg ,"categories.php");
                    echo "</div>";
                }else{
                    $msg ="<div class='alert alert-danger'>failed</div>";
                    echo "<div class='container'>";
                    redirectHome($msg ,"back");
                    echo "</div>";
                }

            }else{
                    $msg ="<div class='alert alert-danger'>this catigory is already exit</div>";
                    echo "<div class='container'>";
                    redirectHome($msg ,"back");
                    echo "</div>";
            }
        }else{

            $msg ="<div class='alert alert-danger'>".$validathion_errors[0]."</div>";
            echo "<div class='container'>";
            redirectHome($msg ,"back");
            echo "</div>";
        }
  
     


     
    }else{
       header("Location:categories.php");
       exit();
    }

}
//edit category
else if($action ==="edit"){
    $pageTitle =" Edit Category";
    include "init.php";
  

    $id =isset($_GET["id"])&&!empty($_GET["id"])&& is_numeric($_GET["id"])? intval($_GET["id"]):0;
    $checkid=  checkItemDb("id","categories",$id);

    if($id > 0 && $checkid >0){
       $categories = get_all("*" ,"categories" ,"WHERE parent = 0");
       $cat = get_all("*" ,"categories" ,"WHERE id = $id ");
   
       $count = count($cat);
      

       if($count <1){
        header("Location:categories.php" );
        exit;    
       }

    }else{
       header("Location:categories.php" );
       exit;
    }




    ?>

<div class="add_categories_page">
<div class="container">
        <form action="?action=update" method="POST">
        <input type="hidden" name="id" value="<?=$cat[0]["id"]?>">
        <div class="row">
         <div class="col-xs-12 col-sm-2">
           <label for="name" class="form-control-bg">Name</label>
         </div>
         <div class="col-xs-12 col-sm-6">
         <input type="text" id="name" name="name" <?=isset($cat[0]["name"])?"value=".$cat[0]["name"]:''?> placeholder="Category Name" class="form-control form-control-bg" required>
         </div>
        </div>

        


        <div class="row">
         <div class="col-xs-12 col-sm-2">
           <label for="Parent" class="form-control-bg">Parent</label>
         </div>
         <div class="col-xs-12 col-sm-6">
         <select id="Parent" name="parent" class="form-select form-select-lg mb-3">
          <option value="0">Parent Category</option>
          <?php
         
           foreach ($categories as $cats){
               $select =intval($cat[0]["parent"])==intval($cats["id"])?'selected':'';
               echo '<option value="'.$cats["id"].'" '. $select.'>'.$cats["name"].'</option>';
           }
          ?>

         </select>
         </div>
        </div>


        <div class="row">
         <div class="col-xs-12 col-sm-2">
           <label for="description" class="form-control-bg">Description</label>
         </div>
         <div class="col-xs-12 col-sm-6">
         <textarea  id="description" name="description" placeholder="descripe The Category" class="form-control form-control-bg"><?=isset($cat[0]["description"])?$cat[0]["description"]:''?> 
         </textarea>
         </div>
        </div>



        <div class="row">
         <div class="col-xs-12 col-sm-2">
           <label for="order" class="form-control-bg">Order</label>
         </div>
         <div class="col-xs-12 col-sm-6">
         <input type="number" id="order" <?=isset($cat[0]["ordering"])?"value=".$cat[0]["ordering"]:''?> name="order" placeholder="Category order" class="form-control form-control-bg" autocomplete="off">
         </div>
        </div>



        <div class="row">
            <div class="col-xs-12 col-sm-2">
            <label  class="form-control-bg">Visible</label>
            </div>
            <div class="col-xs-12 col-sm-6">
                    <div class="form-check">
                    <input class="form-check-input" type="radio" name="visible" id="yes" value="1" <?=isset($cat[0]["visibility"]) && $cat[0]["visibility"] ==1?'checked':''?> >
                    <label class="form-check-label" for="yes">yes</label>
                    </div>
                    <div class="form-check">
                    <input class="form-check-input" type="radio" name="visible" id="no"  value="0" <?=isset($cat[0]["visibility"]) && $cat[0]["visibility"] ==0?'checked':''?> >
                    <label class="form-check-label" for="visible">no</label>
                    </div>
            </div>
        </div>


        <div class="row">
            <div class="col-xs-12 col-sm-2">
            <label  class="form-control-bg">Allow Comments</label>
            </div>
            <div class="col-xs-12 col-sm-6">
                    <div class="form-check">
                    <input class="form-check-input" type="radio" name="comments" id="yes" value="1" <?=isset($cat[0]["allow_comments"]) && $cat[0]["allow_comments"] ==1?'checked':''?>>
                    <label class="form-check-label" for="yes">yes</label>
                    </div>
                    <div class="form-check">
                    <input class="form-check-input" type="radio" name="comments" id="no"  value="0" <?=isset($cat[0]["allow_comments"]) && $cat[0]["allow_comments"] ==0?'checked':''?>>
                    <label class="form-check-label" for="visible">no</label>
                    </div>
            </div>
        </div>



        
        <div class="row">
            <div class="col-xs-12 col-sm-2">
            <label  class="form-control-bg">Allow Adds</label>
            </div>
            <div class="col-xs-12 col-sm-6">
                    <div class="form-check">
                    <input class="form-check-input" type="radio" name="adds" id="yes" value="1" <?=isset($cat[0]["allow_adds"]) && $cat[0]["allow_adds"] ==1?'checked':''?>>
                    <label class="form-check-label" for="yes">yes</label>
                    </div>
                    <div class="form-check">
                    <input class="form-check-input" type="radio" name="adds" id="no"  value="0" <?=isset($cat[0]["allow_adds"]) && $cat[0]["allow_adds"] ==0?'checked':''?>>
                    <label class="form-check-label" for="visible">no</label>
                    </div>
            </div>
        </div>

         <div class="row input-group">
             <div class="offset-sm-2 col-xs-12 col-sm-6 d-grid">
                <input type="submit" value="Edit" class="btn btn-primary ">
             </div>
         </div>




        </form>
</div>
</div>



<?php
}
//update category
else if($action ==="update"){
    $pageTitle =" update Category";
    include "init.php";

    if($_SERVER["REQUEST_METHOD"]=="POST"){

        $id =intval($_POST["id"]);
        $name =clean_string_val($_POST["name"]);
        $description =clean_string_val($_POST["description"]);
        $ordering =intval($_POST["order"]);
        $visible=intval($_POST["visible"]);
        $comments=intval($_POST["comments"]);
        $adds=intval($_POST["adds"]);
        $parent =intval($_POST["parent"]);
        $valid_errors=array();

        if(strlen($name)< 2 || empty($name)){
            $valid_errors[]="the category name must be at more than 2 characters";
        }

       if(!$valid_errors){
                $stm =$conn->prepare("UPDATE categories SET 
                name=?,
                description =?,
                ordering=?,
                visibility=?,
                allow_comments=?,
                allow_adds=?,
                parent =?
                 WHERE id = ?
                ");

                $stm->execute( array($name ,$description ,$ordering ,$visible ,$comments ,$adds , $parent,$id));
                $count = $stm->rowCount();
                if($count >0){

                    echo "<div class='container'>";

                    $msg ="<div class='alert alert-primary'> 1 category updated</div>";

                    redirectHome($msg ,"categories.php");

                    echo "</div>";

                }else{

                    echo "<div class='container'>";

                    $msg ="<div class='alert alert-danger'>0 category updated</div>";
            
                    redirectHome($msg ,"back");
            
                    echo "</div>";

                }
        }else{
            echo "<div class='container'>";

            $msg ="<div class='alert alert-danger'>" .$valid_errors[0]."</div>";
    
            redirectHome($msg ,"back");
    
            echo "</div>";
        }
      

    }else{
        echo "<div class='container'>";

        $msg ="<div class='alert alert-danger'> you cant browese this page directly</div>";

        redirectHome($msg);

        echo "</div>";
    }
}
//delete category
else if($action ==="delete"){
    $pageTitle ="delete Category";
    include "init.php";

    $id= isset($_GET["id"])&&is_numeric($_GET["id"]) && !empty($_GET["id"])?intval($_GET["id"]):0;
    $checkid=checkItemDb('id','categories',$id);
    if($id >0 && $checkid >0){
       
      $stm =$conn->prepare("DELETE FROM categories WHERE id = ? ");
      $stm->execute(array($id));
      $count = $stm->rowCount();
      if($count >0){

          echo "<div class='container'>";

          $msg ="<div class='alert alert-primary'> 1 category Deleted</div>";

          redirectHome($msg ,"categories.php");

          echo "</div>";

      }else{

          echo "<div class='container'>";

          $msg ="<div class='alert alert-danger'>0 category Deleted</div>";
  
          redirectHome($msg ,"categories.php");
  
          echo "</div>";

      }
    }else{
       
        header("location:categories.php");
        exit();
    }
   
}
//if not valid action
else{
header("location:categories.php");
exit;
}




//if not admin
}else{
    header("location:index.php");
    exit;
}


include $tmp ."footer.php";
ob_flush();
?>
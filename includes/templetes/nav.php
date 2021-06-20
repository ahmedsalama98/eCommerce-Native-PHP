<?php 



?>


<div class="ubber-bar">
  <div class="container">


  <div class="line">
    
  <div class="search">
            
            <div class="serch_show  ">
               <i class="fas fa-search"></i> Search
            </div>

            <div class="search_cont">
            <div class="serch_close"><i class="fas fa-times"></i></div>

                <form action="search.php" >
                  <input type="text"  name="key">
                  <button type="submit"> <i class="fas fa-search"></i> </button>
                </form>
            </div>
      </div>
    


     
 
      <div class="cart"> <a href="cart.php"><span class="cart_cart"><i class="fas fa-cart-plus"></i> </span> Cart  

      <?php
       if(isset($_SESSION["user_name"])  && isset($_SESSION["user_id"])){
           $num=  get_all("COUNT(order_id) AS num" ,"orders" ,"WHERE user_id = {$_SESSION["user_id"]} AND status = 0 ")[0];
           
           if($num["num"] >0){
             echo '<span class="badge bg-primary">'.$num["num"].'</span>';
           }
       }
      
      ?>
     </a></div>
      <div class="user">
        
      <?php
      if(isset($_SESSION["user_name"])  && isset($_SESSION["user_id"])){
        $user = get_all("avatar" ,"users" ,"WHERE user_id = {$_SESSION["user_id"]}")[0];
        
        ?>
        <span><?=$_SESSION["user_name"]?></span>
        <img src="<?=!empty($user["avatar"])?"data\uploads\users_avatar\\".$user["avatar"]:"layout/images/avatar.png"?>"alt="user-avatar" class="avatar">

            
            <div class="cont">
              <a href="my_profile.php" class="">My Profile</a>
              <a href="my_profile.php#my-ads" class="">My Ads</a>
              <a href="edit_profile.php"> Edite My Info</a>
              <a href="create_ad.php" class="">Create New Ad</a>
              <a href="log_out.php" class="logout">Logout</a>


            </div>

     <?php }else{?>
   <i class="fas fa-user-tie"></i> s<span>Login / Sign UP</span>
            <div class="cont">
              <a href="login.php" >Login</a>


              <a href="login.php?action=sign-up" >Sign Up</a>

            </div>
   

<?php
      }
      ?>
   
   </div>

     </div>
  </div>
   
</div>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark ">
  <div class="container">

       
        
        <div><a class="navbar-brand" href="index.php"><?= lang("application_name");?></a></div>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
        </button>


        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav  navbar-right">
              <?php 
                $categories =get_all("*" , "categories" ,"WHERE parent = 0");
                $cls='';
                foreach($categories as $category){
                  $cilds=get_all("*" , "categories" ,"WHERE parent = " .intval($category['id']));

                  if(count($cilds)> 0){?>

                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                       <?= $category["name"] ?>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <?php
                        echo '  <li class="nav-item">
                                  <a class="dropdown-item" href="categories.php?categoryname='.$category["name"].'&categoryid='.$category["id"].'&parentcategory='.$category["id"].'">All</a>
                                   </li>';
                        foreach($cilds as $child){
                          echo ' <li><a class="dropdown-item" href="categories.php?categoryname='.$child["name"].'&categoryid='.$child["id"].'">'.$child["name"].'</a></li>';
                       }
                      ?>
                    </ul>
                  </li>

                   <?php    
                  }else{
                    echo '  <li class="nav-item">
                  <a class="nav-link" href="categories.php?categoryname='.$category["name"].'&categoryid='.$category["id"].'">'.$category["name"].'</a>
                             </li>';
                  }
            
                
                }

              
              ?>

            </ul>
            
       </div>



  </div>
</nav>
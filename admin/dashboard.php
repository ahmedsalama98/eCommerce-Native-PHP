<?php
ob_start();
session_start();

if(isset($_SESSION["admin_username"]) &&$_SESSION["is_admin"] ==="admin"){
    $pageTitle = "dashboard";
    include "init.php"; 
    $latestusers =getLatestItem("*","users","user_id",5);
    $latestitem =getLatestItem("*","items","item_id",5);

    

    ?>
<!--start dashboard-->
<div class="dashboard">

   
   <div class="container">

        <div class="states">
            
            <h1> Dashboard</h1>
                <div class="row">
                <div class="col-md-6 col-xl-3">
                    <div class="state sts-tatal">
                        <p> <span><i class="fas fa-users"></i></span> total members</p>
                        <a href="members.php"><?=countItems("user_id","users");?> </a>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="state sts-pend">
                        <p> <span><i class="fas fa-ribbon"></i></span>  pending members</p>
                       <a href="members.php?action=manage&filter=pendening"><?=checkItemDb("reg_stutus","users",0);?></a>

                    </div>
                </div>


                <div class="col-md-6 col-xl-3">
                    <div class="state sts-item">
                        <p>  <span><i class="fas fa-archive"></i></span> total items</p>
                       <a href="items.php"><?=countItems("item_id","items");?></a>
                    </div>
                </div>



                <div class="col-md-6 col-xl-3">
                    <div class="state sts-comments">
                        <p><span><i class="far fa-comments"></i></span>  total comments</p>
                        <a href="comments.php"><?=countItems("comment_id","comments");?></a>

                    </div>
                </div> 

                </div>
            </div>


         <div class="latest">
             <div class="row">
                 <div class="col-lg-6">
                     <div class="item">
                         <div class="head">
                         <div><i class="fas fa-users-cog"></i>  latest registered users</div>

                         <div class="latest_butt_toggle"> <i class="fas fa-minus"></i></div>
                         </div>
                        <div class="body">
                      <?php
                      foreach($latestusers as $key){?>


                          <div class="result">
                                <span><?= array_search($key ,$latestusers )+1 ;?></span>
                                <div> <p>Name : <?= $key["first_name"] ." ".$key["last_name"]?></p>
                                <p>username :  <?= $key["user_name"]?></p>
                                 </div>

                                <a class="btn btn-info" href="members.php?action=edit&id=<?=$key["user_id"]?>">Edit</a>
                                <?php
                                if( $key["reg_stutus"]==0){
                                    echo ' <a class="btn btn-info" href="members.php?action=activate&id='.$key["user_id"].'">Activate</a>';
                                }
                                ?>
                                <a href="members.php?action=delete&id=<?=$key["user_id"]?>" class="btn btn-danger remove_member" >Delete</a>
    
                            </div>

                      <?php }
                      ?>
                            
                        </div>
                     </div>
                 </div>




                 <div class="col-lg-6">
                     <div class="item">
                         <div class="head">
                         <div><i class="fas fa-tags"></i>   latest items</div>
                         <div class="latest_butt_toggle"> <i class="fas fa-minus"></i></div>
                        
                         </div>
                        <div class="body">
                        <?php
                      foreach($latestitem as $key){?>


                          <div class="result">
                                <span><?= array_search($key ,$latestitem )+1 ;?></span>
                                <div> <p>name :  <?= $key["name"]?></p>
                                
                                 </div>

                                <a class="btn btn-info" href="items.php?action=edit&id=<?=$key["item_id"]?>">Edit</a>
                                <?php
                                if( $key["approve"]==0){
                                    echo ' <a class="btn btn-info" href="items.php?action=approve&id='.$key["item_id"].'">approve</a>';
                                }
                                ?>
                                <a href="items.php?action=delete&id=<?=$key["item_id"]?>" class="btn btn-danger remove_member" >Delete</a>
    
                            </div>

                      <?php }
                      ?>
                        </div>
                     </div>
                 </div> 


             </div>
         </div>


   </div>
</div>
<!--end dashboard-->



<?php

}else{
    header("Location:index.php");
    exit();
}




?>


<?php include  $tmp."footer.php" ;
ob_flush();
?>

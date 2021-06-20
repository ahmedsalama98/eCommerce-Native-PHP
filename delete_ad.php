<?php 
ob_start();
session_start();
$pageTitle ="My Profile";
include "init.php";
if(isset($_SESSION["user_name"])  && isset($_SESSION["user_id"])){
    $item_id=isset($_GET["item_id"])&&is_numeric($_GET["item_id"])?filter_var($_GET["item_id"] , FILTER_SANITIZE_NUMBER_INT):0;
    if($item_id < 1){
        header("Location:not_found.php");
        exit();
     }
     
    if($item_id > 0){
        $stm =$conn->prepare("DELETE FROM items WHERE item_id = ? AND member_id =?");
        $stm->execute(array($item_id , intval($_SESSION["user_id"])));
        $done=$stm->rowCount();
        if($done > 0){
            echo "<div class='container'>";
            $msg = '<div class="alert alert-success"> 1 item Deleted</div>';
              redirectHome($msg ,"my_profile.php#my-ads");
              echo "</div>";
        }else{
            echo "<div class='container'>";
            $msg = '<div class="alert alert-danger"> faaled</div>';
              redirectHome($msg ,"my_profile.php#my-ads");
              echo "</div>";
        }


    }



}else{

    header("location:login.php");
    exit();
}


 include  $tmp."footer.php" ;
ob_flush();
?>

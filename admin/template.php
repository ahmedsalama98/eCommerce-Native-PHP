<?php 
ob_start();
session_start();

if(isset($_SESSION["admin_username"]) &&$_SESSION["is_admin"] ==="admin"){

$action = isset($_GET["action"])&&!empty($_GET["action"])?$_GET["action"]:"manage";


//manage items
if($action ==="manage"){

    $pageTitle ="Manage Items";
    include "init.php";

    echo "manage";

}
//Add items 
else if($action ==="add"){
    $pageTitle ="Add Items";
    include "init.php";

    echo "Add";
}
//Insert items 
else if($action ==="insert"){
    $pageTitle ="Add Items";
    include "init.php";

    echo "Add";
}
//Edite items 
else if($action ==="edit"){
    $pageTitle ="   Edit Items";
    include "init.php";

    echo "Edit";
}
//update items 
else if($action ==="update"){
    $pageTitle ="update Items";
    include "init.php";
    echo "update";
}

//approved items 
else if($action ==="approved"){
    $pageTitle ="approved Items";
    include "init.php";
    echo "approved";
}
//delete items
else if($action ==="delete"){
    $pageTitle ="Delete Items";
    include "init.php";
    echo "delete";
}
//if wrong action
else{
    header("Location:items.php");
    exit;  
}





include $tmp ."footer.php";
//if not admin
}else{
header("Location:index.php");
exit;
}

ob_flush();
?>
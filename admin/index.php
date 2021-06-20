<?php 

session_start();
$pageTitle ="login";
$navbar_off=true;
include "init.php";
if(isset($_SESSION["admin_username"]) &&$_SESSION["is_admin"] ==="admin"){
  header("Location:dashboard.php");
  exit;
}



$valid_errors=array();
if($_SERVER["REQUEST_METHOD"]=="POST"){

$user =  clean_string_val($_POST["username"]);
$password = clean_string_val($_POST["password"]);

$stmt= $conn->prepare("SELECT user_name , group_id, user_id , password  FROM users WHERE  user_name = ? AND password =? AND group_id = 1 LIMIT 1");
$stmt ->execute(array($user , sha1($password)));

$data =$stmt->fetch();

$count = $stmt->rowCount();
if($count > 0){
$_SESSION["admin_username"]=$user;
$_SESSION["admin_id"]=$data["user_id"];
$_SESSION["is_admin"]= intval($data["group_id"])===1 ?"admin":"no";

header("Location:dashboard.php");
exit;
}else{
  array_push($valid_errors , "this user not exist");
}


}





?>





<div class="container">


<form class="login"  method="POST" action="<?php echo $_SERVER["PHP_SELF"];?>">
<h3>Login Admin</h3>



<div class="input-group input-group-lg">
  <input class="form-control input-lg" type="text" name="username" placeholder="username" autocomplete="off" >
</div>
<div class="input-group input-group-lg">
  <input class="form-control input-lg" type="password" name="password" placeholder="password" autocomplete="new-password" >  
</div>

<div class="warning"> <?= !empty($valid_errors) ? $valid_errors[0]:''?></div>

<div class="d-grid gap-2">
<input type="submit"  value="log in" class="btn btn-primary btn-lg">
</div>

</form>
</div>

 


<?php include  $tmp."footer.php" ;?>

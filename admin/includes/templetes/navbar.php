<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">

<a class="navbar-brand" href="dashboard.php"><?= lang("application_name");?></a>


<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>


<div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-flex justify-content-center">
   

     <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="categories.php"><?= lang("categories");?></a>
     </li>

     <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="items.php"><?= lang("items");?></a>
     </li>

     <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="members.php"><?= lang("members");?></a>
     </li>

     <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="comments.php"><?= lang("comments");?></a>
     </li>

     <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#"><?= lang("logs");?></a>
     </li>

     </ul>

     <li class="dropdown">
    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"><?=isset($_SESSION["admin_username"])?$_SESSION["admin_username"] :"user";?></a>
    <ul class="dropdown-menu dropdown-menu-dark">
      <li><a class="dropdown-item" href="edit_profile.php"><?= lang("edit_profile");?></a></li>
      <li><a class="dropdown-item" href="../index.php">Visit Shop</a></li>
      <li><hr class="dropdown-divider"></li>
      <li><a class="dropdown-item" href="logout.php"><?= lang("logout");?></a></li>
    </ul>
  </li>

     
  
    </div>
  </div>
</nav>
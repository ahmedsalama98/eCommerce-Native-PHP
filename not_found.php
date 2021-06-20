<?php

ob_start();
session_start();
include "init.php";
echo "<div class'not_found_page'>";
echo "<div class='container'>";

echo "<h1> NOT FOUND ERROR 404</h1>";

echo "</div>";
echo "</div>";
ob_flush();
include  $tmp."footer.php" ;

?>
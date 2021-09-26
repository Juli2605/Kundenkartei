<?php
    require_once("includes/DB.php");
?>
<?php
    require_once("includes/Sessions.php");
?>
<?php
    require_once("includes/Functions.php");
?>
<?php
 $_SESSION["User_ID"]=null;
 $_SESSION["Username"]=null;
 $_SESSION["CustomerName"]=null;
 $_SESSION["CustomerLastName"]=null;
session_destroy();
Redirect_to("Login.php");


?>
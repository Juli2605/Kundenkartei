<?php
    require_once("includes/DB.php");
?>
<?php
    require_once("includes/Functions.php");
?>
<?php
    require_once("includes/Sessions.php");

    
?>
<?php $CustomerIdFromUrl = $_GET["id"]; ?>
<?php
    
    $sql ="DELETE FROM customerlogon WHERE CustomerID=$CustomerIdFromUrl ";
             
    $stmt= $ConectingDB->prepare($sql);
    $Execute=$stmt->execute();
    
        

            if($Execute){
                $_SESSION["SuccessMessage"]="User Deleted ";
                Redirect_to("ManageUsers.php");
            }
            else{
                $_SESSION["ErrorMessage"]="Something Went Wrong. Try Again!";
                Redirect_to("ManageUsers.php");
            }
        
    
    ?>
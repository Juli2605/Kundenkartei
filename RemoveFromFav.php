<?php
    require_once("includes/DB.php");
?>
<?php
    require_once("includes/Functions.php");
?>
<?php
    require_once("includes/Sessions.php");

    
?>
<?php $ArtworkIdFromUrl = $_GET["id"]; ?>
<?php
    
    $sql ="DELETE FROM reviews WHERE ArtworkID=$ArtworkIdFromUrl AND Favorite='1' ";
             
    $stmt= $ConectingDB->prepare($sql);
    $Execute=$stmt->execute();
    
        

            if($Execute){
                $_SESSION["SuccessMessage"]="Artwork removed from the List ";
                Redirect_to("Favorites.php");
            }
            else{
                $_SESSION["ErrorMessage"]="Something Went Wrong. Try Again!";
                Redirect_to("Favorites.php");
            }
        
    
    ?>
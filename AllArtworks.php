<?php
    require_once("includes/DB.php");
?>
<?php
    require_once("includes/Functions.php");
?>
<?php
    require_once("includes/Sessions.php");
?>
<?php Confirm_Login(); ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset = "UFT-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="i=edge">
        <script src="https://kit.fontawesome.com/efbcec780b.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
        <link rel="stylesheet" href="css/Styles.css">
        <link href="https://fonts.googleapis.com/css2?family=Noto+Serif:ital@1&display=swap" rel="stylesheet">
        <style>
            h4 {
                font-family: 'Noto Serif', serif;
            }
        </style>
        <title>Artwork Search</title>

    </head>

    <body>
        <!--NAVBAR-->
        
       <?php include("nav.php"); ?>
        <!--NAV END-->
        
        <!--Header-->
        <!-- <header class="bg-dark text-white py-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1><i class="fas fa-palette " style="color:rgb(106, 216, 17)"></i></i> Our Artworks</h1>
                    </div>
                </div>
            </div>
        </header> -->
        
       
        <!--Header End-->
        
        <div class="container">
            <div class="row mt-4">
                <!--Main Area-->
                <div class="col-sm-8">
                
                
                    <?php
                        global $ConectingDB;
                         if(isset($_GET["SearchButton"])){
                            $Search= $_GET["Search"];
                            
                            $sql="SELECT  artists.LastName, artists.FirstName, artists.ArtistID, artworks.ArtWorkID, artworks.YearOfWork, artworks.ImageFileName, artworks.Title , artworks.Description
                            FROM artworks 
                            INNER JOIN artists ON artists.ArtistID=artworks.ArtistID 
                             
                            WHERE artists.LastName LIKE :search OR artists.FirstName LIKE :search OR artworks.Title LIKE :search
                            ORDER BY YearOfWork desc ";
                            $stmt = $ConectingDB->prepare($sql);
                            $stmt->bindValue(':search','%'.$Search.'%');
                            $stmt->execute();

                        } 
                        // default Sql Query  
                        else{ 
                            $_SESSION["ErrorMessage"]="Bad Request";   
                            Redirect_to("Home.php");

                        }
                        ?> <h3>Results for "<?php echo $Search; ?>"</h3> 
                        <br>
                        <?php
                            
                            while($DataRows=$stmt->fetch()){
                                $Id=$DataRows["ArtWorkID"];
                                $artistId=$DataRows["ArtistID"];
                                $Title=$DataRows["Title"];
                                $Year=$DataRows["YearOfWork"];
                                $ArtistF=$DataRows["FirstName"];
                                $ArtistL=$DataRows["LastName"];
                                $Image=$DataRows["ImageFileName"];
                                $Description=$DataRows["Description"];
                               // $Rating=$DataRows["Rating"];
                        ?>
                        
                        <div class="card">
                                <img src="images/works/average/<?php echo htmlentities ($Image) ; ?>" style="" class="img-fluid card-img-top">
                                <div class="card-body">
                                    <h4 class="card-title"><?php echo htmlentities ($Title) ; ?></h4>
                                    <small class="text-muted">By <a href="FullArtist.php?id=<?php echo $artistId; ?> "><?php echo $ArtistF." ".$ArtistL ; ?></a> On <?php echo $Year ; ?></small>
                                     <span style="float:right;" class="badge badge-dark text-light">Comments <?php echo CountComments($Id);?> </span>
                                     <hr>
                                        <p class="card-text">
                                            <?php 
                                                if (strlen($Description)>150){
                                                    $Description = substr($Description,0,150)."...";}echo htmlentities ($Description) ; 
                                            ?>
                                        </p>
                                        <a href="FullArtwork.php?id=<?php echo $Id ; ?>" style="float:right;">
                                        <span class="btn btn-info">Find Out More>></span>
                                        </a>
                                        </hr>
                                </div>
                        
                        </div>
                        <?php } ?>
                </div>
                <!--Main Area End-->
                <!--Side Area-->
                <div class="col-sm-4">
                        
                </div>
                <!--Side Area End-->
            </div>
        </div>

        <!--Footer-->
        <?php include("footer.php"); ?>

        <!--Footer END-->


        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script> 
        <script>
            $('#year').text(new Date().getFullYear());
        </script>
    </body>
    </html>
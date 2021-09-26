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
        <title>Full Genre</title>

    </head>

    <body>
        <!--NAVBAR-->
        <?php include("nav.php");?>
        <!--NAV END-->

        <div class="container">
            
            <?php
            global $ConectingDB;
            $GenreIdFromUrl=$_GET["id"];
 
                           
            $sql="SELECT  *
            FROM genres
                
            WHERE genres.GenreID= $GenreIdFromUrl";         
            $stmt=$ConectingDB->query($sql);
                        
            while($DataRows=$stmt->fetch()){
                $genreName=$DataRows["GenreName"];
                $genreImage=$DataRows["GenreImage"];
                $genreEra=$DataRows["Era"];
                $genreDescription=$DataRows["Description"];

            ?>
            <h1><?php echo $genreName; ?> </h1>
            
            <div class="row pt-4">
                <div class="col-sm-2">
                    <img style="width:110%;" src="images/genres/square-medium/<?php echo $genreImage; ?>" alt="">
                    <h3>Era: <?php echo $genreEra ; ?> </h3>
                 </div>
                <div class="col-sm-6 pr-5">
                    <div class="card-header">
                        <p><?php echo $genreDescription; ?> </p>
                    </div>
                
                </div> 
            </div>
            <?php } ?>
                    
            <br><br>
            <div class="card-header pt-4"> 
                <h5>Artworks from This Genre </h5>  
            </div>
            <div clas="card-body">       
                <div class="row text-center text-lg-left pt-4">
                <?php
                    global $ConectingDB;
                    $GenreIdFromUrl=$_GET["id"];
 
                           
                    $sql="SELECT DISTINCT genres.GenreName, genres.Era, genres.Description, genres.GenreImage, artworks.ImageFileName, artworks.ArtworkID, artworks.Title, artists.LastName, artists.ArtistID
                    FROM artworkgenres
                    INNER JOIN genres ON artworkgenres.GenreID=genres.GenreID 
                    INNER JOIN artworks ON artworks.ArtWorkID=artworkgenres.ArtWorkID
                    INNER JOIN artists ON artists.ArtistID=artworks.ArtistID 
                    WHERE genres.GenreID= $GenreIdFromUrl
                    ORDER BY artworks.ArtworkID";
                            
                    $stmt=$ConectingDB->query($sql);
                        
                            
                    while($DataRows=$stmt->fetch()){
                    
                        $artworkImage=$DataRows["ImageFileName"];
                        $artworkId=$DataRows["ArtworkID"];
                        // $artistsId=$DataRows["ArtistID"];
                        $artworkTitle=$DataRows["Title"];
                        $artistLast=$DataRows["LastName"];
                                
                               
                    ?>
                        
                        <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                            <a href="FullArtwork.php?id=<?php echo $artworkId; ?>" class="thumbnail">
                            <img class="img-fluid img-thumbnail" src="images/works/square-medium/<?php echo $artworkImage ;?>" alt="">
                            <p><?php echo $artworkTitle." by ".$artistLast;?></p>
                            </a>
                        </div>
                                
                            
                        
                    <?php } ?>
                </div>
            </div>
        </div>
    
         
        <!--Footer-->
        <?php include("footer.php"); ?>

        <!-- Footer END --> 


        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script> 
        <script>
            $('#year').text(new Date().getFullYear());
        </script>
    </body>
    </html>
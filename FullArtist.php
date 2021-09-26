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
        <title>Artist</title>

    </head>

    <body>
        <!--NAVBAR-->
        <?php include("nav.php");?>
        <!--NAV END-->
        
                
        <div class="container">           
                
            <?php
            global $ConectingDB;
            $ArtistIdFromUrl=$_GET["id"];
    
                            
            $sql="SELECT artists.ArtistID, artists.FirstName, artists.LastName, artists.Nationality, artists.YearOfBirth, artists.YearOfDeath , artists.Details, artists.Image, artists.ArtistLink
                FROM artists 
                WHERE ArtistID= $ArtistIdFromUrl";
                                
            $stmt=$ConectingDB->query($sql);
                            
                                
            while($DataRows=$stmt->fetch()){
                $artistsId=$DataRows["ArtistID"];
                $firstName=$DataRows["FirstName"];
                $lastName=$DataRows["LastName"];
                $nationality=$DataRows["Nationality"];
                $yearOfBirth=$DataRows["YearOfBirth"];
                $yearOfDeath=$DataRows["YearOfDeath"];
                $details=$DataRows["Details"];
                $image=$DataRows["Image"];
                $link=$DataRows["ArtistLink"];
                                    
                                
            ?>
        
            <h2><?php echo $firstName." ".$lastName; ?> </h2>
            <div class="row ">
                <div class="col-sm-4">
                    <!-- Add new Column Image-->
                    <!-- UPDATE artists SET Image=ArtistID;-->
                    <!--UPDATE  `artists` SET Image=concat(Image,'.jpg')-->
                    <img src="images/artists/medium/<?php echo $image; ?>" alt="">
                </div>
                <div class="col-sm-6">
                    <p><?php echo $details ;?> </p>
                    <table class="table">
                        
                        <thead  class=" thead-light">
                            <tr>
                            <th colspan="2">Artist Details </th> 
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <th scope="row">Lived during</th>
                            <td><?php echo $yearOfBirth."-".$yearOfDeath ; ?> </td>
                            </tr>
                            <tr>
                            <th scope="row">Nationality</th>
                            <td><?php echo $nationality ; ?> </td>
                            </tr>
                            <tr>
                            <th scope="row">More Info</th>
                            <td><a href="<?php echo $link ; ?>"><?php echo $link ; ?> </a></td>

                            </tr>
                        </tbody>
                    </table>
                    
                </div>
            </div>
            
            <?php } ?>
            <br><br>
            <div class="card-header">
                <h5>Artworks From <?php echo $lastName." ".$firstName ; ?> </h5>
            </div>
            
            <div class="card-body">
                <div class="row text-center text-lg-left pt-4">
                <?php
                    global $ConectingDB;
                    $ArtistIdFromUrl=$_GET["id"];
 
                           
                    $sql="SELECT DISTINCT  artworks.ImageFileName, artworks.Title , artworks.ArtWorkID
                    FROM artists
                    INNER JOIN artworks ON artists.ArtistID=artworks.ArtistID 
                     
                    WHERE artists.ArtistID= $ArtistIdFromUrl";
                            
                    $stmt=$ConectingDB->query($sql);
                        
                            
                    while($DataRows=$stmt->fetch()){
                    
                        $artworkImage=$DataRows["ImageFileName"];
                        $artworkId=$DataRows["ArtWorkID"];
                        
                        // $artistsId=$DataRows["ArtistID"];
                        $artworkTitle=$DataRows["Title"];
                        
                                
                               
                ?>
                        
                    <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                        <a href="FullArtwork.php?id=<?php echo $artworkId; ?>" class="thumbnail">
                        <img class="img-fluid img-thumbnail" src="images/works/square-medium/<?php echo $artworkImage ;?>" alt="">
                        <p><?php echo $artworkTitle;?></p>
                        </a>
                    </div>
                                
                            
                        
                <?php } ?>

            
                </div>            
        
            </div>
        
        </div>
        
           
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
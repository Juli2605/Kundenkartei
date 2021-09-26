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
        <title>Full Subject</title>

    </head>

    <body>
        <!--NAVBAR-->
        <?php include("nav.php");?>
        <!--NAV END-->
        

                <div class="container pt-3">
                    
                    <?php
                        global $ConectingDB;
                        $SubjectIdFromUrl=$_GET["id"];
 
                           
                        $sql="SELECT  *
                        FROM subjects
                        
                        WHERE subjects.SubjectId= $SubjectIdFromUrl
                        ";
                            
                        $stmt=$ConectingDB->query($sql);
                        
                        while($DataRows=$stmt->fetch()){
                            $subjectName=$DataRows["SubjectName"]

                        
                    ?>
                    <div class="col-sm-12">
                        <h1><?php echo $subjectName; ?> </h1>
                        <br><br>
                        <div class="card-header" >
                     
                            <h5>Artworks from This Subject </h5>
                         </div>
                    
                    
                    
                    <?php } ?>
                    <div class="card-body">
                       
                    <div class="row text-center text-lg-left">
                   
                    <?php
                        global $ConectingDB;
                        $SubjectIdFromUrl=$_GET["id"];
 
                           
                        $sql="SELECT DISTINCT subjects.SubjectName,  artworks.ImageFileName, artworks.ArtworkID, artworks.Title, artists.LastName, artists.ArtistID
                        FROM artworksubjects
                        INNER JOIN subjects ON artworksubjects.SubjectID=subjects.SubjectId 
                        INNER JOIN artworks ON artworks.ArtWorkID=artworksubjects.ArtWorkID
                        INNER JOIN artists ON artists.ArtistID=artworks.ArtistID 
                        WHERE subjects.SubjectId= $SubjectIdFromUrl
                        ORDER BY artworks.ArtworkID";
                            
                        $stmt=$ConectingDB->query($sql);
                        
                    
                            
                        while($DataRows=$stmt->fetch()){
                            $subjectName=$DataRows["SubjectName"];
                            
                            $artworkImage=$DataRows["ImageFileName"];
                            $artworkId=$DataRows["ArtworkID"];
                            $artistsId=$DataRows["ArtistID"];
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
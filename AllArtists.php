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
        <title>All Artists</title>

    </head>

    <body>
        <!--NAVBAR-->
        <?php include("nav.php");?>
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
                    <table class="table table-striped table-hover">
                            <thead class="thead-dark ">
                                <tr>
                                    <th>Name</th>
                                    <th>Nationality</th>
                                    <th>Lived during</th>
                                    <th>Image</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                
                    <?php
                        global $ConectingDB;
                        if(isset($_GET["SearchButton"])){
                            $Search= $_GET["Search"];
                            $sql="SELECT artists.ArtistID, artists.FirstName, artists.LastName, artists.Nationality, artists.YearOfBirth, artists.YearOfDeath , artists.Details, artists.Image
                            FROM artists
                            WHERE artists.LastName LIKE :search OR artists.FirstName LIKE :search ";
                            $stmt = $ConectingDB->prepare($sql);
                            $stmt->bindValue(':search','%'.$Search.'%');
                            $stmt->execute();

                        }
                        else{   
                        $sql="SELECT artists.ArtistID, artists.FirstName, artists.LastName, artists.Nationality, artists.YearOfBirth, artists.YearOfDeath , artists.Details, artists.Image
                        FROM artists ";
                            
                        $stmt=$ConectingDB->query($sql);
                        }
                        
                            
                        while($DataRows=$stmt->fetch()){
                            $artistId=$DataRows["ArtistID"];
                            $firstName=$DataRows["FirstName"];
                            $lastName=$DataRows["LastName"];
                            $nationality=$DataRows["Nationality"];
                            $yearOfBirth=$DataRows["YearOfBirth"];
                            $yearOfDeath=$DataRows["YearOfDeath"];
                            $details=$DataRows["Details"];
                            $image=$DataRows["Image"];
                                
                               
                        ?>
                        
                        <tbody>
                            <tr>
                                <td>
                                    <a href="FullArtist.php?id=<?php echo $artistId ; ?>">
                                    <?php
                                        echo $lastName." ".$firstName; 
                                    ?>
                                    </a>
                                </td>
                                <td><?php echo $nationality; ?></td>
                                <td><?php echo $yearOfBirth."-".$yearOfDeath; ?></td>

                                <!-- Add new Column Image-->
                                <!-- UPDATE artists SET Image=ArtistID;-->
                                <!--UPDATE  `artists` SET Image=concat(Image,'.jpg')-->
                                <td><img src="images/artists/square-thumb/<?php echo $image ; ?> "></td>
                                <td>
                                    <?php
                                        if (strlen($details)>150){
                                            $details = substr($details,0,150)."...";}echo htmlentities ($details) ;       
                                    ?>
                                </td>
                            </tr>
                        </tbody>
                        <?php } ?>
                    </table>
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
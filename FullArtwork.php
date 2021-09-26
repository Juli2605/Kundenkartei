<?php
    require_once("includes/DB.php");
?>
<?php
    require_once("includes/Functions.php");
?>
<?php
    require_once("includes/Sessions.php");
?>
<?php Confirm_Login(); 
 Confirm_Master();
 Confirm_Admin();
?>

<?php $SearchQueryParameter= $_GET["id"]; ?>
<?php

if(isset($_POST["Add"])){
    
    // $SearchQuery= $_POST["id"];
    if(Confirm_Login()){
        $CustomerID=$_SESSION["User_ID"];
    }
    if(Confirm_Master()){
        $CustomerID=$_SESSION["Master_ID"];
    }
    if(Confirm_Admin()){
        $CustomerID=$_SESSION["Admin_ID"];
    }
    if(Confirm_Favorite($SearchQueryParameter,$CustomerID)){
        $_SESSION["InfoMessage"]="Already in the List.";
        Redirect_to("FullArtwork.php?id={$SearchQueryParameter}");
    }else{
    $sql="INSERT INTO reviews( ArtWorkId,CustomerId,Favorite) VALUES(:artId,:custId,'1')
    ";
    $stmt= $ConectingDB->prepare($sql);
    
    $stmt->bindValue(':custId',$CustomerID);
    $stmt->bindValue(':artId',$SearchQueryParameter);
    $Execute=$stmt->execute();
   
    //var_dump($Execute);
    if($Execute){
        $_SESSION["SuccessMessage"]="Artwork Added Succesfully";
        Redirect_to("FullArtwork.php?id={$SearchQueryParameter}");
    }
    else{
        $_SESSION["ErrorMessage"]="Something Went Wrong. Try Again!";
        Redirect_to("FullArtwork.php?id={$SearchQueryParameter}");
    }
}

}
    if(isset($_POST["Submit"])){
        $Comment=$_POST["CommenterThoughts"];
        $rate=$_POST["Rate"];
        // $CustomerFirstName =$_SESSION["CustomerName"] ;
        // $CustomerLastName=$_SESSION["CustomerLastName"];
        // $CustomerUserName=$_SESSION["Username"];
        if(Confirm_Login()){
            $CustomerID=$_SESSION["User_ID"];
        }
        if(Confirm_Master()){
            $CustomerID=$_SESSION["Master_ID"];
        }
        if(Confirm_Admin()){
            $CustomerID=$_SESSION["Admin_ID"];
        }

        date_default_timezone_set("Europe/Berlin");
        $CurrentTime=time();
        $DateTime=strftime("%Y-%m-%d %H:%M:%S", $CurrentTime);

        if(empty($Comment)){
            $_SESSION["ErrorMessage"]="The Field must be filled out";
            Redirect_to("FullArtwork.php?id={$SearchQueryParameter}");


        }
        else if(strlen($Comment)>500){
            $_SESSION["ErrorMessage"]="Comment Length should be les than 500 characters";
            Redirect_to("FullArtwork.php?id={$SearchQueryParameter}");
        }
        else{
            $sql="INSERT INTO reviews( ArtWorkId,CustomerId,Comment,ReviewDate,Rating) VALUES(:postIdFromUrl,:custID,:comment, :reviewdate, :rating )
            ";
            
            $stmt= $ConectingDB->prepare($sql);
            $stmt->bindValue(':comment',$Comment);
            $stmt->bindValue(':postIdFromUrl',$SearchQueryParameter);
            $stmt->bindValue(':reviewdate',$DateTime);
            $stmt->bindValue(':rating',$rate);
            // $stmt->bindValue(':firstname',$CustomerFirstName);
            // $stmt->bindValue(':lastname',$CustomerLastName);
            $stmt->bindValue(':custID',$CustomerID);

            
            $Execute=$stmt->execute();
            //var_dump($Execute);
        

            if($Execute){
                $_SESSION["SuccessMessage"]="Comment Submited Succesfully";
                Redirect_to("FullArtwork.php?id={$SearchQueryParameter}");
            }
            else{
                $_SESSION["ErrorMessage"]="Something Went Wrong. Try Again!";
                Redirect_to("FullArtwork.php?id={$SearchQueryParameter}");
            }
        }
    }
?>



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
        
        <title>Full Artwork</title>

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
                <?php 
                echo ErrorMessage();
                echo SuccessMessage();
                echo InfoMessage();
                ?>
                    
                    <?php
                        global $ConectingDB;
                        if(isset($_GET["SearchButton"])){
                            $Search= $_GET["Search"];
                            
                            $sql="SELECT  artists.LastName, artists.FirstName, artworks.ArtWorkID, artworks.YearOfWork, artworks.ImageFileName, artworks.Title , artworks.Description
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
                            $PostIdFromUrl=$_GET["id"]; 
                            if(!isset($PostIdFromUrl)){
                                $_SESSION["ErrorMessage"]="Bad Request! ";
                                Redirect_to("Home.php");
                            }
                            $sql="SELECT  artists.LastName,artists.FirstName,artists.ArtistID, artworks.ArtWorkID, artworks.YearOfWork, artworks.ImageFileName, artworks.Title , artworks.Description
                            FROM artworks 
                            INNER JOIN artists ON artists.ArtistID=artworks.ArtistID 
                            -- INNER JOIN reviews ON reviews.ArtWorkID=artworks.ArtWorkID 
                            WHERE ArtWorkID = $PostIdFromUrl
                            -- GROUP BY ArtWorkID 
                            -- ORDER BY YearOfWork desc ";
                            
                            $stmt=$ConectingDB->query($sql);
                        }
                            
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
                                    <small class="text-muted">By <a href="FullArtist.php?id=<?php echo $artistId; ?>"><?php echo $ArtistF." ".$ArtistL ; ?></a> On <?php echo $Year ; ?></small>
                                     <span style="float:right;" class="badge badge-dark text-light">Comments <?php echo CountComments($Id);?> </span>
                                     <hr>
                                        <p class="card-text">
                                            <?php 
                                               echo htmlentities ($Description) ; 
                                            ?>
                                        </p>
                                        </hr>
                                </div>
                        
                        </div>
                        <?php } ?>

                        <!--Fetch Comments-->
                        <span class="FieldInfo">Comments</span>
                        <br><br>
                        <?php
                        global $ConectingDB;
                        $sql="SELECT DISTINCT customers.FirstName, customers.LastName, reviews.ReviewDate, reviews.Comment 
                        FROM reviews 
                        INNER JOIN customers ON reviews.CustomerId=customers.CustomerID
                        WHERE ArtWorkId='$SearchQueryParameter'And Favorite IS NULL ";
                        $stmt=$ConectingDB->query($sql);
                        while($DataRows=$stmt->fetch()){
                            $reviewDate=$DataRows["ReviewDate"];
                            $comment=$DataRows["Comment"];
                            $customerF=$DataRows["FirstName"];
                            $customerL=$DataRows["LastName"];
                        
                        
                        
                        ?>
                        <div>
                            
                            <div class="media" Style="background:#F6F7F9">
                                <img src="images/artists/square-thumb/49.jpg" alt="">
                                <div class="media-body ml-2">

                                    <h6 class='lead'><?php echo $customerF." ".$customerL ;?></h6>
                                    <p class="small"><?php echo $reviewDate ; ?> </p>
                                    <p><?php echo $comment ;?></p>
                                </div>

                            </div>
                        </div>
                        <hr>
                        <?php } ?>
                        <?php if(Confirm_Login()||Confirm_Master()||Confirm_Admin()){ ?>
                        <form class="" action="FullArtwork.php?id=<?php echo $SearchQueryParameter ; ?>" method="post">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h5 class="FieldInfo"> Share Your Thoughts</h5>
                                </div>
                                <div class="card-body">

                                    <div class="form-group">
                                        <textarea class="form-control" name="CommenterThoughts" type="text"    cols="30" rows="8"></textarea>
                                    </div>
                                        <label for="rate"><span class="FieldInfo"> Rate This Artwork</span></label>
                                        <select class="form-control col-3 mr" name="Rate" id="rate" > 
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    
                                    <div class="pt-3">
                                        <button type="submit" name="Submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </div>       
                        </form> 
                        <?php } ?>
                </div>
                <!--Main Area End-->
                <!--Side Area-->
                <div class="col-sm-4">
                <?php
                global $ConectingDB;
                $PostIdFromUrl=$_GET["id"]; 
                $sql="SELECT DISTINCT artworks.YearOfWork, artworks.Width, artworks.Height, artworks.OriginalHome, artworks.Cost, artworks.Medium
                
                    FROM artworks
                    
                    WHERE artworks.ArtWorkID = $PostIdFromUrl
                    ORDER BY artworks.ArtWorkID ";
                    $stmt=$ConectingDB->query($sql);
                    while($DataRows=$stmt->fetch()){
                        $yearOfWork=$DataRows["YearOfWork"];
                        $width=$DataRows["Width"];
                        $height=$DataRows["Height"];
                        $originalHome=$DataRows["OriginalHome"];
                        $cost=$DataRows["Cost"];
                        $medium=$DataRows["Medium"];
                        
                    ?>
                        <table class="table">
                        
                        <thead  class=" thead-light">
                            <tr>
                            <th colspan="2">Artwork Details </th> 
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <th scope="row">Cost</th>
                            <td><?php echo $cost."$" ; ?> </td>
                            </tr>
                            <tr>
                            <th scope="row">Year Of Work</th>
                            <td><?php echo $yearOfWork ; ?> </td>
                            </tr>
                            <tr>
                            <th scope="row">Medium</th>
                            <td><?php echo $medium ; ?> </td>
                            </tr>
                            <tr>
                            <tr>
                            <th scope="row">Dimensions</th>
                            <td><?php echo $width."cm x".$height."cm" ; ?> </td>
                            </tr>
                            <tr>
                            <th scope="row">Home</th>
                            <td><?php echo $originalHome ; ?> </td>

                            </tr>
                            <?php } ?>
                            <tr>
                            <th scope="row">Subject</th>
                            <td>
                            <?php 
                            global $ConectingDB;
                            $PostIdFromUrl=$_GET["id"]; 
                            $sql="SELECT  subjects.SubjectName,  subjects.SubjectID 
                            
                            FROM artworksubjects 
                            INNER JOIN subjects ON subjects.SubjectId=artworksubjects.SubjectID
                            WHERE artworksubjects.ArtWorkID =$PostIdFromUrl";
                                $stmt=$ConectingDB->query($sql);
                                while($DataRows=$stmt->fetch()){
                                    $subjectName=$DataRows["SubjectName"];
                                    $subjectId=$DataRows["SubjectID"];
                                    
                                   

                            ?>
                            
                            <a href="Fullsubject.php?id=<?php echo $subjectId ; ?>"><?php echo $subjectName."<br>" ; ?> </a><?php } ?>
                            </td>

                            </tr>
                            <tr>
                            <th scope="row">Genre</th>
                            <td>
                            <?php 
                            global $ConectingDB;
                            $PostIdFromUrl=$_GET["id"]; 
                            $sql="SELECT  genres.GenreName,  genres.GenreID 
                            
                            FROM artworkgenres 
                            INNER JOIN genres ON genres.GenreId=artworkgenres.GenreID
                            WHERE artworkgenres.ArtWorkID =$PostIdFromUrl";
                            $stmt=$ConectingDB->query($sql);
                            while($DataRows=$stmt->fetch()){
                                $genreName=$DataRows["GenreName"];
                                $genreId=$DataRows["GenreID"];
                            ?>
                            <a href="Fullgenre.php?id=<?php echo $genreId ;?>"><?php echo $genreName."<br>"; ?></a> <?php } ?> 
                            </td>
                            </tr>
                            

                        </tbody>
                    </table>
                    <!-- ALTER TABLE `reviews` ADD `Favorite` BOOLEAN NULL AFTER `Comment`; -->
                    <?php if(Confirm_Login()||Confirm_Master()||Confirm_Admin()) { ?>
                    <form class="" action="FullArtwork.php?id=<?php echo $SearchQueryParameter ; ?>" method="post"> 
                        <button type="submit" name="Add" class="btn btn-primary">Add to Favorites</button>
                    </form>
                    <?php } ?>

                        
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


                           
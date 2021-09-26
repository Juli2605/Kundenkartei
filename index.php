<?php
    require_once("includes/DB.php");

    require_once("includes/Functions.php");

    require_once("includes/Sessions.php");

Confirm_Login();
Confirm_Master(); 
?>
<?php
    if(isset($_GET["page"])){
        $Page=$_GET["page"];
                            
        $ShowArtWorkFrom=($Page*4)-4;
        $sql="SELECT DISTINCT artists.LastName, artists.FirstName, artists.ArtistID, artworks.ArtWorkID, artworks.YearOfWork, artworks.ImageFileName, artworks.Title ,reviews.Rating, artworks.Description
        FROM artworks 
        INNER JOIN artists ON artists.ArtistID=artworks.ArtistID 
        INNER JOIN reviews ON reviews.ArtWorkId=artworks.ArtWorkID 
        WHERE reviews.Rating='5'
        -- GROUP BY ArtWorkID
        ORDER BY YearOfWork desc LIMIT $ShowArtWorkFrom,4";
        $stmt=$ConectingDB->query($sql);
    }
    else{
        Redirect_to("index.php?page=1");
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
        <link href="https://fonts.googleapis.com/css2?family=Arimo&family=Josefin+Sans:wght@100&family=Lobster&family=Noto+Serif:ital@1&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/Styles.css">
        
        <style>
            h4 {
                font-family: 'Noto Serif', serif;
            }
            h1 {
                font-family: 'Lobster', cursive;
            }
        </style>
        
        <title>Art Gallery Home Page</title>

    </head>

    <body>
       
        <?php include("nav.php") ; ?>
        <header class="bg-dark text-white py-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1><i class="fas fa-palette " style="color:rgb(106, 216, 17)"></i></i> Our Artworks</h1>
                    </div>
                </div>
            </div>
        </header>

        <!--Header End-->        
        <div class="container">
            <div class="row mt-4">
                <!--Main Area-->
                <div class="col-sm-8">
                    
                        <?php
                    echo ErrorMessage();
                    echo SuccessMessage();
                ?> 
                <h1 >The best rated Artworks</h1>
                    <h1 class="lead">Our Suggestions</h1>
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
                            $Rating=$DataRows["Rating"];
                        ?>
                        <div class="card">
                                <img src="images/works/average/<?php echo htmlentities ($Image) ; ?>" style="" class="img-fluid card-img-top">
                                <div class="card-body">
                                    <h4 class="card-title"><?php echo htmlentities ($Title) ; ?></h4>
                                    <small class="text-muted">By <a href="FullArtist.php?id=<?php echo $artistId ; ?>"><?php echo $ArtistF." ".$ArtistL ; ?></a> On <?php echo $Year ; ?></small>
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
                        <!-- Pagination -->
                        <nav>
                            <ul class="pagination pagination-lg">
                            <?php if (isset ($Page)){
                                    if($Page>1){ 
                                    ?>
                                        <li class="page-item">
                                            <a href="index.php?page=<?php echo $Page-1 ; ?>" class="page-link">&laquo;</a> 
                                        </li>
                                <?php } } ?>
                                <?php
                                    global $ConectingDB;
                                    $sql="SELECT count( Distinct reviews.ArtWorkId) AS DATAOBJECT_NUM
                                    FROM reviews
                                    WHERE reviews.Rating = '5'";
                                    $stmt=$ConectingDB->query($sql);
                                    $RowPagination=$stmt->fetch();
                                    $TotalArtworks=array_shift($RowPagination);
                                    //echo $TotalArtworks;
                                    $PostPagination=$TotalArtworks/4;
                                    $PostPagination=ceil($PostPagination);
                                    for($i=1; $i<= $PostPagination; $i++){
                                         if(isset($Page)) { 
                                            if($i==$Page){ ?>
                                                <li class="page-item active">
                                                    <a href="index.php?page=<?php echo $i ; ?>" class="page-link"><?php echo $i ; ?></a> 
                                                </li>
                                            <?php 
                                            } else {
                                            ?>
                                            <li class="page-item">
                                                <a href="index.php?page=<?php echo $i ; ?>" class="page-link"><?php echo $i ; ?></a> 
                                            </li>
                                            <?php } 
                                            }
                                         }
                                            ?>
                                <?php if (isset ($Page)){
                                    if($Page+1<= $PostPagination){ 
                                    ?>
                                        <li class="page-item">
                                            <a href="index.php?page=<?php echo $Page+1 ; ?>" class="page-link">&raquo;</a> 
                                        </li>
                                <?php } } ?>
                            </ul>
                        </nav>
                </div>
                <!--Main Area End-->
                <!--Side Area-->
                <div class="col-sm-4 ">
                    <div class="card mt-4">
                        <div class="card-body">
                            <div class="text-center">
                                <h4>Art enables us to find ourselves and lose ourselves at the same time</h4>
                            </div>
                        </div>
                    </div>
                    <br>
                    <?php if(!Confirm_Login()&&!Confirm_Master()&&!Confirm_Admin()){ ?>
                    <div class="card-header bg-dark text-light">
                        <h2 class="lead"> Sign Up!</h2>
                    </div>
                    <div class="card-body ">
                        <a href="RegisterCustomer.php"><button type="submit" class="btn btn-success btn-block text-center text-white" name="button"> Register </button></a>
                        <br>
                        <a href="Login.php"><button type="submit" class="btn btn-info btn-block text-center text-white" name="button">Login</button></a>
                    </div>
                    <?php } ?>
                      <div class="card ">
                        <div class="card-header">
                            <h2 class="lead">Visit Us in Germany</h2>
                        </div>
                        <div class="card-body">
                        <div class="row">
                            <?php
                            global $ConectingDB;
                            $sql="SELECT * FROM galleries WHERE galleries.GalleryCountry='Germany'";
                            $stmt=$ConectingDB->query($sql);
                            while ($DataRows=$stmt->fetch()){
                                $galleryCity=$DataRows["GalleryCity"];
                                $galleryName=$DataRows["GalleryName"];
                                $galleryWebsite=$DataRows["GalleryWebSite"];
                            ?>
                            
                            <div class="col-6" >
                            
                            <div  class="shadow p-2 mb-2 bg-white rounded h-90 w-90 text-center " style="height:150px;" >
                                <img class="fas fa-store text-primary" src="" alt=""> 
                                <p><a href= "<?php echo $galleryWebsite ; ?>"><?php echo $galleryName."-".$galleryCity ; ?></a></p>
                            </div>
                             
                            </div> 
                            
                            <?php } ?>
                            </div>

                            
                        </div>
                      </div>  
                </div>
                <!--Side Area End-->
            </div>
        </div>

        <!--Footer-->
        <?php include("footer.php"); ?>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script> 
        <script>
            $('#year').text(new Date().getFullYear());
        </script>
    </body>
    </html>
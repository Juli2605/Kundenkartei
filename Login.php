<?php
    require_once("includes/DB.php");
?>
<?php
    require_once("includes/Functions.php");
?>
<?php
    require_once("includes/Sessions.php");
?>
<?php
if (isset($_SESSION["User_ID"])){
    Redirect_to("index.php");
}
if(isset($_POST["Submit"])){
    $UserName=$_POST["Username"];
    $Password=$_POST["Password"];
    if(empty($UserName)||empty($Password)){
        $_SESSION["ErrorMessage"]="All Fields must be filled out";
        Redirect_to("Login.php");

    }
    else{
        $Found_Account=Login_Attempt($UserName,$Password);
        $Found_Master=Master_Login($UserName,$Password);
        $Found_Admin=Admin_Login($UserName,$Password);
         if($Found_Master){
            $_SESSION["Master_ID"]=$Found_Master["CustomerID"];
            $_SESSION["Username"]=$Found_Master["UserName"];
            $_SESSION["CustomerName"]=$Found_Master["FirstName"];
            $_SESSION["CustomerLastName"]=$Found_Master["LastName"];
            $_SESSION["SuccessMessage"]="Welcome Master ".$_SESSION["CustomerName"]." ".$_SESSION["CustomerLastName"];
            Redirect_to("index.php");

        }
        if($Found_Admin){
            $_SESSION["Admin_ID"]=$Found_Admin["CustomerID"];
            $_SESSION["Username"]=$Found_Admin["UserName"];
            $_SESSION["CustomerName"]=$Found_Admin["FirstName"];
            $_SESSION["CustomerLastName"]=$Found_Admin["LastName"];
            $_SESSION["SuccessMessage"]="Welcome Admin ".$_SESSION["CustomerName"]." ".$_SESSION["CustomerLastName"];
            Redirect_to("index.php");

        }
        if($Found_Account){
            $_SESSION["User_ID"]=$Found_Account["CustomerID"];
            $_SESSION["Username"]=$Found_Account["UserName"];
            $_SESSION["CustomerName"]=$Found_Account["FirstName"];
            $_SESSION["CustomerLastName"]=$Found_Account["LastName"];
            $_SESSION["SuccessMessage"]="Welcome ".$_SESSION["CustomerName"]." ".$_SESSION["CustomerLastName"];
            Redirect_to("index.php");

        }
        else{
            $_SESSION["ErrorMessage"]="Incorrect Username or Password";
            Redirect_to("Login.php");
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
        <title>Login</title>

    </head>

    <body>
        <!--NAVBAR-->
        <div style ="height: 10px; background:lightgreen;"></div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a href="#" class="navbar-brand"> artgallery.com</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarcollapseAG"aria-controls="navbarcollapseAG" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarcollapseAG">
                    
                </div>
            </div>
        </nav>
        <div style ="height: 10px; background:lightgreen;"></div>
        <!--NAV END-->
        
        <!--Header-->
        <header class="bg-dark text-white py-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        

                    </div>
                </div>
            </div>
        </header>
       
        <!--Header End-->
        <!--Main Area-->
        <br><br><br>
        <section class="container py-2 mb-4">
            <div class="row">
                <div class="offset-sm-3 col-sm-6">
                    <?php 
                        echo ErrorMessage();
                        echo SuccessMessage();
                    ?>
                        <div class="card bg-secondary text-light">
                            
                            <div class="card-header">
                                <h4>Welcome Back! </h4>
                            </div>
                                <div class="card-body bg-dark">

                                
                                <form action="Login.php" method="post">
                                    <div class="form-group">
                                        <label for="username"><span class="FieldInfo">Username:</span></label>
                                        <div class="input-group" mb-3>
                                            <div class="input-group-prepend">
                                                <span class="input-group-text text-white bg-info"><i class="fas fa-user"></i> </span>

                                            </div>
                                            <input type="text" class="form-control" name="Username" id="username" value="">


                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password"><span class="FieldInfo">Password:</span></label>
                                        <div class="input-group" mb-3>
                                            <div class="input-group-prepend">
                                                <span class="input-group-text text-white bg-info"><i class="fas fa-lock"></i> </span>

                                            </div>
                                            <input type="password" class="form-control" name="Password" id="password" value="">


                                        </div>
                                    </div>
                                    <button type="submit" name="Submit" class="btn btn-info btn-block">
                                            <i class="fas fa-arrow-check"></i>Login
                                        </button>
                                </form>
                                <h5 class="pt-4">Dont Have an Account? <a href="RegisterCustomer.php">Register Here.</a></h5>

                            </div>

                        </div>
                </div>

            </div>

        </section>
        <br><br><br>
        <!--Main Area End-->
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
<?php
    require_once("includes/DB.php");
?>
<?php
    require_once("includes/Functions.php");
?>
<?php
    require_once("includes/Sessions.php");
    Confirm_Login(); 
    Confirm_Master();
    Confirm_Admin();
    
?>
<?php $CustomerIdFromUrl = $_GET["id"]; ?>
<?php
    
    
    if(isset($_POST["Submit"])){
        
        $firstName=$_POST["firstname"];
        $lastName=$_POST["lastname"];
        $Email=$_POST["email"];
        $username=$_POST["username"];
        $password=$_POST["Password"];
        $confirmpassword=$_POST["ConfirmPassword"];
        $address=$_POST["address"];
        $phone=$_POST["phone"];
        $city=$_POST["city"];
        date_default_timezone_set("Europe/Berlin");
        $CurrentTime=time();
        $DateTime=strftime("%Y-%m-%d %H:%M:%S", $CurrentTime);

        if(empty($firstName)||empty($lastName)||empty($Email)||empty($username)||empty($password)||empty($confirmpassword)){
            $_SESSION["ErrorMessage"]="All fields must be filled out";
            Redirect_to("UpdateUser.php?id={$CustomerIdFromUrl}");

        }
        elseif(strlen($firstName||$lastName||$Email||$password)>50){
            $_SESSION["ErrorMessage"]="Each field should be less than 51 characters";
            Redirect_to("UpdateUser.php?id={$CustomerIdFromUrl}");
        }
        elseif($password !== $confirmpassword){
            $_SESSION["ErrorMessage"]="Passwords not matching";
            Redirect_to("UpdateUser.php?id={$CustomerIdFromUrl}");
        }
        // elseif(CheckUserNameExists($username)){
        //     $_SESSION["ErrorMessage"]="Username taken! Try Another One.";
        //     Redirect_to("RegisterCustomer.php");
        //}
        else{
            
            
            
            //ALTER TABLE customers ALTER COLUMN CustomerID AUTO_INCREMENT
            // ALTER TABLE customerlogon AUTO_INCREMENT=70
            // ALTER TABLE  customers AUTO_INCREMENT=70
            $sql ="UPDATE  customers, customerlogon 
                SET FirstName =:firstname, LastName=:lastname, Email=:email, Address=:address, City=:city , Phone=:phone, UserName=:userName, Pass=:pass, DateLastModified=:date
                WHERE customers.CustomerID=$CustomerIdFromUrl AND
                customerlogon.CustomerID=$CustomerIdFromUrl
                
             ";
             
            
            
            $stmt= $ConectingDB->prepare($sql);
           
            $stmt->bindValue(':firstname',$firstName);
            $stmt->bindValue(':lastname',$lastName);
            $stmt->bindValue(':email',$Email);
            $stmt->bindValue(':userName',$username);
            $stmt->bindValue(':pass',$password);
            $stmt->bindValue(':address',$address);
            $stmt->bindValue(':city',$city);
            $stmt->bindValue(':phone',$phone);
            $stmt->bindValue(':date',$DateTime);
            
            $Execute=$stmt->execute();
            
        

            if($Execute){
                $_SESSION["SuccessMessage"]="User Updated ";
                Redirect_to("ManageUsers.php");
            }
            else{
                $_SESSION["ErrorMessage"]="Something Went Wrong. Try Again!";
                Redirect_to("UpdateUser.php?id={$CustomerIdFromUrl}");
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
        <title>Update</title>

    </head>

    <body>

        <!--NAV END-->
        
        <!--Header-->
        <header class="bg-dark text-white py-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1><i class="fas fa-register " style="color:rgb(106, 216, 17)"></i></i>Update</h1>
                    </div>
                </div>
            </div>
        </header>
       
        <!--Header End-->

        <!--Main-->
        <section class="container py-2 mb-4">
            <div class="row">
                <div class="offset-lg-1 col-lg-10" style="min-height:400px">
                    <form class="" action="UpdateUser.php?id=<?php echo $CustomerIdFromUrl; ?> " method="post">
                       
                        <?php 
                        echo ErrorMessage();
                        echo SuccessMessage();
                        ?>
                        <div class="card bg-secondary text-light mb-3">
                            <div class="card-header">
                                <h1>Update Credentials</h1>
                            </div>
                            <?php
                            global $ConectingDB;
                            $custidfromurl=$_GET["id"];
                            $sql="SELECT *
                            FROM customerlogon 
                            LEFT JOIN customers ON customerlogon.CustomerID=customers.CustomerID
                            WHERE customerlogon.CustomerID=$custidfromurl";
                                
                            $stmt=$ConectingDB->query($sql);
                            
                            
                                
                            while($DataRows=$stmt->fetch()){
                                $customerId=$DataRows["CustomerID"];
                                $firstName=$DataRows["FirstName"];
                                $lastName=$DataRows["LastName"];
                                $username=$DataRows["UserName"];
                                $password=$DataRows["Pass"];
                                $address=$DataRows["Address"];
                                $city=$DataRows["City"];
                                $phone=$DataRows["Phone"];
                                $email=$DataRows["Email"];


                            ?>
                            <div class="card-body bg-dark">
                                <div class="form-group">
                                    <label for="firstname"><span class="FieldInfo">First Name</span></label>
                                    <input class="form-control" type="text" name="firstname" id="fName" placeholder="Type Your First Name here" value="<?php echo $firstName ; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="lastname"><span class="FieldInfo">Last Name</span></label>
                                    <input class="form-control" type="text" name="lastname" id="lName" placeholder="Type Your Last Name here" value="<?php echo $lastName ; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="email"><span class="FieldInfo">Email</span></label>
                                    <input class="form-control" type="text" name="email" id="e-mail" placeholder="Type Your Email here" value="<?php echo $email ; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="address"><span class="FieldInfo">Address</span></label>
                                    <input class="form-control" type="text" name="address" id="Address" placeholder="Type Your Address here" value="<?php echo $address ; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="city"><span class="FieldInfo">City</span></label>
                                    <input class="form-control" type="text" name="city" id="City" placeholder="Type Your City here" value="<?php echo $city ; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="phone"><span class="FieldInfo">Phone Number</span></label>
                                    <input class="form-control" type="text" name="phone" id="Phone" placeholder="Type Your Phone Number here" value="<?php echo $phone; ?>">
                                </div>
                                    <label for="username"><span class="FieldInfo">Username</span></label>
                                    <input class="form-control" type="text" name="username" id="uname" placeholder="Type Username here" value="<?php echo $username; ?>">
                                <div class="form-group">
                                    <label for="Password"><span class="FieldInfo">Password</span></label>
                                    <input class="form-control" type="password" name="Password" id="pass" placeholder="Type password here" value="<?php echo $password ; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="ConfirmPassword"><span class="FieldInfo">Confirm Password</span></label>
                                    <input class="form-control" type="password" name="ConfirmPassword" id="confpass" placeholder="Confirm password here" value="<?php echo $password ; ?>">
                                </div>
                                <?php } ?>
                                <div class="row" >
                                    <div class="col-lg-12 mb-2">
                                        <button type="submit" name="Submit" class="btn btn-success btn-block">
                                            <i class="fas fa-arrow-check"></i>Update
                                        </button>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>

                    </form>
                </div>

            </div>

        </section>

        <!--Main End-->

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
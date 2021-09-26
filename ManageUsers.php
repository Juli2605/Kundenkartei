<!-- ALTER TABLE `customerlogon` ADD `Admin` VARCHAR(50) NULL DEFAULT NULL AFTER `DateLastModified`; -->
<!-- UPDATE `customerlogon` SET `Admin` = 'Master' WHERE `customerlogon`.`CustomerID` = 106; -->
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

<?php 


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
        <title>Manage Users</title>

    </head>

    <body>
        <!--NAVBAR-->
        <?php include("nav.php");?>
        <!--NAV END-->
        
        <!--Header-->
        <header class="bg-dark text-white py-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1><i class="fas fa-users-cog " style="color:rgb(106, 216, 17)"></i></i> Manage Users</h1>
                    </div>
                </div>
            </div>
        </header>
        <?php 
            echo ErrorMessage();
            echo SuccessMessage();
        ?>
        
       
        <!--Header End-->
        
        <!-- <div class="container"> -->
            <!-- <div class="row mt-4"> -->
                <!--Main Area-->
                <!-- <div class="col-sm-12"> -->
                <?php if (Confirm_Master()){ ?>
                <h3>Administrators</h3>
                <table class="table table-striped table-hover">
                            <thead class="thead-dark ">
                                <tr>
                                    <th>Customer ID</th>
                                    <th>Username</th>
                                    <th>Password</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Address</th>
                                    <th>City</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                
                    <?php
                        global $ConectingDB;
                        
                           
                        $sql="SELECT *
                        FROM customerlogon 
                        LEFT JOIN customers ON customerlogon.CustomerID=customers.CustomerID
                        WHERE Admin ='Admin' ";
                            
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
                        
                        <tbody>
                            <tr>
                                <td ><?php echo $customerId; ?></td>
                                <td><?php echo $username; ?></td>
                                <td><?php echo $password; ?></td>
                                <td><?php echo $firstName; ?> </td>
                                <td><?php echo $lastName;  ?></td>
                                <td><?php echo $address; ?></td>
                                <td><?php echo $city; ?></td>
                                <td><?php echo $phone ; ?> </td>
                                <td><?php echo $email;  ?></td>
                                <td>
                                <form class="" action="ManageUsers.php" method="post"> 
                                        <a href="delete.php?id=<?php echo $customerId ; ?>" style="float:right;">
                                        <span class="btn btn-danger">Delete User</span>
                                        </a>
                                </form>
                                </td>
                                <td>
                                <form class="" action="ManageUsers.php" method="post">
                                        <a href="UpdateUser.php?id=<?php echo $customerId ; ?>" style="float:right;">
                                        <span class="btn btn-success">Update Admin</span>
                                        </a>
                                </form>
                                </td>
                                <td>
                                <form class="" action="ManageUsers.php" method="post">
                                        <a href="RemoveAdminRights.php?id=<?php echo $customerId ; ?>" style="float:right;">
                                        <span class="btn btn-warning">Remove Rights</span>
                                        </a>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                        <?php } ?>
                    </table>
                    <?php } ?>
                
                <h3>Customers</h3>
                    <table class="table table-striped table-hover">
                            <thead class="thead-dark ">
                                <tr>
                                <th >Customer ID</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Address</th>
                                <th>City</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                </tr>
                            </thead>
                
                    <?php
                        global $ConectingDB;
                        
                           
                        $sql="SELECT *
                        FROM customerlogon 
                        LEFT JOIN customers ON customerlogon.CustomerID=customers.CustomerID
                        WHERE Admin IS NULL ";
                            
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
                        
                        <tbody>
                            <tr>
                                <td><?php echo $customerId; ?></td>
                                <td><?php echo $username; ?></td>
                                <td><?php echo $password; ?></td>
                                <td><?php echo $firstName; ?> </td>
                                <td><?php echo $lastName;  ?></td>
                                <td><?php echo $address; ?></td>
                                <td><?php echo $city; ?></td>
                                <td><?php echo $phone ; ?> </td>
                                <td><?php echo $email;  ?></td>
                                <td>
                                    <form class="" action="ManageUsers.php" method="post"> 
                                        <a href="delete.php?id=<?php echo $customerId ; ?>" style="float:right;">
                                        <span name ="Delete" class="btn btn-danger">Delete User</span>
                                        </a>
                                    </form>
                                    </td>
                                    <td>
                                    <form class="" action="ManageUsers.php" method="post">
                                        <a href="UpdateUser.php?id=<?php echo $customerId ; ?>" style="float:right;">
                                        <span class="btn btn-success">Update User</span>
                                        </a>
                                    </form>
                                    </td>
                                    <?php if(Confirm_Master()){ ?>
                                    <td>
                                    <form class="" action="ManageUsers.php" method="post">
                                        <a href="AdminRights.php?id=<?php echo $customerId ; ?>" style="float:right;">
                                        <span class="btn btn-info">Give Rights</span>
                                        </a>
                                    </form>
                                </td>
                                <?php } ?>
                            </tr>
                        </tbody>
                        <?php } ?>
                    </table>
                <!-- </div> -->
                <!--Main Area End-->
                <!--Side Area-->
                
                <!--Side Area End-->
            <!-- </div> -->
        <!-- </div> -->

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
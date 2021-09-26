<?php
    require_once("includes/DB.php");

    function Redirect_to($New_Location){
        header("Location:".$New_Location);
        exit;
    }
    function CheckUserNameExists($username){
        global $ConectingDB;
        $sql="SELECT UserName FROM customerlogon WHERE username=:userName";
        $stmt =$ConectingDB->prepare($sql);
        $stmt->bindValue('userName',$username);
        $stmt->execute();
        $Result=$stmt->rowcount();
        if($Result==1){
            return true;
        }else{
            return false;
        }
    }
    function Login_Attempt($UserName,$Password){
        global $ConectingDB;
        $sql="SELECT  *
        FROM customerlogon 
        INNER JOIN customers ON customerlogon.CustomerID=customers.CustomerID
        WHERE UserName=:userName AND Pass= :passWord AND Admin IS NULL LIMIT 1";
        $stmt=$ConectingDB->prepare($sql);
        $stmt->bindValue(':userName',$UserName);
        $stmt->bindValue(':passWord',$Password);
        $stmt->execute();
        $Result=$stmt->rowcount();
        if($Result==1){
            return $Found_Account=$stmt->fetch();
        }
        else{
            return null;
        }
    }
    function Confirm_Login(){
        if(isset($_SESSION["User_ID"])){
            return true;
        }
        // else{
        // $_SESSION["ErrorMessage"]="Login Required!";
        // Redirect_to("Login.php");
        // }
    }
    
    
     function Master_Login($UserName,$Password){
        global $ConectingDB;
        $sql="SELECT  *
        FROM customerlogon 
        INNER JOIN customers ON customerlogon.CustomerID=customers.CustomerID
        WHERE UserName=:userName AND Pass= :passWord AND Admin='Master' LIMIT 1";
        $stmt=$ConectingDB->prepare($sql);
        $stmt->bindValue(':userName',$UserName);
        $stmt->bindValue(':passWord',$Password);
        $stmt->execute();
        $Result=$stmt->rowcount();
        if($Result==1){
            return $Found_Master=$stmt->fetch();
        }
        else{
            return null;
        }

    } 
    function Confirm_Master(){
        if(isset($_SESSION["Master_ID"])){
            return true;
        }
    }
        function Admin_Login($UserName,$Password){
            global $ConectingDB;
            $sql="SELECT  *
            FROM customerlogon 
            INNER JOIN customers ON customerlogon.CustomerID=customers.CustomerID
            WHERE UserName=:userName AND Pass= :passWord AND Admin='Admin' LIMIT 1";
            $stmt=$ConectingDB->prepare($sql);
            $stmt->bindValue(':userName',$UserName);
            $stmt->bindValue(':passWord',$Password);
            $stmt->execute();
            $Result=$stmt->rowcount();
            if($Result==1){
                return $Found_Admin=$stmt->fetch();
            }
            else{
                return null;
            }
    
        } 
        function Confirm_Admin(){
            if(isset($_SESSION["Admin_ID"])){
                return true;
            }
        }
    function CountComments($Id){
    global $ConectingDB;
    $sql=" SELECT COUNT(*) FROM reviews WHERE ArtWorkId=$Id AND Favorite IS NULL ";
    $stmt = $ConectingDB->query($sql);
    $RowsTotal=$stmt->fetch();
    $Total= array_shift($RowsTotal);
    return $Total;
    }
    function Confirm_Favorite($SearchQueryParameter,$CustomerID){
        global $ConectingDB;
        $sql="SELECT CustomerId, ArtWorkId, Favorite  FROM reviews 
        WHERE ArtWorkId=:artworkId AND CustomerId=:customerId AND Favorite='1' LIMIT 1";
        $stmt=$ConectingDB->prepare($sql);
        $stmt->bindValue(':artworkId',$SearchQueryParameter);
        $stmt->bindValue(':customerId',$CustomerID);
        $stmt->execute();
        $Result=$stmt->rowcount();
        if($Result==1){
            return true;
        }
        else{
            return false;
        }

    }
?>
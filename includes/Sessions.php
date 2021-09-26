<?php
session_start();

function ErrorMessage(){
    if(isset($_SESSION["ErrorMessage"])){
        $Output="<div class=\"alert alert-danger\">";
        $Output .= htmlentities($_SESSION['ErrorMessage']);
        $Output .="</div>";
        $_SESSION["ErrorMessage"]= null;
        return $Output;

    }
}
function SuccessMessage(){
    if(isset($_SESSION["SuccessMessage"])){
        $Output="<div class=\"alert alert-success\">";
        $Output .= htmlentities($_SESSION['SuccessMessage']);
        $Output .="</div>";
        $_SESSION["SuccessMessage"]= null;
        return $Output;
        
    }
}
function InfoMessage(){
    if(isset($_SESSION["InfoMessage"])){
        $Output="<div class=\"alert alert-info\">";
        $Output .= htmlentities($_SESSION['InfoMessage']);
        $Output .="</div>";
        $_SESSION["InfoMessage"]= null;
        return $Output;
        
    }
}

?>
<?php 
    
    if(empty($_SESSION['authorized']) || $_SESSION['authorized'] == false){
        $_SESSION['error_message'] = "Please login first";
        header("Location: ../");
        exit;
    };
?>
<?php 
    require_once '../db.php';

    $brand = $_POST['name'];

    $sql = "INSERT INTO brands(brand) VALUES ('$brand');";
    
    if($conn->query($sql)){
        echo json_encode($conn->insert_id);
    }else{
        echo json_encode($conn->error);    
    }
?>
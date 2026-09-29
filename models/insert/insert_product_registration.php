<?php 
    require_once '../db.php';

    $product_name = $_POST['name'];

    $sql = "INSERT INTO product_registrations(product_name) VALUES ('$product_name');";
    
    if($conn->query($sql)){
        echo json_encode($conn->insert_id);
    }else{
        echo json_encode($conn->error);    
    }
?>
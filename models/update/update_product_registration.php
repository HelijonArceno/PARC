<?php 
    require_once '../db.php';

    $id                         = $_POST['id'];
    $product_name               = $_POST['name'];

    $sql = "UPDATE product_registrations SET
    product_name = '$product_name' WHERE product_registration_id = '$id'";
    
    if($conn->query($sql)){
        echo json_encode('success');
    }else{
        echo json_encode($conn->error);    
    }
?>
<?php 
    require_once '../db.php';

    $new_product_registration_id    = $_POST['new_id'];
    $existing_product_registration_id    = $_POST['existing_id'];

    $sql = "UPDATE inventory SET
    product_registration_id = '$new_product_registration_id' WHERE product_registration_id = '$existing_product_registration_id'";
    
    if($conn->query($sql)){
        echo json_encode('merged product name');
    }else{
        echo json_encode($conn->error);    
    }
?>
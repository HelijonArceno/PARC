<?php 
    require_once '../db.php';

    $product_code = $_POST['product_code'];
    $quantity = $_POST['quantity'];
    $expiry = $_POST['expiry'];
    $account_id = $_POST['account_id'];

    $sql = "CALL sp_stock_in('$product_code','$quantity','$expiry','$account_id')";
    
    if($conn->query($sql)){
        echo json_encode($conn->insert_id);
    }else{
        echo json_encode($conn->error);    
    }
?>
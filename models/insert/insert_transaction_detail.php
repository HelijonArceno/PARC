<?php 
    require_once '../db.php';

    $transaction_id = $_POST['transaction_id'];
    $product_code = $_POST['product_code'];
    $quantity = $_POST['quantity'];
    $current_cost = $_POST['current_cost'];
    $current_price = $_POST['current_price'];
    


    $sql = "INSERT INTO transaction_details(transaction_id, product_code, current_cost, current_price, quantity) 
            VALUES ('$transaction_id','$product_code','$current_cost','$current_price','$quantity');";
    if($conn->query($sql)){
        echo json_encode($conn->insert_id);
    }else{
        echo json_encode($conn->error);    
    }
?>
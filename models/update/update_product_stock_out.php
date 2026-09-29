<?php 
    require_once '../db.php';

    $amount = $_POST['amount'];
    $product_code = $_POST['product_code'];

    $sql = "UPDATE inventory SET
    stock = stock - '$amount' 
    WHERE product_code = '$product_code'";
    
    if($conn->query($sql)){
        echo json_encode([
            'status' => 'success',
            'message' => 'Updated Stock Successfully!'
        ]);
    }else{
        echo json_encode([
            'status' => 'error',
            'message' => 'ERROR' . $conn->error
        ]);    
    }
?>
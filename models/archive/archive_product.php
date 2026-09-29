<?php 
    require_once '../db.php';

    $product_code   = $_POST['product_code'];

    $sql = "UPDATE inventory SET
    archived = 1 WHERE product_code = '$product_code'";
    
    if($conn->query($sql)){
        echo json_encode([
            "message" =>    'success',
            "status"  =>    'success'
        ]);
    }else{
        echo json_encode([
            "message" =>    $conn->error,
            "status"  =>    'error'
        ]);    
    }
?>
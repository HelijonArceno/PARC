<?php 
    require_once '../db.php';

    $product_code = $_GET['product_code'];
    
    $sql = "SELECT * FROM vw_inventory WHERE product_code = '$product_code'";
    $result = $conn->query($sql);

    if($result){
        echo json_encode($result->fetch_assoc());
    }else{
        echo json_encode($conn->error);
    }
?>
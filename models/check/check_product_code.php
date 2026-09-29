<?php 
    require_once '../db.php';

    $product_code = $_GET['name'];

    $sql = "SELECT * FROM inventory WHERE product_code = '$product_code'";
    $result = $conn->query($sql);

    if($result){
        if($result->num_rows > 0){
            echo json_encode($result->fetch_assoc());
        }else{
            echo json_encode('empty');
        }
        
    }else{
        echo json_encode('error');
    }
?>
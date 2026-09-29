<?php 
    require_once '../db.php';

    $product_name = $_GET['name'];

    $sql = "SELECT product_registration_id FROM product_registrations WHERE product_name = '$product_name'";
    $result = $conn->query($sql);

    if($result){
        if($result->num_rows > 0){
            echo json_encode($result->fetch_assoc());
        }else{
            echo json_encode('empty');
        }
        
    }else{
        echo json_encode('WHAT' + $conn->error);
    }
?>
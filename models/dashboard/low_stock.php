<?php 
    require_once '../db.php';

    $sql = "SELECT COUNT(product_code) AS kpi_data FROM inventory WHERE stock < reorder_level AND stock > 0;";
    $result = $conn->query($sql);

    if($result){
        echo json_encode($result->fetch_assoc());
    }else{
        echo json_encode($conn->error);
    }
?>
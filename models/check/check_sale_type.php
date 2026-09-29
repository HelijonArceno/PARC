<?php 
    require_once '../db.php';

    $sale_type = $_GET['sale_type'];

    $sql = "SELECT * FROM sale_types WHERE sale_type = '$sale_type'";
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
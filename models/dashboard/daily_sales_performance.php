<?php 
    require_once '../db.php';

    $yesterday   = $_GET['date'];
    $today       = $_GET['date_end'];

    $sql = "CALL daily_sales_performance('$yesterday','$today')";
    $result = $conn->query($sql);

    if($result){
        echo json_encode($result->fetch_assoc());
    }else{
        echo json_encode($conn->error);
    }
?>
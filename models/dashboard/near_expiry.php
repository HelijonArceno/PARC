<?php 
    require_once '../db.php';

    $date       = $_GET['date'];
    $date_end   = $_GET['date_end'];

    $sql = "SELECT SUM(quantity) AS kpi_data FROM stock_entries WHERE expiry > '$date' AND expiry < '$date_end'";
    $result = $conn->query($sql);

    if($result){
        echo json_encode($result->fetch_assoc());
    }else{
        echo json_encode($conn->error);
    }
?>
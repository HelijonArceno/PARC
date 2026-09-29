<?php 
    require_once '../db.php';
    
    $date = $_GET['date'];

    $sql = "SELECT SUM(total_profit) AS kpi_data FROM transactions WHERE date = '$date'";
    $result = $conn->query($sql);

    if($result){
        echo json_encode($result->fetch_assoc());
    }else{
        echo json_encode($conn->error);
    }
?>
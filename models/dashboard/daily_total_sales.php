<?php 
    require_once '../db.php';
    
    $date = $_GET['date'];

    $sql = "SELECT SUM(td.current_price * td.quantity) AS kpi_data FROM transaction_details td INNER JOIN transactions t ON t.transaction_id = td.transaction_id WHERE t.date = '$date'";
    $result = $conn->query($sql);

    if($result){
        echo json_encode($result->fetch_assoc());
    }else{
        echo json_encode($conn->error);
    }
?>
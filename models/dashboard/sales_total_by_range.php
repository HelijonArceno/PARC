<?php 
    require_once '../db.php';

    $date_start = $_GET['start'];
    $date_end = $_GET['end'];

    $sql = "SELECT SUM(td.current_price * td.quantity) AS totaL_sales FROM transaction_details td INNER JOIN transactions t ON t.transaction_id = td.transaction_id WHERE t.date BETWEEN '$date_start' AND '$date_end'";
    $result = $conn->query($sql);

    if($result){
        echo json_encode($result->fetch_assoc());
    }else{
        echo json_encode($conn->error);
    }
?>
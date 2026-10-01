<?php 
    require_once '../db.php';

    $dates   = $_GET['date'];
    $str_dates = "'" . implode("','",$dates) . "'";

    $sql = "SELECT SUM(td.current_price * td.quantity) AS totaL_sales FROM transaction_details td INNER JOIN transactions t ON t.transaction_id = td.transaction_id WHERE t.date IN ($str_dates)";
    $result = $conn->query($sql);

    if($result){
        echo json_encode($result->fetch_assoc());
    }else{
        echo json_encode($conn->error);
    }
?>
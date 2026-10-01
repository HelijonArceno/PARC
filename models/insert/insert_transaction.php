<?php 
    require_once '../db.php';

    // $total_sales = $_POST['total_sale'];
    // $total_profit = $_POST['total_profit'];
    $tendered_amount = $_POST['tendered_amount'];
    $change_amount = $_POST['change_amount'];
    $account_id = $_POST['account_id'];

    $sql = "INSERT INTO transactions(tendered_amount, change_amount, account_id) VALUES ('$tendered_amount','$change_amount','$account_id');";
    
    if($conn->query($sql)){
        echo json_encode($conn->insert_id);
    }else{
        echo json_encode($conn->error);    
    }
?>
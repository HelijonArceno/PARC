<?php 
    require_once '../db.php';

    $amount = $_POST['amount'];
    $charge = $_POST['charge'];
    $account_id = $_POST['account_id'];

    $sql = "INSERT INTO top_ups (amount,charge,account_id) VALUES ('$amount', '$charge', '$account_id')";

    if($conn->query($sql)){
        echo json_encode([
            'status' => 'success',
            'message' => 'Top-up record Inserted!'
        ]);
    }else{
        echo json_encode([
            'status' => 'error',
            'message' => 'ERROR' . $conn->error
        ]);    
    }
?>
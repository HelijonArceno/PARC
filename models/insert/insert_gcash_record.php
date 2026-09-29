<?php 
    require_once '../db.php';

    $amount = $_POST['amount'];
    $charge = $_POST['charge'];
    $type = $_POST['type'];
    $account_id = $_POST['account_id'];

    $sql = "INSERT INTO gcash_records (amount,charge,type,account_id) VALUES ('$amount', '$charge', '$type', '$account_id')";

    if($conn->query($sql)){
        echo json_encode([
            'status' => 'success',
            'message' => 'GCash record Inserted!'
        ]);
    }else{
        echo json_encode([
            'status' => 'error',
            'message' => 'ERROR' . $conn->error
        ]);    
    }
?>
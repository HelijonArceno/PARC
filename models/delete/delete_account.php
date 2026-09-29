<?php 
    require_once '../db.php';

    $id = $_POST['id'];

    $sql = "DELETE FROM accounts WHERE account_id = '$id'";
    
    if($conn->query($sql)){
        echo json_encode([
            "message" =>    'success',
            "status"  =>    'success'
        ]);
    }else{
        echo json_encode([
            "message" =>    $conn->error,
            "status"  =>    'error'
        ]);
    }
?>
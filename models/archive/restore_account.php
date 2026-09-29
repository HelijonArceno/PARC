<?php 
    require_once '../db.php';

    $id   = $_POST['id'];

    $sql = "UPDATE accounts SET
    archived = 0 WHERE account_id = '$id'";
    
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
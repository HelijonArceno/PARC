<?php 
    require_once '../db.php';

    $id = $_POST['id'];
    $username = $_POST['username'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $role_id = $_POST['role'];

    $sql = "UPDATE accounts SET
    username = '$username', 
    first_name = '$first_name', 
    last_name = '$last_name',
    role_id = '$role_id'
    WHERE account_id = '$id'";
    
    if($conn->query($sql)){
        echo json_encode('success');
    }else{
        echo json_encode($conn->error);    
    }
?>
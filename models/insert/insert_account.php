<?php 
    require_once '../db.php';

    $username = $_POST['username'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $password = $_POST['password'];
    $role_id = $_POST['role'];

    $sql = "INSERT INTO accounts(username, first_name, last_name, role_id, password) VALUES ('$username','$first_name','$last_name','$role_id','$password');";
    
    if($conn->query($sql)){
        echo json_encode($conn->insert_id);
    }else{
        echo json_encode($conn->error);    
    }
?>
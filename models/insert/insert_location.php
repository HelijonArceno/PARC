<?php 
    require_once '../db.php';

    $location = $_POST['name'];

    $sql = "INSERT INTO locations(location) VALUES ('$location');";
    
    if($conn->query($sql)){
        echo json_encode($conn->insert_id);
    }else{
        echo json_encode($conn->error);    
    }
?>
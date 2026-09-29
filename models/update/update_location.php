<?php 
    require_once '../db.php';

    $id                         = $_POST['id'];
    $location               = $_POST['name'];

    $sql = "UPDATE locations SET
    location = '$location' WHERE location_id = '$id'";
    
    if($conn->query($sql)){
        echo json_encode('success');
    }else{
        echo json_encode($conn->error);    
    }
?>
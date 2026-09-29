<?php 
    require_once '../db.php';

    $id                  = $_POST['id'];
    $brand               = $_POST['name'];

    $sql = "UPDATE brands SET
    brand = '$brand' WHERE brand_id = '$id'";
    
    if($conn->query($sql)){
        echo json_encode('success');
    }else{
        echo json_encode($conn->error);    
    }
?>
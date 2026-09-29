<?php 
    require_once '../db.php';

    $new_location_id    = $_POST['new_id'];
    $existing_location_id    = $_POST['existing_id'];

    $sql = "UPDATE inventory SET
    location_id = '$new_location_id' WHERE location_id = '$existing_location_id'";
    
    if($conn->query($sql)){
        echo json_encode('merged location');
    }else{
        echo json_encode($conn->error);    
    }
?>
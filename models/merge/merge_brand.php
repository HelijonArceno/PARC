<?php 
    require_once '../db.php';

    $new_brand_id    = $_POST['new_id'];
    $existing_brand_id    = $_POST['existing_id'];

    $sql = "UPDATE inventory SET
    brand_id = '$new_brand_id' WHERE brand_id = '$existing_brand_id'";
    
    if($conn->query($sql)){
        echo json_encode('merged brand');
    }else{
        echo json_encode($conn->error);    
    }
?>
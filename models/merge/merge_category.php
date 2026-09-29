<?php 
    require_once '../db.php';

    $new_category_id    = $_POST['new_id'];
    $existing_category_id    = $_POST['existing_id'];

    $sql = "UPDATE inventory SET
    category_id = '$new_category_id' WHERE category_id = '$existing_category_id'";
    
    if($conn->query($sql)){
        echo json_encode('merged category');
    }else{
        echo json_encode($conn->error);    
    }
?>
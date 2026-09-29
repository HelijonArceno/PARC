<?php 
    require_once '../db.php';

    $id                         = $_POST['id'];
    $category               = $_POST['name'];

    $sql = "UPDATE categories SET
    category = '$category' WHERE category_id = '$id'";
    
    if($conn->query($sql)){
        echo json_encode('success');
    }else{
        echo json_encode($conn->error);    
    }
?>
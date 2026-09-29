<?php 
    require_once '../db.php';

    $category = $_POST['name'];

    $sql = "INSERT INTO categories(category) VALUES ('$category');";
    
    if($conn->query($sql)){
        echo json_encode($conn->insert_id);
    }else{
        echo json_encode($conn->error);    
    }
?>
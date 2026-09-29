<?php 
    require_once '../db.php';

    $table          = $_POST['table'];
    $column_name    = $_POST['column'];
    $column_id      = $_POST['column_id'];
    $id             = $_POST['id'];
    $value          = $_POST['value'];

    $sql = "UPDATE $table SET
    $column_name = '$value' WHERE $column_id = '$id'";
    
    if($conn->query($sql)){
        echo json_encode('success');
    }else{
        echo json_encode($conn->error);    
    }
?>
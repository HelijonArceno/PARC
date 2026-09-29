<?php 
    require_once '../db.php';

    $sql = "SELECT * FROM gcash_types";
    $result = $conn->query($sql);
    $results = [];

    while($row = mysqli_fetch_assoc($result)){
        $results[] = $row;
    }

    if($result){
        echo json_encode($results);
    }else{
        echo json_encode($conn->error);
    }
?>
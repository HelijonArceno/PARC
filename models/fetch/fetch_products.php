<?php 
    require_once '../db.php';
    $archived = $_GET['archived'];

    $sql = "SELECT * FROM vw_inventory WHERE archived = $archived";
    
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
<?php 
    require_once '../db.php';

    $archived = $_GET['archived'];

    $sql = "SELECT account_id, username, first_name, last_name, role_id, archived FROM accounts WHERE account_id != 1 && archived = '$archived'";
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
<?php 
    require_once '../db.php';
    $search = $_GET['search'];

    $terms = explode(" ", $search);

    
    $sql = "SELECT * FROM vw_inventory WHERE archived = 0 AND stock > 0";
    
    foreach($terms as $term){
        $sql .= " AND (
        product_code LIKE '%$term%' OR
        product_name LIKE '%$term%' OR 
        brand LIKE '%$term%' OR 
        variant LIKE '%$term%' OR 
        size LIKE '%$term%' OR 
        category LIKE '%$term%' OR 
        location LIKE '%$term%' OR 
        cost LIKE '%$term%' OR 
        price LIKE '%$term%'
        )";
    }
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
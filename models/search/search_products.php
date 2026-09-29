<?php 
    require_once '../db.php';
    $filters = "";

    if(isset($_GET['category_id']) && $_GET['category_id'] != ""){
        $category_id = $_GET['category_id'];
        $filters .= " AND category_id = '$category_id'";
    }
    
    // $sql = "SELECT product_code, brand, product_name, variant, size, category, location, cost, price, stock, sale_type_id FROM `inventory` LEFT JOIN brands ON inventory.brand_id = brands.brand_id INNER JOIN product_registrations ON inventory.product_registration_Id = product_registrations.product_registration_id LEFT JOIN categories ON inventory.category_id = categories.category_id LEFT JOIN locations ON inventory.location_id = locations.location_id WHERE 1 = 1";
    $sql = "SELECT * FROM vw_inventory WHERE 1 = 1";
    $sql .= " $filters";

    if(isset($_GET['search'])){
        $search = $_GET['search'];
        $terms = explode(" ", $search);

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
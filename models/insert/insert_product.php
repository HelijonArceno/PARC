<?php 
    require_once '../db.php';

    $product_code               = $_POST['new_product_code'];
    $brand_id                   = $_POST['new_brand_id'];
    $product_registration_id    = $_POST['new_product_registration_id'];
    $variant                    = $_POST['new_variant'];
    $size                       = $_POST['new_size'];
    $category_id                = $_POST['new_category_id'];
    $cost                       = $_POST['new_cost'];
    $price                      = $_POST['new_price'];
    $location_id                = $_POST['new_location_id'];
    $sale_type_id               = $_POST['new_sale_type_id'];
    $unit_id                    = $_POST['new_unit_id'];

    if(empty($brand_id)){
        $brand_id = "NULL";
    }else{
        $brand_id = "'$brand_id'";
    }
    if(empty($location_id)){
        $location_id = "NULL";
    }else{
        $location_id = "'$location_id'";
    }
    if(empty($category_id)){
        $category_id = "NULL";
    }else{
        $category_id = "'$category_id'";
    }
    if(empty($unit_id)){
        $unit_id = "NULL";
    }else{
        $unit_id = "'$unit_id'";
    }
    if(empty($variant)){
        $variant = "NULL";
    }else{
        $variant = "'$variant'";
    }
    if(empty($size)){
        $size = "NULL";
    }else{
        $size = "'$size'";
    }

    $sql = "INSERT INTO inventory(product_code, brand_id, product_registration_id, variant, size, category_id, cost, price, location_id, sale_type_id, unit_id) 
    VALUES('$product_code', $brand_id, '$product_registration_id', $variant, $size, $category_id, '$cost', '$price', $location_id, '$sale_type_id', $unit_id)";
    
    if($conn->query($sql)){
        echo json_encode([
            'status' => 'success',
            'message' => 'Product Inserted!'
        ]);
    }else{
        echo json_encode([
            'status' => 'error',
            'message' => 'ERROR' . $conn->error
        ]);    
    }
?>
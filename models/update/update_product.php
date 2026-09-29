<?php 
    require_once '../db.php';

    $product_code_store      = $_POST['update_product_code_store'];
    $product_code            = $_POST['update_product_code'];
    $brand_id                = $_POST['update_brand_id'];
    $product_registration_id = $_POST['update_product_registration_id'];
    $variant                 = $_POST['update_variant'];
    $size                    = $_POST['update_size'];
    $category_id             = $_POST['update_category_id'];
    $cost                    = $_POST['update_cost'];
    $price                   = $_POST['update_price'];
    $location_id             = $_POST['update_location_id'];
    $sale_type_id            = $_POST['update_sale_type_id'];
    $unit_id                 = $_POST['update_unit_id'];

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

    $sql = "UPDATE inventory SET
    product_code = '$product_code', 
    product_registration_id = '$product_registration_id',
    variant = $variant,
    size = $size,
    brand_id = $brand_id,
    category_id = $category_id,
    cost = '$cost',
    price = '$price',
    location_id = $location_id,
    sale_type_id = '$sale_type_id',
    unit_id = $unit_id
    WHERE product_code = '$product_code_store'";
    
    if($conn->query($sql)){
        echo json_encode([
            'status' => 'success',
            'message' => 'Product Updated!'
        ]);
    }else{
        echo json_encode([
            'status' => 'error',
            'message' => 'ERROR' . $conn->error
        ]);    
    }
?>
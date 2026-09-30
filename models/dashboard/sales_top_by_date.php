<?php 
    require_once '../db.php';

    $dates   = $_GET['date'];
    $str_dates = "'" . implode("','",$dates) . "'";

    $sql = "SELECT
    i.product_code,
    b.brand,
    pr.product_name,
    i.variant,
    i.size,
    uom.unit,
    c.category,
    SUM(td.current_price * td.quantity) AS total_sales
FROM
    transaction_details td
INNER JOIN inventory i ON
    td.product_code = i.product_code
INNER JOIN product_registrations pr ON
    pr.product_registration_id = i.product_registration_Id
LEFT JOIN brands b ON
    b.brand_id = i.brand_id
INNER JOIN transactions t ON
    t.transaction_id = td.transaction_id
LEFT JOIN unit_of_measurements uom ON
    i.unit_id = uom.unit_id
LEFT JOIN categories c ON
    i.category_id = c.category_id
WHERE 
    t.date IN ($str_dates)
GROUP BY
    td.product_code
ORDER BY 
    SUM(td.current_price * td.quantity) DESC LIMIT 50";
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
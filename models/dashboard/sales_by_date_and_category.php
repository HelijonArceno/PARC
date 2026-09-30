<?php 
    require_once '../db.php';

    $dates   = $_GET['date'];
    $str_dates = "'" . implode("','",$dates) . "'";

    $sql = "SELECT 
        SUM(td.current_price * td.quantity) AS total_sales, 
        c.category 
    FROM transaction_details td 
    INNER JOIN inventory i 
        ON td.product_code = i.product_code 
    INNER JOIN categories c 
        ON c.category_id = i.category_id 
    INNER JOIN transactions t ON t.transaction_id = td.transaction_id
	WHERE t.date IN ($str_dates) GROUP BY c.category ORDER BY SUM(td.current_price * td.quantity) DESC";
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
<?php 
    session_start();
    require_once '../db.php';

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT account_id, username, first_name, last_name, ur.role as role FROM accounts a INNER JOIN user_roles ur ON a.role_id = ur.role_id WHERE username = '$username' AND password = '$password' AND archived = 0";
    $result = $conn->query($sql);

    if($result){

        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $_SESSION['authorized'] = true;
            $_SESSION['account_id'] = $row['account_id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['first_name'] = $row['first_name'];
            $_SESSION['last_name'] = $row['last_name'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['first_fname'] = strtoupper(substr($row['first_name'],0,1));
            $_SESSION['first_lname'] = strtoupper(substr($row['last_name'],0,1));

            echo json_encode([
                'message' => 'Account verified!',
                'status' => 'success'
            ]);
        }else{
            echo json_encode([
                'message' => 'Account does not exist!',
                'status' => 'unknown'
            ]);
        }
        
    }else{
        echo json_encode([
            'message' => $conn->error,
            'status' => 'error'
        ]);
    }
?>
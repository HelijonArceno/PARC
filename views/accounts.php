<?php 
    session_start();
    require('../models/authorization/check_authorization.php');
    if($_SESSION['role'] == 'Admin'){
    }else{
        $_SESSION['error_message'] = "Access Denied";
        header("Location: ../views/home_page.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PARC Store</title>
    <!-- ASSETS -->
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="stylesheet" href="../assets/modal_style.css">
    <script src="../assets/libraries/global.js"></script>
    <script src="../assets/libraries/universal_formatting.js" defer></script>
    <!-- GOOGLE ICONS -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
    <!-- DATATABLES and JQUERY -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.8/css/dataTables.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-4.0.0.js" integrity="sha256-9fsHeVnKBvqh3FB2HYu7g2xseAZ5MlN6Kz/qnkASV8U=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.3.8/js/dataTables.min.js"></script>
    <!-- ALERTIFY -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/semantic.min.css">
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>
</head>
    <style>
        .content{
            display: flex;
            flex-direction: column;
            min-height: 0;
            flex: 1;
        }
        .content > .container{
            background-color: var(--color-obsidian);
            display: flex;
            flex-direction: column;
            border: solid 1px var(--color-smoke);
            padding: var(--card-padding);
            border-radius: var(--radius-cards);
            width: 300px;
            margin: auto;
            gap: var(--spacing-40);
            zoom: 110%;
        }
        .container .header > .title{
            font-size: var(--text-heading-sm);
            text-align: center;
        }
        .container .header > .description{
            font-size: var(--text-caption);
            text-align: center;
        }
        .record{
            display: flex;
            gap: var(--element-gap);
            display: flex;
            align-items: center;
            padding: var(--spacing-16);
        }
        .record .profile{
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--color-carbon);
            border: var(--default-border);
            color: var(--color-mist);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container > .body > .wrapper{
            display: flex;
            flex-direction: column;
        }
        .container > .body{
            display: flex;
            flex-direction: column;
        }
        .description > .name{
            font-size: var(--text-caption);
        }
        .container > .body > .wrapper > .record + .record{
            border-top: solid 1px black;
        }
        /* .description{
            display: flex;
            align-items: center;
            gap: ;
        } */
    </style>
<body>
    <div class="nav_bar">
        <div class="main_nav">
            <div class="left">
                <div class="page_name"><div class="app material-symbols-outlined">Manage_Accounts</div>Accounts</div>
                <div class="archive_button button_subtle">Archives</div>
            </div>
            <div class="right">
                <div class="account_name account"><?php echo $_SESSION['username']; ?></div>
                <div class="account_profile account"><?php echo $_SESSION['first_fname'] . $_SESSION['first_lname']?></div>
            </div>
        </div>
    </div>
    <div class="modal_group"></div>
    <div class="content">
        <div class="container">
            <div class="header">
                <div class="title">Accounts</div>
                <div class="description">Register, edit, and delete accounts</div>
                <!-- <div class="search">
                    Search:_<input type="text" name="" id="">
                </div> -->
            </div>
            <div class="body">
                
                <div class="wrapper">
                    <!-- <table id="accounts_table">
                        <thead>
                            <tr>
                                <th>
                                    username
                                </th>
                                <th>
                                    firstname
                                </th>
                                <th>
                                    lastname
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>username</td>
                                <td>firstname</td>
                                <td>lastname</td>
                            </tr>
                        </tbody>
                    </table> -->
                    <!-- <div class="record">
                        <div class="profile">JD</div>
                        <div class="description">
                            <div class="username">Johhny</div>
                            <div class="name">John Doe</div>
                        </div>
                    </div>
                    <div class="record">
                        <div class="profile">Jo</div>
                        <div class="description">
                            <div class="username">Crown</div>
                            <div class="name">Chris Brown</div>
                        </div>
                    </div>
                    <div class="record">
                        <div class="profile">JN</div>
                        <div class="description">
                            <div class="username">Johhny</div>
                            <div class="name">John Doe</div>
                        </div>
                    </div>
                    <div class="record">
                        <div class="profile">JP</div>
                        <div class="description">
                            <div class="username">Johhny</div>
                            <div class="name">John Doe</div>
                        </div>
                    </div> -->
                    
                </div>
            </div>
            <div class="footer">
                <div class="archive_button button_main" style="width: fit-content;"> Show archives </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php 
    require '../controllers/accounts.php';

?>


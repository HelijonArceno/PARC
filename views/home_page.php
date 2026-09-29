<?php 
    session_start();
    require('../models/authorization/check_authorization.php');
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
    <!-- GOOGLE FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    
    <style>
        :root{
            --app-size: 170px;
        }
        .content{
            width: fit-content;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: auto;
            .title{
                line-height: 0;
                margin-bottom: var(--section-gap);
            }
        }
        /* .content_wrapper{
            display: flex;
            position: absolute;
            top: 0;
            width: 100vw;
            height: 100vh;
            z-index: -100;
        } */
        .apps{
            margin: auto;
            width: auto;
            max-width: 606px; 
            display: inline-grid;
            grid-template-columns: repeat(auto-fill, minmax(var(--app-size), 1fr));
            /*  */
            gap: 32px;
            box-sizing: border-box;
            /* position: relative; */
            /* top: 40%;
            left: 50%;
            transform: translate(-50%,-50%); */

            .deactivated{
                .app{
                    /* border: var(--subtle-border); */
                    color: var(--color-ash);
                    
                }
                .description{
                    color: var(--color-ash);
                }
            }
            .activated{
                .app{
                    border: var(--strong-border);
                    cursor: pointer;
                }
                .app:hover{
                    scale: 1.05;
                    transition: scale 0.2s ease-out;
                }
                .app:active{
                    scale: 0.95;
                    transition: scale 0.2s ease-out;
                }
            }
            
        }
        /* .button_main:hover{
    scale: 1.05;
    transition: scale 0.2s ease-out;
}
.button_main:active{
    scale: 0.95;
    transition: scale 0.2s ease-out;
} */
        
        .app{
            width: var(--app-size);
            height: var(--app-size);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 10px;
            /* cursor: pointer; */
            /* border: var(--strong-border); */
            border-radius: var(--radius-cards);
            font-size: calc(var(--app-size) / 1.75);
            box-sizing: border-box;
            background-color: var(--color-carbon);
        }
        
        .apps .description{
            font-size: var(--leading-caption);
            width: 100%;
            text-align: center;
            box-sizing: border-box;
        }
        .apps .wrapper{
            width: auto;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            
        }
        .title{
            text-align: center;
            font-size: 175px;
            margin: 20px 0;
        }
        .kanit-regular {
            font-family: "Kanit", sans-serif !important;
            font-weight: 200;
            font-style: normal;
        }
        
        
    </style>
</head>
<body>
    <div class="nav_bar">
        <div class="main_nav">
            <div class="left">
                <div class="page_name"><div class="material-symbols-outlined">home</div>Home Page</div>
                <div class="button"></div>
                <div class="button"></div>
            </div>
            <div class="right">
                <div class="account_name account"><?php echo $_SESSION['username']; ?></div>
                <div class="account_profile account"><?php echo $_SESSION['first_fname'] . $_SESSION['first_lname']?></div>
            </div>
        </div>
    </div>
    <div class="modal_group"></div>

        <div class="content">
            <div class="title primary_text kanit-regular">
                PARC STORE
            </div>
            <div class="apps">
                <!-- <div class="wrapper">
                    <div class="app material-symbols-outlined" id="dashboard">dashboard</div>
                    <div class="description">Dashboard</div>
                </div>
                <div class="wrapper">
                    <div class="app material-symbols-outlined" id="inventory">Inventory</div>
                    <div class="description">Inventory</div>
                </div>
                <div class="wrapper">
                    <div class="app material-symbols-outlined" id="pos">Point_of_Sale</div>
                    <div class="description">Point-of-sale</div>
                </div>
                <div class="wrapper">
                    <div class="app material-symbols-outlined" id="history">History</div>
                    <div class="description">History</div>
                </div>
                <div class="wrapper">
                    <div class="app material-symbols-outlined" id="accounts">Manage_Accounts</div>
                    <div class="description">Accounts</div>
                </div>
                <div class="wrapper">
                    <div class="app material-symbols-outlined" id="reports">Analytics</div>
                    <div class="description">Reports</div>
                </div> -->
                
                <!-- <div class="app material-symbols-outlined" id="inventory">inventory </div>
                <div class="app material-symbols-outlined" id="history">History </div>
                <div class="app material-symbols-outlined" id="accounts">Manage_Accounts </div>
                <div class="app material-symbols-outlined" id="pos">Point_of_Sale </div>
                <div class="app material-symbols-outlined" id="reports">Analytics </div> -->
            </div>
        </div>
</body>
</html>
<?php 
    require '../controllers/home_page.php'; 
 
?>
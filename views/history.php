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
</head>
    <style>
        .content{
            flex: 1;
            display: flex;
            flex-direction: row;
            min-height: 0;
        }
        .content > .left{
            width: 25%;
            border-right: solid 1px var(--border-color);
            display: flex;
            flex-direction: column;
        }
        .content > .left > .top{
            flex: 1;
            display: flex;
            flex-direction: column;
            padding: calc(var(--spacing-unit) * 2);
            justify-content: space-between;
            min-height: 0;
        }
         .content > .left > .bottom{
            border-top: solid 1px var(--border-color);
            padding: calc(var(--spacing-unit) * 2);
        }
        .content > .left > .bottom > div{
            border: solid 1px var(--border-color);
            text-align: center;
            padding: var(--card-padding);
        }
        .content > .right{
            box-sizing: border-box;
            width: 75%;
            display: flex;
            flex-direction: column;
            gap: var(--element-gap);
            padding: calc(var(--spacing-unit) * 2);
        }
        .content > .right > .filters{
            display: flex;
            flex-direction: row;
            gap: var(--element-gap);
            max-width: 100%;
            overflow-x: auto;
        }
        .content > .right > .filters > div{
            padding: var(--card-padding);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-cards);
        }
        .list{
            display: flex;
            flex-direction: column;
            gap: var(--element-gap);
            overflow-y: auto;
        }
        .list .row{
            display: flex;
            justify-content: space-between;
        }
        .summary .row{
            display: flex;
            justify-content: space-between;
        }
        .cards{
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(175px, 1fr));
            gap: 16px;
            min-height: 0;
            overflow-y: auto;
        }
        .cards div{
            padding: var(--card-padding);
            border: solid 1px var(--border-color);
            border-radius: var(--radius-cards);
        }

    </style>
<body>
    <div class="nav_bar">
        <div class="main_nav">
            <div class="left">
                <div class="page_name">History</div>
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
        type 
    </div>
</body>
</html>
<script>
    load_asset('modal');
    modal_load('global','modal','profile', null, null, 'php');
    $(document).ready(function(){
        ready();
    })
    $('.page_name').on('click', function(){
        window.location.href = 'home_page.php';
    });
    function ready(){

    }

</script>
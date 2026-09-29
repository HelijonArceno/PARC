<?php 
    session_start();
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- ASSETS -->
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="assets/modal_style.css">
    <script src="assets/libraries/global.js"></script>
    <script src="assets/libraries/universal_formatting.js" defer></script>
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
    <style>
        .container{
            width: 300px;
            border-radius: var(--radius-cards);
            padding: var(--card-padding);
            display: flex;
            flex-direction: column;
            gap: var(--spacing-32);

            border: solid 1px var(--color-smoke);
            background-color: var(--color-obsidian);
        }
        body{
            display: flex;
            min-height: 100vh;
            justify-content: center;
            align-items: center;
            margin: 0;
        }
        .input_group{
            width: 100%;
            display: flex;
            gap: 8px;
            border: solid 1px black;
            border-radius: var(--radius-inputs);
            padding: var(--spacing-unit);
            align-items: center;
        }
        .input_group input{
            flex: 1;
            border: 0;
            background: none;
        }
        .header{
            display: flex;
            flex-direction: column;
            gap: var(--element-gap);
        }
        .header div{
            text-align: center;
        }
        .title{
            font-size: var(--text-heading);
        }
        .desc{
            font-size: var(--text-caption);
            color: var(--color-fog);
        }
        form{
            display: flex;
            flex-direction: column;
            gap: var(--spacing-8);
        }

        .footer div{
            margin: auto;
            text-align: center;
        }
        .modal, .dropdown{
            background-color: var(--color-obsidian);
        }
        /* .modal_content input{
            background: var(--color-carbon);
            color: var(--color-mist);
            border: 2px solid var(--color-graphite);
            border-radius: var(--radius-inputs);
            padding: var(--spacing-4);
        } */
        .input_group input:focus{
            outline: none;
        }
        .input_group{
            background: var(--color-carbon);
            border: 2px solid var(--color-graphite);
            border-radius: var(--radius-inputs);
            padding: var(--spacing-4);
        }
        .input_group div{
            color: var(--color-fog);
        }
        .button{
            width: fit-content;
        }
        .input_group .description{
            display: flex;
            gap: var(--element-gap);
            width: 110px;
            border-right: 2px solid var(--color-graphite);
        }
        .about{
            font-size: var(--text-caption);
        }
        .logo{
            font-size: var(--text-heading);
        }
        .footer{
            display: flex;
            flex-direction: column;
            gap: var(--element-gap);
        }
        .container{
            zoom: 110%;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo material-symbols-outlined">lock</div>
            <div class="title">Log-in</div>
        </div>
        <div class="content">
            <form action="">
                <div class="about">
                    Account details
                </div>
                <label class="input_group" for="username">
                    
                    <div class="description">
                        <div class="icon material-symbols-outlined">
                            person
                        </div>
                        Name
                    </div>
                    <input type="text" name="username" id="username">
                </label>

                <label class="input_group" for="password">
                    <div class="description">
                        <div class="icon material-symbols-outlined">
                            person
                        </div>
                        Password
                    </div>
                    <input type="password" name="password" id="password">
                </label>
                
            </form>
        </div>
        <div class="footer">
            <div class="desc">Please Login to continue, contact your admin if you dont have an account.</div>
            <div class="button button_main">Login <div class="material-symbols-outlined">login</div></div>
        </div>
    </div>
</body>
</html>
<?php 
    require 'controllers/login.php';
?>
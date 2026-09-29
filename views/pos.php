<?php 
    session_start();
    require('../models/authorization/check_authorization.php');
    if($_SESSION['role'] == 'Admin' || $_SESSION['role'] == 'Sales'){
        
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
        .main_nav{
            margin: unset !important;
        }
        .content{
            flex: 1;
            display: flex;
            flex-direction: row;
            min-height: 0;
        }
        .content > .left{
            background-color: var(--color-carbon);
            width: 25%;
            border-right: var(--default-border);
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
            padding: calc(var(--spacing-unit) * 2);
        }
        #payment_button{
            display: flex;
            align-items: center;
            justify-content: center;
            gap: var(--element-gap);
            padding: calc(var(--card-padding)/2);
            background-color: var(--color-carbon);
            border-radius: var(--radius-buttons);
            border: 2px solid var(--color-graphite);
            font-size: var(--text-heading-sm);
            div{
                font-size: var(--text-heading-sm);
            }
        }
        #payment_button:hover{
            background-color: var(--color-obsidian);
            scale: 1.02;
            transition: scale 0.2s ease-out;
        }
        #payment_button:active{
            background-color: var(--color-carbon);
            scale: 0.95;
            transition: scale 0.2s ease-out;
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
            min-height: fit-content;
            padding-bottom: var(--element-gap);
            div:hover{
                scale: 1.02;
                transition: scale 0.2s ease-out;
                background-color: var(--color-obsidian);
                div {
                    color: var(--color-mist);
                }
                cursor: pointer;
            }
            div:active{
                background-color: var(--color-carbon);
                scale: 0.98;
                transition: scale 0.2s ease-out;
            }
        }
        .content > .right > .filters > div{
            padding: var(--card-padding);
            background-color: var(--color-carbon);
            border: var(--strong-border);
            border-radius: var(--radius-cards);
            min-width: fit-content;
            min-height: fit-content;
        }
        .list{
            display: flex;
            flex-direction: column;
            gap: var(--element-gap);
            overflow-y: auto;
            overflow-x: hidden;
        }
        .list .row{
            display: flex;
            justify-content: space-between;
        }
        .summary .row{
            display: flex;
            justify-content: space-between;
            padding-left: var(--element-gap);
            padding-right: var(--element-gap);
            padding-top: var(--element-gap);
            border-top: var(--strong-border);
            .left, .right{
                font-size: var(--text-body-lg);
            }
        }
        .cards{
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(175px, 1fr));
            gap: 16px;
            min-height: 0;
            overflow-y: auto;
            .available:hover{
                scale: 1.02;
                transition: scale 0.2s ease-out;
                background-color: var(--color-obsidian);
                div {
                    color: var(--color-mist);
                }
                cursor: pointer;
            }
            .available:active{
                background-color: var(--color-carbon);
                scale: 0.98;
                transition: scale 0.2s ease-out;
            }

            .unavailable{
                border: 1px solid var(--color-coral-red);
            }
            .unavailable:hover{
                div{
                    color: var(--color-coral-red);
                    transition: all 0.2s ease-in-out;
                }
                
            }
        }
        .cards > div{
            padding: var(--card-padding);
            background-color: var(--color-carbon);
            
            border: var(--default-border);
            border-radius: var(--radius-cards);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: var(--element-gap);
        }
        .cards div{
            color: var(--color-fog);
        }

        /* Scrollbar width */
        ::-webkit-scrollbar {
        width: 4px;
        height: 4px;
        }

        /* Track (background) */
        ::-webkit-scrollbar-track {
        background: #0f1011;
        }

        /* Thumb (the part you drag) */
        ::-webkit-scrollbar-thumb {
        background: #383b3f;
        border-radius: 10px;
        }

        /* Thumb when hovering */
        ::-webkit-scrollbar-thumb:hover {
        background: #62666d;
        }
        .product_list_price{
            text-align: right;
        }
        /*.list table td{
            padding: var(--element-gap);
        }
        .list table tr{
            background-color: blue;
        }*/

        .list table{
            td{
                padding: var(--element-gap);
                border-top: var(--default-border);
                border-bottom: var(--default-border);
                color: var(--color-fog);
            }
            td:first-child{
                border-left: var(--default-border);
                border-top: var(--default-border);
                border-bottom: var(--default-border);
                border-top-left-radius: var(--radius-cards);
                border-bottom-left-radius: var(--radius-cards);
                color: var(--color-mist);
            }
            td:last-child{
                border-right: var(--default-border);
                border-top: var(--default-border);
                border-bottom: var(--default-border);
                border-top-right-radius: var(--radius-cards);
                border-bottom-right-radius: var(--radius-cards);
            }
            td:nth-child(2){
                width: auto;

            }
            tr:hover{
                scale: 1.02;
                transition: scale 0.2s ease-out;
                background-color: var(--color-obsidian);
                td{
                    color: var(--color-mist);
                }
                cursor: pointer;
            }
            tr:active{
                background-color: var(--color-carbon);
                scale: 0.98;
                transition: scale 0.2s ease-out;
                
            }
        }
                #tendered_amount::-webkit-inner-spin-button{
                    display: none;
                }
        

    </style>
<body>
    <div class="nav_bar">
        <div class="main_nav">
            <div class="left">
                <div class="page_name"><div class="material-symbols-outlined">Point_of_Sale</div>Point-of-sale</div>
                <div class="button gcash_button button_subtle">GCash</div>
                <div class="button top_up_button button_subtle">Load</div>
            </div>
            <div class="right">
                <div class="middle search_wrapper">
                    Search: 
                    <input type="text" class="searchbox search_input" id="product_catalog_search">
                    <div class="search_clear material-symbols-outlined">clear</div>
                </div>
                <div class="account_name account"><?php echo $_SESSION['username']; ?></div>
                <div class="account_profile account"><?php echo $_SESSION['first_fname'] . $_SESSION['first_lname']?></div>
            </div>
        </div>
    </div>
    <div class="modal_group"></div>
    <div class="content">
        <div class="left">
            <div class="top">
                <div class="list">
                    <table>
                        <!-- <tr>
                            <td>
                                1
                            </td>
                            <td>
                                Safeguard Soap ,White, 85g
                            </td>
                            <td class="product_list_price">
                                30.00
                            </td>
                        </tr> -->
                    </table>

                </div>
                <div class="summary">
                    <div class="row">
                        <div class="left">
                        Customer Total
                        </div>
                        <div class="right">
                            00,000,00
                        </div>
                    </div>
                </div>
            </div>
            <div class="bottom">
                <div id="payment_button">Process<div class="material-symbols-outlined">payments</div></div>
            </div>
        </div>
        <div class="right">
            <div class="filters">
                <div data-id="">ALL</div>
            </div>
            
            <div class="cards">
            </div>
            
            <div class="change_interface">
                <input type="number" id="tendered_amount" placeholder="Enter Paid Amount"sss>
            </div>
        </div>
    </div>
    <style>
                .change_interface{
                    text-align: center;
                    margin: auto;
                    display: none;
                }
                .change_interface input{
                    all: unset;
                    font-size: var(--text-display);
                }
            </style>
</body>
</html>
<?php 
    require '../controllers/pos.php';
?>
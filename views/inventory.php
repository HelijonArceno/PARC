<?php 
    session_start();
    require('../models/authorization/check_authorization.php');
    if($_SESSION['role'] == 'Admin' || $_SESSION['role'] == 'Inventory'){

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
        
        .product{
            padding: var(--card-padding);

            border: 1px solid var(--border-color);
            border-radius: var(--radius-cards);

            flex: 0 0 350px;
            box-sizing: border-box;
        }
        .product > div{
            display: flex;
            gap: 8px;
        }
        .cards{
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 16px;
        }
        .end{
            flex:1;
        }

        #product_table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 12px; 
        }

        
        #product_table th {
            padding: 12px;
            text-align: left;
        }
        .content{
            margin-left: var(--section-gap);
            margin-right: var(--section-gap);
            flex:1;
            overflow-y: auto;
        }

        /* Scrollbar width */
        ::-webkit-scrollbar {
        width: 1px;
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

       
        /* #product_table tbody td {
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
            padding: var(--card-padding);; 
            background-color: #fff; 
        }

        
        #product_table tbody td:first-child {
            border-left: 1px solid var(--border-color);
            border-top-left-radius: 8px;
            border-bottom-left-radius: 8px;
        }

        
        #product_table tbody td:last-child {
            border-right: 1px solid var(--border-color);
            border-top-right-radius: 8px;
            border-bottom-right-radius: 8px;
        } */
        /* #inventory_page > .content{
            padding: var(--spacing-16);
        } */

        /* #product_table tbody tr + tr td{
            border-top: solid 1px p;
        } */
        
        tbody td{
            color: var(--color-fog);
        }
        #archive_toggle:checked{
            .archive_button{
                color: var(--color-fog)
            }
        }
        tbody tr:hover{
            td{
                background-color: var(--color-obsidian);
                color: var(--color-mist);
            }
            scale: 1.01;
            transition: scale 0.2s ease-out;
            cursor: pointer;
        }
        tbody tr:active{
            td{
                background-color: var(--color-carbon);
            }
            scale: 0.98;
        }

        /* .available:hover{
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
            } */
    </style>
<body id="inventory_page">
    <div class="nav_bar">
        <div class="main_nav">
            <div class="left">
                <div class="page_name"><div class="material-symbols-outlined">inventory</div>Inventory</div>
                <div class="master_data_button dropdown_wrapper button_subtle" title="Manage brands, categories, locations">Master Data
                    <div>
                        <div id="modal_master_data" class="dropdown modals"></div>
                    </div>
                </div>
                <label class="archive_button button_subtle_off" title="View archives" for="archive_toggle">Archives </label>
                <input type="checkbox" id="archive_toggle" class="toggle">
            </div>
            <div class="right">
                <div class="account_name account"><?php echo $_SESSION['username']; ?></div>
                <div class="account_profile account"><?php echo $_SESSION['first_fname'] . $_SESSION['first_lname']?></div>
            </div>
        </div>
        <div class="sec_nav">
            <div class="left">
                <div class="button_main" id="new_product"  title="Register new products">Add
                    <div class="material-symbols-outlined">list_alt_add</div>
                </div>
                <div class="button_main" id="restock_product" title="Restock product stock levels">Restock 
                    <div class="material-symbols-outlined">input_circle</div>
                </div>
            </div>
            <div class="middle search_wrapper">
                Search: 
                <input type="text" class="searchbox search_input">
                <div class="search_clear material-symbols-outlined">clear</div>
            </div>
            <div class="right">
                <div class="dt-container">
                    <div class="paging "></div>
                </div>
                <!-- <div class="button_main material-symbols-outlined" id="table_mode" title="Table view mode">table</div> -->
                <!-- <div class="button_main material-symbols-outlined" id="cards_mode" title="Visual kanban mode">view_kanban</div> -->
            </div>
        </div>
    </div>
    <div class="modal_group">
    </div>
    <div class="content">
        
        <div class="table">
        <table id="product_table">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Brand</th>
                    <th>Name</th>
                    <th>Variant</th>
                    <th>Size</th>
                    <th>Category</th>
                    <th>Location</th>
                    <th>Type</th>
                    <th>Cost</th>
                    <th>Price</th>
                    <th>Stock</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
        </div>
        <div class="cards">

            <div class="product">  
                <div>
                    <div class="attribute">X</div>
                    <div class="value">Jerbey Condensed Creamer</div>
                </div>
                <div>
                    <div class="value">Mango</div>
                </div>
                <div>
                    <div class="attribute">Size</div>
                    <div class="value">390g</div>
                </div>
                <div>
                    <div class="attribute">Stock: </div>
                    <div class="value">11</div>
                </div>
                <div>
                    <div class="attribute">Price: </div>
                    <div class="value">PHP1,231</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php 
    require '../controllers/inventory.php';

?>
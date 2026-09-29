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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- D3 -->
    <script src="https://d3js.org/d3.v4.js"></script>
</head>
    <style>
        .content{
            margin-left: var(--section-gap);
            margin-right: var(--section-gap);
            display: flex;
            flex-direction: column;
            padding: 16px;
            gap: 16px;
            min-height: 0px;
            flex: 1;
        }
        .row{
            display: flex;
            gap: 16px;
        }
        .cards{
            width: 100%;
            display: flex;
            gap: 16px;
        }
        .cell{
            border: var(--subtle-border);
            background-color: var(--color-carbon);
            padding: var(--card-padding);
            border-radius: var(--radius-cards);
        }
        .cards > .cell{
            flex:1;
            border: var(--subtle-border);
            background-color: var(--color-carbon);
            padding: var(--card-padding);
            border-radius: var(--radius-cards);
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        .cards > .cell > .description{
            font-size: var(--text-body-lg);
        }
        .cards > .cell > .data{
            font-size: var(--text-body-sm);
            color: var(--color-fog);
        }
        .container{
            height: 500px;
            border: solid black 1px;
            padding: var(--card-padding);
            border-radius: var(--radius-cards);
            box-sizing: border-box;
        }
        #sales_line_chart{
            width: 100% !important;
            height: 100%;
        }
        #sales_line_chart text{
            fill: #8a8f98;
        }
        #sales_line_chart .tick line, #sales_line_chart .domain{
            stroke: #8a8f98;
        }
        .graph_container{
            border: var(--subtle-border);
            background-color: var(--color-carbon);
        }
        .row_title{
            font-size: var(--text-subheading-l);
        }
        </style>
<body>
    <div class="nav_bar">
        <div class="main_nav">
            <div class="left">
                <div class="page_name"><div class="app material-symbols-outlined">dashboard</div>Dashboard</div>
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
        <div class="row_title">
            Daily Key Performance Indicators
        </div>
        
        <div class="row">
            <div class="cards">
                <!-- SALES -->
                <div class="cell" id="today_total_sales">
                    <div class="description">Daily sales</div>
                    <div class="data">PHP amount</div>
                </div>
                <!-- <div class="cell" id="today_total_sales">
                    <div class="description">Weekly Sales</div>
                    <div class="data">PHP amount</div>
                </div> -->
                <div class="cell" id="today_total_sales">
                    <div class="description">Monthly Sales</div>
                    <div class="data">PHP amount</div>
                </div>
                <div class="cell" id="today_total_sales">
                    <div class="description">Annual Sales</div>
                    <div class="data">PHP amount</div>
                </div>
                <!-- <div class="cell" id="today_products_sold">
                    <div class="description">Daily Products Sold</div>
                    <div class="data">QTY</div>
                </div>
                <div class="cell" id="today_gross_profit">
                    <div class="description">Today's gross profit</div>
                    <div class="data">PHP amount</div>
                </div> -->
                <div class="cell" id="daily_sales_performance">
                    <div class="description">Daily Sales Performance</div>
                    <div class="data">% better than yesterday</div>
                </div>
            </div>
            
        </div>
        
        <div class="row_title">
            This Week's Sales
        </div>
        <div class="row">
            <div class="container graph_container" style="flex:4">
                <canvas id="daily_sales_line_chart"></canvas>
            </div>
            <div class="cell">
                <div>1 coca-cola php982.00</div>
                <div>2 coca-cola php982.00</div>
                <div>4 coca-cola php982.00</div>
                <div>4 coca-cola php982.00</div>
            </div>
            <div class="container graph_container" style="flex:1">
                <canvas id="daily_sales_category_distribution_pie_chart"></canvas>
            </div>
        </div>
        <div class="row_title">
            Inventory Status
        </div>
         <div class="row">
            <div class="cards">
                <!-- INVENTORY -->
                <div class="cell" id="near_expiry">
                    <div class="description">Near Expiry</div>
                    <div class="data">QTY products</div>
                </div>
                <div class="cell" id="low_stock">
                    <div class="description">low stock</div>
                    <div class="data">QTY products</div>
                </div>
                <div class="cell" id="expired">
                    <div class="description">Expired</div>
                    <div class="data">QTY products</div>
                </div>
                <div class="cell" id="no_stock">
                    <div class="description">Out of stock</div>
                    <div class="data">QTY products</div>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>
<?php 
    require '../controllers/dashboard.php';

?>
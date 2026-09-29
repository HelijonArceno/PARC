
<?php
session_start();
// Ensure user is logged in
if(!isset($_SESSION['employee_id'])){
    header('Location: auth.php');
    exit;
}
?>
        <div class="user_inf">
            <img src="https://cdn.pixabay.com/photo/2023/02/18/11/00/icon-7797704_1280.png" class="pfp"></img>
            <div class="user_details">
                <div class="username"><?php echo htmlspecialchars($_SESSION['first_name'] . ' ' . $_SESSION['last_name']); ?></div>
                <div class="userrole"><?php echo strtoupper($_SESSION['role']); ?></div>
            </div>
        </div>
        <div class="nav_bar">
            <div class="nav_item ui_button" id="dashboard">
                <i class="bi bi-speedometer2"></i>
                <div class="nav_item_name">
                    Dashboard
                </div> 
                            
            </div>
            <div class="nav_item ui_button" id="inventory">
                <i class="bi bi-box-seam"></i>
                <div class="nav_item_name">
                    Inventory
                </div> 
            </div>
            <div class="nav_item ui_button" id="info">
                <i class="bi bi-database"></i>
                <div class="nav_item_name">
                    Master Data
                </div> 
            </div>
            <div class="nav_item ui_button" id="point_of_sale">
                <i class="bi bi-cart4"></i>
                <div class="nav_item_name">
                    Point of Sale
                </div> 
            </div>
            <div class="nav_item ui_button" id="accounts">
                <i class="bi bi-people"></i>
                <div class="nav_item_name">
                    Accounts
                </div> 
            </div>
            <div class="nav_item ui_button" id="logs">
                <i class="bi bi-clock-history"></i>
                <div class="nav_item_name">
                    Logs
                </div> 
            </div>

            <div class="nav_gap"></div>
            <div class="custom_modal exit_confirm_modal"></div>
            

            <div class="nav_item ui_button exit_btn">
                <i class="bi bi-box-arrow-right"></i>
                <div class="nav_item_name" style="text-decoration: none; color: white;">
                    EXIT
                </div> 
            </div> 
        </div>
        <script>
                let current_user_role = <?php echo json_encode($_SESSION['role'])?>;
                $(document).ready(function(){
                $(".exit_confirm_modal").load('modals/exit_confirm_modal.php');
                 $(".exit_confirm_modal").appendTo('body');
                
                $('#dashboard').click(function(){
                    window.location.href = "dashboard.php";
                });
                $('#inventory').click(function(){
                    window.location.href = "inventory.php";
                });
                $('#accounts').click(function(){
                    window.location.href = "accounts.php";
                });
                $('#point_of_sale').click(function(){
                    window.location.href = "point_of_sale.php";
                });
                $('#logs').click(function(){
                    window.location.href = "logs_transactions.php";
                });
                 $('#info').click(function(){
                    window.location.href = "Product_registrations.php";
                });

                if(current_user_role != 'admin'){
                    $('#logs').hide();
                    $('#accounts').hide();
                    $('#dashboard').hide();
                }

                if(current_user_role == 'sales'){
                    $('#inventory').hide();
                    $('#info').hide();
                }
                if(current_user_role == 'inventory'){
                    $('#point_of_sale').hide();
                }
                if(current_user_role == 'audit'){
                    $('#point_of_sale').hide();
                    $('#info').hide();
                    $('#point_of_sale').hide();
                }

                $(document).on('keydown', function(event){
                    if(event.key === "Escape"){
                        event.preventDefault();
                        $('.sidebar_wrap').toggleClass('collapsed');     
                    }
                    if(event.altKey && (event.code === "Digit1" )){
                        event.preventDefault();
                        window.location.href = "dashboard.php"; 
                    }
                    if(event.altKey && (event.code === "Digit2")){
                        event.preventDefault();
                        window.location.href = "inventory.php"; 
                    }
                    if(event.altKey && (event.code === "Digit3")){
                        event.preventDefault();
                        window.location.href = "product_registrations.php"; 
                    }
                    if(event.altKey && (event.code === "Digit4")){
                        event.preventDefault();
                        window.location.href = "point_of_sale.php"; 
                    }
                    if(event.altKey && (event.code === "Digit5")){
                        event.preventDefault();
                        window.location.href = "accounts.php"; 
                    }
                    if(event.altKey && (event.code === "Digit6")){
                        event.preventDefault();
                        window.location.href = "logs_transactions.php"; 
                    }
                });
                // $('.sidebar_wrap').hover(function(){
                //     $('.sidebar_wrap').removeClass('collapsed');     
                // },function(){
                //     $('.sidebar_wrap').addClass('collapsed');     
                // });
            })
        </script>

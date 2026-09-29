<script>
    let error_message = <?php 
        echo json_encode($_SESSION['error_message'] ?? null); 
        unset($_SESSION['error_message']); 
        ?>;

        if(error_message !== null){
            alertify.error(error_message);
        }

        let success_message = <?php 
        echo json_encode($_SESSION['success_message'] ?? null); 
        unset($_SESSION['success_message']); 
        ?>;

        if(success_message !== null){
            alertify.success(success_message);
        }
    load_asset('modal');
    modal_load('global','modal','profile', null, null, 'php');
    $(document).ready(function(){
        function redirect_button(page){
            $('.apps').on('click','#'+page, function(){
                window.location.href = page+'.php';
            });
        };
        // $('#inventory').on('click', function(){
        //     window.location.href = 'inventory.html';
        // });
        // $('#pos').on('click', function(){
        //     window.location.href = 'pos.html';
        // });
        // $('#pos').on('click', function(){
        //     window.location.href = 'pos.html';
        // });

    
        let role = <?php echo json_encode($_SESSION['role']);?>

        let dashboard = 'deactivated';
        let inventory = 'deactivated';
        let pos = 'deactivated';
        let accounts = 'deactivated';
        let history = 'deactivated';
        let reports = 'deactivated';
        
        if(role == 'Admin'){
            dashboard = 'activated';
            inventory = 'activated';
            pos = 'activated';
            accounts = 'activated';

            redirect_button('dashboard');
            redirect_button('inventory');
            redirect_button('pos');
            redirect_button('accounts');
        }
        if(role == 'manager'){
            inventory = 'activated';
            pos = 'activated';
            accounts = 'activated';

            redirect_button('inventory');
            redirect_button('pos');
            redirect_button('accounts');
        }
        if(role == 'Inventory'){
            inventory = 'activated';

            redirect_button('inventory');
        }
        if(role == 'Sales'){
            pos = 'activated';

            redirect_button('pos');
        }

        let apps = 
        `
                <div class="wrapper ${dashboard}">
                    <div class="app material-symbols-outlined " id="dashboard">dashboard</div>
                    <div class="description">Dashboard</div>
                </div>
                <div class="wrapper ${inventory}">
                    <div class="app material-symbols-outlined " id="inventory">Inventory</div>
                    <div class="description">Inventory</div>
                </div>
                <div class="wrapper ${pos}">
                    <div class="app material-symbols-outlined " id="pos">Point_of_Sale</div>
                    <div class="description">Point-of-sale</div>
                </div>
                <div class="wrapper ${accounts}">
                    <div class="app material-symbols-outlined " id="accounts">Manage_Accounts</div>
                    <div class="description">Accounts</div>
                </div>
                <div class="wrapper ${history}">
                    <div class="app material-symbols-outlined " id="history">History</div>
                    <div class="description">History</div>
                </div>
                <div class="wrapper ${reports}">
                    <div class="app material-symbols-outlined " id="reports">Analytics</div>
                    <div class="description">Reports</div>
                </div>
        `
        $('.apps').html(apps);
    });
</script>

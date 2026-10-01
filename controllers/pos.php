<script>
    load_asset('modal');
    modal_load('global','modal','profile', null, null, 'php');
    modal_load('pos','modal','modify_amount');
    modal_load('pos','modal','gcash_new');
    modal_load('pos','modal','gcash_new_confirm');
    modal_load('pos','modal','top_up_new');
    modal_load('pos','modal','top_up_new_confirm');
    modal_load('pos','modal','transaction_confirm');
    let list = [];
    let li = 0; //LIST INDEX
    let pos_search_category_id;
    let payment_mode = false;
    $(document).ready(function(){
        ready();
    })

    $('#product_catalog_search').on('keyup', function(){
        display_products(pos_search_category_id);
    })
    $('.search_clear').on('click', function(){
        $('#product_catalog_search').val('');
        display_products(pos_search_category_id);
    })
    let barcode_buffer = '';
    let checking = false;
    $(document).on('keydown', function(e){
        if(e.key === 'Enter'){
            return;
        }

        if(!isNaN(e.key)){
           barcode_buffer += e.key
        }

        if(checking == false){
            setTimeout(check_barcode, 25)
            checking = true;
        }
        
        function check_barcode(){
            if(barcode_buffer.length >= 12){
                console.log('barcode');
                insert_product_barcode(barcode_buffer);
                barcode_buffer = '';
            }else{
                console.log('keyboard');
                barcode_buffer = '';
            }
            checking = false;
        }
    });

    function insert_product_barcode(product_code){
        $.ajax({
            url: '../models/fetch/fetch_product.php',
            type: 'GET',
            dataType: 'json',
            data: {
                product_code: product_code
            },
            success: function(response){
                console.log('inserting product barcode');
                
                let str_size = response.size;
                if(response.unit != null){
                    str_size += response.unit;
                }
                add_item_list(response.product_code, response.product_name, response.variant, str_size, response.cost, response.price, response.sale_type_id, response.brand);
            },
            error: function(response){
                console.log('ERROR insert : ' + response);
            }
        })
        
    }

    $('.page_name').on('click', function(){
        window.location.href = 'home_page.php';
    });
    $('.filters').on('click', 'div', function(){
        console.log('clicked filter');
        pos_search_category_id = $(this).data('id');
        display_products(pos_search_category_id);
    })


    $('#payment_button').on('click', function(){
        let num_records = 0;
        
        for(i = 0; i < li; i++){
            if (list[i][100] === 'skip'){
                continue;
            }
            num_records++;
        }
        if(num_records == 0 ){
            alertify.error('Please select a product first')
        }else{
            toggle_payment_view();
        }
    })

    $('#tendered_amount').on('keyup', function(e){
        if(e.key === 'Enter'){
            let tendered_amount = $('#tendered_amount').val();
            let total_sale = 0.0;
            for(i = 0; i < li; i++){
                if (list[i][100] === 'skip'){
                    continue;
                }
                product_sale = parseFloat(list[i][6]) * parseFloat(list[i][4]);
                total_sale = parseFloat(total_sale) + parseFloat(product_sale)
            }

            console.log('TA: '+ tendered_amount);
            console.log('TS: '+ total_sale)

            if(tendered_amount < total_sale){
                alertify.error('Insufficient Funds');
            }else{
                let change = tendered_amount - total_sale

                let str_tendered_amount = tendered_amount.toLocaleString('en-US', {minimumFractionDigits: 2}) + ' PHP';
                let str_total_sale = total_sale.toLocaleString('en-US', {minimumFractionDigits: 2}) + ' PHP';
                let str_change = change.toLocaleString('en-US', {minimumFractionDigits: 2}) + ' PHP';
                
                $('.new_transaction_confirm_tendered_amount').html(str_tendered_amount);
                $('.new_transaction_confirm_sale').html(str_total_sale);
                $('.new_transaction_confirm_change').html(str_change);
                $('#modal_transaction_confirm').show();
                $('#modal_transaction_confirm .confirm').focus();
            }
            
        }
    })

    function ready(){
        display_filters();
        display_products();
        // clear_list();
    }

    function record_transaction(tendered_amount){
        console.log('NEW TRANSACTION PROCESSING');
        let total_sale = 0.0;
        let total_profit = 0.0;
        for(i = 0; i < li; i++){
            if (list[i][100] === 'skip'){
                continue;
            }
            // price * quantity
            product_sale = parseFloat(list[i][6]) * parseFloat(list[i][4]);
            total_sale = parseFloat(total_sale) + parseFloat(product_sale);

            // (price - cost) * quantity
            product_profit = parseFloat(parseFloat(list[i][6]) - parseFloat(list[i][5])) * parseFloat(list[i][4]);
            total_profit = parseFloat(total_profit) + parseFloat(product_profit) 
        }

        let change_amount = tendered_amount - total_sale;
        // alert(change_amount);
        // alert ('test: ' + insert_transaction(total_sale, total_sale));
        let new_transaction_id = insert_transaction(total_sale, total_profit, tendered_amount, change_amount);
        if(new_transaction_id){
            for(i = 0; i < li; i++){
                if (list[i][100] === 'skip'){
                    continue;
                }
                // alert(new_transaction_id + "|" + list[i][0] + "|" + list[i][4] + "|" + list[i][5] + "|" + list[i][6])
                $.ajax({
                    url: '../models/insert/insert_transaction_detail.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        transaction_id: new_transaction_id,
                        product_code: list[i][0],
                        quantity: list[i][4],
                        current_cost: list[i][5],
                        current_price: list[i][6]
                    },
                    success: function(response){
                        console.log('NEW detail id#'+ response + ' |index: ' + i);
                    },
                    error: function(response){
                        console.log('ERROR transaction detail: '+ response);
                    }
                })

                $.ajax({
                    url: '../models/update/update_product_stock_out.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        product_code: list[i][0],
                        amount: list[i][4]
                    },
                    success: function(response){
                        if(response.status === 'success'){
                            console.log('Updated inventory stock levels');
                            // alertify.success(response.message);
                            $('.modals').hide();
                        }else if(response.status === 'error'){
                            alertify.error(response.message);
                        }
                    },
                    error: function(response){
                        console.log('ERROR transaction detail: '+ response);
                    }
                })
            }
            alertify.success('Processed Transaction');
            reset_list();
            toggle_payment_view();
            $('#tendered_amount').val('');
            console.log('PROCESSED TRANSACTION');
        }else{
            console.log('PROCESSING ERROR');
        }
        
    }

    $('.cards').on('click', '.catalog_product', function(){
        let id = $(this).data('id');
        let brand = $(this).data('brand');
        let name = $(this).data('name');
        let variant = $(this).data('variant');
        let size = $(this).data('size');
        let cost = $(this).data('cost');
        let price = $(this).data('price');
        let sale_type_id = $(this).data('sale_type_id');

        add_item_list(id, name, variant, size, cost, price, sale_type_id, brand);
    })

    function add_item_list(id, name, variant, size, cost, price, sale_type_id, brand){
        console.log('add_item_list()');
        let inventory_stock = get_stock(id);
        
        if(inventory_stock <= 0){
            alertify.error('Stock Unavailable');
            return;
        }

        if(exist_in_list(id) === false){
            // IF PRODUCT IS NEW

            // list data reference
            list[li] = [id, name, variant, size, 1, cost, price, sale_type_id, brand];
            console.log('NEW list no' + (li+1) + ': ' + list[li]);
            li = parseInt(li) + parseInt(1);
        }else{
            // IF PRODUCT IS IN LIST

            let index = exist_in_list(id); //index of array in existing product in list
            let stock = list[index][4]; //stock

            if(stock >= inventory_stock){
                alertify.error('Stock Unavailable');
                return;
            }

            let new_stock = parseInt(stock) + parseInt(1);
            console.log('new stock level: '+new_stock);
            list[index][4] = new_stock;
        }

        update_list_display();
    }

    function reset_list(){
        li = 0;
        list = [];
        update_list_display();
    }

    function insert_transaction(total_sales_calc, total_profit_calc, tendered_amount_calc, change_amount_calc){
        let response;
        $.ajax({
            url: '../models/insert/insert_transaction.php',
            type: 'POST',
            dataType: 'json',
            async: false,
            data:{
                // total_sale : total_sales_calc,
                // total_profit : total_profit_calc,
                tendered_amount: tendered_amount_calc,
                change_amount: change_amount_calc,
                account_id: <?php echo json_encode($_SESSION['account_id']); ?>

            },
            success: function(id){
                // alert('success! id: '+ id);
                response = id;
            },
            error: function(error){
                console.log('ERROR: ' + error)
            }
            
        });
        return response;
    };
    function exist_in_list(id){
        for(i = 0; i < li; i++){
            if (list[i][100] === 'skip'){
                continue;
            }
            if (list[i][0] === id){
                console.log('FOUND existing, index: ' + i)
                return i;
            }
        }
        console.log('NOT FOUND in list: '+ id);
        return false
    }
    
    function update_list_display(){
        let list_i = li; //list index to avoid confusion
        let total_sale = 0.0;
        let row = ``;
        for(i1 = 0; i1 < list_i; i1++){
            if (list[i1][100] === 'skip'){
                continue;
            }
            product_sale = parseFloat(list[i1][6]) * parseFloat(list[i1][4]);
            total_sale = parseFloat(total_sale) + parseFloat(product_sale);
            let data_product_name = '';

            if(list[i1][8] != null){
                data_product_name += list[i1][8] + ', ';
            }
            if(list[i1][1] != null){
                data_product_name += list[i1][1];
            }
            if(list[i1][2] != null){
                data_product_name += ', '+list[i1][2];
            }
            if(list[i1][3] != null){
                data_product_name += ', '+list[i1][3];
            }

            // row += `
            //     <div class="row">

            //         <div class="middle">
            //            ${list[i1][4]} | ${list[i1][1]} ,${list[i1][2]}, ${list[i1][3]}
            //         </div>
            //         <div class="right">
            //             ${list[i1][6]}
            //         </div>
            //     </div>
            // `
            row += `
                <tr data-id="${list[i1][0]}" data-amount="${list[i1][4]}" data-name="${data_product_name}" data-sale_type_id="${list[i1][7]}">
                    <td>
                        ${list[i1][4]}
                    </td>
                    <td>
                        ${data_product_name}
                    </td>
                    <td class="product_list_price">
                        ${list[i1][6]}
                    </td>
                <tr>
            `
        }
        clear_list();
        $('.list table').html(row);
        $('.summary .row .right').html(total_sale.toLocaleString('en-US', {minimumFractionDigits: 2}) + ' PHP');


    }

    function clear_list(){
        // $('.list table').empty();
        // $('.summary .row .right').empty();
    }
    function display_products(category_id){
        console.log('displaying products');
        $.ajax({
            url:'../models/search/search_products.php',
            type: 'GET',
            dataType: 'json',
            data: {
                category_id: category_id,
                search: $('#product_catalog_search').val()
            },
            success: function(response){
                $('.cards').empty();
                $.each(response, function(index, record){

                    let availability = 'available';
                    if(record.stock <= 0){
                        availability = 'unavailable'
                    }
                    let data_product_name = '';
                    let data_product_size = '';

                    if(record.brand != null){
                        data_product_name += record.brand + ', ';
                    }
                    if(record.product_name != null){
                        data_product_name += record.product_name;
                    }
                    if(record.variant != null){
                        data_product_name += ', '+ record.variant;
                    }
                    if(record.size != null){
                        data_product_name += ', '+ record.size;
                        data_product_size += record.size;
                    }
                    if(record.unit != null){
                        data_product_name += record.unit;
                        data_product_size += record.unit;
                    }


                    let row = `
                    <div class='catalog_product ${availability}'
                        data-id='${record.product_code}' 
                        data-brand='${record.brand}'
                        data-name='${record.product_name}' 
                        data-variant='${record.variant}' 
                        data-size='${data_product_size}' 
                        data-cost='${record.cost}'
                        data-price='${record.price}'
                        data-sale_type_id='${record.sale_type_id}'
                    >
                        <div>   
                            ${data_product_name}
                        </div>
                        <div>
                            PHP ${record.price}
                            <div>Available: ${record.stock}</div>
                        </div>
                    </div>
                    `;
                    // let row = `

                    //     <div class='catalog_product'    
                    //         data-id='${record.product_code}' 
                    //         data-brand='${record.brand}' 
                    //         data-name='${record.product_name}' 
                    //         data-variant='${record.variant}' 
                    //         data-size='${record.size}' 
                    //         data-cost='${record.cost}'
                    //         data-price='${record.price}'
                    //     >
                    //         ${record.brand},
                    //         ${record.product_name},
                    //         ${record.variant},
                    //         ${record.size}
                    //     </div>

                    // `;
                $('.cards').append(row)
                });
            }
        })
    }

    function display_filters(){
        $.ajax({
            url:'../models/fetch/fetch_categories.php',
            type: 'GET',
            dataType: 'json',
            success: function(response){
                $.each(response, function(index, record){
                    let row = `
                    <div data-id="${record.category_id}">
                        ${record.category} 
                    </div>
                    `;
                $('.filters').append(row)
                });
            }
        })
    }
    function get_stock(id){
        let stock = 0;

        $.ajax({
            url:'../models/fetch/fetch_product_stock.php',
            type: 'GET',
            dataType: 'json',
            async: false,
            data: {
                id: id
            },
            success: function(response){
                if(response == 'empty'){
                    alertify.error('ERROR STOCK: ' + response);
                }else{
                    stock = response.stock;
                }
            },
            error: function(response){
                alertify.error('ERROR STOCK: ' + response);
            }
        })

        return stock;
    }
    function toggle_payment_view(){
        if(payment_mode){
            
            $('.filters').show();
            $('.cards').show();
            $('.change_interface').hide();

            let display = `Pay <div class="material-symbols-outlined">payments</div>`
            $('#payment_button').html(display)

            payment_mode = false;
        }else{
            $('.filters').hide();
            $('.cards').hide();
            $('.change_interface').show();
            $('#tendered_amount').focus();

            let display = `Cancel <div class="material-symbols-outlined">close</div>`
            $('#payment_button').html(display)

            payment_mode = true;
        }
        
    }
</script>
<script>
    load_asset('modal');
    modal_load('inventory', 'modal', 'product_new', 101);
    modal_load('inventory', 'modal', 'product_edit', 102);
    modal_load('inventory', 'modal', 'product_edit_confirm', 103);
    modal_load('inventory', 'modal menu', 'brand_menu', 104);
    modal_load('inventory', 'modal menu', 'category_menu', 105);
    modal_load('inventory', 'modal menu', 'location_menu', 106);
    modal_load('inventory', 'modal', 'product_restock', 107);
    modal_load('inventory', 'modal', 'product_delete_confirm', 109);
    modal_load('inventory', 'modal', 'master_data', 110, '#modal_master_data');
    modal_load('inventory', 'modal', 'master_data_edit', 111);
    modal_load('global','modal','profile', null, null, 'php');
    modal_load('inventory', 'modal','product_restore',112);
    modal_load('inventory', 'modal', 'master_data_delete_confirm',113);
    // $('.table').hide();
    // INITIALIZATION
    function table_mode(){
        $("#product_table").show();
        $(".cards").hide();
    }

    function cards_mode(){
        $("#product_table").hide();
        $(".cards").show();
    }

    let inventory_table = '';
    $(document).ready(function(){
        table_mode();
        inventory_table = $('#product_table').DataTable({
            "dom": 'p', 
            pageLength: 17        
        });
        $('.sec_nav .search_input').on('keyup', function(){
            inventory_table.search(this.value).draw();
        })
        $('.dt-paging').appendTo('.paging');

        ready_inventory();
    })

    $('.page_name').on('click', function(){
        window.location.href = 'home_page.php';
    });

    // let archive_mode = false;
    // $('.archive_button').on('click', function(){
    //     if(archive_mode == false){
    //         fetch_inventory(1);
    //         archive_mode = true;
    //     }else{
    //         fetch_inventory(0);
    //         archive_mode = false;
    //     }
    // });
    $('#archive_toggle').on('change',function(){
        let toggle_value = $(this).is(':checked');
        if(toggle_value){
            fetch_inventory(1);
        }else{
            fetch_inventory(0)
        }
    })

    // TOGLE TABLE / CARDS
    $("#table_mode").on("click", function(){
        table_mode();
    });
    $("#cards_mode").on("click", function(){
        cards_mode();
    })
    // DATA HANDLING
    function ready_inventory(){

        fetch_inventory();
        // CLICK ROW
        $("#product_table tbody").on('click','tr', function(event){
            console.log('dbl click detected');
            let row_id = inventory_table.row(this).data();
            
            $.ajax({
                url: '../models/fetch/fetch_product.php',
                type: 'GET',
                data: {
                    product_code : row_id[0]
                },
                dataType: 'json',
                success: function(response){
                    if(response.archived == 0){
                        $('#update_product_code_store').val(response.product_code);
                        $('#update_product_name').val(response.product_name);
                        $('#update_variant').val(response.variant);
                        $('#update_size').val(response.size);
                        $('#update_unit').val(response.unit_id);
                        $('#update_brand').val(response.brand);
                        $('#update_category').val(response.category);
                        $('#update_product_code').val(response.product_code);
                        $('#update_cost').val(response.cost);
                        $('#update_price').val(response.price);
                        $('#update_location').val(response.location);
                        $('#update_sale_type').val(response.sale_type_id);
                        $('#update_product_registration_id').val(response.product_registration_id);
                        $('#update_category_id').val(response.category_id);
                        $('#update_brand_id').val(response.brand_id);
                        $('#update_location_id').val(response.location_id);
                        $('.modals').hide();
                        $('#modal_product_edit').show();
                    }else if(response.archived == 1) {
                        $('#modal_product_restore').show();
                        $('#restore_product_code').val(response.product_code);
                        let row = 
                        `
                        <tr>
                            <td>${response.product_code}</td>
                            <td>${response.product_name}</td>
                            <td>${response.variant}</td>
                            <td>${response.size}</td>
                            <td>${response.brand}</td>
                            <td>${response.category}</td>
                            <td>${response.location}</td>
                            <td>${response.cost}</td>
                            <td>${response.price}</td>
                            <td>${response.stock}</td>
                        </tr>
                        `;
                        $('#modal_product_restore tbody').append(row);
                    }
                },
                error: function(error){
                    alertify.error(error);
                }
            });
        });
    }

    function fetch_inventory(archived = 0){
        $.ajax({
            url: '../models/fetch/fetch_products.php',
            type: 'GET',
            dataType: 'json',
            data:{
                archived    : archived
            },
            success: function(response){

                inventory_table.clear();
                $.each(response, function(index, product){
                    let variant = "";
                    if(product.variant != null){
                        variant = product.variant;
                    };

                    let str_value = product.size;
                    let str_unit = product.unit;
                    
                    if(str_value === null){
                        str_value = '';
                    }
                    if(str_unit === null){
                        str_unit= '';
                    }

                    let str_product_size = str_value + str_unit;

                    inventory_table.row.add([
                        product.product_code,
                        product.brand,
                        product.product_name,
                        variant,
                        str_product_size,
                        product.category,
                        product.location,
                        product.sale_type,
                        product.cost,
                        product.price,
                        product.stock
                    ])

                    
                    let row = `
                    <div class="product">  
                        <div>
                            <div class="attribute">X</div>
                            <div class="value">${product.brand}, ${product.product_name}</div>
                        </div>
                        <div>
                            <div class="value"> ${variant}</div>
                        </div>
                        <div>
                            <div class="attribute">Category: </div>
                            <div class="value">${product.category}</div>
                        </div>
                        <div>
                            <div class="attribute">Location: </div>
                            <div class="value">${product.location}</div>
                        </div>
                        <div>
                            <div class="attribute">Price: </div>
                            <div class="value">${product.price}</div>
                        </div>
                    </div>
                    `;
                    
                    $('.cards').append(row);

                })
                inventory_table.draw(false);
                
                // $.each(response, function(index, product){

                    
                // })

                
            },
            error: function(response){
                alertify.error('ERROR inventory fetch: ' + response);
            }
        })
    }
</script>
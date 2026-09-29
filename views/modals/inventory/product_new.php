
        <form>
            <div class="modal_heading">
                <div class="caption">adding new product</div>
                <div class="product_name form_group">
                    Product :
                    <input type="text" id="new_product_registration" name="new_product_registration">
                </div>
            </div>

            <div class="modal_content">
                <div>
                    <div class="heading">
                        Specifications
                    </div>
                    <div class="form_group">
                        Variant
                        <input type="text" id="new_variant" name="new_variant">
                    </div>
                    <div class="form_group form_group_double">
                        Size
                        <div>
                            <input type="text" id="new_size" name="new_size">
                            <select name="new_unit" id="new_unit">
                                <option value="">unit?</option>
                            </select>
                        </div> 
                    </div>
                    <div class="form_group">
                        Brand
                        <input type="text" id="new_brand" name="new_brand">
                    </div>
                    <div class="form_group">
                        Category
                        <input type="text" id="new_category" name="new_category">
                    </div>
                    <div class="form_group">
                        Location
                        <input type="text" id="new_location" name="new_location">
                    </div>
                </div>
                <div>
                    <div class="heading">
                        Details
                    </div>
                    <div class="form_group">
                        Barcode
                        <input type="number" id="new_product_code" name="new_product_code" maxlength="13">
                    </div>
                    <div class="form_group">
                        Cost
                        <input type="number" id="new_cost" name="new_cost">
                    </div>
                    <div class="form_group">
                        Price
                        <input type="number" id="new_price" name="new_price">
                    </div>
                    <!-- <div class="form_group">
                        Stock
                        <input type="number" id="new_stock" name="new_stock">
                    </div> -->
                    <div class="form_group">
                        Sold By
                        <!-- Weight / QTY / -->
                        <!-- <input type="text" id="new_sale_type" name="new_sale_type"> -->
                        <select name="new_sale_type" id="new_sale_type">
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal_footer">
                <div>
                    <div class="cancel">Cancel</div>
                    <div class="clear">Clear</div>
                </div>
                <div>
                    <div class="confirm" tabindex="1">Confirm</div>
                </div>
            </div>
        </form>
        <script>

            $(document).ready(function(){
                let modal = '#modal_product_new';

                //CANCEL
                $(modal + ' .cancel').on('click', function(){
                    $(modal).toggle();
                })
                
                // CLOSE WHEN ADD PRODUCT IS CLOSED
                $('#modal_product_new .cancel').on('click', function(){
                    $('.modals').hide();
                })

                function finish_register(){
                    $('#modal_product_new').hide();
                    fetch_inventory();
                }

                //CLEAR
                $(modal + ' .clear').on('click', function(){
                    $(modal + ' form')[0].reset();
                })
               
                $("#new_product").on("click", function(){
                    if($(modal).is(':hidden')){
                        console.log(11);
                        $('.modals').hide();
                        $(modal).show();
                    }else{
                        console.log(22);
                        $(modal).hide();
                    }
                });

                $(modal + ' .confirm').on('click', function(){
                    let product_registration_val = $('#new_product_registration').val().trim();

                    let new_barcode = $('#new_product_code').val().trim();
                    
                    

                    if(required('#new_product_registration')){
                        alertify.error('Product name is required');
                        return;
                    };
                    if(new_barcode !== ''){
                        let test_barcode = check('product_code', new_barcode);
                        if(test_barcode != 0){
                            alertify.error('Barcode is already taken');
                            return;
                        }
                    }
                    if(required('#new_price')){
                        alertify.error('Price is required');
                        return;
                    };
                    if(required('#new_cost')){
                        alertify.error('Cost is required');
                        return;
                    };

                    let brand_val = $('#new_brand').val().trim();
                    let category_val = $('#new_category').val().trim();
                    let location_val = $('#new_location').val().trim();
    
                    let validated = true;
                    let new_product_registration_id = check('product_registration', product_registration_val);

                    let new_brand_id = null;
                    let new_category_id = null;
                    let new_location_id = null;

                    if(brand_val !== ''){
                        new_brand_id = check('brand', brand_val);
                    }

                    if(category_val !== ''){
                        new_category_id = check('category', category_val);
                    }

                    if(location_val !== ''){
                        new_location_id = check('location', location_val);
                    }


                    
                    
                    

                    let new_unit = $('#new_unit').val().trim();
    
                    if(validated == true){
                        if(new_product_registration_id == 0){
                            new_product_registration_id = insert('product_registration', product_registration_val)
                        }
                        if(new_brand_id == 0){
                            new_brand_id = insert('brand', brand_val)
                        }
                        if(new_category_id == 0){
                            new_category_id = insert('category', category_val)
                        }
                        if(new_location_id == 0){
                            new_location_id = insert('location', location_val)
                        }
                        $.ajax({
                            url: '../models/insert/insert_product.php',
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                new_product_code:               new_barcode,
                                new_brand_id:                   new_brand_id,
                                new_product_registration_id:    new_product_registration_id,
                                new_variant:                    $('#new_variant').val(),
                                new_size:                       $('#new_size').val(),
                                new_category_id:                new_category_id,
                                new_cost:                       $('#new_cost').val(),
                                new_price:                      $('#new_price').val(),
                                new_location_id:                new_location_id,
                                new_sale_type_id:               $('#new_sale_type').val(),
                                new_unit_id:                    new_unit
                            },
                            success: function(response){
            
                                if(response.status === 'success'){
                                    alertify.success(response.message);
                                    finish_register();
                                }else if(response.status === 'error'){
                                    alertify.error(response.message);
                                }
    
                                $(modal + ' form')[0].reset();
                            },
                            error: function(response){
                                alert('ERROR product insert: ' + response.message);
                            }
                        });
                    }
    
                })
                 $.ajax({
                    url: '../models/fetch/fetch_sale_types.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response){
                        $.each(response, function(index, sale_types){
                            let row = `
                            <option value="${sale_types.sale_type_id}">${sale_types.sale_type}</option>
                            `;
                            
                            $('#new_sale_type').append(row);

                        });
                    }        
                })
                $.ajax({
                    url: '../models/fetch/fetch_unit_of_measurements.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response){
                        $.each(response, function(index, unit_of_measurement){
                            let row = `
                            <option value="${unit_of_measurement.unit_id}">${unit_of_measurement.unit_of_measurement}</option>
                            `;
                            
                            $('#new_unit').append(row);

                        });
                    }        
                })
                function check(type, value){
                    let result = ''
                    $.ajax({
                        url: '../models/check/check_' + type + '.php',
                        type: 'GET',
                        dataType: 'json',
                        async: false,
                        data: {
                            name: value
                        },          
                        success: function(response){
                            if(response == 'empty'){
                                result = 0;
                                console.log(type+'_id is 0');
                            }else{
                                // alertify.success(type+'_id' + response[type + '_id']);
                                result = response[type + '_id'];
                                console.log(type+'_id is' + response[type + '_id'])
                            }
                        },
                        error: function(response){
                            console.log('ERROR IN CHECK: '+ type + '|'+  response);
                        }
                    })
                    return result;
                }

                function insert(type, value){
                    let result = '';
                    $.ajax({
                        url: '../models/insert/insert_' + type + '.php',
                        type: 'POST',
                        async: false,
                        dataType: 'json',
                        data:{
                            name: value
                        },
                        success: function(response){
                            console.log(type +' ID: ' + response);
                            result = response;
                        },
                        error: function(response){
                            console.log('ERROR IN INSERT: '+ type + '|'+  response);
                        }
                    })
                    return result
                }
            });
        </script>
        

        <form id="edit_product_form">
            <div class="modal_heading">
                <div class="caption">updating product</div>
                <input type="hidden" id="update_product_code_store" name="update_product_code_store">
                <input type="hidden" id="update_product_registration_id" name="update_product_registration_id">
                <input type="hidden" id="update_brand_id" name="update_brand_id">
                <input type="hidden" id="update_category_id" name="update_category_id">
                <input type="hidden" id="update_location_id" name="update_location_id">
                <div class="product_name form_group">
                    Product:
                    <input type="text" id="update_product_name" name="update_product_name">
                </div>
            </div>

            <div class="modal_content">
                <div>
                    <div class="heading">
                        Specifications
                    </div>
                    <div class="form_group">
                        Variant
                        <input type="text" id="update_variant" name="update_variant">
                    </div>
                    <div class="form_group form_group_double">
                        Size
                        <div>
                            <input type="text" id="update_size" name="update_size">
                            <select name="update_unit" id="update_unit">
                                <option value="">unit?</option>
                            </select>
                        </div>
                    </div>
                    <div class="form_group">
                        Brand
                        <input type="text" id="update_brand" name="update_brand">
                    </div>
                    <div class="form_group">
                        Category
                        <input type="text" id="update_category" name="update_category">
                    </div>
                    <div class="form_group">
                        Location
                        <input type="text" id="update_location" name="update_location">
                    </div>
                </div>
                <div>
                    <div class="heading">
                        Details
                    </div>
                    <div class="form_group">
                        Barcode
                        <input type="text" id="update_product_code" name="update_product_code" maxlength="13">
                    </div>
                    <div class="form_group">
                        Cost
                        <input type="number" id="update_cost" name="update_cost">
                    </div>
                    <div class="form_group">
                        Price
                        <input type="number" id="update_price" name="update_price">
                    </div>
                    <div class="form_group">
                        Sold By
                        <!-- Weight / QTY / -->
                        <!-- <input type="text" id="update_sale_type" name="update_sale_type"> -->
                        <select name="update_sale_type" id="update_sale_type">
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal_footer">
                <div>
                    <div class="cancel">[CANCEL]</div>
                    <div class="clear">[DELETE]</div>
                    
                </div>
                <div>
                    <div class="confirm">[CONFIRM]</div>
                </div>
            </div>
        </form>
        <script>
            $(document).ready(function(){
                let modal = '#modal_product_edit ';
                // CANCEL
                $(modal + '.cancel').on('click', function(){
                    $(modal).toggle();
                });
                //UNDO
                // $(modal + '.clear').on('click', function(){
                    
                // });
                // confirm
                $(modal + '.confirm').on('click', function(){
                    if(required('#update_product_name')){
                        alertify.error('Product name is required');
                        return;
                    };
                    if(required('#update_price')){
                        alertify.error('Price is required');
                        return;
                    };
                    if(required('#update_cost')){
                        alertify.error('Cost is required');
                        return;
                    };

                    let update_barcode = $('#update_product_code').val().trim();
                    let current_barcode = $('#update_product_code_store').val().trim();
                    
                    if(update_barcode !== '' && update_barcode !== current_barcode){
                        update_barcode = check('product_code', update_barcode);
                        if(update_barcode != 0){
                            alertify.error('Barcode is already taken');
                            return;
                        }
                    }
                    $("#modal_product_edit_confirm").show();
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
                })

                

                $('#modal_product_edit .cancel').on('click', function(){
                    $('.modals').hide();
                })
                
                // $("#product_table tbody").on('dblclick','tr', function(){
                //     if($(modal).is(':hidden')){
                //         console.log(11);
                //         $('.modal').hide();
                //         $(modal).show();
                //     }else{
                //         console.log(22);
                //         $(modal).hide();
                //     }
                // });

                // DROPBOX
                $.ajax({
                    url: '../models/fetch/fetch_sale_types.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response){
                        $.each(response, function(index, sale_types){
                            let row = `
                            <option value="${sale_types.sale_type_id}">${sale_types.sale_type}</option>
                            `;
                            
                            $('#update_sale_type').append(row);

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
                            
                            $('#update_unit').append(row);

                        });
                    }        
                })

            });
        
        </script>
        
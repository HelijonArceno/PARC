
        <style>
            #update_product_confirm_form .form_group input{
                width: auto;
            }
        </style>
        <form>
            <div class="modal_heading">
                <div class="title">
                    Confirm Update?
                </div>
            </div>

            <div class="modal_content">
                <div>
                    <div class="heading">
                        Replicate Changes to:
                    </div>
                    <div class="form_group">
                        Name
                        <input type="checkbox" name="replicate_edit_product_registration" id="replicate_edit_product_registration" checked>
                    </div>
                    <div class="form_group">
                        Brand
                        <input type="checkbox" name="replicate_edit_brand" id="replicate_edit_brand">
                    </div>
                    <div class="form_group">
                        Category
                        <input type="checkbox" name="replicate_edit_category" id="replicate_edit_category">
                    </div>
                    <div class="form_group">
                        Location
                        <input type="checkbox" name="replicate_edit_location" id="replicate_edit_location">
                    </div>
                </div>
            </div>
            <div class="modal_footer">
                <div>
                    <div class="cancel">[CANCEL]</div>
                </div>
                <div>
                    <div class="confirm">[CONFIRM]</div>
                </div>
            </div>
        </form>
        <script>
            $(document).ready(function(){
                // INITIALIZATION
                let modal = "#modal_product_edit_confirm ";

                function close(){
                    $(modal).hide();
                }

                function finish_edit(){
                    $('#modal_product_edit').hide();
                    fetch_inventory();
                }



                // CANCEL
                $(modal + '.cancel').on('click', function(){
                    $(modal).hide();
                });
                //UNDO
                $(modal + '.clear').on('click', function(){
                    console.log('reset to defaults');
                });
                // CONFIRM
                $(modal + '.confirm').on('click', function(){
                    update_product();
                    close();
                });

                



                function update_product(){
                    let merge_input = {
                        'product_registration': false,
                        'brand': false,
                        'category': false,
                        'location': false
                    }
                    let product_registration_val = $('#update_product_name').val().trim();
                    let brand_val = $('#update_brand').val().trim();
                    let category_val = $('#update_category').val().trim();
                    let location_val = $('#update_location').val().trim();

                    let validated = true;
                    let update_product_registration_id = check('product_registration', product_registration_val);
                    
                    let update_brand_id = null;
                    let update_category_id = null;
                    let update_location_id = null;

                    if(brand_val !== ''){
                        update_brand_id = check('brand', brand_val);
                    }

                    if(category_val !== ''){
                        update_category_id = check('category', category_val);
                    }

                    if(location_val !== ''){
                        update_location_id = check('location', location_val);
                    }


                    if(validated == true){
                        if(update_product_registration_id == 0){

                            console.log('register name');
                            update_product_registration_id = insert('product_registration', $('#update_product_name').val());

                        }else if($('#replicate_edit_product_registration').is(':checked') == true && merge_input['product_registration'] == false){

                            console.log('update current name');
                            update('product_registration', $('#update_product_registration_id').val(), $('#update_product_name').val())
                        }

                        if(update_brand_id == 0){

                            console.log('insert brand');
                            update_brand_id = insert('brand',$('#update_brand').val());

                        }else if($('#replicate_edit_brand').is(':checked') == true && merge_input['brand'] == false){
                            
                            console.log('update current brand');
                            update('brand', $('#update_brand_id').val(), $('#update_brand').val())

                        } 

                        if(update_category_id == 0){

                            console.log('insert category');
                            update_category_id = insert('category', $('#update_category').val());

                        }else if($('#replicate_edit_category').is(':checked') == true && merge_input['category'] == false){
                            console.log('update category');
                            update('category', $('#update_category_id').val(), $('#update_category').val())
                        }

                        if(update_location_id == 0){
                            console.log('insert location');
                            update_location_id = insert('location', $('#update_location').val());

                        }else if($('#replicate_edit_location').is(':checked') == true && merge_input['location'] == false){
                            console.log('update location');
                            update('location', $('#update_location_id').val(), $('#update_location').val())
                        }

                        update_product();

                        
                        
                        function update_product(){
                            let update_unit = $('#update_unit').val().trim();
                            
                            console.log('product code: '+  $('#update_product_code_store').val());
                            console.log('new code: '+  $('#update_product_code').val());
                            $.ajax({
                                url: '../models/update/update_product.php',
                                type: 'POST',
                                dataType: 'json',
                                data: {
                                    update_product_code_store:         $('#update_product_code_store').val(),
                                    update_product_code:               $('#update_product_code').val(),
                                    update_brand_id:                   update_brand_id,
                                    update_product_registration_id:    update_product_registration_id,
                                    update_variant:                    $('#update_variant').val(),
                                    update_size:                       $('#update_size').val(),
                                    update_category_id:                update_category_id,
                                    update_cost:                       $('#update_cost').val(),
                                    update_price:                      $('#update_price').val(),
                                    update_location_id:                update_location_id,
                                    update_sale_type_id:               $('#update_sale_type').val(),
                                    update_unit_id:                    update_unit
                                },
                                success: function(response){
                
                                    if(response.status === 'success'){
                                        alertify.success('Successful Product Update');
                                        finish_edit();
                                    }else if(response.status === 'error'){
                                        alert('ERROR IN UPDATE1'+response.message);
                                    }
                                },
                                error: function(response){
                                    console.log('ERROR IN UPDATE2'+response);
                                }
                            });
                        }
                    }else{
                        console.log('unvalidated!');
                    }
                    function merge(type, old_id, new_id){
                        console.log('merging: '+ type)
                        $.ajax({
                            url: '../models/merge/merge_' + type + '.php',
                            type: 'POST',
                            dataType: 'json',
                            async: false,
                            data: {
                                existing_id: old_id,
                                new_id: new_id
                            },          
                            success: function(response){
                                console.log(response);
                            },
                            error: function(response){
                                alertify.error(response);
                            }
                        })  
                    }
                    function check(type, value){
                        let result = ''
                        if($('#replicate_edit_'+ type).is(':checked') == true){
                            console.log('replicate name');
                            result = check_merge(type, value);
                        }else{
                            console.log('checking for existing' + type);
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
                                    console.log('ERROR IN CHECK: '+ type);
                                }
                            })
                        }
                        return result;
                    }

                    function check_merge(type, value){
                        console.log('type: ' + type + '|value: ' + value);
                        let result = '';
                        $.ajax({
                            url: '../models/check/check_' + type + '.php',
                            type: 'GET',
                            dataType: 'json',
                            async: false,
                            data: {
                                name: value
                            },          
                            success: function(response){
                                if(response != 'empty'){
                                    console.log('cant replicate! continuing with merging ' + type);
                                    // TRUE MERGE
                                    merge_input[type] = true;
                                    // CONTINUE WITH MERGE
                                    merge(type,$('#update_'+type+'_id').val(), response[type +'_id']);
            
                                    result = response[type +'_id'];
            
                                }else{
                                    console.log('default ' + type + '_id: ' + $('#update_' + type + '_id').val());
                                    result = $('#update_' + type + '_id').val();
                                }
                            },
                            error: function(response){
                                alertify.error("check_merge ERROR: "+ response);
                            }
                        })
                        return result;
                    }
                    function insert(type, val){
                        let result = ''
                        $.ajax({
                            url: '../models/insert/insert_'+ type +'.php',
                            type: 'POST',
                            dataType: 'json',
                            async: false,
                            data:{
                                name: val
                            },
                            success: function(response){
                                alertify.success('ID:' + response);
                                result = response;
                            },
                            error: function(response){
                                alertify.error(response);
                            }

                        })
                        return result;
                    }
                    function update(type, id, value){
                        $.ajax({
                            url: '../models/update/update_'+ type +'.php',
                            type: 'POST',
                            dataType: 'json',
                            async: false,
                            data:{
                                id: id,
                                name: value
                            },
                            success: function(response){
                                console.log('updated ' + type);
                                alertify.success(response);
                            },
                            error: function(response){
                                alertify.error(response);
                            }
    
                        })
                    }
                }

            });
        </script>
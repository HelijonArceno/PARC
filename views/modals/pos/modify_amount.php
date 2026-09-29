
    <style>
        #modal_modify_amount{
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);

            .modify_amount_form_group{
                
                align-content: center;
                display: flex;
                
                input::-webkit-outer-spin-button, input::-webkit-inner-spin-button{
                    display: none;
                }
                input{
                    width: 100px;
                    font-size: var(--text-body-lg);
                    flex: 1;
                    text-align: center;
                }
                div{
                    font-size: var(--text-body-lg);
                }
            }
            .modal_content > div{
                width: 100%;
                align-items: center;
            }
            .modal_heading{
                display: flex;
                flex-direction: column;
                gap: 16px;
            }
            .caption{
                text-align: center;
                color: var(--color-fog)
            }
            .title{
                text-align: center;
            }
        }
        
    </style>
        <form>
            <div class="modal_heading">
                <div class="title">
                    Modifying Amount
                </div>
                <div class="caption"></div>
                <input type="hidden" id="edit_product_list_product_code" name="edit_product_list_product_code">
                <input type="hidden" id="edit_product_list_sale_type_id" name="edit_product_list_sale_type_id">
            </div>

            <div class="modal_content">
                <div>
                    
                    <div class="heading">
                        Product amount
                    </div>
                    <div class="modify_amount_form_group">
                        <div class="button_main material-symbols-outlined amount_decrease">keyboard_arrow_left</div>
                        <input type="number" id="edit_product_list_amount" name="edit_product_list_amount">
                        <div class="button_main material-symbols-outlined amount_increase">keyboard_arrow_right</div>
                    </div>
                </div>
            </div>
            <div class="modal_footer">
                
                <div>
                    <div class="cancel material-symbols-outlined">close</div>
                </div>
                <div>
                    <div class="clear material-symbols-outlined">delete</div>
                </div>
                <div>
                    <div class="confirm material-symbols-outlined">check</div>
                </div>
            </div>
        </form>
        <script>
            

            $(document).ready(function(){
                let inventory_stock;
                let sale_type_id;

                $('.list table').on('click', 'tr', function(){
                    if(payment_mode == false){
                        let id = $(this).data('id');
                        let amount = $(this).data('amount');
                        let name = $(this).data('name');
                        sale_type_id = $(this).data('sale_type_id');
    
                        $('#modal_modify_amount').toggle();
                        $('#edit_product_list_product_code').val(id);
                        $('#edit_product_list_sale_type_id').val(sale_type_id);
                        $('#edit_product_list_amount').val(amount);
                        $('#edit_product_list_amount').focus();
                        $('#modal_modify_amount .caption').html(name);
    
                        inventory_stock = get_stock($('#edit_product_list_product_code').val());
                    }else{
                        alertify.error('Cannot modify list while in payment');
                    }
                })
                
                let modal = '#modal_modify_amount'; //INSERT MODAL NAME HERE
                //CANCEL
                $(modal + ' .cancel').on('click', function(){
                    $(modal).toggle();
                });
                

                $(modal + ' .confirm').on('click', function(){
                    let product_code = $('#edit_product_list_product_code').val();
                    inventory_stock = get_stock(product_code);
                    let amount = $('#edit_product_list_amount').val();

                    if(sale_type_id == 2){
                        inventory_stock = parseFloat(inventory_stock).toFixed(2);
                        amount = parseFloat(amount).toFixed(2);
                        alert('inventory_stock: ' + inventory_stock + ' amount: ' + amount);
                        
                        
                        
                        if(parseFloat(amount) > parseFloat(inventory_stock)){
                            alertify.error('Amount reaches above inventory stock value');
                            $('#edit_product_list_amount').val(inventory_stock);
                        }else if(amount < 0){
                            alertify.error('Amount must be greater than 0.')
                            $('#edit_product_list_amount').val(1);
                        }else{
                            $(modal).toggle();
                            for(i = 0; i < li; i++){
                                if(list[i][0] == product_code){
                                    list[i][4] = amount;
                                    update_list_display();
                                    alertify.success('Updated amount');
                                    break;
                                }
                            }
                        }
                    }else{
                        inventory_stock = parseInt(inventory_stock);
                        amount = parseInt(amount);

                        if(parseInt(amount) > parseInt(inventory_stock)){
                            alertify.error('Amount reaches above inventory stock value');
                            $('#edit_product_list_amount').val(inventory_stock);
                        }else if(amount <= 0){
                            alertify.error('Amount must be greater than 0.')
                            $('#edit_product_list_amount').val(1);
                        }else{
                            $(modal).toggle();
                            for(i = 0; i < li; i++){
                                if(list[i][0] == product_code){
                                    list[i][4] = amount;
                                    update_list_display();
                                    alertify.success('Updated amount');
                                    break;
                                }
                            }
                        }
                    }


                    
                });

                $(modal + ' .clear').on('click', function(){
                    let product_code = $('#edit_product_list_product_code').val();
                    for(i = 0; i < li; i++){
                        if(list[i][0] == product_code){
                            list[i][100] = 'skip';
                            update_list_display();
                            alertify.success('Removed product in list');
                            $(modal).hide();
                            break;
                        }
                    }
                });

                $('.cards').on('click', '.catalog_product', function(){
                    $(modal).hide();
                })

                $(modal).on('keydown', function(e){
                    let amount = $('#edit_product_list_amount').val();
                    if(e.key === 'ArrowRight'){
                        amount_increase(amount);
                    }
                    if(e.key === 'ArrowLeft'){
                        amount_decrease(amount);
                    }
                });

                $(modal + ' .amount_increase').on('click', function(){
                    let amount = $('#edit_product_list_amount').val();
                    amount_increase(amount);
                });
                $(modal + ' .amount_decrease').on('click', function(){
                    let amount = $('#edit_product_list_amount').val();
                    amount_decrease(amount);
                });

                function amount_increase(amount, sale_type_id){
                    if(parseInt(amount) >= parseInt(inventory_stock)){
                        console.log('ERROR FUNCTION: Increase');
                        console.log(amount);
                        console.log(inventory_stock);
                        
                        alertify.error('Amount reaches above inventory stock value')
                        $('#edit_product_list_amount').val(inventory_stock);
                        return;
                    }

                    let new_amount = parseInt(amount) + parseInt(1);
                    $('#edit_product_list_amount').val(new_amount)
                }
                function amount_decrease(amount, sale_type_id){
                    if(amount < 0 && sale_type_id == 2){
                        console.log('ERROR FUNCTION: Decrease');
                        alertify.error('Amount must be greater than 0')
                        $('#edit_product_list_amount').val(0);
                        return;
                    }else if(amount <= 1){
                        console.log('ERROR FUNCTION: Decrease');
                        alertify.error('Amount must be greater than 0')
                        $('#edit_product_list_amount').val(0);
                        return;
                    }
                    let new_amount = parseInt(amount) - parseInt(1);
                    $('#edit_product_list_amount').val(new_amount)
                }
            });
        </script>
        
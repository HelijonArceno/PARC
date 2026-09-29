<?php 
    session_start();
?>
        <form>
            <div class="modal_heading">
                <div class="caption">caption here</div>
                <div class="title">
                    Restocking
                </div>
            </div>

            <div class="modal_content">
                <div>
                    <div class="heading">
                        Details
                    </div>
                    <div class="form_group">
                        Barcode
                        <input type="text" id="restock_barcode" name="restock_barcode" maxlength="13">
                    </div>
                    <div class="form_group">
                        Quantity
                        <input type="number" id="restock_quantity" name="restock_quantity">
                    </div>
                    <div class="form_group">
                        Expiry
                        <input type="date" id="restock_expiry" name="restock_expiry">
                    </div>
                </div>
            </div>
            <div class="modal_footer">
                <div>
                    <div class="cancel">[CANCEL]</div>
                    <div class="clear">[CLEAR]</div>
                </div>
                <div>
                    <div class="confirm">[CONFIRM]</div>
                </div>
            </div>
        </form>
        <script>
            $(document).ready(function(){
                let modal = '#modal_product_restock'; //INSERT MODAL NAME HERE
                //CANCEL
                $(modal + ' .cancel').on('click', function(){
                    $(modal).toggle();

                })
                //CLEAR
                $(modal + ' .clear').on('click', function(){
                    $(modal + ' form')[0].reset();
                })
               

                $(modal + ' .confirm').on('click', function(){
                    if(required('#restock_barcode')){
                        alertify.error('Barcode is required');
                        return;
                    };
                    if(required('#restock_quantity')){
                        alertify.error('Restock Amount is required');
                        return;
                    };

                    $.ajax({
                        url: '../models/insert/insert_stock_in.php',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            product_code:   $('#restock_barcode').val(),
                            quantity:       $('#restock_quantity').val(),
                            expiry:         $('#restock_expiry').val(),
                            account_id: <?php echo json_encode($_SESSION['account_id']); ?>
                        },
                        success: function(response){
                            $(modal + ' form')[0].reset();
                            fetch_inventory();
                            alertify.success('Restocked Product Code:' + $('#restock_barcode').val() + ' with QTY: ' + $('#restock_quantity').val());
                        },
                        error: function(response){
                            alertify.error('ERROR insert: ' + response);
                        }
                    })

                    // $.ajax({
                    //     url: '../models/insert/insert_stock_in.php',
                    //     type: 'POST',
                    //     dataType: 'json',
                    //     data: {
                    //         product_code:   $('#restock_barcode').val(),
                    //         quantity:       $('#restock_quantity').val(),
                    //         expiry:         $('#restock_expiry').val()
                    //     },
                    //     success: function(response){
                    //         fetch_inventory();
                    //         alertify.success('Restocked Product Code:' + $('#restock_barcode').val() + ' with QTY: ' + $('#restock_quantity').val());
                    //     },
                    //     error: function(response){
                    //         alertify.error('ERROR insert: ' + response);
                    //     }
                    // })
                })

                // close all modals before opening
                $('#restock_product').on('click', function(){
                    if($(modal).is(':hidden')){
                        console.log(1)
                        $('.modals').hide();
                        $(modal).show();
                    }else{
                        console.log(2)
                        $(modal).hide();
                    }
                })
            });
        </script>
        
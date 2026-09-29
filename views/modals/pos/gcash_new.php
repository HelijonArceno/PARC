
        <form>
            <div class="modal_heading">
                <div class="caption">record cash-in/cash-out</div>
                <div class="title">
                    G-Cash Transactions
                </div>
            </div>

            <div class="modal_content">
                <div>
                    <div class="heading">
                        Transaction Details
                    </div>
                    <div class="form_group">
                        Amount
                        <input type="number" id="new_gcash_amount" name="new_gcash_amount">
                    </div>
                    <div class="form_group">
                        Type
                        <select name="new_gcash_type" id="new_gcash_type">
                        </select>
                    </div>
                </div>
                <!-- <div>
                    <div class="heading">
                        SUBTITLE
                    </div>
                    <div class="form_group">  
                        text
                        <input type="text" id="new_variant" name="new_variant">
                    </div>
                </div> -->
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
                let modal = '#modal_gcash_new'; //INSERT MODAL NAME HERE
                //CANCEL
                $(modal + ' .cancel').on('click', function(){
                    $(modal).toggle();

                })
                //CLEAR
                $(modal + ' .clear').on('click', function(){
                    $(modal + ' form')[0].reset();
                })

                $('.gcash_button').on('click', function(){
                    if($(modal).is(':hidden')){
                        $('.modals').hide();
                        $(modal).show();
                    }else{
                        $(modal).hide();
                    }
                })
               

                $(modal + ' .confirm').on('click', function(){
                    let amount = $('#new_gcash_amount').val();
                    if(amount <= 0){
                        alertify.error('GCash amount must be greater than 0');
                    }else{
                        $(modal).toggle();
                        $('#modal_gcash_new_confirm').show();
                        
                        let charge = calc_charge(amount);
                        let sale = parseFloat(amount) + parseFloat(charge);
    
                        let str_amount  = amount.toLocaleString('en-US', {minimumFractionDigits: 2}) + ' PHP';
                        let str_charge  = charge.toLocaleString('en-US', {minimumFractionDigits: 2}) + ' PHP';
                        let str_sale    = sale.toLocaleString('en-US', {minimumFractionDigits: 2}) + ' PHP';
                        $('.new_gcash_confirm_amount').html(str_amount);
                        $('.new_gcash_confirm_charge').html(str_charge);
                        $('.new_gcash_confirm_sale').html(str_sale);
                    }
                })

                $.ajax({
                    url: '../models/fetch/fetch_gcash_types.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response){
                        $.each(response, function(index, gcash_types){
                            let row = `
                            <option value="${gcash_types.gcash_ty}">${gcash_types.gcash_type}</option>
                            `;
                            
                            $('#new_gcash_type').append(row);

                        });
                    }        
                })

                function calc_charge(new_gcash_amount){
                    let ga = new_gcash_amount;
                    let charge = 5;
                    if(ga <= 100){
                        charge = 5;
                    }else if (ga <= 1500){
                        charge += (Math.ceil((ga / 500)) * 5);
                        
                    }else{
                        charge = 20;
                        charge += (Math.ceil(((ga - 1500) / 500)) * 10);
                    }
                    return charge;
                }
            });
        </script>
        
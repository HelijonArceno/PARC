
        <form>
            <div class="modal_heading">
                <div class="caption">record top-up</div>
                <div class="title">
                    Cellphone Top-up
                </div>
            </div>

            <div class="modal_content">
                <div>
                    <div class="heading">
                        Top-up Details
                    </div>
                    <div class="form_group">
                        Amount
                        <input type="number" id="new_top_up_amount" name="new_top_up_amount">
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
                let modal = '#modal_top_up_new'; //INSERT MODAL NAME HERE
                //CANCEL
                $(modal + ' .cancel').on('click', function(){
                    $(modal).toggle();

                })
                //CLEAR
                $(modal + ' .clear').on('click', function(){
                    $(modal + ' form')[0].reset();
                })

                $('.top_up_button').on('click', function(){
                    if($(modal).is(':hidden')){
                        $('.modals').hide();
                        $(modal).show();
                    }else{
                        $(modal).hide();
                    }
                })
               

                $(modal + ' .confirm').on('click', function(){
                    let amount = $('#new_top_up_amount').val();
                    
                    if(amount <= 0){
                        alertify.error('Top-up amount must be greater than 0');
                    }else{
                        $(modal).toggle();
                        $('#modal_top_up_new_confirm').show();
                        let charge = calc_charge(amount);
                        let sale = parseFloat(amount) + parseFloat(charge);
    
                        let str_amount  = amount.toLocaleString('en-US', {minimumFractionDigits: 2}) + ' PHP';
                        let str_charge  = charge.toLocaleString('en-US', {minimumFractionDigits: 2}) + ' PHP';
                        let str_sale    = sale.toLocaleString('en-US', {minimumFractionDigits: 2}) + ' PHP';
                        $('.new_top_up_confirm_amount').html(str_amount);
                        $('.new_top_up_confirm_charge').html(str_charge);
                        $('.new_top_up_confirm_sale').html(str_sale);
                    }
                })

                function calc_charge(amount){
                    let charge = 5;
                    if(amount < 100){
                        charge = 5;
                    }else if (amount < 500){
                        charge += (Math.ceil((amount / 500)) * 5);
                    }else{
                        charge = (Math.floor((amount / 500)) * 15);
                    }
                    return charge;
                }

            });
        </script>
        
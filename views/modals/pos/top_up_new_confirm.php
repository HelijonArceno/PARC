<?php 
    session_start();
?>
        <style>
            #modal_top_up_new_confirm{
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                .row{
                    display: flex;
                    justify-content: space-between;
                    gap: var(--section-gap);
                    padding: var(--element-gap);
                    color: var(--color-fog);
                    font-size: var(--text-body-lg);
                    div{
                        font-size: var(--text-body-lg);
                    }
                }
                .row:last-child{
                    border-top: var(--strong-border);
                }
                .title{
                    text-align: center;
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
                .modal_content .heading{
                    text-align: center;
                }
            }
        </style>
        <form>
            <div class="modal_heading">
                <div class="title">
                    Top-up Confirmation
                </div>
                <div class="caption">Has the customer paid yet?</div>
            </div>

            <div class="modal_content">
                <div>
                    <div class="heading">
                        Summary
                    </div>
                    <div class="row">
                        Amount
                        <div class="new_top_up_confirm_amount">123</div>
                    </div>
                    <div class="row">
                        Charge
                        <div class="new_top_up_confirm_charge">123</div>
                    </div>
                    <div class="row">
                        Total sale
                        <div class="new_top_up_confirm_sale">1234123</div>
                    </div>
                </div>
            </div>
            <div class="modal_footer">
                <div>
                    <div class="cancel">Cancel</div>
                </div>
                <div>
                    <div class="confirm">Confirm</div>
                </div>
            </div>
        </form>
        <script>
            $(document).ready(function(){
                // INITIALIZATION
                let modal = "#modal_top_up_new_confirm ";
                //CANCEL
                $(modal + ' .cancel').on('click', function(){
                    $(modal).toggle();
                    $('#modal_top_up_new').show();
                })           

                $(modal + ' .confirm').on('click', function(){
                    $.ajax({
                        url: '../models/insert/insert_top_up.php',
                        type: 'POST',
                        dataType: 'json',
                        data:{
                            amount: $('#new_top_up_amount').val(),
                            charge: calc_charge($('#new_top_up_amount').val()),
                            account_id: <?php echo json_encode($_SESSION['account_id']); ?>
                        },
                        success: function(response){
                            if(response.status === 'success'){
                                alertify.success(response.message);
                                $('.modals').hide();
                            }else if(response.status === 'error'){
                                alertify.error(response.message);
                            }
                        },
                        error: function(response){
                            console.log('ERROR IN TOPUP: ' + response);
                        }
                    });
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
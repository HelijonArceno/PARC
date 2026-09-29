
        <style>
            #modal_transaction_confirm{
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
                    color: var(--color-fog);
                }
                .modal_content .heading{
                    text-align: center;
                }
            }
        </style>
        <form>
            <div class="modal_heading">
                <div class="title">
                    Transaction Confirmation
                </div>
                <div class="caption">Is there sufficient change available?</div>
            </div>

            <div class="modal_content">
                <div>
                    <div class="heading">
                        Summary
                    </div>
                    <div class="row">
                        Total sale
                        <div class="new_transaction_confirm_sale">1234123</div>
                    </div>
                    <div class="row">
                        tendered_amount
                        <div class="new_transaction_confirm_tendered_amount">1234123</div>
                    </div>
                    <div class="row">
                        Change
                        <div class="new_transaction_confirm_change">123</div>
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
                let modal = "#modal_transaction_confirm";
                //CANCEL
                $(modal + ' .cancel').on('click', function(){
                    $(modal).toggle();
                })           

                $(modal + ' .confirm').on('click', function(){
                    record_transaction($('#tendered_amount').val());
                })
            });
        </script>
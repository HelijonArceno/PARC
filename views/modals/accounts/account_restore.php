
        <form>
            <div class="modal_heading">
                <div class="title">
                    Restore Account?
                </div>
                <input type="hidden" id="restore_account_id" name="restore_account_id">
            </div>

            <!-- <div class="modal_content">
                <table>
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Brand</th>
                            <th>Name</th>
                            <th>Variant</th>
                            <th>Size</th>
                            <th>Category</th>
                            <th>Location</th>
                            <th>Cost</th>
                            <th>Price</th>
                            <th>Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div> -->
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
                let modal = "#modal_account_restore";

                // CANCEL
                $(modal + ' .cancel').on('click', function(){
                    $(modal).hide();
                });

                //CONFIRM
                $(modal + ' .confirm').on('click', function(){
                    $.ajax({
                        url: '../models/archive/restore_account.php',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            id : $('#restore_account_id').val()
                        },
                        success: function(response){
                            if(response.status == 'success'){
                                alertify.success('Restored Account');
                                fetch_accounts(1);
                            }
                            if(response.status == 'error'){
                                alertify.error(response.message);
                            }
                        },
                        error: function(response){
                            console.log('ERROR restoration: ' + response);
                        }
                    })
                    $('.modals').hide();
                });

            });
        </script>

        <form>
            <div class="modal_heading">
                <!-- <div class="caption">updating account</div> -->
                <div class="title">
                    Confirm Update?
                </div>
            </div>

            <!-- <div class="modal_content">
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
                let modal = "#modal_account_edit_confirm ";

                // CANCEL
                $(modal + '.cancel').on('click', function(){
                    $(modal).hide();
                });

                // CONFIRM
                $(modal + '.confirm').on('click', function(){
                    $.ajax({
                        url: '../models/update/update_account.php',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            id: $('#edit_account_id').val(),
                            username: $('#edit_username').val(),
                            first_name: $('#edit_first_name').val(),
                            last_name: $('#edit_last_name').val(),
                            role: $('#updated_role').val()
                        },
                        success: function(response){    
                            alertify.success('Account updated Successfully');
                            $('.modals').hide();
                            fetch_accounts();
                        },
                        error: function(response){
                            console.log(response.message);
                        }
                    });
                });

            });    
        </script>
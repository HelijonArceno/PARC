
        <form>
            <div class="modal_heading">
                <div class="title">
                    Confirm Delete?
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
                let modal = "#modal_account_delete_confirm ";

                function close(){
                    $('.modals').hide();
                }

                function finish_edit(){
                    $('#modal_account_edit').hide();
                    fetch_inventory();
                }


                $('#modal_account_edit .clear').on('click', function(){
                    $(modal).toggle();
                })
                // CANCEL
                $(modal + '.cancel').on('click', function(){
                    $(modal).hide();
                });

                $(modal + '.confirm').on('click', function(){
                    // $.ajax({
                    //     url: '../models/delete/delete_account.php',
                    //     type: 'POST',
                    //     dataType: 'json',
                    //     data: {
                    //         id : $('#edit_account_id').val()
                    //     },
                    //     success: function(response){
                    //         if(response.status == 'success'){
                    //             alertify.success('Deleted Account');
                    //         }
                    //         if(response.status == 'error'){
                    //             console.log('Cannot delete, archiving instead')
                    //             archive_product($('#edit_account_id').val())
                    //         }
                    //     },
                    //     error: function(response){
                    //         console.log('ERROR deletion: ' + response);
                    //     }
                    // })
                    delete_account($('#edit_account_id').val());
                    // fetch_accounts(0);
                });

                function delete_account(id){
                    $.ajax({
                        url: '../models/delete/delete_account.php',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            id : id
                        },
                        success: function(response){
                            if(response.status == 'success'){
                                alertify.success('Deleted account');
                                fetch_accounts(0);
                                $('.modals').hide();
                                
                            }
                            if(response.status == 'error'){
                                alertify.error('Cannot delete account, archiving instead');
                                // alertify.error(response.message);
                                archive_account(id);
                            }
                        },
                        error: function(response){
                            console.log('ERROR archiving: ' + response);
                        }
                    })

                    function archive_account(id){
                        $.ajax({
                            url: '../models/archive/archive_account.php',
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                id : id
                            },
                            success: function(response){
                                if(response.status == 'success'){
                                    alertify.success('Archived account');
                                    fetch_accounts(0);
                                    $('.modals').hide();
                                }
                                if(response.status == 'error'){
                                    alertify.error(response.message);
                                }
                            },
                            error: function(response){
                                console.log('ERROR archiving: ' + response);
                            }
                        })

                    }

                }

            });
        </script>

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
                let modal = "#modal_product_delete_confirm ";

                function close(){
                    $('.modals').hide();
                }

                function finish_edit(){
                    $('#modal_product_edit').hide();
                    fetch_inventory();
                }


                $('#modal_product_edit .clear').on('click', function(){
                    $(modal).toggle();
                })
                // CANCEL
                $(modal + '.cancel').on('click', function(){
                    $(modal).hide();
                });
                //UNDO
                // $(modal + '.clear').on('click', function(){
                //     console.log('reset to defaults');
                // });
                // CONFIRM
                $(modal + '.confirm').on('click', function(){
                    delete_product();
                    close();
                });

                function delete_product(){
                    $.ajax({
                        url: '../models/delete/delete_product.php',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            product_code : $('#update_product_code_store').val()
                        },
                        success: function(response){
                            if(response.status == 'success'){
                                alertify.success('Deleted Product');
                            }
                            if(response.status == 'error'){
                                console.log('Cannot delete, archiving instead')
                                archive_product($('#update_product_code_store').val())
                            }
                        },
                        error: function(response){
                            console.log('ERROR deletion: ' + response);
                        }
                    })
                }

                function archive_product(id){
                    $.ajax({
                        url: '../models/archive/archive_product.php',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            product_code : id
                        },
                        success: function(response){
                            if(response.status == 'success'){
                                alertify.success('Archived Product');
                            }
                            if(response.status == 'error'){
                                alertify.error(response.message);
                            }
                        },
                        error: function(response){
                            console.log('ERROR deletion: ' + response);
                        }
                    })
                }

            });
        </script>
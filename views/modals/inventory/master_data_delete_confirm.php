
        <form>
            <div class="modal_heading">
                <div class="caption">deleting brand</div>
                <div class="title">
                    Confirm Delete?
                </div>
                <input type="hidden" name="delete_master_data_type" id="delete_master_data_type">
                <input type="hidden" name="delete_master_data_id" id="delete_master_data_id">
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
                let modal = "#modal_master_data_delete_confirm ";

                function close(){
                    $('.modals').hide();
                }

                // $('#modal_master_data_edit .clear').on('click', function(){
                //     $(modal).toggle();
                // })
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
                    let type = $('#delete_master_data_type').val();
                    remove_master_data(type);
                });

                function remove_master_data(type){
                    $.ajax({
                        url: '../models/delete/delete_'+type+'.php',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            id : $('#delete_master_data_id').val()
                        },
                        success: function(response){
                            if(response.status == 'success'){
                                alertify.success('Deleted Product');
                            }
                            if(response.status == 'error'){
                                alertify.error(type + ' is currently being used!');
                            }
                            close();
                        },
                        error: function(response){
                            console.log('ERROR deletion: ' + response);
                        }
                    })
                }

            });
            function delete_master_data(id, type, display){
                console.log(2);
                let modal = "#modal_master_data_delete_confirm ";
                $(modal).show();
                $(modal + ' .caption').html('deleting ' + type);
                $(modal + ' .title').html('Delete ' + display + '?');
                $('#delete_master_data_type').val(type)
                $('#delete_master_data_id').val(id)
            }
            
        </script>
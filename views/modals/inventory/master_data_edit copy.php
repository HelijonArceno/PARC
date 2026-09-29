
    <style>
        #modal_profile{
            right: 0;
        }
    </style>
        <form>
            <div class="modal_heading">
                <div class="caption">updating brand</div>
                <div class="title">
                    Brand Update
                </div>
                <input type="hidden" id="edit_master_data_type" name="edit_master_data_type">
                <input type="hidden" id="edit_master_data_id" name="edit_master_data_id">
            </div>

            <div class="modal_content">
                <div>
                    <div class="heading">
                        Details
                    </div>
                    <div class="form_group">
                        <div class="input_name">Brand</div>
                        <input type="text" id="edit_master_data_name" name="edit_master_data_name">
                    </div>
                </div>
            </div>
            <div class="modal_footer">
                <div>
                    <div class="cancel">[CANCEL]</div>
                    <div class="clear">[DELETE]</div>
                </div>
                <div>
                    <div class="confirm">[CONFIRM]</div>
                </div>
            </div>
        </form>
        <script>
            function edit_master_data(table, id, name, type){
                let modal = '#modal_master_data_edit';
                $(modal).show();
                $(modal + ' .caption').html('updating ' + type);
                $(modal + ' .title').html(type + ' update');
                $(modal + ' .input_name').html(type);

                $('#edit_master_data_type').val(type);
                $('#edit_master_data_id').val(id);
                $('#edit_master_data_name').val(name);
            }
            $(document).ready(function(){
                let modal = '#modal_master_data_edit'; //INSERT MODAL NAME HERE
                //CANCEL
                $(modal + ' .cancel').on('click', function(){
                    $(modal).toggle();
                })

                $(modal + ' .clear').on('click', function(){
                    let id = $('#edit_master_data_id').val();
                    let type = $('#edit_master_data_type').val();
                    let display = $('#edit_master_data_name').val();
                    delete_master_data(id, type, display);
                })
               

                $(modal + ' .confirm').on('click', function(){
                    let type = $('#edit_master_data_type').val();
                    let id = $('#edit_master_data_id').val();
                    let name = $('#edit_master_data_name').val();
                    update(type, id, name);
                })
                function update(type, id, value){
                    $.ajax({
                        url: '../models/update/update_'+ type +'.php',
                        type: 'POST',
                        dataType: 'json',
                        data:{ 
                            id: id,
                            name: value
                        },
                        success: function(response){
                            console.log('updated ' + type);
                            alertify.success(response);
                        },
                        error: function(response){
                            alertify.error(response);
                        } 
                    })
                }
            });
        </script>
        

        <form>
            <div class="modal_heading">
                <div class="caption">editing brand</div>
                <div class="title">
                    Brand Update
                </div>
            </div>

            <div class="modal_content">
                <div>
                    <div class="heading">
                        Details
                    </div>
                    <input type="text" id="edit_master_data_table">
                    <input type="hidden" id="edit_id" name="edit_id">
                    <div class="form_group">
                        Brand:
                        <input type="text" id="edit_brand" name="edit_brand">
                    </div>
                </div>
            </div>
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
                $(modal).toggle();
                let modal = '#master_data_edit'; //INSERT MODAL NAME HERE
                //CANCEL
                $(modal + ' .cancel').on('click', function(){
                    $(modal).toggle();

                })
               

                // $(modal + ' .confirm').on('click', function(){
    
                // })
            });

            // function edit_masterdata(table, id, name){
            //     $('#edit_master_data_table').val(table);
            //     $('#edit_master_data_id').val(id);
            //     $('#edit_master_data_name').val(name);
            // };
        </script>
        

        <form>
            <div class="modal_heading">
                <div class="title">
                    Restore Product?
                </div>
                <input type="hidden" id="restore_product_code" name="restore_product_code">
            </div>

            <div class="modal_content">
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
                // INITIALIZATION
                let modal = "#modal_product_restore ";
                function close(){
                    $('.modals').hide();
                }

                // CANCEL
                $(modal + '.cancel').on('click', function(){
                    $(modal).hide();
                });
                //UNDO

                $(modal + '.confirm').on('click', function(){
                    restore_product($('#restore_product_code').val());
                    close();
                });


                function restore_product(id){
                    $.ajax({
                        url: '../models/archive/restore_product.php',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            product_code : id
                        },
                        success: function(response){
                            if(response.status == 'success'){
                                alertify.success('Restored Product');
                            }
                            if(response.status == 'error'){
                                alertify.error(response.message);
                            }
                        },
                        error: function(response){
                            console.log('ERROR restoration: ' + response);
                        }
                    })
                }

            });
        </script>
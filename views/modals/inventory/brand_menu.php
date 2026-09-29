
        <form>
            <div class="modal_heading">
                <!-- <div class="caption">caption here</div> -->
                <div class="title">
                    BRANDS MENU
                </div>
            </div>
            
            <div class="modal_content">
                <div>
                    <div class="search_wrapper">
                        Search: 
                        <input type="text" class="searchbox search_input">
                    </div>
                    <table id="brands_table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Brand</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- <tr>
                                <td>brand_name</td>
                            </tr> -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal_footer">
                <div>
                    <div class="cancel">[CANCEL]</div>

                </div>
                <!-- <div>
                    <div class="confirm">[CONFIRM]</div>
                </div> -->
            </div>
        </form>
        <script>
            $(document).ready(function(){
                let modal = '#modal_brand_menu'; //INSERT MODAL NAME HERE
                let table = $('#brands_table').DataTable({
                    'dom' : 'tp',
                    createdRow: function(row, data, dataIndex){
                        $(row).attr("data-id", data[0]);
                        $(row).attr("data-name", data[1]);
                    },
                    columnDefs: [
                        {
                            targets: 0,
                            visible: false
                        }
                    ]
                });
                $(modal + ' .search_input').on('keyup', function(){
                    table.search(this.value).draw();
                })
                // open on click input
                $('#new_brand, #update_brand').on('focus', function(){
                    $('.menu').hide();
                    $(modal).show();
                });

                ready_brand_menu(table);
                $(modal + ' .cancel').on('click', function(){
                    $(modal).toggle();
                })
            });

            $("#brands_table tbody").on('click','tr', function(event){
                if($('#modal_product_edit').is(':hidden') && $('#modal_product_new').is(':hidden')){
                    let id = $(this).data('id');
                    let name = $(this).data('name');
                    edit_master_data('brands', id, name, 'brand');
                }
            });
            
            // copy name to input
            $("#brands_table tbody").on('click','tr', function(event){
                // copy input to NEW or UPDATE/EDIT
                if($('#modal_product_edit').is(':hidden')){
                    console.log('copy to new');
                    $('#new_brand').val($(this).data('name'))
                }
                
                if($('#modal_product_new').is(':hidden')){
                    console.log('copy to update');
                    $('#update_brand').val($(this).data('name'))
                }
            });

            // ON READY FUNCTION
            function ready_brand_menu(table){
                $.ajax({
                    url: '../models/fetch/fetch_brands.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response){
                        table.clear();
                        $.each(response, function(index, record){
                            let row = table.row.add([
                                record.brand_id,   
                                record.brand
                            ]);
                        });
                        table.draw(false)
                    },
                    error: function(response){
                        console.log('ERROR fetch: ' + response);
                    }
                })
            }
        </script>
        

        <form>
            <div class="modal_heading">
                <div class="title">
                    CATEGORIES MENU
                </div>
            </div>

            <div class="modal_content">
                <div>
                    <div class="search_wrapper">
                        Search: 
                        <input type="text" class="searchbox search_input">
                    </div>
                    <table id="categories_table">
                        
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Category</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>ID</td>
                                <td>category_name</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal_footer">
                <div>
                    <div class="cancel">[CLOSE]</div>
                </div>
            </div>
        </form>
        <script>
            $(document).ready(function(){
                let modal = '#modal_category_menu'; //INSERT MODAL NAME HERE
                let table = $('#categories_table').DataTable({
                    'dom' : 'tp',
                    createdRow: function(row, data, dataIndex){
                        row.dataset.name = data[0];
                    },
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
                $('#new_category, #update_category').on('focus', function(){
                    $('.menu').hide();
                    $(modal).show();
                });

                ready_category_menu(table);
                $(modal + ' .cancel').on('click', function(){
                    $(modal).toggle();
                })
            });

            $("#categories_table tbody").on('click','tr', function(event){
                if($('#modal_product_edit').is(':hidden') && $('#modal_product_new').is(':hidden')){
                    let id = $(this).data('id');
                    let name = $(this).data('name');
                    edit_master_data('categories', id, name, 'category');
                }

            });

            // copy name to input
            $("#categories_table tbody").on('click','tr', function(event){
                if($('#modal_product_edit').is(':hidden')){
                    console.log('copy to new');
                    $('#new_category').val($(this).data('name'))
                }
                
                if($('#modal_product_new').is(':hidden')){
                    console.log('copy to update');
                    $('#update_category').val($(this).data('name'))
                }
            });

            function ready_category_menu(table){
                $.ajax({
                    url: '../models/fetch/fetch_categories.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response){
                        table.clear()
                        $.each(response, function(index, record){
                            table.row.add([
                                record.category_id,
                                record.category
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
        
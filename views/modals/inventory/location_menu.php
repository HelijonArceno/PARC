
        <form>
            <div class="modal_heading">
                <!-- <div class="caption">caption here</div> -->
                <div class="title">
                    LOCATIONS MENU
                </div>
            </div>

            <div class="modal_content">
                <div>
                    <div class="search_wrapper">
                        Search: 
                        <input type="text" class="searchbox search_input">
                    </div>
                    <table id="locations_table">
                        
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Location</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>ID</td>
                                <td>location_name</td>
                            </tr>
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
                let modal = '#modal_location_menu'; //INSERT MODAL NAME HERE
                let table = $('#locations_table').DataTable({
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
                $('#new_location, #update_location').on('focus', function(){
                    $('.menu').hide();
                    $(modal).show();
                });

                ready_location_menu(table);
                $(modal + ' .cancel').on('click', function(){
                    $(modal).toggle();
                })
            });

            // EDIT DATA
            $("#locations_table tbody").on('click','tr', function(event){
                if($('#modal_product_edit').is(':hidden') && $('#modal_product_new').is(':hidden')){

                    let id = $(this).data('id');
                    let name = $(this).data('name');
                    edit_master_data('locations', id, name, 'location');
                }
            });

            // copy name to input
            $("#locations_table tbody").on('click','tr', function(event){
                if($('#modal_product_edit').is(':hidden')){
                    console.log('copy to new');
                    $('#new_location').val($(this).data('name'))
                }
                
                if($('#modal_product_new').is(':hidden')){
                    console.log('copy to update');
                    $('#update_location').val($(this).data('name'))
                }
            });
            

            // ON READY
            function ready_location_menu(table){
                $.ajax({
                    url: '../models/fetch/fetch_locations.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response){
                        table.clear().draw(false)
                        $.each(response, function(index, record){
                            table.row.add([
                                record.location_id,
                                record.location
                            ])  
                        });
                        table.draw(false)
                    },
                    error: function(response){
                        console.log('ERROR fetch: ' + response);
                    }
                })
            }
        </script>
        
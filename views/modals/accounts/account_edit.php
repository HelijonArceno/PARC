

<style>
    #modal_account_edit .modal_content{
        flex-direction: column;
        gap: var(--spacing-40);
    }
</style>
        <form>
            <div class="modal_heading">
                <div class="title">
                    Account Update
                </div>
                <input type="hidden" id="edit_account_id" name="edit_account_id">
            </div>

            <div class="modal_content">
                <div>
                    <div class="heading">
                        Login Credentials
                    </div>
                    <div class="form_group">
                        <div class="input_name">Username</div>
                        <input type="text" id="edit_username" name="edit_username">
                    </div>
                </div>
                <div>
                    <div class="heading">
                        Personal Information
                    </div>
                    <div class="form_group">
                        <div class="input_name">First name</div>
                        <input type="text" id="edit_first_name" name="edit_first_name">
                    </div>
                    <div class="form_group">
                        <div class="input_name">Last name</div>
                        <input type="text" id="edit_last_name" name="edit_last_name">
                    </div>
                </div>
                <div>
                    <div class="heading">
                        User Authorization level
                    </div>
                    <div class="form_group">
                        <div class="input_name">Role</div>
                        <select id="updated_role" name="updated_role">
                            
                        </select>
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
            $(document).ready(function(){
                let modal = '#modal_account_edit'; //INSERT MODAL NAME HERE
                //CANCEL
                $(modal + ' .cancel').on('click', function(){
                    $(modal).toggle();

                })
                //CLEAR
                $(modal + ' .clear').on('click', function(){
                    $(modal + ' form')[0].reset();
                })

                $(modal + ' .confirm').on('click', function(){
                    $('#modal_account_edit_confirm').show();
                })
            });
            $.ajax({
                    url: '../models/fetch/fetch_user_roles.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response){
                        $.each(response, function(index, record){
                            let row = `
                            <option value="${record.role_id}">${record.role}</option>
                            `;
                            
                            $('#updated_role').append(row);

                        });
                    }        
                })
        </script>
        
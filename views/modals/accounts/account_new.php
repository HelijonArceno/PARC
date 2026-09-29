

<style>
    #modal_account_new .modal_content{
        flex-direction: column;
        gap: var(--spacing-40);
    }
</style>
        <form>
            <div class="modal_heading">
                <div class="title">
                    Account Registration
                </div>
            </div>

            <div class="modal_content">
                <div>
                    <div class="heading">
                        Login Credentials
                    </div>
                    <div class="form_group">
                        <div class="input_name">Username</div>
                        <input type="text" id="new_username" name="new_username">
                    </div>
                    <div class="form_group">
                        <div class="input_name">Password</div>
                        <input type="password" id="new_password" name="new_password">
                    </div>
                </div>
                <div>
                    <div class="heading">
                        Personal Information
                    </div>
                    <div class="form_group">
                        <div class="input_name">First name</div>
                        <input type="text" id="new_first_name" name="new_first_name">
                    </div>
                    <div class="form_group">
                        <div class="input_name">Last name</div>
                        <input type="text" id="new_last_name" name="new_last_name">
                    </div>
                </div>
                 <div>
                    <div class="heading">
                        User Authorization level
                    </div>
                    <div class="form_group">
                        <div class="input_name">Role</div>
                        <select id="new_role" name="new_role">
                            
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal_footer">
                <div>
                    <div class="cancel">[CANCEL]</div>
                    <div class="clear">[CLEAR]</div>
                </div>
                <div>
                    <div class="confirm"></div>
                </div>
            </div>
        </form>
        <script>
            $(document).ready(function(){
                let modal = '#modal_account_new'; //INSERT MODAL NAME HERE
                //CANCEL
                $(modal + ' .cancel').on('click', function(){
                    $(modal).toggle();

                })
                //CLEAR
                $(modal + ' .clear').on('click', function(){
                    $(modal + ' form')[0].reset();
                })

                $('.container .body > .wrapper').on('click','.add_new_account', function(){
                    if($('#modal_account_new').is(':hidden')){
                        $('.modal').hide();
                        $(modal).show();
                    }else{
                        $(modal).hide();
                    }
                })
               

                $(modal + ' .confirm').on('click', function(){
                    $.ajax({
                        url: '../models/insert/insert_account.php',
                        type: 'POST',
                        dataType: 'json',
                        data:{
                            username: $('#new_username').val(),
                            first_name: $('#new_first_name').val(),
                            last_name: $('#new_last_name').val(),
                            password: $('#new_password').val(),
                            role: $('#new_role').val()
                        },
                        success: function(response){
                            console.log('INSERT status: ' + response);
                            alertify.success('Account Successfully registered!');
                            fetch_accounts(0);
                        },
                        error: function(response){
                            console.log('ERROR IN INSERT: ' + response);
                        }
                    })
                    $(modal).hide();
                })
                $.ajax({
                    url: '../models/fetch/fetch_user_roles.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response){
                        $.each(response, function(index, record){
                            let row = `
                            <option value="${record.role_id}">${record.role}</option>
                            `;
                            
                            $('#new_role').append(row);

                        });
                    }        
                })
                
            });
        </script>
        
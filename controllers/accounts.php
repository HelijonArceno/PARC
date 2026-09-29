<script>
    load_asset('modal');
        modal_load('global','modal','profile', null, null, 'php');
        modal_load('accounts','modal','account_edit');
        modal_load('accounts', 'modal', 'account_new');
        modal_load('accounts', 'modal', 'account_edit_confirm');
        modal_load('accounts', 'modal', 'account_delete_confirm');
        modal_load('accounts', 'modal', 'account_restore');
    $(document).ready(function(){
        fetch_accounts(0);
    })
    $('.page_name').on('click', function(){
        window.location.href = 'home_page.php';
    });

    let archive_mode = false
    $('.archive_button').on('click', function(){
        
        if(archive_mode){
            fetch_accounts(0);
            archive_mode = false;
        }else{
            fetch_accounts(1);
            archive_mode = true;
        }
    });

    $('.container .body > .wrapper').on('click','.account_record', function(){
        let account_id = $(this).data('id');
        let username = $(this).data('username');
        let first_name = $(this).data('first_name');
        let last_name = $(this).data('last_name');
        let role = $(this).data('role');
        let archived = $(this).data('archived');
        
        if(archived == 0){
            $('#edit_account_id').val(account_id);
            $('#edit_username').val(username);
            $('#edit_first_name').val(first_name);
            $('#edit_last_name').val(last_name);
            $('#updated_role').val(role)

            $('.modal').hide();
            $('#modal_account_edit').show();
        }else{
            $('#modal_account_restore').show();
            $('#restore_account_id').val(account_id);
        }
        
    })

    function fetch_accounts(archived = 0){
        $.ajax({
            url: '../models/fetch/fetch_accounts.php',
            type: 'GET',
            data: {
                archived : archived
            },
            dataType: 'json',
            success: function(response){
                $('.container .body > .wrapper').html('');
                $.each(response, function(index, record){
                    let first_name = new String(record.first_name).toUpperCase(); 
                    let last_name = new String(record.last_name).toUpperCase(); 
                    let output = `
                    <div class="record account_record" data-id='${record.account_id}' data-username='${record.username}' data-first_name='${record.first_name}' data-last_name='${record.last_name}' data-archived='${record.archived}' data-role='${record.role_id}'>
                        <div class="profile">${first_name[0]}${last_name[0]}</div>
                        <div class="description">
                            <div class="username">${record.username}</div>
                            <div class="name">${record.first_name} ${record.last_name}</div>
                        </div>
                    </div>
                    `
    
                    $('.container .body > .wrapper').append(output);
                    
                });
                insert_add_account_button(archived);
            },
            error: function(response){
                console.log('ERROR fetch: ' + response);
            }
        })

        function insert_add_account_button(){
            if(archived == 0){
                let output =`
                <div class="record add_new_account">
                    <div class="profile">+</div>
                    <div class="description">
                        <div class="username">ADD NEW ACCOUNT</div>
                    </div>
                </div>
                `
                $('.container .body > .wrapper').append(output);
            }
        }
    }
</script>
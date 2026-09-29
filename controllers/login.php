<script>
    $(document).ready(function(){
        
        let error_message = <?php 
        echo json_encode($_SESSION['error_message'] ?? null); 
        unset($_SESSION['error_message']); 
        ?>;

        if(error_message !== null){
            alertify.error(error_message);
        }

        let success_message = <?php 
        echo json_encode($_SESSION['success_message'] ?? null); 
        unset($_SESSION['success_message']); 
        ?>;

        if(success_message !== null){
            alertify.success(success_message);
        }
        
        $('.button').on('click', function(){
            // alertify.success('Logged in Successfully');
            
            function home_page(){
                window.location.href = 'views/home_page.php';
            }
            $.ajax({
                url: 'models/authorization/verify_account.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    username : $('#username').val(),
                    password : $('#password').val()
                },
                success: function(response){
                    if(response.status === 'success'){
                        alertify.success(response.message);
                        
                        setTimeout(() => {
                            window.location.href = 'views/home_page.php';
                        }, 2000)
                    }
                    if(response.status === 'unknown'){
                        alertify.error(response.message);
                    }
                    if(response.status === 'error'){
                        alertify.error(response.message);
                    }
                },
                error: function(response){
                    console.log('ERROR auth: ' + response)
                }
            })
        });
    });
</script>
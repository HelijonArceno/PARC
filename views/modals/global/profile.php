

    <link rel="stylesheet" href="../assets/modal_style.css">
    <style>
        #modal_profile{
            right: 0;
            text-align: center;
        }
    </style>
        <form>
            <div class="modal_heading">
                <div class="title">
                    Logout?
                </div>
            </div>

            <div class="modal_content">
                <div>
                    <!-- <div class="heading">
                        Press confirm to continue
                    </div>
                    <div class="form_group">
                        <div>Username</div>
                        <div>John Doe</div>
                    </div> -->
                    Press confirm to continue
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
                let modal = '#modal_profile'; //INSERT MODAL NAME HERE
                //CANCEL
                $(modal + ' .cancel').on('click', function(){
                    $(modal).toggle();

                })
                //CLEAR
                $(modal + ' .clear').on('click', function(){
                    $(modal + ' form')[0].reset();
                })

                $('.account').on('click', function(){
                    $(modal).toggle();
                })

                $(modal + ' .confirm').on('click', function(){
                    $.ajax({
                        url: '../models/authorization/log_out.php',
                        type: 'POST',
                        success: function(response){
                            window.location.href = '../';
                        },
                        error: function(response){
                            alertify.error('Logout error!')
                        }
                    });
                })
            });
        </script>
        
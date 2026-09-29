
    <style>
        #modal_profile{
            right: 0;
        }
    </style>
        <form>
            <div class="modal_heading">
                <div class="caption">caption here</div>
                <div class="title">
                    TITLE HERE
                </div>
            </div>

            <div class="modal_content">
                <div>
                    <div class="heading">
                        SUBTITLE
                    </div>
                    <div class="form_group">
                        text
                        <input type="text" id="new_variant" name="new_variant">
                    </div>
                </div>
                <div>
                    <div class="heading">
                        SUBTITLE
                    </div>
                    <div class="form_group">
                        text
                        <input type="text" id="new_variant" name="new_variant">
                    </div>
                </div>
            </div>
            <div class="modal_footer">
                <div>
                    <div class="cancel">[CANCEL]</div>
                    <div class="clear">[CLEAR]</div>
                </div>
                <div>
                    <div class="confirm">[CONFIRM]</div>
                </div>
            </div>
        </form>
        <script>
            $(document).ready(function(){
                let modal = '#modal_profile'; //INSERT MODAL NAME HERE
                $(modal).toggle();
                //CANCEL
                $(modal + ' .cancel').on('click', function(){
                    $(modal).toggle();

                })
                //CLEAR
                $(modal + ' .clear').on('click', function(){
                    $(modal + ' form')[0].reset();
                })
               

                $(modal + ' .confirm').on('click', function(){
    
                })
            });
        </script>
        
<div class="header"></div>
<div class="contents">
    <div id="dropdown_brand">Brand</div>
    <div id="dropdown_category">Category</div>
    <div id="dropdown_location">Location</div>
</div>
<script>
    $(document).ready(function(){
        let modal = '#modal_master_data';
        // show menus

        // stop event propagation
        $('#modal_master_data').on('click', function(e){
            e.stopPropagation();
        });

        //show brand
        $('#dropdown_brand').on('click', function(){
            $('.modals').hide();
            $('#modal_brand_menu').show();
        });

        //show category
        $('#dropdown_category').on('click', function(){
            $('.modals').hide();
            $('#modal_category_menu').show();
        });

        //show lcocation
        $('#dropdown_location').on('click', function(){
            $('.modals').hide();
            $('#modal_location_menu').show();
        });

        //show dropdown
        $('.master_data_button').on('click', function(e){
            if($(modal).is(':hidden')){
                $('.modals').hide();
                $(modal).show();
            }else{
                $(modal).hide();
            }
            

        });
    })
</script>
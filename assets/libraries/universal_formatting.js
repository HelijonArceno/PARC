let confirm =
`
<div class="material-symbols-outlined">check</div>
`
let cancel =
`
<div class="material-symbols-outlined">close</div>
`
let clear =
`
<div class="material-symbols-outlined">delete</div>
`
$(document).ajaxComplete(function(){
    console.log('loaded resource');
    $('.confirm').html(confirm);
    $('.cancel').html(cancel);
    $('.clear').html(clear);
})
function load_asset(name){
    let dom = `
        <script src="../assets/libraries/${name}.js">
    `
    $('head').append(dom)
}
function required(name){
    let value= $(name).val().trim();
    if(value == ''){
        return 1;
    }
    return;
}


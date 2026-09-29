function modal_load(source, type, name, index, target, filetype = 'php'){
    let row = `
    <div id="modal_${name}" class="${type} modals" style="z-index:${index};"></div>
    `;
    if(target){
        $(target).append(row);
    }else{
        $('.modal_group').append(row);
    }
    
    if(filetype){
        return $("#modal_"+name).load("modals/"+source+"/"+name+"."+filetype);
    }else{  
        return $("#modal_"+name).load("modals/"+source+"/"+name+".html");
    }

}
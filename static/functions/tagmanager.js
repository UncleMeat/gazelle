
function Select_Tag(tagID, tagname) {
   
    //alert("Tag: "+tagID +" '"+tagname+"'");
    var div = ($('#multiID').raw().value !='')?',':'';
    $('#multiID').raw().value += div+tagID;
    $('#showmultiID').raw().value += div+tagID;
    $('#multiNames').raw().innerHTML += div+tagname;
    
    $('#movetagid').raw().selectedIndex = 0;
}


function Clear_Multi() {
    $('#multiID').raw().value = '';
    $('#showmultiID').raw().value = '';
    $('#multiNames').raw().innerHTML = '';
}




function Select_Badge(id){ 
        
        var badgeid = $('#badgeid'+id).raw().value;
        ajax.getXML('ajax.php?action=get_badge_info&badgeid='+badgeid, function (responseXML) {
            x=responseXML.documentElement.getElementsByTagName("name");
            try {
              name = x[0].firstChild.nodeValue;
            } catch (er) {}
            x=responseXML.documentElement.getElementsByTagName("desc");
            try {
              desc = x[0].firstChild.nodeValue;
            } catch (er) {}
            x=responseXML.documentElement.getElementsByTagName("image");
            try {
              image = x[0].firstChild.nodeValue;
            } catch (er) {}
            
            $('#image'+id).raw().innerHTML = '<img src="'+image+'" title="'+name+'. '+desc+'" alt="'+name+'" />';
            $('#desc'+id).raw().innerHTML = desc;
            Set_Edit(id);
        }); 
}

function Select_Image(id){
        var image_file = $('#imagesrc'+id).raw().value;
        $('#image'+id).raw().innerHTML = '<img src="/static/common/badges/'+image_file+'" title="'+image_file+'" alt="'+image_file+'" />';
        Set_Edit(id);
}

function Set_Edit(id){
    $('#id_'+id).raw().checked = true;
}

function Fill_From(id){
    for(var i=0;i<5;i++){
        var newid = 'new'+i;
        if (newid!=id){
            $('#badge'+newid).raw().value = $('#badge'+id).raw().value;
            $('#title'+newid).raw().value = $('#title'+id).raw().value;
            $('#desc'+newid).raw().value = $('#desc'+id).raw().value;
            //$('#image'+newid).raw().value = $('#image'+id).raw().value;
            $('#type'+newid).raw().value = $('#type'+id).raw().value;
            $('#row'+newid).raw().value = $('#row'+id).raw().value;
            $('#rank'+newid).raw().value = $('#rank'+id).raw().value;
            $('#sort'+newid).raw().value = $('#sort'+id).raw().value;
            $('#cost'+newid).raw().value = $('#cost'+id).raw().value;
        }
    }
}
 
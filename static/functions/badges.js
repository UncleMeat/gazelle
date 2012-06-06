
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
        }); 
}

function Select_Image(id){
        var image_file = $('#imagesrc'+id).raw().value;
        $('#image'+id).raw().innerHTML = '<img src="/static/common/badges/'+image_file+'" title="'+image_file+'" alt="'+image_file+'" />';
}

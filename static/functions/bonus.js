
        
function SetUsername(itemID){
    var name= prompt("Enter the username of the person you wish to give a gift to")
    if (name!=null && name!="") {
        $('#' + itemID).raw().value = name;
    }
}

function SetTitle(itemID){
    var name= prompt("Enter the custom title you want to have\n(max 32 chars)")
    if (name!=null && name!="") {
        $('#' + itemID).raw().value = name;
    }
}
 
function SetTorrent(itemID){
    var id= prompt("Enter the ID of YOUR torrent (ie. that you uploaded) that you want to make permanently Freeleech")
    if (id!=null && id!="") {
        $('#' + itemID).raw().value = id;
    }
}


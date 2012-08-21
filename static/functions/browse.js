
function change_status(onoff){
    var ToPost = [];
    ToPost['auth'] = authkey;
    if (onoff=='0') ToPost['remove'] = 1;
    ajax.post("torrents.php?action=change_status", ToPost, function(response){  
		$('#staff_status').raw().innerHTML = response; 	
    });
}


function Update_status(){
    var ToPost = [];
    ToPost['auth'] = authkey;
    ajax.post("torrents.php?action=update_status", ToPost, function(response){  
		$('#staff_status').raw().innerHTML = response; 	
            setTimeout("Update_status();", 15000);
    });
}


function add_tag(tag) {
    if ($('#tags').raw().value == "") {
        $('#tags').raw().value = tag;
    } else {
        $('#tags').raw().value = $('#tags').raw().value + " " + tag;
    }
    CursorToEnd($('#tags').raw());
}
function CursorToEnd(textarea){ 
     // set the cursor to the end of the text already present
    if (textarea.setSelectionRange) { // ff/chrome/opera
        var len = textarea.value.length * 2; //(*2 for opera stupidness)
        textarea.setSelectionRange(len, len);
    } else { // ie8-, fails in chrome
        textarea.value = textarea.value;
    }
}

function Load_Cookie()  {
			 
	if(jQuery.cookie('searchPanelState') == undefined) {
		jQuery.cookie('searchPanelState', 'expanded');
	}
	//var state = jQuery.cookie('searchPanelState');
      
	if(jQuery.cookie('searchPanelState') == 'collapsed') {
		jQuery('#search_box').hide();
		jQuery('#search_button').text('Open Search Center');
	} else {
		jQuery('#search_button').text('Close Search Center');
      }
}
		
 
function Panel_Toggle() {
    if(jQuery.cookie('searchPanelState') == 'expanded') {
        jQuery.cookie('searchPanelState', 'collapsed');
        jQuery('#search_button').text('Open Search Center');
    } else {
        jQuery.cookie('searchPanelState', 'expanded');
        jQuery('#search_button').text('Close Search Center');
    }
    jQuery('#search_box').slideToggle('slow');
    return false;
}
            

addDOMLoadEvent(Load_Cookie);

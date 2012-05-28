
function Send_Okay_Message(group_id, conv_id){
    
    if (confirm("Make sure you have really fixed the problem before sending this message!\n\nAre you sure it is fixed?")){
        
	  var ToPost = [];
	  ToPost['groupid'] = group_id; 
	  ToPost['auth'] = authkey; 
	  ToPost['convid'] = conv_id; 
        ajax.post('?action=send_okay_message', ToPost, function (response) {
            // show  user response 
            conv_id = response;
            $('#user_message').raw().innerHTML = '<div class="messagebar"><a href="staffpm.php?action=viewconv&id=' + conv_id + '">Message sent to staff</a></div>';
            $('#convid').raw().value = conv_id;
            //$('#review_message').show(); 
        });
    }
    return false;
}

function Validate_Form_Reviews(status){
    if(status == 'Warned' || status== 'Pending'){
        return confirm("Are you sure you want to override the warning already in process?"); 
    } else if(status == 'Okay'){
        return confirm("Are you sure you want to override the okay status?"); 
    }
    return true;
}

function Select_Reason(overwrite_warn){ 
   
    var value = $('#reasonid').raw().value;
    //if reason == -1 (not set)
    if(value == -1){
        $('#mark_delete_button').disable(); 
        $('#review_message').hide(); 
        $('#warn_insert').html('');
    } else { // is set
	  var ToPost = [];
	  ToPost['groupid'] = $('#groupid').raw().value;
	  ToPost['reasonid'] = $('#reasonid').raw().value;
        ajax.post('?action=get_review_message', ToPost, function (response) {
            //enable button and show pm response
            $('#mark_delete_button').disable(false); 
            //if reason == other then show textarea
            if (value == 0 )$('#reason_other').show();
            else $('#reason_other').hide();
            $('#message_insert').raw().innerHTML = response;
            $('#review_message').show(); 
            if (overwrite_warn){
                $('#warn_insert').html("Are you sure you want to override the current status?");
            }
        });
    }
    return false;
}

function Tools_Toggle() {
        /*  to slide or not to slide?
         *jQuery('#staff_tools').slideToggle('500', function(){
            if ($('#slide_tools_button').raw().innerHTML=='Hide Tools'){
                            jQuery.cookie('torrentDetailsToolState', 'collapsed');
                            $('#slide_tools_button').raw().innerHTML=('Show Tools');
            }  else{
                            jQuery.cookie('torrentDetailsToolState', 'expanded');
                            $('#slide_tools_button').raw().innerHTML=('Hide Tools');
            }
        }); */
            if ($('#slide_tools_button').raw().innerHTML=='Hide Tools'){
                            jQuery.cookie('torrentDetailsToolState', 'collapsed');
                            $('#slide_tools_button').raw().innerHTML=('Show Tools');
                            jQuery('#staff_tools').hide();
                            
            } else{
                            jQuery.cookie('torrentDetailsToolState', 'expanded');
                            $('#slide_tools_button').raw().innerHTML=('Hide Tools');
                            jQuery('#staff_tools').show();
            }
        return false;
}


function Load_Tools_Cookie()  {
	var panel = jQuery('#staff_tools');
	var button = jQuery('#slide_tools_button');
    
	if(jQuery.cookie('torrentDetailsToolState') == undefined) {
		jQuery.cookie('torrentDetailsToolState', 'expanded');
	}
	if(jQuery.cookie('torrentDetailsToolState') == 'collapsed') {
		panel.hide();
		button.text('Show Tools');
	} else {
		button.text('Hide Tools');
      }
}

function Details_Toggle() {
        jQuery('#details_top').slideToggle('700', function(){
            //if(jQuery.cookie('torrentDetailsState') == 'expanded') {
            if ($('#slide_button').raw().innerHTML=='Hide Info'){
                            jQuery.cookie('torrentDetailsState', 'collapsed');
                            $('#slide_button').raw().innerHTML=('Show Info');
                            //$('#top_info').show();
            } else{
                            jQuery.cookie('torrentDetailsState', 'expanded');
                            $('#slide_button').raw().innerHTML=('Hide Info');
                            //$('#top_info').hide();
            }
        });
        return false;
}


function Load_Details_Cookie()  {
			
	// the div that will be hidden/shown
	var panel = jQuery('#details_top');
	var button = jQuery('#slide_button');
    
	if(jQuery.cookie('torrentDetailsState') == undefined) {
		jQuery.cookie('torrentDetailsState', 'expanded');
	}
	var state = jQuery.cookie('torrentDetailsState');
      
	if(state == 'collapsed') {
		panel.hide();
            //$('#top_info').show();
		button.text('Show Info');
	} else {
		button.text('Hide Info');
      }
}
 

/* Torrent Details:  Show various tables etc dynamically */

function show_peers (TorrentID, Page) {
	if(Page>0) {
		ajax.get('torrents.php?action=peerlist&page='+Page+'&torrentid=' + TorrentID,function(response){
			$('#peers_' + TorrentID).show().raw().innerHTML=response;
		});
	} else {
		if ($('#peers_' + TorrentID).raw().innerHTML === '') {
			$('#peers_' + TorrentID).show().raw().innerHTML = '<h4>Loading...</h4>';
			ajax.get('torrents.php?action=peerlist&torrentid=' + TorrentID,function(response){
				$('#peers_' + TorrentID).show().raw().innerHTML=response;
			});
		} else {
			$('#peers_' + TorrentID).toggle();
		}
	}
	$('#snatches_' + TorrentID).hide();
	$('#downloads_' + TorrentID).hide();
	$('#files_' + TorrentID).hide();
	$('#reported_' + TorrentID).hide();
}

function show_snatches (TorrentID, Page){
	if(Page>0) {
		ajax.get('torrents.php?action=snatchlist&page='+Page+'&torrentid=' + TorrentID,function(response){
			$('#snatches_' + TorrentID).show().raw().innerHTML=response;
		});
	} else {
		if ($('#snatches_' + TorrentID).raw().innerHTML === '') {
			$('#snatches_' + TorrentID).show().raw().innerHTML = '<h4>Loading...</h4>';
			ajax.get('torrents.php?action=snatchlist&torrentid=' + TorrentID,function(response){
				$('#snatches_' + TorrentID).show().raw().innerHTML=response;
			});
		} else {
			$('#snatches_' + TorrentID).toggle();
		}
	}
	$('#peers_' + TorrentID).hide();
	$('#downloads_' + TorrentID).hide();
	$('#files_' + TorrentID).hide();
	$('#reported_' + TorrentID).hide();
}

function show_downloads (TorrentID, Page){
	if(Page>0) {
		ajax.get('torrents.php?action=downloadlist&page='+Page+'&torrentid=' + TorrentID,function(response){
			$('#downloads_' + TorrentID).show().raw().innerHTML=response;
		});
	} else {
		if ($('#downloads_' + TorrentID).raw().innerHTML === '') {
			$('#downloads_' + TorrentID).show().raw().innerHTML = '<h4>Loading...</h4>';
			ajax.get('torrents.php?action=downloadlist&torrentid=' + TorrentID,function(response){
				$('#downloads_' + TorrentID).raw().innerHTML=response;
			});
		} else {
			$('#downloads_' + TorrentID).toggle();
		}
	}
	$('#peers_' + TorrentID).hide();
	$('#snatches_' + TorrentID).hide();
	$('#files_' + TorrentID).hide();
	$('#reported_' + TorrentID).hide();
}

function show_files(TorrentID){
	$('#files_' + TorrentID).toggle();
	$('#peers_' + TorrentID).hide();
	$('#snatches_' + TorrentID).hide();
	$('#downloads_' + TorrentID).hide();
	$('#reported_' + TorrentID).hide();
}

function show_reported(TorrentID){
	$('#files_' + TorrentID).hide();
	$('#peers_' + TorrentID).hide();
	$('#snatches_' + TorrentID).hide();
	$('#downloads_' + TorrentID).hide();
	$('#reported_' + TorrentID).toggle();
}


 


            
addDOMLoadEvent(Load_Details_Cookie);



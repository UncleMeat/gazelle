
function Vote_Tag(tagname, tagid, groupid, way){
 
	  var ToPost = [];
	  ToPost['tagid'] = tagid; 
	  ToPost['groupid'] = groupid; 
	  ToPost['way'] = way; 
	  ToPost['auth'] = authkey; 
        ajax.post('torrents.php?action=vote_tag', ToPost, function (response) { 
            var x = json.decode(response); 
            if ( is_array(x)){
                if(x[0]==0){    // already voted so no vote
                    $('#messagebar').add_class('alert');
                    $('#messagebar').html(x[1] +tagname+"'");
                } else {        // vote was counted
                    $('#messagebar').remove_class('alert');
                    $('#messagebar').html(x[1] +tagname+"'");
                    $('#tagscore' + tagid).html(parseInt( $('#tagscore' + tagid).raw().innerHTML) + x[0]);
                }
            } else { // a non array == an error 
                $('#messagebar').add_class('alert');
                $('#messagebar').html(response);
            }
            $('#messagebar').show(); 
            /*
            if (response==0) { // already voted so no vote
                $('#messagebar').add_class('alert');
                $('#messagebar').html("you have already voted for tag '" + tagname +"'");
            } else if (Math.abs(response)==1) { // vote was counted
                $('#messagebar').remove_class('alert');
                $('#messagebar').html("your " + way + " vote was counted for tag '" + tagname +"'");
                $('#tagscore' + tagid).html(parseInt( $('#tagscore' + tagid).raw().innerHTML) + parseInt(response));
            } else { // a non number == an error  if ( !isnumeric(response)) 
                $('#messagebar').add_class('alert');
                $('#messagebar').html(response);
            }
            $('#messagebar').show(); */
            //setTimeout("$('#messagebar').hide()", 3000);
        });
}

function Send_Okay_Message(group_id, conv_id){
    if(conv_id==0) conv_id = null;
    if (confirm("Make sure you have really fixed the problem before sending this message!\n\nAre you sure it is fixed?")){
        
	  var ToPost = [];
	  ToPost['groupid'] = group_id; 
	  ToPost['auth'] = authkey; 
	  if (conv_id) ToPost['convid'] = conv_id; 
        ajax.post('?action=send_okay_message', ToPost, function (response) {
            // show  user response 
            conv_id = response;
            $('#user_message').raw().innerHTML = '<div class="messagebar"><a href="staffpm.php?action=viewconv&id=' + conv_id + '">Message sent to staff</a></div>';
            $('#convid').raw().value = conv_id;
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
    var state = new Array();
    state[1]=((jQuery('#coverimage').is(':hidden'))?'0':'1');
    
    jQuery('#details_top').slideToggle('700', function(){
            
        if (jQuery('#details_top').is(':hidden')) 
            jQuery('#slide_button').html('Show Info'); 
        else
            jQuery('#slide_button').html('Hide Info');
            
        state[0]=((jQuery('#details_top').is(':hidden'))?'0':'1');
        jQuery.cookie('torrentDetailsState', json.encode(state));
   
    });
    return false;
}

function Cover_Toggle() {

    jQuery('#coverimage').toggle();
 
    if (jQuery('#coverimage').is(':hidden')) 
        jQuery('#covertoggle').html('(Show)');
    else  
        jQuery('#covertoggle').html('(Hide)');
            
    jQuery.cookie('torrentDetailsState', Get_Cookie());
    return false;
}

function Get_Cookie() {
    return json.encode([((jQuery('#details_top').is(':hidden'))?'0':'1'), ((jQuery('#coverimage').is(':hidden'))?'0':'1')]);
}


function Load_Details_Cookie()  {
 
	// the div that will be hidden/shown
	var panel = jQuery('#details_top');
	var button = jQuery('#slide_button');
    
	if(jQuery.cookie('torrentDetailsState') == undefined) {
		jQuery.cookie('torrentDetailsState', json.encode(['1', '1']));
	}
	var state = json.decode( jQuery.cookie('torrentDetailsState') );
      
	if(state[0] == '0') {
		panel.hide();
		button.text('Show Info');
	} else
		button.text('Hide Info');
      
	if(state[1] == '0') {
		jQuery('#coverimage').hide();
		jQuery('#covertoggle').text('(Show)');
      } else 
		jQuery('#covertoggle').text('(Hide)');
 
}
 
 function Say_Thanks() {
    
    ajax.post("torrents.php?action=thank","thanksform", function (response) {
        if(response=='err'){
            alert('Error: GroupID not set!');
        } else {
            if($('#thankstext').raw().innerHTML!='') response = ', ' + response;
            $('#thankstext').raw().innerHTML += response;
            $('#thanksform').hide();
            $('#thanksdiv').show();
        }
    });
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



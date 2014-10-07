function SetMessage() {
	var id = document.getElementById('common_answers_select').value;

	ajax.get("?action=get_response&plain=1&id=" + id, function (data) {
		if ( $('#message').raw().value != '') data = "\n"+data+"\n";
        insert(data, 'message');
		$('#common_answers').hide();
	});
}

function UpdateMessage() {
	var id = document.getElementById('common_answers_select').value;

	ajax.get("?action=get_response&plain=0&id=" + id, function (data) {
		$('#common_answers_body').raw().innerHTML = data;
		$('#first_common_response').remove()
	});
}

function ValidateForm(id) {
    var ajax_message = '#ajax_message_' + id;
    var name =  jQuery.trim($('#response_name_' + id).raw().value);
    var message =  jQuery.trim($('#response_message_' + id).raw().value);
     
    if (name==null || name=="" || message==null || message=="")
    {
	  $(ajax_message).raw().innerHTML = 'One or more fields were blank.';
        $(ajax_message).add_class('alert');
        $(ajax_message).show();
        jQuery(ajax_message).fadeIn(0);
        setTimeout("jQuery('" + ajax_message + "').fadeOut(400)", 2000);
        return false;
    }
    return true;
}
// displays a message in common_responses
function Display_Message(added_id){
                //$JustAdded = (int)$_GET['added'];
    if (added_id>0) {
        msg = "Response successfully created.";  
        $('#ajax_message_' + added_id).remove_class('alert');  
    } else  {
        if (added_id==-1) msg='One or more fields were blank.';
        else if (added_id==-2) msg='Not a valid ID!';
        else msg = "Something unexpected went wrong!";  
        added_id=0;  
        $('#ajax_message_' + added_id).add_class('alert');  
   }  
   $('#ajax_message_' + added_id).show();
   $('#ajax_message_' + added_id).raw().innerHTML = msg;
   setTimeout("jQuery('#ajax_message_" + added_id + "').fadeOut(400)", 3000); 
}

function SaveMessage(id) {
	var ajax_message = '#ajax_message_' + id;
	var ToPost = [];
	
	ToPost['id'] = id;
	ToPost['name'] = $('#response_name_' + id).raw().value;
	ToPost['message'] = $('#response_message_' + id).raw().value;

	ajax.post("?action=edit_response", ToPost, function (data) {
			if (data == '1') {
				$(ajax_message).raw().innerHTML = 'Response successfully created.';
                        $(ajax_message).remove_class('alert');
			} else if (data == '2') {
				$(ajax_message).raw().innerHTML = 'Response successfully edited.';
                        $(ajax_message).remove_class('alert');
                        
			} else if (data == '-1') {
				$(ajax_message).raw().innerHTML = 'One or more fields were blank.';
                        $(ajax_message).add_class('alert');
			} else if (data == '-2') {
				$(ajax_message).raw().innerHTML = 'Not a valid ID!';
                        $(ajax_message).add_class('alert');
			} else {
				$(ajax_message).raw().innerHTML = data;
                        $(ajax_message).add_class('alert');
			}
			$(ajax_message).show();
                  jQuery(ajax_message).fadeIn(0);
                  setTimeout("jQuery('" + ajax_message + "').fadeOut(400)", 2000);
		}
	);
}
 

function DeleteMessage(id) {
      var tt = $('#response_name_' + id).raw().value;
      if(!confirm("Are you sure you want to delete response #" + id + "\n'" + tt + "' ?")) return;
	var ajax_message = '#ajax_message_' + id;

	var ToPost = [];
	ToPost['id'] = id;
	ajax.post("?action=delete_response", ToPost, function (data) {
		$('#response_head_' + id).hide();
		$('#response_' + id).hide();
		if (data == '1') {
			$(ajax_message).raw().textContent = "Response #" + id + " successfully deleted.";
		} else {
			$(ajax_message).raw().textContent = 'Something went wrong.';
		}
		$(ajax_message).show();
            jQuery(ajax_message).fadeIn(0);
		setTimeout("jQuery('" + ajax_message + "').fadeOut(400)", 2000);
		setTimeout("$('#container_" + id + "').hide()", 2400);
	});
}

function Assign() {
	var ToPost = [];
	ToPost['assign'] = document.getElementById('assign_to').value;
	ToPost['convid'] = document.getElementById('convid').value;

	ajax.post("?action=assign", ToPost, function (data) {
		if (data == '1') {
			document.getElementById('ajax_message').textContent = 'Conversation successfully assigned.';
		} else {
			document.getElementById('ajax_message').textContent = 'Something went wrong.';
		}
                location.reload();
		$('#ajax_message').show();
            jQuery('#ajax_message').fadeIn(0);
		setTimeout("jQuery('#ajax_message').fadeOut(400)", 2000);
	});
}

function PreviewResponse(id) {
	var div = '#response_div_'+id;
	if ($(div).has_class('hidden')) {
		var ToPost = [];
		ToPost['message'] = document.getElementById('response_message_'+id).value;
		ajax.post('?action=preview', ToPost, function (data) {
			document.getElementById('response_div_'+id).innerHTML = data;
			$(div).toggle();
			$('#response_editor_'+id).toggle();
		});
	} else {
		$(div).toggle();
		$('#response_editor_'+id).toggle();
	}
}

function PreviewMessage() {
	if ($('#preview').has_class('hidden')) {
		var ToPost = [];
		ToPost['message'] = document.getElementById('message').value;
		ajax.post('?action=preview', ToPost, function (data) {
			document.getElementById('preview').innerHTML = data;
			$('#preview').toggle();
			$('#quickpost').toggle();
			$('#previewbtn').raw().value = "Edit";
		});
	} else {
		$('#preview').toggle();
		$('#quickpost').toggle();
		$('#previewbtn').raw().value = "Preview";
	}
}

function Quote(id,user) {
        username = user;
        messageid = id;
        ajax.get("?action=get_message&body=1&message=" + messageid, function(response){
            var s = "[quote="+username+"]" +  html_entity_decode(response) + "[/quote]";
            if ( $('#message').raw().value != '')   s = "\n" + s + "\n";
            insert( s, 'message');
                resize('message');
        });
}


function Edit_Form(id,key) {
        messageid = id;
        $('#bar' + messageid).raw().cancel = $('#message' + messageid).raw().innerHTML;
        $('#bar' + messageid).raw().oldbar = $('#bar' + messageid).raw().innerHTML;
        $('#message' + messageid).raw().innerHTML = "<div id=\"preview" + messageid + "\" class=\"body\"></div><input type=\"hidden\" name=\"auth\" value=\"" + authkey + "\" /><input type=\"hidden\" id=\"key"+messageid+"\" name=\"key\" value=\"" + key + "\" /><input type=\"hidden\" name=\"post\" value=\"" + messageid + "\" /><div id=\"editcont" + messageid + "\"></div>";
        $('#bar' + messageid).raw().innerHTML = "<input type=\"button\" value=\"Preview\" onclick=\"Preview_Edit('" + messageid + "');\" /><input type=\"button\" value=\"Save\" onclick=\"Save_Edit('" + messageid + "')\" /><input type=\"button\" value=\"Cancel\" onclick=\"Cancel_Edit('" + messageid + "');\" />";
        ajax.get("?action=get_message&message=" + messageid, function(response){
                $('#editcont' + messageid).raw().innerHTML = response;
                resize('editbox' + messageid);
        });
}


function Cancel_Edit(messageid) {
        $('#bar' + messageid).raw().innerHTML = $('#bar' + messageid).raw().oldbar;
        $('#message' + messageid).raw().innerHTML = $('#bar' + messageid).raw().cancel;
}

function Preview_Edit(messageid) {
                var ToPost = [];
                ToPost['auth'] = authkey;
                ToPost['key'] = $('#key'+messageid).raw().value;
                ToPost['id'] = messageid;
                ToPost['message'] = $('#editbox'+messageid).raw().value;
        $('#bar' + messageid).raw().innerHTML = "<input type=\"button\" value=\"Editor\" onclick=\"Cancel_Preview('" + messageid + "');\" /><input type=\"button\" value=\"Save\" onclick=\"Save_Edit('" + messageid + "')\" /><input type=\"button\" value=\"Cancel\" onclick=\"Cancel_Edit('" +messageid + "');\" />";
        ajax.post("ajax.php?action=preview_staffpm", ToPost, function(response){  // "form" + messageid
                $('#preview' + messageid).raw().innerHTML = response;
                $('#editcont' + messageid).hide();
        });
}

function Cancel_Preview(postid) {
        $('#bar' + postid).raw().innerHTML = "<input type=\"button\" value=\"Preview\" onclick=\"Preview_Edit('" + postid + "');\" /><input type=\"button\" value=\"Save\" onclick=\"Save_Edit('" + postid + "')\" /><input type=\"button\" value=\"Cancel\" onclick=\"Cancel_Edit('" + postid + "');\" />";
        $('#preview' + postid).raw().innerHTML = "";
        $('#editcont' + postid).show();
}


function Save_Edit(messageid) {
    var ToPost = [];
    ToPost['auth'] = authkey;
    ToPost['key'] = $('#key'+messageid).raw().value;
    ToPost['id'] = messageid;
    ToPost['message'] = $('#editbox'+messageid).raw().value;
    ajax.post("staffpm.php?action=takeedit",ToPost, function (response) {
        $('#bar' + messageid).raw().innerHTML = "";
        $('#preview' + messageid).remove();
	$('#message' + messageid).raw().innerHTML = response;
        $('#editcont' + messageid).hide();
        $('#editcont' + messageid).raw().innerHTML = '';
    });
}

function LoadEdit(messageid, depth) {
        ajax.get("staffpm.php?action=get_edit&id=" + messageid + "&depth=" + depth, function(response) {
                        $('#message' + messageid).raw().innerHTML = response;
                }
        );
}



function SetMessage() {
	var id = document.getElementById('common_answers_select').value;

	ajax.get("?action=get_response&plain=1&id=" + id, function (data) {
		$('#quickpost').raw().value = data;
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

function SaveMessage(id, conv_id) {
	var ajax_message = 'ajax_message_' + id;
	var ToPost = [];
	
	ToPost['id'] = id;
	ToPost['name'] = document.getElementById('response_name_' + id).value;
	ToPost['message'] = document.getElementById('response_message_' + id).value;

	ajax.post("?action=edit_response", ToPost, function (data) {
			if (data == '1') {
				document.getElementById(ajax_message).textContent = 'Response successfully created.';
			} else if (data == '2') {
				document.getElementById(ajax_message).textContent = 'Response successfully edited.';
			} else {
				document.getElementById(ajax_message).textContent = 'Something went wrong.';
			}
			$('#' + ajax_message).show();
                  jQuery('#' + ajax_message).fadeIn(0);
                  setTimeout("jQuery('#" + ajax_message + "').fadeOut(400)", 2000);
		}
	);
}

function DeleteMessage(id) {
      var tt = $('#response_name_' + id).raw().value;
      if(!confirm("Are you sure you want to delete response #" + id + "\n'" + tt + "' ?")) return;
	var div = '#response_' + id;
	var ajax_message = '#ajax_message_' + id;

	var ToPost = [];
	ToPost['id'] = id;
	ajax.post("?action=delete_response", ToPost, function (data) {
		$(div).hide();
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
		ToPost['message'] = document.getElementById('quickpost').value;
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






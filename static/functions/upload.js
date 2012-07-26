function Categories() {
	ajax.get('ajax.php?action=upload_section&categoryid=' + $('#categories').raw().value, function (response) {
		$('#dynamic_form').raw().innerHTML = response;
	});
}

function add_tag() {
	if($('#tags').raw().value == "") {
		$('#tags').raw().value = $('#genre_tags').raw().options[$('#genre_tags').raw().selectedIndex].value;
	} else if($('#genre_tags').raw().options[$('#genre_tags').raw().selectedIndex].value == '---') {
	} else {
		$('#tags').raw().value = $('#tags').raw().value + ' ' + $('#genre_tags').raw().options[$('#genre_tags').raw().selectedIndex].value;
	}
      CursorToEnd($('#tags').raw());
      resize('tags');
}


function SynchInterface(){
    change_tagtext();
    resize('tags');
}

function SelectTemplate(can_delete_any){ // a proper check is done in the backend.. the param is just for the interface
    $('#fill').disable($('#template').raw().value==0);
    //var svalue=$('#template').raw().options[$('#template').raw().selectedIndex].text;
    //alert(svalue);
    $('#delete').disable($('#template').raw().value==0 || 
            (can_delete_any!='1' && EndsWith($('#template').raw().options[$('#template').raw().selectedIndex].text, ')*')));
    
    return false;
}

function AddTemplate(is_public){
    if(is_public==1) if(!confirm("Public templates are available for any user to use and display their authorname\nWarning: You cannot delete a public template once it is created\nAre you sure you want to proceed?"))return false;
    var name = prompt("Please enter the name for this template", "");
    if (!name || name =='') return false;
    var ToPost = [];
    ToPost['name'] = name;
    ToPost['ispublic'] = is_public;
    ToPost['title'] = $('#title').raw().value;
    ToPost['category'] = $('#category').raw().value;
    ToPost['image'] = $('#image').raw().value;
    ToPost['tags'] = $('#tags').raw().value;
    ToPost['body'] = $('#desc').raw().value;
    ajax.post("upload.php?action=add_template", ToPost, function(response){
            if (response==0) { //  
                $('#messagebar').add_class('alert');
                $('#messagebar').html("unexpected error!");
            } else if ( parseInt(response)>0 ) { // vote was counted
                $('#messagebar').remove_class('alert');
                $('#messagebar').html("added template '"+name+"' id#" + response  );
            } else { // a non number == an error  if ( !isnumeric(response)) 
                $('#messagebar').add_class('alert');
                $('#messagebar').html(response);
            }
            $('#messagebar').show(); 
    });
    return false;
}





var LogCount = 1;

function AddLogField() {
		if(LogCount >= 200) {return;}
		var LogField = document.createElement("input");
		LogField.type = "file";
		LogField.id = "file";
		LogField.name = "logfiles[]";
		LogField.size = 50;
		var x = $('#logfields').raw();
		x.appendChild(document.createElement("br"));
		x.appendChild(LogField);
		LogCount++;
}

function RemoveLogField() {
		if(LogCount == 1) {return;}
		var x = $('#logfields').raw();
		for (i=0; i<2; i++) {x.removeChild(x.lastChild);}
		LogCount--;
}


function Upload_Quick_Preview() { 
	$('#post_preview').raw().value = "Make changes";
	$('#post_preview').raw().preview = true;
	ajax.post("ajax.php?action=preview_upload","upload_table", function(response){
		$('#uploadpreviewbody').show();
		$('#contentpreview').raw().innerHTML = response;
		$('#uploadbody').hide(); 
	});
}

function Upload_Quick_Edit() {
	$('#post_preview').raw().value = "Preview";
	$('#post_preview').raw().preview = false;
	$('#uploadpreviewbody').hide();
	$('#uploadbody').show(); 
}
 
//Using this instead of comments as comments has pertty damn strict requirements on the variable names required

function Quick_Preview() {
	$('#buttons').raw().innerHTML = "<input type='button' value='Editor' onclick='Quick_Edit();' /><input type='submit' value='Send Message' />";
	ajax.post("ajax.php?action=preview","messageform", function(response){
		$('#quickpost').hide();
		$('#preview').raw().innerHTML = response;
		$('#preview').show();
	});
}

function Quick_Edit() {
	$('#buttons').raw().innerHTML = "<input type='button' value='Preview' onclick='Quick_Preview();' /><input type='submit' value='Send Message' />";
	$('#preview').hide();
	$('#quickpost').show();
}




function Inbox_Preview() {
	$('#buttons').raw().innerHTML = "<input type='button' value='Editor' onclick='Inbox_Edit();' /><input type='submit' value='Send Message' />";
	ajax.post("ajax.php?action=preview_newpm","messageform", function(response){
		$('#quickpost').hide();
		$('#preview').raw().innerHTML = response;
		$('#preview').show();
	});
}

function Inbox_Edit() {
	$('#buttons').raw().innerHTML = "<input type='button' value='Preview' onclick='Inbox_Preview();' /><input type='submit' value='Send Message' />";
	$('#preview').hide();
	$('#quickpost').show();
}

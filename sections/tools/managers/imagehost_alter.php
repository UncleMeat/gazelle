<?
if(!check_perms('admin_dnu')) { error(403); }

authorize();

if($_POST['submit'] == 'Delete'){ //Delete
	if(!is_number($_POST['id']) || $_POST['id'] == ''){ error(0); }
	$DB->query('DELETE FROM imagehost_whitelist WHERE ID='.$_POST['id']);
} else { //Edit & Create, Shared Validation
	$Val->SetFields('host', '1','string','The name must be set, and has a max length of 255 characters', array('maxlength'=>255, 'minlength'=>1));
	$Val->SetFields('comment', '0','string','The description has a max length of 255 characters', array('maxlength'=>255));
	$Val->SetFields('link', '0','link','The goto link is not a valid url.', array('maxlength'=>255, 'minlength'=>1));
	$_POST['link'] = trim($_POST['link']); // stop whitespace errors on validating link input
      $_POST['comment'] = trim($_POST['comment']); // stop db from storing empty comments
      $Err=$Val->ValidateForm($_POST); // Validate the form
	if($Err){ error($Err); }

	$P=array();
	$P=db_array($_POST); // Sanitize the form

	if($_POST['submit'] == 'Edit'){ //Edit
		if(!is_number($_POST['id']) || $_POST['id'] == ''){ error(0); }
		$DB->query("UPDATE imagehost_whitelist SET
			Imagehost='$P[host]',
			Link='$P[link]',
			Comment='$P[comment]',
			UserID='$LoggedUser[ID]',
			Time='".sqltime()."'
			WHERE ID='$P[id]'");
	} else { //Create
		$DB->query("INSERT INTO imagehost_whitelist 
			(Imagehost, Link, Comment, UserID, Time) VALUES
			('$P[host]','$P[link]','$P[comment]','$LoggedUser[ID]','".sqltime()."')");
	}
}
$Cache->delete_value('imagehost_whitelist');

// Go back
header('Location: tools.php?action=imghost_whitelist')
?>

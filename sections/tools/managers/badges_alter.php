<?

if(!check_perms('site_manage_badges')){ error(403); }

authorize();

if($_POST['submit'] == 'Delete') {
    
	if(!is_number($_POST['id']) || $_POST['id'] == ''){ error(0); }
	$DB->query('DELETE FROM badges WHERE ID='.$_POST['id']); 
      
} else {
    
	$Val->SetFields('name', '1','string','The name must be set, and has a max length of 64 characters', array('maxlength'=>64, 'minlength'=>1));
	$Val->SetFields('desc', '1','string','The description must be set, and has a max length of 255 characters', array('maxlength'=>255, 'minlength'=>1));
      $Val->SetFields('image', '1','string','The image must be set.', array('minlength'=>1));
	$Val->SetFields('type', '1','inarray','Invalid badge type was set.',array('inarray'=>$BadgeTypes));
	$Err=$Val->ValidateForm($_POST); // Validate the form
	if($Err){ error($Err); }

      $Name=db_string($_POST['name']);
      $Desc=db_string($_POST['desc']);
      $Image=db_string($_POST['image']);
      $Sort=(int)$_POST['sort'];
      $Cost=(int)$_POST['cost'];
      
	if($_POST['submit'] == 'Edit'){ //Edit
		if(!is_number($_POST['id']) || $_POST['id'] == ''){ error(0); }
		$DB->query("UPDATE badges SET
                              Type='{$_POST['type']}',
                              Sort='$Sort',
                              Cost='$Cost',
                              Name='$Name',
                              Description='$Desc',
                              Image='$Image'
                              WHERE ID='{$_POST['id']}'");
	} else { //Create
		$DB->query("INSERT INTO badges
			(Type, Sort, Cost, Name, Description, Image) VALUES
			('{$_POST['type']}','$Sort','$Cost','$Name','$Desc','$Image')");
	}
}
$Cache->delete_value('available_badges');

// Go back
header('Location: tools.php?action=badges_list');

?>

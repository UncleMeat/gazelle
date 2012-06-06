<?

if(!check_perms('site_manage_awards')){ error(403); }

authorize();

if($_POST['submit'] == 'Delete') {
    
	if(!is_number($_POST['id']) || $_POST['id'] == ''){ error(0); }
	$DB->query('DELETE FROM badges_auto WHERE ID='.$_POST['id']); 
      
} else {
	
      if ( !in_array($_POST['type'], $AutoAwardTypes) ) { error(0); }
	
      $BadgeId = (int)$_POST['badgeid'];
      $Action=db_string($_POST['type']);
      $Active=$_POST['active']==1?1:0;
      $SendPm=$_POST['sendpm']==1?1:0;
      $Value=(int)$_POST['value'];
      $CatId=(int)$_POST['catid'];
      
	if($_POST['submit'] == 'Edit'){ //Edit
		if(!is_number($_POST['id']) || $_POST['id'] == ''){ error(0); }
		$DB->query("UPDATE badges_auto SET
                              BadgeID='$BadgeId',
                              Action='$Action',
                              Active='$Active',
                              SendPM='$SendPm',
                              Value='$Value',
                              CategoryID='$CatId'
                              WHERE ID='{$_POST['id']}'");
	} else { //Create
		$DB->query("INSERT INTO badges_auto 
			(BadgeID, Action, Active, SendPM, Value, CategoryID) VALUES
			('$BadgeId','$Action','$Active','$SendPm','$Value','$CatId')");
	}
        
}

// Go back
header('Location: tools.php?action=awards_auto');

?>

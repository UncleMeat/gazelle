<?

if(!check_perms('site_manage_badges')){ error(403); }

authorize();

if($_POST['submit'] == 'Delete') {
    
    if(!is_number($_POST['id']) || $_POST['id'] == ''){ error(0); }
    $BadgeID = (int)$_POST['id'];
      
      
    $DB->query("SELECT DISTINCT UserID FROM users_badges WHERE BadgeID=$BadgeID");
    if ($DB->record_count()>0) {
        $Users = $DB->to_array();

        foreach ($Users as $UserID) {
              $Cache->delete_value('user_badges_ids_'.$UserID[0]);
              $Cache->delete_value('user_badges_'.$UserID[0]);
        }

        $DB->query("DELETE FROM users_badges WHERE BadgeID=$BadgeID"); 
    }
    
    $DB->query("DELETE FROM badges WHERE ID=$BadgeID"); 
    
} else {
    
	$Val->SetFields('badge', '1','string','The badge field must be set, and has a max length of 12 characters', array('maxlength'=>12, 'minlength'=>1));
	$Val->SetFields('title', '1','string','The name must be set, and has a max length of 64 characters', array('maxlength'=>64, 'minlength'=>1));
	$Val->SetFields('desc', '1','string','The description must be set, and has a max length of 255 characters', array('maxlength'=>255, 'minlength'=>1));
      $Val->SetFields('image', '1','string','The image must be set.', array('minlength'=>1));
	$Val->SetFields('type', '1','inarray','Invalid badge type was set.',array('inarray'=>$BadgeTypes));
	$Err=$Val->ValidateForm($_POST); // Validate the form
	if($Err){ error($Err); }

      $BadgeID = (int)$_POST['id'];
      $Badge=db_string($_POST['badge']);
      $Title=db_string($_POST['title']);
      $Desc=db_string($_POST['desc']);
      $Image=db_string($_POST['image']);
      $Rank=(int)$_POST['rank'];
      if ($Rank<=0) $Rank=1;
      $Sort=(int)$_POST['sort'];
      $Cost=(int)$_POST['cost'];
      
      // automagically constrain badge/rank 
      $DB->query("SELECT Rank FROM badges WHERE Badge='$Badge' AND ID !='$BadgeID'");
      $Ranks = $DB->collect('Rank');
      while( in_array($Rank, $Ranks )){
          $Rank++;
      }
      
      // automagically constrain badge/rank 
      $DB->query("SELECT Sort FROM badges WHERE ID !='$BadgeID'");
      $Sorts = $DB->collect('Sort');
      while( in_array($Sort, $Sorts )){
          $Sort++;
      }
      
	if($_POST['submit'] == 'Edit'){ //Edit
		if(!is_number($_POST['id']) || $_POST['id'] == ''){ error(0); }
		$DB->query("UPDATE badges SET
                              Badge='$Badge',
                              Rank='$Rank',
                              Type='{$_POST['type']}',
                              Sort='$Sort',
                              Cost='$Cost',
                              Title='$Title',
                              Description='$Desc',
                              Image='$Image'
                              WHERE ID='$BadgeID'");
	} else { //Create
		$DB->query("INSERT INTO badges
			(Badge, Rank, Type, Sort, Cost, Title, Description, Image) VALUES
			('$Badge','$Rank','{$_POST['type']}','$Sort','$Cost','$Title','$Desc','$Image')");
           // $BadgeID = $DB->inserted_id();
	}
}
$Cache->delete_value('available_badges');

// Go back
header("Location: tools.php?action=badges_list#$BadgeID");

?>

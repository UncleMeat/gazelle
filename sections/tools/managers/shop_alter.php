<?

if(!check_perms('site_manage_shop')){ error(403); }

authorize();

if($_POST['submit'] == 'Delete') {
    
	if(!is_number($_POST['id']) || $_POST['id'] == ''){ error(0); }
	$DB->query('DELETE FROM bonus_shop_actions WHERE ID='.$_POST['id']); 
      $Cache->delete_value('shop_items');
      $Cache->delete_value('shop_item_'.$_POST['id']);
      
} elseif ($_POST['autosynch'] == 'autosynch') {
    
      // Auto update shop items with applicable badge items

      if ($_POST['delete']==1){
            $DB->query("DELETE FROM bonus_shop_actions WHERE Action='badge'");
      }
      $Sort=(int)$_POST['sort'];
      
      $SQL = 'INSERT INTO bonus_shop_actions (Title, Description, Action, Value, Cost, Sort) VALUES';
      $Div = '';
      $DB->query("SELECT ID, 
                       Cost,
                       Name,
                       Description,
                       Image
                  FROM badges 
                 WHERE Type='Shop'
                 ORDER BY Sort");
      while(list($ID, $Cost, $Name, $Description, $Image)=$DB->next_record()) {
            $SQL .= "$Div ('$Name', '$Description', 'badge', '$ID', '$Cost', '$Sort')";
            $Div = ',';
            $Sort++;
      }
      $DB->query($SQL);
      $Cache->delete_value('shop_items');

} else {
	
	$Val->SetFields('name', '1','string','The name must be set, and has a max length of 64 characters', array('maxlength'=>64, 'minlength'=>1));
	$Val->SetFields('desc', '1','string','The description must be set, and has a max length of 255 characters', array('maxlength'=>255, 'minlength'=>1));
      $Val->SetFields('shopaction', '1','inarray','Invalid shop action was set.',array('inarray'=>$ShopActions));
	$Err=$Val->ValidateForm($_POST); // Validate the form
	if($Err){ error($Err); }
      
      $Name=db_string($_POST['name']);
      $Desc=db_string($_POST['desc']);
      $Action=db_string($_POST['shopaction']);
      $Value=(int)$_POST['value'];
      $Cost=(int)$_POST['cost'];
      $Sort=(int)$_POST['sort'];
      
	if($_POST['submit'] == 'Edit'){ //Edit
		if(!is_number($_POST['id']) || $_POST['id'] == ''){ error(0); }
		$DB->query("UPDATE bonus_shop_actions SET
                              Title='$Name',
                              Description='$Desc',
                              Action='$Action',
                              Value='$Value',
                              Cost='$Cost',
                              Sort='$Sort'
                              WHERE ID='{$_POST['id']}'");
           $Cache->delete_value('shop_items');
           $Cache->delete_value('shop_item_'.$_POST['id']);
	} else { //Create
		$DB->query("INSERT INTO bonus_shop_actions 
			(Title, Description, Action, Value, Cost, Sort) VALUES
			('$Name','$Desc','$Action','$Value','$Cost','$Sort')");
            $Cache->delete_value('shop_items');
	}
}

// Go back
header('Location: tools.php?action=shop_list');

?>

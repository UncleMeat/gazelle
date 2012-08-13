<?

if(!check_perms('site_manage_awards')){ error(403); }

authorize();

if(isset($_POST['delselected'])) {
    
    $AwardIDs = $_POST['deleteids'];  
    if (!is_array($AwardIDs)) error("Nothing selected to delete");
        
    foreach ($AwardIDs as $bID) {
        if (!is_number($bID))  error(0);  
    }
    $AwardIDs = implode(',', $AwardIDs);
        
    $DB->query("DELETE FROM badges_auto WHERE ID IN ($AwardIDs)"); 
      
    $ReturnID = 'editawards'; // return user to edit items on return
    
} else {
	
    if (!is_array($_POST['id'])) error("Nothing selected to add");
    $AwardIDs = $_POST['id'];
    
    $DB->query("SELECT ID FROM badges");
    $ValidBadgeIDs = $DB->collect('ID');
  
        
    $Val->OnlyValidateKeys = $_POST['id'];
    
    $Val->SetFields('badgeid', '1','inarray','The badge ', array('inarray'=>$ValidBadgeIDs)); 
    $Val->SetFields('type', '1','inarray','Invalid award action was set.',array('inarray'=>$AutoAwardTypes));
    $Val->SetFields('value', '1','number','The value must be a valid number.', array('allowcomma'=>1));
    
    $Err=$Val->ValidateForm($_POST); // Validate the form
    if($Err){ error($Err); }
    
    foreach ($AwardIDs as $AwardID) {
        if (isset($_POST['saveall'])) {
            if(!is_number($AwardID))  error(0);
            if(!$ReturnID) $ReturnID = $AwardID; // return user to first edited item on return
        } 
        
        if ( !in_array($_POST['type'][$AwardID], $AutoAwardTypes) ) { error(0); }
	
        $BadgeId = (int)$_POST['badgeid'][$AwardID];
        $Action=db_string($_POST['type'][$AwardID]);
        $Active=$_POST['active'][$AwardID]==1?1:0;
        $SendPm=$_POST['sendpm'][$AwardID]==1?1:0;
        $Value=(int)$_POST['value'][$AwardID];
        $CatId=(int)$_POST['catid'][$AwardID];
        
        
        if( isset($_POST['create']) ) {    // create
            
		$SQL_values[] = "('$BadgeId','$Action','$Active','$SendPm','$Value','$CatId')" ;
         
        } elseif( isset($_POST['saveall']) ) { //Edit
            
            $DB->query("UPDATE badges_auto SET
                              BadgeID='$BadgeId',
                              Action='$Action',
                              Active='$Active',
                              SendPM='$SendPm',
                              Value='$Value',
                              CategoryID='$CatId'
                              WHERE ID='$AwardID'");
         
        }
    } 
 
    if( isset($_POST['create']) && count($SQL_values)>0 ){   //Create
            $SQL_values = implode(',', $SQL_values);
		$DB->query("INSERT INTO badges_auto 
			(BadgeID, Action, Active, SendPM, Value, CategoryID)
			VALUES $SQL_values");  
            $ReturnID = $DB->inserted_id(); // return user to first saved item on return
    }
     
}

if ($_POST['returntop']==1) $ReturnID='';
else $ReturnID = "#$ReturnID";

if(isset($_REQUEST['numadd'])){ // set num add forms to be same as current
    $numAdds = (int)$_REQUEST['numadd'];
    if ($numAdds<1 || $numAdds > 20) $numAdds = 1;
    $UrlExtra = "&numadd=$numAdds";
} 
header("Location: tools.php?action=awards_auto$UrlExtra$ReturnID");

?>

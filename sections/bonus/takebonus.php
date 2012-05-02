<?php
enforce_login();
authorize();

$P=array();
$P=db_array($_POST);
      
$ItemID = empty($P['itemid']) ? '' : $P['itemid'];
if(!is_number($ItemID))  error(0);
$UserID = empty($P['userid']) ? '' : $P['userid'];
if(!is_number($UserID))  error(0);
if($UserID != $LoggedUser['ID'])  error(0);

$ShopItem = get_shop_item($ItemID);

if(!empty($ShopItem)){
    
    list($ItemID, $Title, $Description, $Action, $Value, $Cost) = $ShopItem[0];
 
    $OtherID = true;
    
    // if we need to have otherID get it from passed username 
    $forother = strpos($Action, 'give');
    if ($forother!==false){
        $Othername = empty($P['othername']) ? '' : $P['othername'];
        if($Othername){
            
            $DB->query("SELECT ID From users_main WHERE Username='$Othername'"); 
            if(($DB->record_count()) > 0) {
                list($OtherID) = $DB->next_record(); 
            } else {
                $OtherID=false;
                $ResultMessage = "Could not find user $Othername";
            }
        } else {
            $OtherID = false;
            //$ResultMessage = "No name set";
        }
    }
    
    // again lets not trust the check on the previous page as to whether they can afford it
    if ($OtherID && ($Cost <= $LoggedUser['Credits'])) {
        
        $UpdateSet = array();
        $UpdateSetOther = array();
         
        Switch($Action){  //  givecredits, givegb, gb, slot
            case 'givecredits':
                
                $Summary = sqltime().' - '.ucfirst("user gave a gift of $Value credits to {$P['othername']} Cost: $Cost credits");
                $UpdateSet[]="i.AdminComment=CONCAT_WS( '\n\n', '$Summary', i.AdminComment)";
                
                $Summary = sqltime().' - '.ucfirst("user recieved a gift of $Value credits from {$LoggedUser['Username']}");	
                $UpdateSetOther[]="i.AdminComment=CONCAT_WS( '\n\n', '$Summary', i.AdminComment)";
                
                $Summary = sqltime().' - '.ucfirst("you recieved a gift of $Value credits from {$LoggedUser['Username']}");
                $UpdateSetOther[]="i.BonusLog=CONCAT_WS( '\n', '$Summary', i.BonusLog)";
                $UpdateSetOther[]="m.Credits=(m.Credits+'$Value')";
                $Summary = sqltime().' - '.ucfirst("you gave a gift of $Value credits to {$P['othername']} Cost: $Cost credits");	
                $UpdateSet[]="i.BonusLog=CONCAT_WS( '\n', '$Summary', i.BonusLog)";
                $UpdateSet[]="m.Credits=(m.Credits-'$Cost')";
                $ResultMessage=$Summary;
                break;
            
            case 'gb':
                
                $Summary = sqltime().' - '.ucfirst("user bought -$Value gb. Cost: $Cost credits");	
                $UpdateSet[]="i.AdminComment=CONCAT_WS( '\n\n', '$Summary', i.AdminComment)";
      
                $Summary = sqltime().' - '.ucfirst("you bought -$Value gb. Cost: $Cost credits");	
                $UpdateSet[]="i.BonusLog=CONCAT_WS( '\n', '$Summary', i.BonusLog)";
                $Value = get_bytes($Value.'gb');
                $UpdateSet[]="m.Downloaded=(m.Downloaded-'$Value')";
                $UpdateSet[]="m.Credits=(m.Credits-'$Cost')";
                $ResultMessage=$Summary;
                break;
            
            case 'givegb':
                $Summary = sqltime().' - '.ucfirst("user gave a gift of -$Value gb to {$P['othername']} Cost: $Cost credits");	
                $UpdateSet[]="i.AdminComment=CONCAT_WS( '\n\n', '$Summary', i.AdminComment)";
                
                $Summary = sqltime().' - '.ucfirst("user recieved a gift of -$Value gb from {$LoggedUser['Username']}");	
                $UpdateSetOther[]="i.AdminComment=CONCAT_WS( '\n\n', '$Summary', i.AdminComment)";
                
                $Summary = sqltime().' - '.ucfirst("you recieved a gift of -$Value gb from {$LoggedUser['Username']}");
                $UpdateSetOther[]="i.BonusLog=CONCAT_WS( '\n', '$Summary', i.BonusLog)";
                $Summary = sqltime().' - '.ucfirst("you gave a gift of -$Value gb to {$P['othername']} Cost: $Cost credits");	
                $UpdateSet[]="i.BonusLog=CONCAT_WS( '\n', '$Summary', i.BonusLog)";
                $UpdateSet[]="m.Credits=(m.Credits-'$Cost')";
                $Value = get_bytes($Value.'gb');
                $UpdateSetOther[]="m.Downloaded=(m.Downloaded-'$Value')";
                $ResultMessage=$Summary;
                break;
            
            case 'slot':
                
                $Summary = sqltime().' - '.ucfirst("user bought $Value slot".($Value>1?'s':'').". Cost: $Cost credits");		
                $UpdateSet[]="i.AdminComment=CONCAT_WS( '\n\n', '$Summary', i.AdminComment)";
                $Summary = sqltime().' - '.ucfirst("you bought $Value slot".($Value>1?'s':'').". Cost: $Cost credits");	
                $UpdateSet[]="i.BonusLog=CONCAT_WS( '\n', '$Summary', i.BonusLog)";
                $UpdateSet[]="m.FLTokens=(m.FLTokens+'$Value')";
                $UpdateSet[]="m.Credits=(m.Credits-'$Cost')";
                $ResultMessage=$Summary;
                break;
        }

        if($UpdateSetOther){
            $SET = implode(', ', $UpdateSetOther);
            $sql = "UPDATE users_main AS m JOIN users_info AS i ON m.ID=i.UserID SET $SET WHERE m.ID='$OtherID'";
            $DB->query($sql);
            $Cache->delete_value('users_stats_'.$OtherID);
        }
        
        if($UpdateSet){
            $SET = implode(', ', $UpdateSet);
            $sql = "UPDATE users_main AS m JOIN users_info AS i ON m.ID=i.UserID SET $SET WHERE m.ID='$UserID'";
            $DB->query($sql);
            $Cache->delete_value('users_stats_'.$UserID);
        }
    }
}

// Go back
header("Location: bonus.php". (!empty($ResultMessage) ? "?result=" . htmlentities($ResultMessage):"")); 

?>

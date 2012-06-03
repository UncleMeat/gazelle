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

if(!empty($ShopItem) && is_array($ShopItem)){
    
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
                //$OtherUserStats = get_user_stats($OtherID);
            } else {
                $OtherID=false;
                $ResultMessage = "Could not find user $Othername";
            }
        } else {
            $OtherID = false; // user cancelled js prompt so othername is not set
            //$ResultMessage = "User cancelled operation";
        }
    }
    
    // again lets not trust the check on the previous page as to whether they can afford it
    if ($OtherID && ($Cost <= $LoggedUser['Credits'])) {
        
        $UpdateSet = array();
        $UpdateSetOther = array();
         
        Switch($Action){  // atm hardcoded in db:  givecredits, givegb, gb, slot, title, badge
            case 'badge' :
                
                $UserBadgeIDs = get_user_shop_badges_ids($UserID);
                if ( in_array($Value, $UserBadgeIDs)) {
                    $ResultMessage='Something bad happened (duplicate badge insertion)';
                    break;
                }
                
                
                $Summary = sqltime().' - '.ucfirst("user bought $Title badge. Cost: $Cost credits");	
                $UpdateSet[]="i.AdminComment=CONCAT_WS( '\n', '$Summary', i.AdminComment)";
                $Summary = sqltime()." | -$Cost credits | ".ucfirst("you bought a $Title badge.");
                $UpdateSet[]="i.BonusLog=CONCAT_WS( '\n', '$Summary', i.BonusLog)";
                //$LoggedUser['Badges'][] = $Value;
                //$LoggedUser['Badges'] = $BadgeBuilder->get_user_badge_array($LoggedUser['Badges']);
                //$UpdateSet[]="m.Badges='".db_string( serialize($LoggedUser['Badges']) )."'";
                
                $DB->query( "INSERT INTO users_badges (UserID, BadgeID, Title) 
                                  VALUES ( '$UserID', '$Value', '$Title')");
                
                $Cache->delete_value('user_badges_ids_'.$UserID);
                $Cache->delete_value('user_badges_'.$UserID);
                $UpdateSet[]="m.Credits=(m.Credits-'$Cost')";
                $ResultMessage=$Summary;
                
                /*
                if (in_array($Value, $LoggedUser['Badges'])){
                    $ResultMessage='Something bad happened (duplicate badge insertion)';
                    break;
                }
                include(SERVER_ROOT.'/classes/class_badges.php');
                $BadgeBuilder = new BADGES();
                $BadgeTitle = $BadgeBuilder->get_title($Value);
                
                $Summary = sqltime().' - '.ucfirst("user bought $BadgeTitle badge. Cost: $Cost credits");	
                $UpdateSet[]="i.AdminComment=CONCAT_WS( '\n', '$Summary', i.AdminComment)";
                $Summary = sqltime()." | -$Cost credits | ".ucfirst("you bought a $BadgeTitle badge.");
                $UpdateSet[]="i.BonusLog=CONCAT_WS( '\n', '$Summary', i.BonusLog)";
                $LoggedUser['Badges'][] = $Value;
                $LoggedUser['Badges'] = $BadgeBuilder->get_user_badge_array($LoggedUser['Badges']);
                $UpdateSet[]="m.Badges='".db_string( serialize($LoggedUser['Badges']) )."'";
                $UpdateSet[]="m.Credits=(m.Credits-'$Cost')";
                $ResultMessage=$Summary;
                 */
                break;
            
            case 'givecredits':
                
                $Summary = sqltime().' - '.ucfirst("user gave a gift of $Value credits to {$P['othername']} Cost: $Cost credits");
                $UpdateSet[]="i.AdminComment=CONCAT_WS( '\n', '$Summary', i.AdminComment)";
                
                $Summary = sqltime().' - '.ucfirst("user recieved a gift of $Value credits from {$LoggedUser['Username']}");	
                $UpdateSetOther[]="i.AdminComment=CONCAT_WS( '\n', '$Summary', i.AdminComment)";
                
                $Summary = sqltime()." | +$Value credits | ".ucfirst("you recieved a gift of $Value credits from {$LoggedUser['Username']}");
                $UpdateSetOther[]="i.BonusLog=CONCAT_WS( '\n', '$Summary', i.BonusLog)";
                $UpdateSetOther[]="m.Credits=(m.Credits+'$Value')";
                $Summary = sqltime()." | -$Cost credits | ".ucfirst("you gave a gift of $Value credits to {$P['othername']}");	
                $UpdateSet[]="i.BonusLog=CONCAT_WS( '\n', '$Summary', i.BonusLog)";
                $UpdateSet[]="m.Credits=(m.Credits-'$Cost')";
                $ResultMessage=$Summary;
                break;
            
            case 'gb':
                
                $Summary = sqltime().' - '.ucfirst("user bought -$Value gb. Cost: $Cost credits");	
                $UpdateSet[]="i.AdminComment=CONCAT_WS( '\n', '$Summary', i.AdminComment)";
      
                $Summary = sqltime()." | -$Cost credits | ".ucfirst("you bought -$Value gb.");	
                $UpdateSet[]="i.BonusLog=CONCAT_WS( '\n', '$Summary', i.BonusLog)";
                $Value = get_bytes($Value.'gb');
                $UpdateSet[]="m.Downloaded=(m.Downloaded-'$Value')";
                $UpdateSet[]="m.Credits=(m.Credits-'$Cost')";
                $ResultMessage=$Summary;
                break;
            
            case 'givegb':
                $Summary = sqltime().' - '.ucfirst("user gave a gift of -$Value gb to {$P['othername']} Cost: $Cost credits");	
                $UpdateSet[]="i.AdminComment=CONCAT_WS( '\n', '$Summary', i.AdminComment)";
                
                $Summary = sqltime().' - '.ucfirst("user recieved a gift of -$Value gb from {$LoggedUser['Username']}.");	
                $UpdateSetOther[]="i.AdminComment=CONCAT_WS( '\n', '$Summary', i.AdminComment)";
                
                $Summary = sqltime()." | ".ucfirst("you recieved a gift of -$Value gb from {$LoggedUser['Username']}.");
                $UpdateSetOther[]="i.BonusLog=CONCAT_WS( '\n', '$Summary', i.BonusLog)";
                $Summary = sqltime()." | -$Cost credits | ".ucfirst("you gave a gift of -$Value gb to {$P['othername']}.");	
                $UpdateSet[]="i.BonusLog=CONCAT_WS( '\n', '$Summary', i.BonusLog)";
                $UpdateSet[]="m.Credits=(m.Credits-'$Cost')";
                $Value = get_bytes($Value.'gb');
                $UpdateSetOther[]="m.Downloaded=(m.Downloaded-'$Value')";
                $ResultMessage=$Summary;
                break;
            
            case 'slot':
                
                $Summary = sqltime().' - '.ucfirst("user bought $Value slot".($Value>1?'s':'').". Cost: $Cost credits");	
                $UpdateSet[]="i.AdminComment=CONCAT_WS( '\n', '$Summary', i.AdminComment)";
                $Summary = sqltime()." | -$Cost credits | ".ucfirst("you bought $Value slot".($Value>1?'s':'').".");
                $UpdateSet[]="i.BonusLog=CONCAT_WS( '\n', '$Summary', i.BonusLog)";
                $UpdateSet[]="m.FLTokens=(m.FLTokens+'$Value')";
                $UpdateSet[]="m.Credits=(m.Credits-'$Cost')";
                $ResultMessage=$Summary;
                break;
            
            case 'title':
                
                $NewTitle = empty($P['title']) ? '' : display_str($P['title']);
                if(!$NewTitle){
                    $ResultMessage = "Title was not set";
                } else {
                    $Summary = sqltime().' - '.ucfirst("user bought a new custom title ''$NewTitle''. Cost: $Cost credits");	
                    $UpdateSet[]="i.AdminComment=CONCAT_WS( '\n', '$Summary', i.AdminComment)";
                    $Summary = sqltime()." | -$Cost credits | ".ucfirst("you bought a new custom title ''$NewTitle''.");
                    $UpdateSet[]="i.BonusLog=CONCAT_WS( '\n', '$Summary', i.BonusLog)";
                    $UpdateSet[]="m.Title='$NewTitle'";
                    $UpdateSet[]="m.Credits=(m.Credits-'$Cost')";
                    $ResultMessage=$Summary;
                } 
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

    
<?


function print_dupe_ips($UserID, $Username) {
	global $DB, $LoggedUser;

	if (!check_perms('users_mod')) error(403);
	if (!is_number($UserID)) error(403);
	
	$DB->query("SELECT d.ID 
				FROM dupe_groups AS d
				JOIN users_dupes AS u ON u.GroupID = d.ID
				WHERE u.UserID = $UserID");
	if (list($GroupID ) = $DB->next_record()) {
		$DB->query("SELECT m.ID
					FROM users_main AS m
					JOIN users_dupes AS d ON m.ID = d.UserID
					WHERE d.GroupID = $GroupID
					ORDER BY m.ID ASC");
		$DupeCount = $DB->record_count();
		$Dupes = $DB->to_array('ID');
	} else {
		$DupeCount = 0;
		$Dupes = array();
	}
    
    
	$DB->query(" SELECT e.UserID AS UserID, um.IP, 'account', 'history' FROM users_main AS um JOIN users_history_ips AS e ON um.IP=e.IP 
				 WHERE um.IP != '127.0.0.1' AND um.IP !='' AND e.UserID!= $UserID AND um.ID = $UserID
                UNION
                 SELECT e.ID AS UserID, um.IP, 'account', 'account' FROM users_main AS um JOIN users_main AS e ON um.IP=e.IP 
				 WHERE um.IP != '127.0.0.1' AND um.IP !='' AND e.ID!= $UserID AND um.ID = $UserID
                UNION
                 SELECT um.ID AS UserID, um.IP, 'history', 'account' FROM users_main AS um JOIN users_history_ips AS e ON um.IP=e.IP 
				 WHERE um.IP != '127.0.0.1' AND um.IP !='' AND e.UserID = $UserID AND um.ID != $UserID
                UNION
                 SELECT um.UserID AS UserID, um.IP, 'history', 'history' FROM users_history_ips AS um JOIN users_history_ips AS e ON um.IP=e.IP 
				 WHERE um.IP != '127.0.0.1' AND um.IP !='' AND e.UserID = $UserID AND um.UserID != $UserID  
                ORDER BY  UserID, IP   ");
    $IPDupeCount = $DB->record_count();
    $IPDupes = $DB->to_array();
    if ($IPDupeCount>0) {
?>
        <div class="head">
            <span style="float:left;"><?=$IPDupeCount?> Account<?=(($IPDupeCount == 1)?'':'s')?> with the same IP address</span>
            <span style="float:right;">
                <a href="#" onclick="$('#linkeddiv').toggle();this.innerHTML=this.innerHTML=='(hide)'?'(view)':'(hide)';return false;">(view)</a></span>
        </div> 
        <div class="box">
            <table width="100%" id="linkeddiv" class="shadow">
<?
            $i = 0;
            foreach($IPDupes AS $IPDupe) {
                list($EUserID, $IP, $EType1, $EType2) = $IPDupe;
                $i++;
                $DupeInfo = user_info($EUserID);
?> 
            <tr>
                <td align="left">
                    <?=format_username($EUserID, $DupeInfo['Username'], $DupeInfo['Donor'], $DupeInfo['Warned'], $DupeInfo['Enabled'], $DupeInfo['PermissionID'])?>
                </td>
                <td align="left">
                    <?=$IP?>
                </td>
                <td align="left">
                    <?="$Username's $EType1 <-> $DupeInfo[Username]'s $EType2"?>
                </td>
                <td>
<?
                    if ( !array_key_exists($EUserID, $Dupes) ) {
?>
						[<a href="user.php?action=dupes&dupeaction=link&auth=<?=$LoggedUser['AuthKey']?>&userid=<?=$UserID?>&targetid=<?=$EUserID?>">link</a>]
<?
                    }
?>
                </td> 
            </tr>
<?
            }
?>
            </table>
        </div>
<? 
    }
    
      
}


function ban_users($overspeed) { 
    $overspeed = (int)$overspeed;
    $DB->query("SELECT uid, Username 
                          FROM xbt_peers_history AS xbt
                     LEFT JOIN users_main AS um ON um.ID=xbt.uid
                     LEFT JOIN users_info AS ui ON ui.UserID=xbt.uid
                         WHERE (xbt.upspeed)>='$overspeed' 
                      GROUP BY xbt.uid ");


    
    
}

function ban_user($UserID){
    disable_users(array($UserID), "Disabled for speeding", 2);
}


// instead of banning disables from leeching - resets passkey - and sends pm (in case its borderline?)
function disable_cheat() {
    
    
}










function print_speed_option($speed, $selected_speed){
?>
    <option value="<?=$speed?>" <?=($selected_speed==$speed?' selected="selected"':'');?>>&nbsp;<?=get_size($speed);?>/s&nbsp;&nbsp;</option>
<?
}

function print_user_watchlist() {
    global $DB;
    
    //---------- user watch

    $DB->query("SELECT wl.UserID, um.Username, StaffID, um2.Username AS Staffname, Time, wl.Comment, KeepTorrents,
                                 ui.Donor, ui.Warned, um.Enabled, um.PermissionID
                  FROM users_watch_list AS wl
             LEFT JOIN users_main AS um ON um.ID=wl.UserID
             LEFT JOIN users_info AS ui ON ui.UserID=wl.UserID
             LEFT JOIN users_main AS um2 ON um2.ID=wl.StaffID
              ORDER BY Time DESC");
    $Watchlist = $DB->to_array('UserID');

?> 
        <div class="head">User watch list &nbsp;<img src="static/common/symbols/watched.png" alt="view" /><span style="float:right;"><a href="#" onclick="$('#uwatchlist').toggle();this.innerHTML=this.innerHTML=='(hide)'?'(view)':'(hide)';">(view)</a></span>&nbsp;</div>
        <table id="uwatchlist" class="hidden">
            <tr class="rowa"> 
                <td colspan="6" style="text-align: left;color:grey"> 
                    Users in the watch list will have their records retained until they are manually deleted. You can use this information to help detect ratio cheaters.<br/>
                    note: use the list sparingly - this can quickly fill the database with a huge number of records.
                </td>
            </tr>
            <tr class="colhead">
                <td class="center"></td>
                <td class="center">User</td>
                <td class="center">Time added</td>
                <td class="center">added by</td>
                <td class="center">comment</td>
                <!--<td class="center" width="100px" title="keep torrent records related to this user">keep torrents</td>-->
                <td class="center" width="240px"></td>
            </tr>
<?
            $row = 'a';
            if(count($Watchlist)==0){
?> 
                    <tr class="rowb">
                        <td class="center" colspan="7">no users on watch list</td>
                    </tr>
<?
            } else {
                foreach ($Watchlist as $Watched) {
                    list($UserID, $Username, $StaffID, $Staffname, $Time, $Comment, $KeepTorrents,
                                       $IsDonor, $Warned, $Enabled, $ClassID) = $Watched;
                    $row = ($row === 'b' ? 'a' : 'b');
?> 
    
                    <tr class="row<?=$row?>">
                        <form action="tools.php" method="post">
                            <input type="hidden" name="action" value="edit_userwl" />
                            <input type="hidden" name="viewspeed" value="<?=$ViewSpeed?>" />
                            <input type="hidden" name="userid" value="<?=$UserID?>" />
                            <input type="hidden" name="auth" value="<?=$LoggedUser['AuthKey']?>" />
                            <td class="center">
                                <a href="?action=speed_records&viewspeed=<?=$ViewSpeed?>&userid=<?=$UserID?>" title="View records for just <?=$Username?>">
                                    [view]
                                </a>
                            </td>
                            <td class="center"><?=format_username($UserID, $Username, $IsDonor, $Warned, $Enabled, $ClassID, false, false)?></td>
                            <td class="center"><?=time_diff($Time, 2, true, false, 1)?></td>
                            <td class="center"><?=format_username($StaffID, $Staffname)?></td>
                            <td class="center" title="<?=$Comment?>"><?=cut_string($Comment, 40)?></td>
                            <!--<td class="center">
                                <input type="checkbox" name="keeptorrent" <?if($KeepTorrents)echo'checked="checked"'?> value="1" title="if checked keep all torrent records this user is on as well" />
                            </td>-->
                            <td class="center">
                                <!--<input type="submit" name="submit" value="Save" title="Save edited value" />-->
                                <input type="submit" name="submit" value="Delete records" title="Remove all of this users records from the watchlist" /> 
                                <input type="submit" name="submit" value="Remove" title="Remove user from watchlist" /> 
                            </td>
                        </form>
                    </tr>
<?              }
            }
?>
    </table>
    <br/>   
<?
    return $Watchlist;
}

?>
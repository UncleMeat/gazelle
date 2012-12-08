    
<?



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
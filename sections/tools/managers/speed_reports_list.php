<?
if(!check_perms('admin_manage_cheats')) { error(403); }
 
show_header('Speed Reports','bbcode');


?>
<div class="thin">
    <h2>Speed Reports</h2>
    
    <div class="head"> </div>
    <form id="speedrecords" action="tools.php" method="post">
        <input type="hidden" name="action" value=" " />
        <input type="hidden" name="auth" value="<?=$LoggedUser['AuthKey']?>" />
        <table>
            <tr class="colhead">
                <td width="10px"></td>
                <td >User</td>
                <td >Downloaded</td>
                <td >Remaining</td>
                <td >Uploaded</td>
                <td >UpSpeed</td>
                <td >DownSpeed</td>
                <td >timespent</td>
                <td >Client</td>
                <td >ip</td>
                <td >TorrentID</td>
                <td >time</td>
            </tr>
<?
            $DB->query("SELECT xbt.id, uid, Username, xbt.downloaded, remaining, xbt.uploaded, upspeed, downspeed, 
                                                                            timespent, peer_id, xbt.ip, fid, xbt.mtime
                          FROM xbt_peers_history AS xbt
                          JOIN users_main AS um ON um.ID=xbt.uid
                      ORDER BY mtime DESC");

            $Row = 'b';
            if($DB->record_count()==0){
?> 
                    <tr class="<?=$Row?>">
                        <td class="center" colspan="12">no speed records</td>
                    </tr>
<?
            } else {
                while(list($ID, $UserID, $Username, $Downloaded, $Remaining, $Uploaded, $UpSpeed, $DownSpeed, 
                                                    $Timespent, $ClientPeerID, $IP, $TorrentID, $Time) = $DB->next_record()){  
                    $Row = ($Row === 'a' ? 'b' : 'a');
?> 
                    <tr class="<?=$Row?>">
                        <td>
                            <a id="<?=$ID?>"></a>#<?=$ID?><br/>
                            <input type="checkbox" id="id_<?=$ID?>" name="id[<?=$ID?>]" value="<?=$ID?>" title="If checked edits to this award schedule will be saved when you click on 'Save changes'" />
                        </td>
                        <td class="center"><?=$Username?></td>
                        <td class="center"><?=get_size($Downloaded)?></td>
                        <td class="center"><?=get_size($Remaining)?></td>
                        <td class="center"><?=get_size($Uploaded)?></td>
                        <td class="center"><?=get_size($UpSpeed)?>/s</td>
                        <td class="center"><?=get_size($DownSpeed)?>/s</td>
                        <td class="center"><?=time_diff($Timespent, 2, true, false, 0)?></td>
                        <td class="center"><?=substr($ClientPeerID,0,8)?></td>
                        <td class="center"><?=$IP?></td>
                        <td class="center"><?=$TorrentID?></td>
                        <td class="center"><?=time_diff($Time, 2, true, false, 0)?></td>
                    </tr>
<?              }
            }
            
            ?>
                
                <? /*
            <tr class="rowb"> 
                <td colspan="6" style="text-align: right;"> 
                    <input type="submit" name="saveall" value="Save changes" title="Save changes for all selected automatic awards schedules" />
                </td>
                <td colspan="6" style="text-align: right;"> 
                    <input type="submit" name="delselected" value="Delete selected" title="Delete selected auto award schedules" /> 
                </td>   */  ?>
            </tr>
        </table>
    </form>
</div>
<? show_footer(); ?>
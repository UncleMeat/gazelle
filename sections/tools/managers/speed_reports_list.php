<?
if(!check_perms('admin_manage_cheats')) { error(403); }
 
show_header('Speed Reports','bbcode');

function format_torrentid($torrentID, $name) {
    if ($torrentID == 0) return 'None';
    if ($name == '') $tname = $torrentID;
    else $tname = $name;
    $str = '<a href="torrents.php?torrentid='.$torrentID.'" title="'.$tname.'">'. cut_string($tname, 20).'</a>';
    if ($name == '') $str = "torrent not found [$str]";
    return $str;
}
function speed_span($speed, $text) {
    return '<span style="color:'.($speed>0?'black':'lightgrey').'">'.$text.'</span>';
}

            
list($Page,$Limit) = page_limit(50);

$DB->query("SELECT SQL_CALC_FOUND_ROWS
                            xbt.id, uid, Username, xbt.downloaded, remaining, t.Size, xbt.uploaded, 
                            upspeed, downspeed, timespent, peer_id, xbt.ip, fid, tg.Name, xbt.mtime
                          FROM xbt_peers_history AS xbt
                     LEFT JOIN users_main AS um ON um.ID=xbt.uid
                     LEFT JOIN torrents AS t ON t.ID=xbt.fid
                     LEFT JOIN torrents_group AS tg ON tg.ID=t.GroupID
                      ORDER BY mtime DESC
                         LIMIT $Limit");

$Records = $DB->to_array();
$DB->query("SELECT FOUND_ROWS()");
list($NumResults) = $DB->next_record();
 
$Pages=get_pages($Page,$NumResults,50,9);

?>
<div class="thin">
    <h2><?=$NumResults?> Speed Reports</h2>
    
	<div class="linkbox"><?=$Pages?></div>
    <div class="head"> </div>
    <form id="speedrecords" action="tools.php" method="post">
        <input type="hidden" name="action" value=" " />
        <input type="hidden" name="auth" value="<?=$LoggedUser['AuthKey']?>" />
        <table>
            <tr class="colhead">
                <td width="10px" rowspan="2"></td>
                <td class="center">User</td>
                <td class="center">Remaining</td>
                <td class="center">Uploaded</td>
                <td class="center">UpSpeed</td>
           <!-- <td >Downloaded</td>
                <td >DownSpeed</td>-->
                <td class="center">Client IP address</td>
                <td class="center">date time</td>
            </tr>
            <tr class="colhead">
                <td class="center"><span style="color:#777">TorrentID</span></td>
                <td class="center"><span style="color:#777">Total</span></td>
                <td class="center"><span style="color:#777">Downloaded</span></td>
                <td class="center"><span style="color:#777">DownSpeed</span></td>
                <td class="center"><span style="color:#777">ClientID</span></td>
                <td class="center"><span style="color:#777">total time</span></td>
            </tr>
<?

            if($NumResults==0){
?> 
                    <tr class="rowb">
                        <td class="center" colspan="12">no speed records</td>
                    </tr>
<?
            } else {
                foreach ($Records as $Record) {
                    list($ID, $UserID, $Username, $Downloaded, $Remaining, $Size, $Uploaded, $UpSpeed, $DownSpeed, 
                                                    $Timespent, $ClientPeerID, $IP, $TorrentID, $Name, $Time) = $Record;
                    $row = ($row === 'a' ? 'b' : 'a');
                    $ipcc = geoip($IP);
?> 
                    <tr class="row<?=$row?>">
                        <td rowspan="2">
                            <a id="<?=$ID?>"></a>#<?=$ID?><br/>
                            <input type="checkbox" id="id_<?=$ID?>" name="id[<?=$ID?>]" value="<?=$ID?>" title="If checked edits to this award schedule will be saved when you click on 'Save changes'" />
                        </td>
                        <td class="center"><?=format_username($UserID, $Username)?></td>
                        <td class="center"><?=get_size($Remaining)?></td>
                        <td class="center"><?=speed_span($Uploaded, get_size($Uploaded))?></td>
                        <td class="center"><?=speed_span($UpSpeed, get_size($UpSpeed).'/s')?></td>
                        <td class="center"><?=display_ip($IP, $ipcc)?></td>
                        <td class="center"><?=time_diff($Time, 2, true, false, 1)?></td>
                    </tr>
                    <tr class="row<?=$row?>">
                        <td class="center"><span style="color:#555"><?=format_torrentid($TorrentID, $Name)?></span></td>
                        <td class="center"><span style="color:#555"><?=get_size($Size)?></span></td>
                        <td class="center"><?=speed_span($Downloaded, get_size($Downloaded))?></td>
                        <td class="center"><?=speed_span($DownSpeed, get_size($DownSpeed).'/s')?></td>
                        <td class="center"><span style="color:#555"><?=substr($ClientPeerID,0,8)?></span></td>
                        <td class="center"><span style="color:#555" title="<?=time_span($Timespent, 4)?>"><?=time_span($Timespent, 2)?></span></td>
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
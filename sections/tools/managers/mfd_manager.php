<?
if(!check_perms('torrents_review')) { error(403); }

//include(SERVER_ROOT.'/sections/tools/managers/mfd_functions.php');

$ShowWarnOnly = isset($_REQUEST['warnonly']) && $_REQUEST['warnonly'];
$OverdueOnly = isset($_REQUEST['overdue']) && $_REQUEST['overdue'];

$DB->query("SELECT Hours, AutoDelete FROM review_options LIMIT 1");
list($Hours, $Delete) = $DB->next_record();


show_header('Manage torrents marked for deletion');
  
?>
    <div class="thin">
        <h2>Torrents marked for deletion</h2>
     
<?
	if($NumDeleted) {
          $ResultMessage ="Successfully Deleted $NumDeleted Torrent";
          if($NumDeleted>1) $ResultMessage .= 's';
          if($ResultMessage){
          ?>
			<div id="messagebar" class="messagebar"><?=$ResultMessage?></div><br />
<?
          }
      }
?>
        
        <table class="box pad wid740">
            <tr class="colhead"><td colspan="3" class="center">options</td></tr>
            <tr>
                <form action="tools.php?action=marked_for_deletion" method="post">
                        <input type="hidden" name="action" value="save_mfd_options" />
                        <input type="hidden" name="auth" value="<?=$LoggedUser['AuthKey']?>" />
                        <input type="hidden" name="warnonly" value="<?=$ShowWarnOnly?>" />
                        <input type="hidden" name="overdue" value="<?=$OverdueOnly?>" />
                        
                        <td class="center">
                            <label for="hours">Warning period: (hours) </label>
                            <input name="hours" type="text" size="3" value="<?=$Hours?>"<?=check_perms('torrents_review_override')?'':' disabled="disabled"';?> title="This is the hours given to fix the torrent when warned (has no effect on current list)" />
                        </td>
                        <td  class="center" width="25%">    
                            <label for="autodelete" title="AutoDelete">Auto Delete</label>
                            <select id="autodelete" name="autodelete"<?=check_perms('torrents_review_override')?'':' disabled="disabled"';?>>
                                <option value="1"<?=$Delete?' selected="selected"':'';?>>On&nbsp;&nbsp;</option> 
                                <option value="0"<?=$Delete?'':' selected="selected"';?>>Off&nbsp;&nbsp;</option> 
                            </select>
                        </td>
                        <td  class="center" width="30%">  
                            <?=check_perms('torrents_review_override')?'<input type="submit" value="Save Changes" />':'';?>
                        </td>
                </form>
            </tr>
        </table>
                  
        <div class="linkbox" >
        
<?     if (!$ShowWarnOnly){  ?>
          [<a href="tools.php?action=marked_for_deletion&amp;warnonly=1&amp;overdue=<?=$OverdueOnly?'1':'0';?>"> View warned only </a>] &nbsp;&nbsp;&nbsp;
<?     } else {     ?>
          [<a href="tools.php?action=marked_for_deletion&amp;warnonly=0&amp;overdue=<?=$OverdueOnly?'1':'0';?>"> View pending and warned </a>] &nbsp;&nbsp;&nbsp;
<?     }    ?>

          
<?     if ($OverdueOnly){  ?>
          [<a href="tools.php?action=marked_for_deletion&amp;warnonly=<?=$ShowWarnOnly?'1':'0';?>&amp;overdue=0"> View due and overdue </a>] &nbsp;&nbsp;&nbsp;
<?     } else {     ?>
          [<a href="tools.php?action=marked_for_deletion&amp;warnonly=<?=$ShowWarnOnly?'1':'0';?>&amp;overdue=1"> View overdue only </a>] &nbsp;&nbsp;&nbsp;
<?     }    ?>

        </div>
        <br/>
<?       
        $Torrents = get_torrents_under_review(!$ShowWarnOnly, $OverdueOnly);
        $NumTorrents = count($Torrents);
            
?>
        <form method="post" action="tools.php" id="reviewform">
            
            <div class="box pad">
                <h3 style="float:right;margin:5px 10px 0 0;">Showing: <?=$ShowWarnOnly?'Warned':'Pending and Warned';?> <?=$OverdueOnly?'(overdue only)':'';?></h3>
            
<? 		if (true) {  //     ?> 
                      <input type="button" name="submit" onclick="alert('not implemented yet')" title="Delete selected torrents" value="Delete selected" />
			<span style="margin-left:25%;">
                      <input type="submit" name="submit" title="Delete All Warned and Overdue torrents (red background)" value="Delete All Warned and Overdue torrents" />
                  </span>
<?		} ?>
             </div> 
        
            <table>
                <tr class="colhead">
                    <td width="8"><input type="checkbox" onclick="toggleChecks('reviewform',this)" /></td>
                    <td>Torrent</td>
                    <td width="40px"><strong>Status</strong></td>
                    <td width="160px">time till nuke</td>
                    <td><strong>Reason</strong>
                    <td width="8%">Username</td>
                </tr>
<?
    if ($NumTorrents==0){ // 
?>
                <tr>
                    <td colspan="6" class="center">no torrents are under review</td>
                </tr>
<? 
    } else {
        $Row = 'a';
        foreach($Torrents as $Torrent){
            $Row = $Row=='a'?'b':'a';
            list($TorrentID, $GroupID, $TorrentName, $Status, $ConvID, $KillTime, $Reason, $UserID, $Username) = $Torrent;
            
            $IsOverdue = strtotime($KillTime)<time();
?>
                <tr class="<?=($IsOverdue?($Status=='Pending'?'orangebar':'redbar'):"row$Row")?>">
                    <td class="center"><?=$IsOverdue?'<input type="checkbox" name="id[]" value="'.$GroupID.'" />':''?></td>
                    <td><a href="torrents.php?id=<?=$GroupID?>"><?=$TorrentName?></a></td>
                    <td><?=$Status?></td>
                    <td><?=time_diff($KillTime)?></td>
                    <td><?=$Reason?>
<?
        if ($ConvID>0) {
                echo '<span style="float:right;">'.($Status=='Pending'?'(user sent fixed message) &nbsp;&nbsp;':'').'<a href="staffpm.php?action=viewconv&id='.$ConvID.'">'.($Status=='Pending'?'Message sent to staff':"reply sent to $Username").'</a></span>';
        } elseif ($Status == 'Warned') {
                echo '<span style="float:right;">(pm sent to '.$Username.')</span>';
        }
?>
                    </td>
                    <td><?=format_username($UserID, $Username)?></td>
                </tr>      
<?
        }
    } // end print table of warned torrents    
?>
                <input type="hidden" name="warnonly" value="<?=$ShowWarnOnly?>" />
                <input type="hidden" name="overdue" value="<?=$OverdueOnly?>" />
                <input type="hidden" name="auth" value="<?=$LoggedUser['AuthKey']?>" />
                <input type="hidden" name="action" value="mfd_delete" />
            
            </table>
        </form>
 
        <br/>
    </div>

<? show_footer(); ?>

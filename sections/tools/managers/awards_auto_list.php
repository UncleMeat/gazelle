<?
if(!check_perms('site_manage_awards')) { error(403); }
/*
<!--
	<tr class="rowb">
		<td>this field is matched against image urls. displayed on the upload page.</td>
		<td>optional, if a valid url is present then it appears as an icon that can be clicked to take you to the link in a new page.</td>
		<td colspan="2">displayed to users on the upload page.</td>
		<td></td> 
	</tr> -->  */

show_header('Automatic Awards','badges');

$AutoAwardTypes = array ('NumPosts', 'NumComments', 'NumUploaded', 'NumNewTags', 'NumTags', 'NumTagVotes',
                  'RequestsFilled', 'UploadedTB', 'DownloadedTB', 'MaxSnatches');

$DB->query("SELECT ID, Title
              FROM badges WHERE Type='Single' ORDER BY Sort");
$BadgesArray = $DB->to_array();

$DB->query("SELECT ID, Name
              FROM categories ORDER BY Name");
$CatsArray = $DB->to_array();

function print_badges_select($ElementID, $CurrentBadgeID=-1){
    global $BadgesArray;
?>
    <select name="badgeid" id="badgeid<?=$ElementID?>" onchange="Select_Badge(<?=$ElementID?>)">
<?      foreach ($BadgesArray as $Badge) {  
        list($ID, $Name) = $Badge;  ?>
            <option value="<?=$ID?>"<?=($ID==$CurrentBadgeID?' selected="selected"':'')?> >#<?=$ID?> <?=$Name?>&nbsp;&nbsp;</option>
<?      } ?>
    </select>
<?
}
function print_categories($SelectedCat=-1){
    global $CatsArray;
?>
    <select name="catid" title="Category ID: If specified for NumUploaded then only torrents in this cateogry are counted (has no effect on other actions)">
        <option value="0">-none-</option>
<?      foreach ($CatsArray as $Cat) {   
            list($CatID,$CatName)=$Cat;  ?>
            <option value="<?=$CatID?>"<?=($CatID==$SelectedCat?' selected="selected"':'')?>><?=$CatName?>&nbsp;&nbsp;</option>
<?      } ?>
    </select>
<?
}
?>
<div class="thin">
<h2>Automatic Awards</h2>
<table>
    <tr>
        <td colspan="9" class="colhead">Add Automatic Award item</td>
    </tr>
    <tr class="colhead">
		<td width="40px" rowspan="2"></td>
		<td width="100px">Badge</td>
		<td width="80px">For</td>
		<td width="60px">Value</td>
		<td width="80px">Category<br />(NumUploaded only)</td>
		<td width="40px">Send PM</td>
		<td width="40px">Active</td>
		<td width="60px" rowspan="2"></td>
    </tr>
    <tr class="colhead">
		<td colspan="6">Description (from badges)</td>
    </tr>
    <form action="tools.php" method="post">
    <tr class="rowb">
		<input type="hidden" name="action" value="awards_alter" />
		<input type="hidden" name="auth" value="<?=$LoggedUser['AuthKey']?>" />
		<td class="center" rowspan="2">
                <div class="badge">
                    <span id="image0">
                    </span>
                </div>
		</td>
		<td>  
<?                  print_badges_select(0); ?> 
		</td>
		<td>
                <select name="type" >
<?                  foreach ($AutoAwardTypes as $Act) {   ?>
                        <option value="<?=$Act?>"><?=$Act?>&nbsp;&nbsp;&nbsp;&nbsp;</option>
<?                  } ?>
                </select>
		</td>
		<td>
			<input class="medium"  type="text" name="value" />
		</td>
		<td>
                <? print_categories() ?>
		</td>
		<td class="center">
			<input class="medium"  type="checkbox" name="sendpm" value="1" title="If checked then the user is sent a PM telling them when they recieve this award" />
		</td>
		<td class="center">
			<input class="medium"  type="checkbox" name="active" value="1" title="If checked this award will be automatically distributed to users who meet the specified requirements" />
		</td>
		<td rowspan="2">
			<input type="submit" value="Create" />
		</td>
    </tr>
    <tr class="rowb">
		<td colspan="6"> 
                <span id="desc0"></span>
		</td>
    </tr>
    </form>
</table>
<br/><br/>
<div class="box pad">
    When awarding these the system checks for users that do not have this badge, then checks those results against the Parameter and Value settings to determine who should get the award.
    Do not have the same badge being awarded by 2 different active items, or at least be aware the user will only get one and then be blocked from receiving the other.
    <p><strong>note:</strong> Badges are defined in the <a href="/tools.php?action=badges_list">Badges Manager</a></p>
</div><br/>
<table>
    <tr class="colhead">
		<td width="40px" rowspan="2"></td>
		<td width="120px">Badge</td>
		<td width="80px">Parameter</td>
		<td width="60px">Value</td>
		<td width="80px">Category<br />(NumUploaded only)</td>
		<td width="40px">Send PM</td>
		<td width="40px">Active</td>
		<td width="60px" rowspan="2"></td>
    </tr>
    <tr class="colhead"> 
		<td colspan="6">Description (from badges)</td>
    </tr>
<? 

$DB->query("SELECT ba.ID, ba.BadgeID, Title, Action, SendPM, Value, CategoryID, Description, Image , Active
              FROM badges_auto AS ba 
              JOIN badges AS b ON b.ID=ba.BadgeID ORDER BY b.Sort");

$Row = 'b';
while(list($ID, $BadgeID, $Name, $Action, $SendPM, $Value, $CategoryID, $Description, $Image, $Active) = $DB->next_record()){  
	$Row = ($Row === 'a' ? 'b' : 'a');
?>
    <form action="tools.php" method="post">
                <input type="hidden" name="action" value="awards_alter" />
                <input type="hidden" name="auth" value="<?=$LoggedUser['AuthKey']?>" />
                <input type="hidden" name="id" value="<?=$ID?>" />
                
        <tr class="rowb">
		<td class="center" rowspan="2">
                <div class="badge">
                    <span id="image<?=$ID?>">
                        <img src="<?=STATIC_SERVER.'common/badges/'.$Image?>" title="<?=$Name.'. '.$Description?>" alt="<?=$Name?>" />
                    </span>
                </div>
		</td>
		<td>
<?                  print_badges_select($ID, $BadgeID); ?> 
		</td>
		<td>
                <select name="type" >
<?          foreach ($AutoAwardTypes as $Act) {   ?>
                        <option value="<?=$Act?>"<?=($Act==$Action?' selected="selected"':'')?> ><?=$Act?>&nbsp;&nbsp;&nbsp;&nbsp;</option>
<?          } ?>
                </select>
		</td>
		<td>
			<input class="medium" type="text" name="value" value="<?=display_str($Value)?>" />
		</td>
		<td>
                <? print_categories($CategoryID) ?>
		</td>
		<td class="center">
			<input class="medium" type="checkbox" name="sendpm" value="1" <?=($SendPM?'checked="checked"':'')?> title="If checked then the user is sent a PM telling them when they recieve this award" />
		</td>
		<td class="center">
			<input class="medium" type="checkbox" name="active" value="1" <?=($Active?'checked="checked"':'')?> title="If checked this award will be automatically distributed to users who meet the specified requirements" />
		</td>
		<td rowspan="2">
                <input type="submit" name="submit" value="Edit" />
                <input type="submit" name="submit" value="Delete" />
		</td>
        </tr>
        <tr class="rowb">
		<td colspan="6">
			<span id="desc<?=$ID?>"><?=display_str($Description)?></span>
		</td>
        </tr>
        <tr class="rowa">
		<td colspan="8">
		</td>
        </tr>
    </form>
<? }  ?>
</table>
</div>
<? show_footer(); ?>

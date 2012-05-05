<?

/*
 * Yeah, that's right, edit and new are the same place again.
 * It makes the page uglier to read but ultimately better as the alternative means
 * maintaining 2 copies of almost identical files. 
 */

$NewRequest = ($_GET['action'] == "new" ? true : false);

if(!$NewRequest) {
	$RequestID = $_GET['id'];
	if(!is_number($RequestID)) {
		error(404);
	}
}


if($NewRequest && ($LoggedUser['BytesUploaded'] < 250*1024*1024 || !check_perms('site_submit_requests'))) {
	error('You do not have enough uploaded to make a request.');
}

if(!$NewRequest) {
	if(empty($ReturnEdit)) {
		
		$Request = get_requests(array($RequestID));
		$Request = $Request['matches'][$RequestID];
		if(empty($Request)) {
			error(404);
		}
		
		list($RequestID, $RequestorID, $RequestorName, $TimeAdded, $LastVote, $CategoryID, $Title, $Year, $Image, $Description, $CatalogueNumber, $RecordLabel, 
		     $ReleaseType, $BitrateList, $FormatList, $MediaList, $LogCue, $FillerID, $FillerName, $TorrentID, $TimeFilled, $GroupID) = $Request;
		$VoteArray = get_votes_array($RequestID);
		$VoteCount = count($VoteArray['Voters']);
		
		$NeedCue = (strpos($LogCue, "Cue") !== false);
		$NeedLog = (strpos($LogCue, "Log") !== false);
		if($NeedLog) {
			if(strpos($LogCue, "%")) {
				preg_match("/\d+/", $LogCue, $Matches);
				$MinLogScore = (int) $Matches[0];
			}
		}
		
		$IsFilled = !empty($TorrentID);
		$CategoryName = $NewCategories[$CategoryID]['name'];
		$ProjectCanEdit = (check_perms('project_team') && !$IsFilled && (($CategoryID == 0)));
		$CanEdit = ((!$IsFilled && $LoggedUser['ID'] == $RequestorID && $VoteCount < 2) || $ProjectCanEdit || check_perms('site_moderate_requests'));
		
		if(!$CanEdit) {
			error(403);
		}
				
		$Tags = implode(" ", $Request['Tags']);
	}
}

if($NewRequest && !empty($_GET['artistid']) && is_number($_GET['artistid'])) {
	$DB->query("SELECT Name FROM artists_group WHERE artistid = ".$_GET['artistid']." LIMIT 1");
	list($ArtistName) = $DB->next_record();
	$ArtistForm = array(
		1 => array(array('name' => trim($ArtistName))),
		2 => array(),
		3 => array()
	);
} elseif($NewRequest && !empty($_GET['groupid']) && is_number($_GET['groupid'])) {
	$ArtistForm = get_artist($_GET['groupid']);
	$DB->query("SELECT tg.Name, 
					tg.Year, 
					tg.ReleaseType, 
					tg.WikiImage,
					GROUP_CONCAT(t.Name SEPARATOR ', '),
				FROM torrents_group AS tg 
					JOIN torrents_tags AS tt ON tt.GroupID=tg.ID
					JOIN tags AS t ON t.ID=tt.TagID
				WHERE tg.ID = ".$_GET['groupid']);
	if(list($Title, $Year, $ReleaseType, $Image, $Tags) = $DB->next_record()) {
		$GroupID = trim($_REQUEST['groupid']);
	}
}

show_header(($NewRequest ? "Create a request" : "Edit a request"), 'requests');
?>
<div class="thin">
	<h2><?=($NewRequest ? "Create a request" : "Edit a request")?></h2>
	
	<div class="box pad">
		<form action="" method="post" id="request_form" onsubmit="Calculate();">
			<div>
<? if(!$NewRequest) { ?>
				<input type="hidden" name="requestid" value="<?=$RequestID?>" /> 
<? } ?>
				<input type="hidden" name="auth" value="<?=$LoggedUser['AuthKey']?>" />
				<input type="hidden" name="action" value="<?=$NewRequest ? 'takenew' : 'takeedit'?>" />
			</div>
			
			<table>
				<tr>
					<td colspan="2" class="center">Please make sure your request follows <a href="rules.php?p=requests">the request rules!</a></td>
				</tr>
<?	if($NewRequest || $CanEdit) { ?>
				<tr>
					<td class="label">
						Category
					</td>
					<td>
						<select id="categories" name="category">
<? foreach($NewCategories as $Cat){ $Cat = display_array($Cat); ?>
							<option value='<?=$Cat['id']?>' <?=(!empty($CategoryName) && ($CategoryName ==  $Cat['name']) ? 'selected="selected"' : '')?>><?=$Cat['name']?></option>
<?		} ?>
						</select>
					</td>
				</tr>
				<tr>
					<td class="label">Title</td>
					<td>
						<input type="text" name="title" size="45" value="<?=(!empty($Title) ? display_str($Title) : '')?>" />
					</td>
				</tr>
<?	} ?>
<?	if($NewRequest || $CanEdit) { ?>
				<tr id="image_tr">
					<td class="label">Image</td>
					<td>
						<input type="text" name="image" size="45" value="<?=(!empty($Image) ? $Image : '')?>" />
					</td>
				</tr>
<?	} ?>
				<tr>
					<td class="label">Tags</td>
					<td>
<?
	$GenreTags = $Cache->get_value('genre_tags');
	if(!$GenreTags) {
		$DB->query('SELECT Name FROM tags WHERE TagType=\'genre\' ORDER BY Name');
		$GenreTags =  $DB->collect('Name');
		$Cache->cache_value('genre_tags', $GenreTags, 3600*6);
	}
?>
						<select id="genre_tags" name="genre_tags" onchange="add_tag();return false;" >
							<option>---</option>
<?	foreach(display_array($GenreTags) as $Genre){ ?>
							<option value="<?=$Genre ?>"><?=$Genre ?></option>
<?	} ?>
						</select>
						<input type="text" id="tags" name="tags" size="45" value="<?=(!empty($Tags) ? display_str($Tags) : '')?>" />
						<br />
						Tags should be separated by a space, and you should use a period ('.') to bind words inside a tag - eg. '<strong style="color:green;">big.breast</strong>'. 
						<br /><br />
						There is a list of official tags to the left of the text box. Please use these tags instead of 'unofficial' tags (eg. use the official '<strong style="color:green;">drum.and.bass</strong>' tag, instead of an unofficial '<strong style="color:red;">dnb</strong>' tag.)
					</td>
				</tr>
				<tr>
					<td class="label">Description</td>
					<td>
						<textarea name="description" cols="70" rows="7"><?=(!empty($Description) ? $Description : '')?></textarea> <br />
					</td>
				</tr>

<?	if($NewRequest) { ?>
				<tr id="voting">
					<td class="label">Bounty (MB)</td>
					<td>
						<input type="text" id="amount_box" size="8" value="<?=(!empty($Bounty) ? $Bounty : '100')?>" onchange="Calculate();" />
						<select id="unit" name="unit" onchange="Calculate();">
							<option value='mb'<?=(!empty($_POST['unit']) && $_POST['unit'] == 'mb' ? ' selected="selected"' : '') ?>>MB</option>
							<option value='gb'<?=(!empty($_POST['unit']) && $_POST['unit'] == 'gb' ? ' selected="selected"' : '') ?>>GB</option>
						</select>
						<input type="button" value="Preview" onclick="Calculate();"/>
						<strong><?=($RequestTax * 100)?>% of this is deducted as tax by the system.</strong>
					</td>
				</tr>
				<tr>
					<td class="label">Post request information</td>
					<td>
						<input type="hidden" id="amount" name="amount" value="<?=(!empty($Bounty) ? $Bounty : '100')?>" />
						<input type="hidden" id="current_uploaded" value="<?=$LoggedUser['BytesUploaded']?>" />
						<input type="hidden" id="current_downloaded" value="<?=$LoggedUser['BytesDownloaded']?>" />
						If you add the entered <strong><span id="new_bounty">100.00 MB</span></strong> of bounty, your new stats will be: <br/>
						Uploaded: <span id="new_uploaded"><?=get_size($LoggedUser['BytesUploaded'])?></span>
						Ratio: <span id="new_ratio"><?=ratio($LoggedUser['BytesUploaded'],$LoggedUser['BytesDownloaded'])?></span>
					</td>
				</tr>
				<tr>
					<td colspan="2" class="center">
						<input type="submit" id="button" value="Create request" />
					</td>
				</tr>
<?	} else { ?>		
				<tr>
					<td colspan="2" class="center">
						<input type="submit" id="button" value="Edit request" />
					</td>
				</tr>
<?	} ?>
			</table>
		</form>
	</div>
</div>
<?
show_footer(); 
?>

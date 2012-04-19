<?
//*********************************************************************//
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Upload form ~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
// This page relies on the TORRENT_FORM class. All it does is call	 //
// the necessary functions.											//
//---------------------------------------------------------------------//
// $Properties, $Err are set in takeupload.php, and                     //
// are only used when the form doesn't validate and this page must be  //
// called again.													   //
//*********************************************************************//

ini_set('max_file_uploads','100');
show_header('Upload','upload');

if(empty($Properties) && !empty($_GET['groupid']) && is_number($_GET['groupid'])) {
	$DB->query("SELECT 
		tg.ID as GroupID,
		tg.CategoryID,
		tg.Name AS Title,
		tg.Year,
		tg.RecordLabel,
		tg.CatalogueNumber,
		tg.WikiImage AS Image,
		tg.WikiBody AS GroupDescription,
		tg.ReleaseType,
		tg.VanityHouse
		FROM torrents_group AS tg
		LEFT JOIN torrents AS t ON t.GroupID = tg.ID
		WHERE tg.ID=".$_GET['groupid']."
		GROUP BY tg.ID");
	if ($DB->record_count()) {	
		list($Properties) = $DB->to_array(false,MYSQLI_BOTH);
		$Properties['CategoryName'] = $Categories[$Properties['CategoryID']-1];
		$Properties['Artists'] = get_artist($_GET['groupid']);
		
		$DB->query("SELECT 
			GROUP_CONCAT(tags.Name SEPARATOR ', ') AS TagList 
			FROM torrents_tags AS tt JOIN tags ON tags.ID=tt.TagID
			WHERE tt.GroupID='$_GET[groupid]'");
		
		list($Properties['TagList']) = $DB->next_record();
	} else {
		unset($_GET['groupid']);
	}
	if (!empty($_GET['requestid']) && is_number($_GET['requestid'])) {
		$Properties['RequestID'] = $_GET['requestid'];
	}	
} elseif (empty($Properties) && !empty($_GET['requestid']) && is_number($_GET['requestid'])) {
	include(SERVER_ROOT.'/sections/requests/functions.php');	
	$DB->query("SELECT
		r.ID AS RequestID,
		r.CategoryID,
		r.Title AS Title,
		r.Year,
		r.RecordLabel,
		r.CatalogueNumber,
		r.ReleaseType,
		r.Image
		FROM requests AS r
		WHERE r.ID=".$_GET['requestid']);
	
	list($Properties) = $DB->to_array(false,MYSQLI_BOTH);
	$Properties['CategoryName'] = $Categories[$Properties['CategoryID']-1];
	$Properties['Artists'] = get_request_artists($_GET['requestid']);
	$Properties['TagList'] = implode(", ", get_request_tags($_GET['requestid']));
}

if(!empty($ArtistForm)) {
	$Properties['Artists'] = $ArtistForm;
}

require(SERVER_ROOT.'/classes/class_torrent_form.php');
$TorrentForm = new TORRENT_FORM($Properties, $Err);

if(!isset($Text)) {
	include(SERVER_ROOT.'/classes/class_text.php'); // Text formatting class
	$Text = new TEXT;
}

$GenreTags = $Cache->get_value('genre_tags');
if(!$GenreTags) {
	$DB->query("SELECT Name FROM tags WHERE TagType='genre' ORDER BY Name");
	$GenreTags =  $DB->collect('Name');
	$Cache->cache_value('genre_tags', $GenreTags, 3600*6);
}

/* -------  Draw a box with do_not_upload list  ------- */   
$DB->query("SELECT 
	d.Name, 
	d.Comment,
	d.Time
	FROM do_not_upload as d
	ORDER BY d.Time");
$DNU = $DB->to_array();
list($Name,$Comment,$Updated) = end($DNU);
reset($DNU);
$DB->query("SELECT IF(MAX(t.Time) < '$Updated' OR MAX(t.Time) IS NULL,1,0) FROM torrents AS t
			WHERE UserID = ".$LoggedUser['ID']);
list($NewDNU) = $DB->next_record();
$HideDNU = check_perms('torrents_hide_dnu') && !$NewDNU;
/*  class="<?=(check_perms('torrents_hide_dnu')?'box pad':'')?>"   */
?><div class="thin">
<div class="box pad" style="margin:10px auto">
	<span style="float:right;clear:right"><p><?=$NewDNU?'<strong class="important_text">':''?>Last Updated: <?=time_diff($Updated)?><?=$NewDNU?'</strong>':''?></p></span>
	<h3 id="dnu_header">Do not upload from the following list</h3> 
	<p>The following releases are currently forbidden from being uploaded to the site. Do not upload them unless your torrent meets a condition specified in the comment.
<? if ($HideDNU) { ?>
   <span id="showdnu"><a href="#" <a href="#" onclick="$('#dnulist').toggle(); this.innerHTML=(this.innerHTML=='(Hide)'?'(Show)':'(Hide)'); return false;">(Show)</a></span>
<? } ?>
	</p>
	<table id="dnulist" class="<?=($HideDNU?'hidden':'')?>" style="">
		<tr class="colhead">
			<td width="50%"><strong>Name</strong></td>
			<td><strong>Comment</strong></td>
		</tr>
<? foreach($DNU as $BadUpload) { 
		list($Name, $Comment, $Updated) = $BadUpload;
?>		
		<tr>
			<td><?=$Text->full_format($Name)?></td>
			<td><?=$Text->full_format($Comment)?></td>
		</tr>
<? } ?>
	</table>
</div><?=($HideDNU?'<br />':'')?>
<?   
/* -------  Draw a box with imagehost whitelist  ------- */   
$DB->query("SELECT 
            w.Imagehost, 
            w.Link,
            w.Comment,
            w.Time
            FROM imagehost_whitelist as w
            ORDER BY w.Time");
$Whitelist = $DB->to_array();
list($Host, $Link, $Comment,$Updated) = end($Whitelist);
reset($Whitelist);

$DB->query("SELECT IF(MAX(t.Time) < '$Updated' OR MAX(t.Time) IS NULL,1,0) FROM torrents AS t
			WHERE UserID = ".$LoggedUser['ID']);
list($NewWL) = $DB->next_record();  
$HideWL = check_perms('torrents_hide_imagehosts') && !$NewWL;
?>
<div class="box pad" style="margin:10px auto;">
	<span style="float:right;clear:right"><p><?=$NewWL?'<strong class="important_text">':''?>Last Updated: <?=time_diff($Updated)?><?=$NewWL?'</strong>':''?></p></span>
	<h3 id="dnu_header">Approved Imagehosts</h3> 
      <p>You must use one of the following approved imagehosts for all images. 
<? if ($HideWL) { ?>
   <span id="showdnu"><a href="#" <a href="#" onclick="$('#whitelist').toggle(); this.innerHTML=(this.innerHTML=='(Hide)'?'(Show)':'(Hide)'); return false;">(Show)</a></span>
<? } ?>
	</p>
	<table id="whitelist" class="<?=($HideWL?'hidden':'')?>" style="">
		<tr class="colhead">
			<td width="50%"><strong>Imagehost</strong></td>
			<td><strong>Comment</strong></td>
		</tr>
<? foreach($Whitelist as $ImageHost) { 
		list($Host, $Link, $Comment, $Updated) = $ImageHost;
?>		
		<tr>
			<td><?=$Text->full_format($Host)?>
               <?  // if a goto link is supplied and is a validly formed url make a link icon for it
               if ( !empty($Link) && $Text->valid_url($Link)) { 
                   ?><a href="<?=$Link?>"  target="_blank"><img src="<?=STATIC_SERVER?>common/symbols/offsite.gif" width="16" height="16" style="" alt="Goto <?=$Host?>" /></a>
               <? } // endif has a link to imagehost ?>
                  </td>
			<td><?=$Text->full_format($Comment)?></td>
		</tr>
<? } ?>
	</table> 
</div></div><?=($HideWL?'<br />':'')?>

<?
 
/* -------  Draw upload torrent form  ------- */   
$TorrentForm->head();
//$TorrentForm->simple_form($Properties['CategoryID'], $GenreTags);
$TorrentForm->simple_form($GenreTags);
$TorrentForm->foot();
?>
<script type="text/javascript">
	Format();
	Bitrate();
	Media();
</script>

<?
show_footer();
?>

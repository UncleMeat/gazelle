<?
/************************************************************************
||------------|| Edit artist wiki page ||------------------------------||

This page is the page that is displayed when someone feels like editing 
an artist's wiki page.

It is called when $_GET['action'] == 'edit'. $_GET['artistid'] is the 
ID of the artist, and must be set.

The page inserts a new revision into the wiki_artists table, and clears 
the cache for the artist page. 

************************************************************************/

$GroupID = $_GET['groupid'];
if(!is_number($GroupID) || !$GroupID) { error(0); }

// Get the artist name and the body of the last revision
$DB->query("SELECT
	tg.Name,
	wt.Image,
	wt.Body,
	tg.WikiImage,
	tg.WikiBody,
	tg.Year,
	tg.RecordLabel,
	tg.CatalogueNumber,
	tg.ReleaseType,
	tg.VanityHouse
	FROM torrents_group AS tg
	LEFT JOIN wiki_torrents AS wt ON wt.RevisionID=tg.RevisionID
	WHERE tg.ID='$GroupID'");
if($DB->record_count() == 0) { error(404); }
list($Name, $Image, $Body, $WikiImage, $WikiBody, $Year, $RecordLabel, $CatalogueNumber, $ReleaseType, $VanityHouse) = $DB->next_record();

if(!$Body) { $Body = $WikiBody; $Image = $WikiImage; }

include(SERVER_ROOT.'/classes/class_text.php');

$Text = new TEXT;

show_header('Edit torrent','bbcode');

// Start printing form
?>
<div class="thin">
	<h2>Edit <a href="torrents.php?id=<?=$GroupID?>"><?=$Name?></a></h2>
	<div class="box pad">
		<form action="torrents.php" method="post">
			<div>
				<input type="hidden" name="action" value="takegroupedit" />
				<input type="hidden" name="auth" value="<?=$LoggedUser['AuthKey']?>" />
				<input type="hidden" name="groupid" value="<?=$GroupID?>" />
				<h3>Image</h3>
				<input type="text" name="image" size="92" value="<?=$Image?>" /><br />
				<h3>Description</h3>
                            <? $Text->display_bbcode_assistant("textbody"); ?>
				<textarea id="textbody" name="body" cols="91" rows="20"><?=$Body?></textarea><br />
				<h3>Edit summary</h3>
				<input type="text" name="summary" size="92" /><br />
				<div style="text-align: center;">
					<input type="submit" value="Submit" />
				</div>
			</div>
		</form>
	</div>
<?	$DB->query("SELECT UserID FROM torrents WHERE GroupID = ".$GroupID);
	//Users can edit the group info if they've uploaded a torrent to the group or have torrents_edit
	if(in_array($LoggedUser['ID'], $DB->collect('UserID')) || check_perms('torrents_edit')) { ?> 
	<h2>Other</h2>
	<div class="box pad">
		<form action="torrents.php" method="post">
			<input type="hidden" name="action" value="nonwikiedit" />
			<input type="hidden" name="auth" value="<?=$LoggedUser['AuthKey']?>" />
			<input type="hidden" name="groupid" value="<?=$GroupID?>" />
			<table cellpadding="3" cellspacing="1" border="0" class="border" width="100%">                              
<? if(check_perms('torrents_freeleech')) { ?>
				<tr>
					<td class="label">Freeleech</td>
					<td>
						<input type="checkbox" name="unfreeleech" /> Reset
						<input type="checkbox" name="freeleech" /> Freeleech
						<input type="checkbox" name="neutralleech" /> Neutralleech
						 because 
						<select name="freeleechtype">
	<?	$FL = array("N/A", "Staff Pick", "Perma-FL", "Vanity House");
		foreach($FL as $Key => $FLType) { ?>	
							<option value="<?=$Key?>" <?=($Key == $Torrent['FreeLeechType'] ? ' selected="selected"' : '')?>><?=$FLType?></option>
	<?	} ?>
						</select>
					</td>
				</tr>	
<? } ?>
			</table>
			<input type="submit" value="Edit" />
		</form>
	</div>
<? 
	}
	if(check_perms('torrents_edit')) { 
?> 
	<h2>Rename Title</h2>
	<div class="box pad">
		<form action="torrents.php" method="post">
			<div>
				<input type="hidden" name="action" value="rename" />
				<input type="hidden" name="auth" value="<?=$LoggedUser['AuthKey']?>" />
				<input type="hidden" name="groupid" value="<?=$GroupID?>" />
				<input type="text" name="name" size="92" value="<?=$Name?>" />
				<div style="text-align: center;">
					<input type="submit" value="Rename" />
				</div>
				
			</div>
		</form>
	</div>
<?	} ?> 
</div>
<?
show_footer();
?>

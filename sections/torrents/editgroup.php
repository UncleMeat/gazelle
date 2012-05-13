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

if($HasDescriptionData === TRUE) {
    $DB->query("SELECT
          tg.Name,
          t.UserID
          FROM torrents_group AS tg
          JOIN torrents AS t ON t.GroupID = tg.ID
          WHERE tg.ID='$GroupID'");
    if($DB->record_count() == 0) { error(404); }
    list($Name, $UserID) = $DB->next_record();
} else {
    $DB->query("SELECT
          tg.NewCategoryID,
          tg.Name,
          tg.Image,
          tg.Body,
          t.UserID
          FROM torrents_group AS tg
          JOIN torrents AS t ON t.GroupID = tg.ID
          WHERE tg.ID='$GroupID'");
    if($DB->record_count() == 0) { error(404); }
    list($CategoryID, $Name, $Image, $Body, $UserID) = $DB->next_record();
    $CanEdit = check_perms('torrents_edit') || ($UserID == $LoggedUser['ID']);
}

if(!$CanEdit) { error(403); }

if (!isset($Text)) {
    include(SERVER_ROOT.'/classes/class_text.php');
    $Text = new TEXT;
}

show_header('Edit torrent','bbcode,edittorrent');

// Start printing form
?>
<div class="thin">
<?
    if($Err) {
        echo '<div class="box pad"><h4 style="color: red;text-align:center;">'.$Err.'</h4></div>';
    } 
?>
	<h2>Edit <a href="torrents.php?id=<?=$GroupID?>"><?=$Name?></a></h2>
	<div class="box pad">
		<form id="edit_torrent" action="torrents.php" method="post">
			<div>
				<input type="hidden" name="action" value="takegroupedit" />
				<input type="hidden" name="auth" value="<?=$LoggedUser['AuthKey']?>" />
				<input type="hidden" name="groupid" value="<?=$GroupID?>" />

                                <h3>Category</h3>
                                <select name="categoryid">
                                <? foreach($NewCategories as $category) { ?>
                                <option <?=$CategoryID==$category['id'] ? 'selected="selected"' : ''?> value="<?=$category['id']?>"><?=$category['name']?></option>
                                <? } ?>
                                </select>                              
				<h3>Image</h3>
				<input type="text" name="image" size="92" value="<?=$Image?>" /><br />
				<h3>Description</h3>
                        
                        <div id="preview" class="hidden"  style="text-align:left;">
                        </div>
                        <div id="editor"> 
                                <h3>Cover Image</h3>
                                <input type="text" name="image" class="long" value="<?=$Image?>" /><br />
                                <h3>Description</h3>
                                    <? $Text->display_bbcode_assistant("body", get_permissions_advtags($LoggedUser['ID'], $LoggedUser['CustomPermissions'])); ?>
                                <textarea id="body" name="body" class="long" rows="20"><?=$Body?></textarea><br />
                        </div>
                        <h3>Edit summary</h3>
				<input type="text" name="summary" class="long" value="<?=$EditSummary?>" /><br />
				<div style="text-align: center;">
                                <input id="preview_button" type="button" value="Preview" onclick="Preview_Toggle();" />
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

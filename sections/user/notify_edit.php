<?
if(!check_perms('site_torrents_notify')){ error(403); }
show_header('Manage notifications');
?>
<div class="thin">
	<div class="head">Notify me of all new torrents with...<a href="torrents.php?action=notify">(View)</a></div>
<?
$DB->query("SELECT ID, Label, Tags, NotTags, Categories FROM users_notify_filters WHERE UserID='$LoggedUser[ID]' UNION ALL SELECT NULL, NULL, NULL, 1, NULL");
$i = 0;
$NumFilters = $DB->record_count()-1;

$Notifications = $DB->to_array();

foreach($Notifications as $N) { //$N stands for Notifications
	$N['Tags']		= implode(' ', explode('|', substr($N['Tags'],1,-1)));
	$N['NotTags']		= implode(' ', explode('|', substr($N['NotTags'],1,-1)));
	$N['Categories'] 	= explode('|', substr($N['Categories'],1,-1));
	$i++;

	if($i>$NumFilters && $NumFilters>0){ ?>
			<h3>Create a new notification filter</h3>
<?	} elseif($NumFilters>0) { ?>
			<h3>
				<a href="feeds.php?feed=torrents_notify_<?=$N['ID']?>_<?=$LoggedUser['torrent_pass']?>&amp;user=<?=$LoggedUser['ID']?>&amp;auth=<?=$LoggedUser['RSS_Auth']?>&amp;passkey=<?=$LoggedUser['torrent_pass']?>&amp;authkey=<?=$LoggedUser['AuthKey']?>&amp;name=<?=urlencode($N['Label'])?>"><img src="<?=STATIC_SERVER?>/common/symbols/rss.png" alt="RSS feed" /></a>
				<?=display_str($N['Label'])?>
				<a href="user.php?action=notify_delete&amp;id=<?=$N['ID']?>&amp;auth=<?=$LoggedUser['AuthKey']?>">(Delete)</a>
			</h3>
<?	} ?>
	<form action="user.php" method="post">
		<input type="hidden" name="action" value="notify_handle" />
		<input type="hidden" name="auth" value="<?=$LoggedUser['AuthKey']?>" />
		<table>
<?	if($i>$NumFilters){ ?>
			<tr>
				<td class="label"><strong>Label</strong></td>
				<td>
					<input type="text" name="label" style="width: 100%" />
					<p class="min_padding">A label for the filter set, to tell different filters apart.</p>
				</td>
			</tr>
			<tr>
				<td colspan="2" class="center">
					<strong>All fields below here are optional</strong>
				</td>
			</tr>
<?	} else { ?>
			<input type="hidden" name="id" value="<?=$N['ID']?>" />
<?	} ?>

			<tr>
				<td class="label"><strong>At least one of these tags</strong></td>
				<td>
					<textarea name="tags" style="width:100%" rows="2"><?=display_str($N['Tags'])?></textarea>
					<p class="min_padding">Space-separated list - eg. <em>hardcore big.tits anal</em></p>
				</td>
			</tr>
			<tr>
				<td class="label"><strong>None of these tags</strong></td>
				<td>
					<textarea name="nottags" style="width:100%" rows="2"><?=display_str($N['NotTags'])?></textarea>
					<p class="min_padding">Space-separated list - eg. <em>hardcore big.tits anal</em></p>
				</td>
			</tr>
			<tr>
				<td class="label"><strong>Only these categories</strong></td>
				<td>
<?	foreach($NewCategories as $Category){ ?>
					<input type="checkbox" name="categories[]" id="<?=$Category['name']?>_<?=$N['ID']?>" value="<?=$Category['name']?>"<? if(in_array($Category['name'], $N['Categories'])) { echo ' checked="checked"';} ?> />
					<label for="<?=$Category['name']?>_<?=$N['ID']?>"><?=$Category['name']?></label>
<?	} ?>
				</td>
			</tr>
			<tr>
				<td colspan="2" class="center">
					<input type="submit" value="<?=($i>$NumFilters)?'Create filter':'Update filter'?>" />
				</td>
			</tr>
		</table>
	</form>
	<br /><br />
<? } ?>
</div>
<?
show_footer();
?>

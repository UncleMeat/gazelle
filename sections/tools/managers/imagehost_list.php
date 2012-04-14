<?
if(!check_perms('admin_dnu')) { error(403); }

show_header('Manage imagehost whitelist');
$DB->query("SELECT 
	w.ID,
	w.Imagehost, 
	w.Comment, 
	w.UserID, 
	um.Username, 
	w.Time 
	FROM imagehost_whitelist as w
	LEFT JOIN users_main AS um ON um.ID=w.UserID
	ORDER BY w.Time DESC");
?>
<h2>Imagehost Whitelist</h2>
<div>
<table>
	<tr class="colhead">
		<td>Imagehost</td>
		<td>Comment</td>
		<td>Added</td>
		<td width="120">Submit</td>
	</tr>
<? while(list($ID, $Host, $Comment, $UserID, $Username, $WLTime) = $DB->next_record()){ ?>
	<tr>
		<form action="tools.php" method="post">
			<td>
				<input type="hidden" name="action" value="iw_alter" />
				<input type="hidden" name="auth" value="<?=$LoggedUser['AuthKey']?>" />
				<input type="hidden" name="id" value="<?=$ID?>" />
				<input class="long" type="text" name="host" value="<?=display_str($Host)?>" />
			</td>
			<td>
				<input class="long"  type="text" name="comment" value="<?=display_str($Comment)?>" />
			</td>
			<td>
				<?=format_username($UserID, $Username)?><br />
				<?=time_diff($WLTime, 1)?></td>
			<td>
				<input type="submit" name="submit" value="Edit" />
				<input type="submit" name="submit" value="Delete" />
			</td>
		</form>
	</tr>
<? } ?>
<tr>
	<td colspan="4" class="colhead">Add Imagehost</td>
</tr>
<tr class="rowa">
	<form action="tools.php" method="post">
		<input type="hidden" name="action" value="iw_alter" />
		<input type="hidden" name="auth" value="<?=$LoggedUser['AuthKey']?>" />
		<td>
			<input class="long"  type="text" name="host" />
		</td>
		<td colspan="2">
			<input class="long"  type="text" name="comment" />
		</td>
		<td>
			<input type="submit" value="Create" />
		</td>
	</form>
</tr>
</table> </div>
<? show_footer(); ?>

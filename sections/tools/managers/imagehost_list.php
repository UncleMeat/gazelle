<?
if(!check_perms('admin_imagehosts')) { error(403); }

show_header('Manage imagehost whitelist');
$DB->query("SELECT 
	w.ID,
	w.Imagehost, 
	w.Link, 
	w.Comment, 
	w.UserID, 
	um.Username, 
	w.Time 
	FROM imagehost_whitelist as w
	LEFT JOIN users_main AS um ON um.ID=w.UserID
	ORDER BY w.Time DESC");
?>
<div class="thin">
<h2>Imagehost Whitelist</h2>
<table>
    <tr>
        <td colspan="5" class="colhead">Add Imagehost</td>
    </tr>
    <tr class="colhead">
		<td width="25%">Imagehost</td>
		<td width="20%">Link</td>
		<td width="30%">Comment</td>
		<td width="10%">Added</td>
		<td width="15%">Submit</td>
    </tr>
	<tr class="rowb">
		<td>this field is matched against image urls. displayed on the upload page.</td>
		<td>optional, if a valid url is present then it appears as an icon that can be clicked to take you to the link in a new page.</td>
		<td colspan="2">displayed to users on the upload page.</td>
		<td></td> 
	</tr>
<tr class="rowa">
	<form action="tools.php" method="post">
		<input type="hidden" name="action" value="iw_alter" />
		<input type="hidden" name="auth" value="<?=$LoggedUser['AuthKey']?>" />
		<td>
			<input class="long"  type="text" name="host" />
		</td>
			<td>
				<input class="long"  type="text" name="link" />
			</td>
		<td colspan="2">
			<input class="long"  type="text" name="comment" />
		</td>
		<td>
			<input type="submit" value="Create" />
		</td>
	</form>
</tr>
</table>
<br/>
<table>
    <tr class="colhead">
		<td width="25%">Imagehost</td>
		<td width="20%">Link</td>
		<td width="30%">Comment</td>
		<td width="10%">Added</td>
		<td width="15%">Submit</td>
    </tr>
<? $Row = 'b';
while(list($ID, $Host, $Link, $Comment, $UserID, $Username, $WLTime) = $DB->next_record()){  
	$Row = ($Row === 'a' ? 'b' : 'a');
?>
    <tr class="row<?=$Row?>">
		<form action="tools.php" method="post">
			<td>
				<input type="hidden" name="action" value="iw_alter" />
				<input type="hidden" name="auth" value="<?=$LoggedUser['AuthKey']?>" />
				<input type="hidden" name="id" value="<?=$ID?>" />
				<input class="long" type="text" name="host" value="<?=display_str($Host)?>" />
			</td>
			<td>
				<input class="long"  type="text" name="link" value="<?=display_str($Link)?>" />
			</td>
			<td>
				<input class="long"  type="text" name="comment" value="<?=display_str($Comment)?>" />
			</td>
			<td>
				<?=format_username($UserID, $Username)?><br />
				<?=time_diff($WLTime, 1)?>
                  </td>
			<td>
				<input type="submit" name="submit" value="Edit" />
				<input type="submit" name="submit" value="Delete" />
			</td>
		</form>
	</tr>
<? } ?>
</table> 
</div>
<? show_footer(); ?>

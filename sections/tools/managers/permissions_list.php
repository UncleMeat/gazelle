<?
show_header('Manage Permissions');
?>
<script type="text/javascript" language="javascript">
//<![CDATA[
function confirmDelete(id) {
	if (confirm("Are you sure you want to remove this permission class?")) {
		location.href="tools.php?action=permissions&removeid="+id;
	}
	return false;
}
//]]>
</script>
<div class="thin">
      <h2>User Classes</h2>
	<div class="linkbox">
		[<a href="tools.php?action=permissions&amp;id=new">Create a new User Class<!--permission set--></a>]
		[<a href="tools.php">Back to Tools</a>]
	</div>
<?
//$DB->query("SELECT p.ID,p.Name,p.Level,COUNT(u.ID) FROM permissions AS p LEFT JOIN users_main AS u ON u.PermissionID=p.ID GROUP BY p.ID ORDER BY p.Level ASC");
$DB->query("SELECT p.ID,p.Name,p.Level,p.DisplayStaff,p.MaxSigLength,p.MaxAvatarWidth,
                   p.MaxAvatarHeight,COUNT(u.ID) 
                   FROM permissions AS p LEFT JOIN users_main AS u ON u.PermissionID=p.ID 
                   GROUP BY p.ID 
                   ORDER BY p.Level ASC");
if($DB->record_count()) {
?>
	<table width="100%">
		<tr class="colhead">
			<td width="18%">Name</td>
			<td width="10%">Level</td>
			<td width="14%">Max Sig Length</td>
			<td width="14%">Max Avatar Size</td>
			<td width="14%">Display as Staff</td>
			<td width="10%">User Count</td>
			<td width="20%" class="center">Actions</td>
		</tr>
<?	while(list($ID,$Name,$Level,$DisplayStaff,$MaxSigLength,$MaxAvatarWidth,$MaxAvatarHeight,$UserCount)=$DB->next_record()) { ?>
		<tr>
			<td><?=display_str($Name); ?></td>
			<td><?=$Level; ?></td>
			<td><?=$MaxSigLength; ?></td>
			<td><?=($MaxAvatarWidth.' x '.$MaxAvatarHeight); ?></td>
			<td><?=$DisplayStaff=='1'?'<strong>True</strong>':'False'; ?></td>
			<td><?=number_format($UserCount); ?></td>
			<td class="center">[<a href="tools.php?action=permissions&amp;id=<?=$ID ?>">Edit</a> | <a href="#" onclick="return confirmDelete(<?=$ID?>)">Remove</a>]</td>
		</tr>
<?	} ?>
	</table>
<? } else { ?>
	<h2 align="center">There are no permission classes.</h2>
<? } ?>
</div>
<?
show_footer();
?>

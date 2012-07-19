<?
/*  // mifune: I think its okay to remove this as every link has its own perm check just to be visible.
if (!check_perms('users_mod')) {
	error(403);
}
 */
show_header('Staff Tools');
?>
<div class="permissions">
	<div class="permission_container">
		<table>
			<tr><td class="colhead">Managers</td></tr>
<?   if (check_perms('users_groups')) { ?>
			<tr><td><a href="groups.php">User Groups</a></td></tr>
                  
<? } if (check_perms('admin_manage_categories')) { ?>
			<tr><td><a href="tools.php?action=categories">Categories</a></td></tr>                    
<? } if (check_perms('admin_manage_permissions')) { ?>
			<tr><td><a href="tools.php?action=permissions">User Classes<!--Permissions--></a></td></tr>
<? } if (check_perms('admin_whitelist')) { ?>
			<tr><td><a href="tools.php?action=whitelist">Client Whitelist</a></td></tr>
<? } if (check_perms('admin_manage_ipbans')) { ?>
			<tr><td><a href="tools.php?action=ip_ban">IP Bans</a></td></tr>

<? } if (check_perms('users_view_ips')) { ?>
			<tr><td><a href="tools.php?action=login_watch">Login Watch</a></td></tr>
<? } if (check_perms('admin_manage_forums')) { ?>
			<tr><td><a href="tools.php?action=forum">Forums</a></td></tr>
<? } if (check_perms('admin_manage_news')) { ?>
			<tr><td><a href="tools.php?action=news">News</a></td></tr>
<? } if (check_perms('admin_manage_articles')) { ?>
			<tr><td><a href="tools.php?action=articles">Articles</a></td></tr>                        
<? } if (check_perms('admin_dnu')) { ?> 
			<tr><td><a href="tools.php?action=dnu">Do not upload list</a></td></tr>
<? } if (check_perms('admin_imagehosts')) { ?>
			<tr><td><a href="tools.php?action=imghost_whitelist">Imagehost Whitelist</a></td></tr>
<? } if (check_perms('users_mod')) { ?>
			<tr><td><a href="tools.php?action=email_blacklist">Email Blacklist</a></td></tr>
			<tr><td><a href="tools.php?action=tokens">Manage freeleech tokens</a></td></tr>
<? } if (check_perms('site_manage_tags')) { ?>
			<tr><td><a href="tools.php?action=official_tags">Official Tags Manager</a></td></tr> 
<? } if (check_perms('torrents_review')) { ?>
			<tr><td><a href="tools.php?action=marked_for_deletion">Marked for Deletion</a></td></tr>

<? } if (check_perms('site_manage_shop')) { ?>
			<tr><td><a href="tools.php?action=shop_list">Bonus Shop</a></td></tr>
<? } if (check_perms('site_manage_badges')) { ?>
			<tr><td><a href="tools.php?action=badges_list">Badges</a></td></tr>
<? } if (check_perms('site_manage_awards')) { ?>
			<tr><td><a href="tools.php?action=awards_auto">Automatic Awards</a></td></tr>
                  
<? } ?>

		</table>
	</div>
	<div class="permission_container">
		<table>
			<tr><td class="colhead">Data</td></tr>

<?
if (check_perms('admin_donor_log')) { ?>
			<tr><td><a href="tools.php?action=donation_log">Donation Log</a></td></tr>
			<tr><td><a href="tools.php?action=bitcoin_balance">Bitcoin donation balance</a></td></tr>
<? } if (check_perms('users_view_ips') && check_perms('users_view_email')) { ?>
			<tr><td><a href="tools.php?action=registration_log">Registration Log</a></td></tr>
<? } if (check_perms('users_view_invites')) { ?>
			<tr><td><a href="tools.php?action=invite_pool">Invite Pool</a></td></tr>
<? } if (check_perms('site_view_flow')) { ?>
			<tr><td><a href="tools.php?action=upscale_pool">Upscale Pool</a></td></tr>
			<tr><td><a href="tools.php?action=user_flow">User Flow</a></td></tr>
			<tr><td><a href="tools.php?action=torrent_stats">Torrent Stats</a></td></tr>
			<tr><td><a href="tools.php?action=economic_stats">Economic Stats</a></td></tr>
<? } if (check_perms('site_debug')) { ?>
			<tr><td><a href="tools.php?action=opcode_stats">Opcode Stats</a></td></tr>
			<tr><td><a href="tools.php?action=service_stats">Service Stats</a></td></tr>
<? } if (check_perms('admin_manage_permissions')) { ?>
			<tr><td><a href="tools.php?action=special_users">Special Users</a></td></tr>

<? } ?>
		</table>
	</div>
	<div class="permission_container">
		<table>
			<tr><td class="colhead">Misc</td></tr>

<? if (check_perms('users_mod')) { ?>
			<tr><td><a href="tools.php?action=manipulate_tree">Manipulate Tree</a></td></tr>
<? } 
if (check_perms('admin_update_geoip')) { ?>
			<tr><td><a href="tools.php?action=update_geoip">Update GeoIP </a></td></tr>
<? } if (check_perms('admin_create_users')) { ?>
			<tr><td><a href="tools.php?action=create_user">Create User</a></td></tr>
<? } if (check_perms('admin_clear_cache')) { ?>
			<tr><td><a href="tools.php?action=clear_cache">Clear/view a cache key</a></td></tr>
<? } if (check_perms('users_view_ips')) { ?>
			<tr><td><a href="tools.php?action=dupe_ips">Duplicate IPs</a></td></tr>

<? } if (check_perms('site_debug')) { ?>
			<tr><td><a href="tools.php?action=sandbox1">Sandbox (1)</a></td></tr>
			<tr><td><a href="tools.php?action=sandbox2">Sandbox (2)</a></td></tr>
			<tr><td><a href="tools.php?action=sandbox3">Sandbox (3)</a></td></tr>
			<tr><td><a href="tools.php?action=sandbox4">Sandbox (4)</a></td></tr>
			<tr><td><a href="tools.php?action=sandbox5">Sandbox (5)</a></td></tr>
			<tr><td><a href="tools.php?action=sandbox6">Sandbox (6)</a></td></tr>
			<tr><td><a href="tools.php?action=sandbox7">Sandbox (7)</a></td></tr>
			<tr><td><a href="tools.php?action=sandbox8">Sandbox (8)</a></td></tr>
			<tr><td><a href="tools.php?action=nightoath">NightOath's Sandbox</a></td></tr>
			<tr><td><a href="schedule.php?auth=<?=$LoggedUser['AuthKey']?>">Schedule</a></td></tr>
			<tr><td><a href="tools.php?action=branches">Git branches</a></td></tr>
<? }?>	
			<tr><td><strong><a href="tools.php?action=public_sandbox">Public Sandbox</a></strong></td></tr>
<? if (check_perms('users_mod')) { ?>
			<tr><td><strong><a href="tools.php?action=mod_sandbox">Mod level Sandbox</a></strong></td></tr>
<? } ?>
		</table>
	</div>
</div>
<? show_footer(); ?>

<?php
if (!check_perms('site_admin_forums')) {
    error(403);
}

if (empty($_GET['id']) || !is_number($_GET['id'])) {
    die();
}

$ID = $_GET['id'];

if (!isset($_GET['depth']) || !is_number($_GET['depth'])) {
    die();
}

$Depth = $_GET['depth'];

include(SERVER_ROOT.'/classes/class_text.php');
$Text = new TEXT;

$DB->query("SELECT ce.EditUser, um.Username, ce.EditTime, ce.Body
        FROM comments_edits AS ce
            JOIN users_main AS um ON um.ID=ce.EditUser
        WHERE Page = 'staffpm' AND PostID = $ID
        ORDER BY ce.EditTime DESC");
    $Edits = $DB->to_array();
list($UserID, $Username, $Time) = $Edits[$Depth];
if ($Depth != 0) {
    list(,,,$Body) = $Edits[$Depth - 1];
} else {
    //Not an edit, have to get from the original
    $DB->query("SELECT Message FROM staff_pm_messages WHERE ID=$ID");
    list($Body) = $DB->next_record();
}
?>

	<div class="body"><?=$Text->full_format($Body, get_permissions_advtags($UserID))?></div>
<?php if ($Depth < count($Edits)) { ?>
                    <a href="#edit_info_<?=$ID?>" onclick="LoadEdit(<?=$ID?>, <?=($Depth + 1)?>); return false;">&laquo;</a>
                    <span class="editedby"><?=(($Depth == 0) ? 'Last edited by' : 'Edited by')?>
                    <?=format_username($UserID, $Username) ?> <?=time_diff($Time,2,true,true)?>
                              </span>
<?php } else { ?>
                    <em>Original Post</em>
<?php }

if ($Depth > 0) { ?>
                              <span class="editedby">
                                  <a href="#edit_info_<?=$ID?>" onclick="LoadEdit(<?=$ID?>, <?=($Depth - 1)?>); return false;">&raquo;</a>
                              </span>
<?php } ?>

                        </div>

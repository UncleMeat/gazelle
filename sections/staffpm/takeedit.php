<?php
authorize();

/*********************************************************************\
//--------------Take Message--------------------------------------------//

The page that handles the backend of the 'edit post' function.

$_GET['action'] must be "takeedit" for this page to work.

It will be accompanied with:
    $_POST['id'] - the ID of the post
    $_POST['message']

\*********************************************************************/

include(SERVER_ROOT.'/classes/class_text.php'); // Text formatting class

$Text = new TEXT;

// Quick SQL injection check
if (!$_POST['id'] || !is_number($_POST['id'])) {
    error(0,true);
}
// End injection check

// Variables for database input
$UserID = $LoggedUser['ID'];
$Message = $_POST['message'];
$ID = $_POST['id'];
$Key = $_POST['key'];

// Mainly
$DB->query("SELECT Message FROM staff_pm_messages WHERE ID=$ID");
list($OldMessage) = $DB->next_record();

// Make sure they aren't trying to edit posts they shouldn't
// We use die() here instead of error() because whatever we spit out is displayed to the user in the box where his forum post is
if (!IsStaff) {
    error('Only Staff may use this function',true);
}

if ($DB->record_count()==0) {
    error(404,true);
}

$preview = $Text->full_format($_POST['message'], true);
if ($Text->has_errors()) {
    $bbErrors = implode('<br/>', $Text->get_errors());
    $preview = ("<strong>NOTE: Changes were not saved.</strong><br/><br/>There are errors in your bbcode (unclosed tags)<br/><br/>$bbErrors<br/><div class=\"box\"><div class=\"post_content\">$preview</div></div>");
}

if (!$bbErrors) {
    // Perform the update
    $DB->query("UPDATE staff_pm_messages SET
          EditedUserID = '$UserID',
          EditedTime = '".sqltime()."',
          Message = '".db_string($Message)."'
          WHERE ID='$ID'");
    $DB->query("INSERT INTO comments_edits (Page, PostID, EditUser, EditTime, Body)
                                                    VALUES ('staffpm', ".$ID.", ".$UserID.", '".sqltime()."', '".db_string($OldMessage)."')");
}

?>
<div class='body'>
    <?=$preview; ?>
</div>
<div class="post_footer">
    <a href="#message<?=$ID?>" onclick="LoadEdit(<?=$ID?>, 1); return false;">&laquo;</a>
    <span class="editedby">Last edited by <?=format_username($LoggedUser, $LoggedUser['Username']) ?> Just Now
    </span>
</div>



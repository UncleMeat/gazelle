<?
enforce_login();
if(!check_perms('admin_manage_articles')){ error(403); }

include(SERVER_ROOT.'/classes/class_text.php');
$Text = new TEXT;

switch($_REQUEST['action']) {
	case 'takeeditarticle':
		if(!check_perms('admin_manage_articles')){ error(403); }
		if(is_number($_POST['articleid'])){
			authorize();

                        $DB->query("SELECT Count(*) as c FROM articles WHERE TopicID='".db_string($_POST['topicid'])."' AND ID<>'".db_string($_POST['articleid'])."'");
                        list($Count) = $DB->next_record();
                        if ($Count > 0) {
                            error('The topic ID must be unique for the article');
                        }
                        
                        list($TopicID) = $DB->next_record();
			$DB->query("UPDATE articles SET Category='".$_POST['category']."', TopicID='".db_string(strtolower($_POST['topicid']))."', Title='".db_string($_POST['title'])."', Description='".db_string($_POST['description'])."', Body='".db_string($_POST['body'])."', Time='".sqltime()."' WHERE ID='".db_string($_POST['articleid'])."'");

		}
		header('Location: tools.php?action=articles');
		break;
	case 'editarticle':
            $ArticleID = db_string($_REQUEST['id']);

                    $DB->query("SELECT ID, Category, TopicID, Title, Description, Body FROM articles WHERE ID='$ArticleID'");
                    list($ArticleID, $Category, $TopicID, $Title, $Description, $Body) = $DB->next_record();
                break;
}

show_header('Manage articles','bbcode');

?>
<div class="thin">
    <h2><?= ($_GET['action'] == 'articles')? 'Create a new article' : 'Edit an article';?></h2> 
    <div id="quickreplypreview">
        <div id="contentpreview" style="text-align:left;"></div>
    </div>
    <form  id="quickpostform" action="tools.php" method="post">
        <div class="box pad">
            <div id="quickreplytext">
			<input type="hidden" name="action" value="<?= ($_GET['action'] == 'articles')? 'takearticle' : 'takeeditarticle';?>" />
			<input type="hidden" name="auth" value="<?=$LoggedUser['AuthKey']?>" />
<? if($_GET['action'] == 'editarticle'){?> 
			<input type="hidden" name="articleid" value="<?=$ArticleID; ?>" />
<? }?> 
                        <h3>Category</h3>
                        <select name="category">
<? foreach($ArticleCats as $Key => $Value) { ?> 
                            <option value="<?=display_str($Key)?>"<?=($Category == $Key) ? 'selected="selected"' : '';?>><?=$Value?></option>
<? } ?>
                        </select>                     
                        <h3>Topic ID</h3>
			<input type="text" name="topicid" <? if(!empty($TopicID)) { echo 'value="'.display_str($TopicID).'"'; } ?> />
			<h3>Title</h3>
			<input type="text" name="title" size="95" <? if(!empty($Title)) { echo 'value="'.display_str($Title).'"'; } ?> />
                        <h3>Description</h3>
			<input type="text" name="description" size="100" <? if(!empty($Description)) { echo 'value="'.display_str($Description).'"'; } ?> />
			<br />
			<h3>Body</h3>
                  <? $Text->display_bbcode_assistant('textbody', true) ?>
                  <textarea id="textbody" name="body" class="long" rows="15"><? if(!empty($Body)) { echo display_str($Body); } ?></textarea> 
            </div>
            <br />
           <div class="center">
			<input id="post_preview" type="button" value="Preview" onclick="if(this.preview){Quick_Edit_Blog();}else{Quick_Preview_Blog();}" />
                  <input type="submit" value="<?= ($_GET['action'] == 'articles')? 'Create new article' : 'Edit article';?>" />
            </div> 
        </div>
    </form>
<br /><br />
	<h2>Other articles</h2>
        
<?
$OldCategory = -1;
$DB->query("SELECT ID, Category, TopicID, Title, Body, Time FROM articles ORDER BY Category ASC, TopicID ASC");// LIMIT 20
while(list($ArticleID,$Category,$TopicID, $Title,$Body,$ArticleTime)=$DB->next_record()) {
?>
<? if($OldCategory != $Category) { ?>
            <h3 id="general"><?= $ArticleCats[$Category] ?></h3>
<?
    $OldCategory = $Category;
}?>
	<div class="box vertical_space">
		<div class="head">
			<strong><?=$TopicID?> - <?=display_str($Title) ?></strong> - posted <?=time_diff($ArticleTime) ?>
			- <a href="tools.php?action=editarticle&amp;id=<?=$ArticleID?>">[Edit]</a> 
			<a href="tools.php?action=deletearticle&amp;id=<?=$ArticleID?>&amp;auth=<?=$LoggedUser['AuthKey']?>">[Delete]</a>
		</div>
		
		<div class="pad"><?=$Text->full_format($Body, true) ?></div>
	</div>
<? } ?>
</div>
<? show_footer();?>
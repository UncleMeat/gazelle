<?
enforce_login();

include(SERVER_ROOT.'/sections/articles/functions.php');
include(SERVER_ROOT.'/classes/class_text.php');
$Text = new TEXT;

if (isset($_REQUEST['topic'])) {
    $TopicID = db_string($_REQUEST['topic']);
} else {
    error(404);
}

if (empty($Page)) {
    $DB->query("SELECT Category, Title, Body, Time FROM articles WHERE TopicID='$TopicID'");
    if (!list($Category, $Title, $Body, $Time) = $DB->next_record()) {
        error(404);
    }
}

$Body = $Text->full_format($Body, true); // true so regardless of author permissions articles can use adv tags

$Body = replace_special_tags($Body);

//$Page['Topic']
show_header( (empty($LoggedUser['ShortTitles'])?"{$ArticleCats[$Category]} > $Title":$Title ), 'browse,overlib,bbcode');
?>

<div class="thin">
    <div class="head"><?= $Title ?></div>
    <div class="box pad" style="padding:10px 10px 10px 20px;">
        <?=$Body?>
    </div>

<?
    $Row = 'a';
    $LastSubCat=-1;
    $OpenTable=false;
    $DB->query("SELECT TopicID, Title, Description, SubCat 
                  FROM articles 
                 WHERE Category='$Category' AND TopicID<>'$TopicID' 
              ORDER BY SubCat, Title");
    while(list($TopicID, $Title, $Description, $SubCat) = $DB->next_record()) {
        $Row = ($Row == 'a') ? 'b' : 'a';

        if($LastSubCat != $SubCat) {
		$Row = 'b';
            $LastSubCat = $SubCat;
            if($OpenTable){  ?>
        </table><br/>
<?           }  ?>
    <div class="head"><?=($SubCat==1?"Other $ArticleCats[$Category] articles":$ArticleSubCats[$SubCat])?></div>
    <table width="100%" class="topic_list">
            <tr class="colhead">
                    <td style="width:300px;">Title</td>
                    <td>Additional Info</td>
            </tr>
<? 
            $OpenTable=true;
        }
?>
            <tr class="row<?=$Row?>">

                    <td class="nobr topic_link">
                            <a href="articles.php?topic=<?=$TopicID?>"><?=display_str($Title)?></a>
                    </td>
                    <td class="nobr">
                            <?=display_str($Description)?>
                    </td>
            </tr>
<?  } ?>
    </table>
</div>


<?
show_footer();

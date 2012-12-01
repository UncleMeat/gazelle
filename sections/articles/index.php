<?
enforce_login();

include(SERVER_ROOT.'/sections/articles/functions.php');
include(SERVER_ROOT.'/classes/class_text.php');
$Text = new TEXT;

if (isset($_REQUEST['topic'])) {
    $CurrentTopicID = db_string($_REQUEST['topic']);
} else {
    error(404);
}

$StaffClass = 0;
if ($LoggedUser['Class']>=STAFF_LEVEL){ // only interested in staff classes
    $StaffClass = $LoggedUser['Class'];
} elseif ($LoggedUser['SupportFor']) {
    $StaffClass = STAFF_LEVEL;
}
//if (empty($Page)) {
//}
$DB->query("SELECT Category, Title, Body, Time, MinClass FROM articles WHERE TopicID='$CurrentTopicID'");
if (!list($Category, $Title, $Body, $Time, $MinClass) = $DB->next_record()) {
        error(404);
}
if($MinClass>0){ // check permissions
    // should there be a way for FLS to see these... perm setting maybe?
    if ( $StaffClass < $MinClass ) error(403);
}

$Body = $Text->full_format($Body, true); // true so regardless of author permissions articles can use adv tags

$Body = replace_special_tags($Body);

//$Page['Topic']
show_header( (empty($LoggedUser['ShortTitles'])?"{$ArticleCats[$Category]} > $Title":$Title ), 'browse,overlib,bbcode');
?>

<div class="thin">
    <h2><?=$ArticleCats[$Category]?> Articles</h2>
    <div class="head"><?= $Title ?></div>
    <div class="box pad" style="padding:10px 10px 10px 20px;">
        <?=$Body?>
    </div>

<?
    $Row = 'a';
    $LastSubCat=-1;
    $OpenTable=false;
    /*
    $DB->query("SELECT TopicID, Title, Description, SubCat 
                  FROM articles 
                 WHERE Category='$Category' AND TopicID<>'$TopicID'    AND MinClass<='$StaffClass'
              ORDER BY SubCat, Title"); */
    $Articles = $Cache->get_value("articles_$Category");
    if($Articles===false){
        $DB->query("SELECT TopicID, Title, Description, SubCat, MinClass
                  FROM articles 
                 WHERE Category='$Category' 
              ORDER BY SubCat, Title");
        $Articles = $DB->to_array();
        $Cache->cache_value("articles_$Category", $Articles);
    }
    //while(list($TopicID, $Title, $Description, $SubCat) = $DB->next_record()) {
    foreach($Articles as $Article) {
        list($TopicID, $Title, $Description, $SubCat, $MinClass) = $Article;
        
        if($CurrentTopicID==$TopicID) continue;
        if($MinClass>$StaffClass) continue;
        
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

                    <td class="topic_link">
                            <a href="articles.php?topic=<?=$TopicID?>"><?=display_str($Title)?></a>
                    </td>
                    <td>
                            <?=display_str($Description)?>
<?                  if($MinClass) { ?>
                        <span style="float:right">
                            <?="[{$ClassLevels[$MinClass][Name]}+]"?>
                        </span>
<?                  } ?>
                    </td>
            </tr>
<?  } ?>
    </table>
</div>


<?
show_footer();

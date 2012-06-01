<?
if (!check_perms('site_manage_tags')) {
    error(403);
}

show_header('Official Tags Manager');
?>
<div class="thin">
    <h2>Official Tags</h2>
    <?
    if (isset($_GET['rst']) && is_number($_GET['rst'])) {
        $Result = (int) $_GET['rst'];
        $ResultMessage = display_str($_GET['msg']);
        if ($Result !== 1)
            $AlertClass = ' alert';

        if ($ResultMessage) {
            ?>
            <div class="messagebar<?= $AlertClass ?>"><?= $ResultMessage ?></div>
    <?
    }
}
?>
    <div class="tagtable center">
        <div class=" box pad">
            <form method="post">
                <input type="hidden" name="action" value="official_tags_alter" />
                <input type="hidden" name="auth" value="<?= $LoggedUser['AuthKey'] ?>" />
                <input type="hidden" name="doit" value="1" />
                <table class="tagtable">
                    <tr class="colhead_dark">
                        <td style="font-weight: bold" style="text-align: center">Remove</td>
                        <td style="font-weight: bold">Tag</td>
                        <td style="font-weight: bold">Uses</td>
                        <td>&nbsp;&nbsp;&nbsp;</td>
                        <td style="font-weight: bold" style="text-align: center">Remove</td>
                        <td style="font-weight: bold">Tag</td>
                        <td style="font-weight: bold">Uses</td>
                        <td>&nbsp;&nbsp;&nbsp;</td>
                        <td style="font-weight: bold" style="text-align: center">Remove</td>
                        <td style="font-weight: bold">Tag</td>
                        <td style="font-weight: bold">Uses</td>
                    </tr>
                    <?
                    $i = 0;
                    $DB->query("SELECT ID, Name, Uses FROM tags WHERE TagType='genre' ORDER BY Name ASC");
                    $TagCount = $DB->record_count();
                    $Tags = $DB->to_array();
                    for ($i = 0; $i < $TagCount / 3; $i++) {
                        list($TagID1, $TagName1, $TagUses1) = $Tags[$i];
                        list($TagID2, $TagName2, $TagUses2) = $Tags[ceil($TagCount / 3) + $i];
                        list($TagID3, $TagName3, $TagUses3) = $Tags[2 * ceil($TagCount / 3) + $i];
                        ?>
                        <tr class="<?= (($i % 2) ? 'rowa' : 'rowb') ?>">
                            <td><input type="checkbox" name="oldtags[]" value="<?= $TagID1 ?>" /></td>
                            <td><a href="torrents.php?taglist=<?= $TagName1 ?>" ><?= $TagName1 ?></a></td>
                            <td><?= $TagUses1 ?></td>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td>
    <? if ($TagID2) { ?>
                                    <input type="checkbox" name="oldtags[]" value="<?= $TagID2 ?>" />
                                <? } ?>
                            </td>
                            <td><a href="torrents.php?taglist=<?= $TagName2 ?>" ><?= $TagName2 ?></a></td>
                            <td><?= $TagUses2 ?></td>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td>
    <? if ($TagID3) { ?>
                                    <input type="checkbox" name="oldtags[]" value="<?= $TagID3 ?>" />
                        <? } ?>
                            </td>
                            <td><a href="torrents.php?taglist=<?= $TagName3 ?>" ><?= $TagName3 ?></a></td>
                            <td><?= $TagUses3 ?></td>
                        </tr>
    <?
}
?>		
                    <tr class="<?= (($i % 2) ? 'rowa' : 'rowb') ?>">
                        <td colspan="11"><label for="newtag">New official tag: </label><input type="text" name="newtag" /></td>
                    </tr>
                    <tr style="border-top: thin solid #98AAB1">
                        <td colspan="11" style="text-align: center"><input type="submit" value="Submit Changes" /></td>
                    </tr>

                </table>
            </form>
        </div>
    </div>
    <br />
    <h2>Tag Synomyns</h2>

    <div class="tagtable">
        <div class="box pad center">
            <form  class="tagtable" action="tools.php" method="post">

                <input type="hidden" name="action" value="official_tags_alter" />
                <input type="hidden" name="auth" value="<?= $LoggedUser['AuthKey'] ?>" />


                <input type="text" name="newsynname"style="width:200px" />&nbsp;&nbsp;
                <input type="submit" name="addsynomyn" value="Add new synomyn for " title="add new synomyn" />&nbsp;&nbsp;

                <select name="parenttagid" >
<? foreach ($Tags as $Tag) {
    list($TagID, $TagName) = $Tag; ?>
                        <option value="<?= $TagID ?>"><?= $TagName ?>&nbsp;&nbsp;&nbsp;&nbsp;</option>
        <? } ?>
                </select>

            </form>
        </div>
        <?
        $Synomyns = $Cache->get_value('all_synomyns');
        if (!$Synomyns) {
            $DB->query("SELECT ts.ID, Synomyn, TagID, t.Name, Uses
                    FROM tag_synomyns AS ts LEFT JOIN tags AS t ON ts.TagID=t.ID 
                    ORDER BY Name ASC");
            $Synomyns = $DB->to_array(false, MYSQLI_BOTH);
            $Cache->cache_value('all_synomyns', $Synomyns);
        }
        $LastParentTagName = '';
        $Row = 'a';

        foreach ($Synomyns as $Synomyn) {
            list($SnID, $SnName, $ParentTagID, $ParentTagName, $Uses) = $Synomyn;

            if ($LastParentTagName != $ParentTagName) {
                if ($LastParentTagName != '') {
                    $Row = $Row == 'b' ? 'a' : 'b';
                    ?>
                    <tr class="row<?= $Row ?>">
                        <td class="tag_add" style="text-align:left"  colspan="2">
                            <input type="submit" name="delsynomyns" value="del selected" title="delete selected synomyns for <?= $LastParentTagName ?>" />
                        </td>
                    </tr>
            <? $Row = $Row == 'b' ? 'a' : 'b'; ?>
                    <tr class="row<?= $Row ?>">  
                        <td class="tag_add" colspan="2"> 
                            <input type="text" name="newsynname" size="10" />
                            <input type="submit" name="addsynomyn" value="+" title="add new synomyn for <?= $LastParentTagName ?>" />
                        </td>
                    </tr>
                    </table>
                    </form>
            <? } ?>
                <form  class="tagtable" action="tools.php" method="post">
                    <table  class="tagtable" style="width:200px">
                        <input type="hidden" name="action" value="official_tags_alter" />
                        <input type="hidden" name="auth" value="<?= $LoggedUser['AuthKey'] ?>" />
                        <input type="hidden" name="parenttagid" value="<?= $ParentTagID ?>" />
                        <tr class="colhead" >
                            <td style="width:20px;text-align:right;">&nbsp;</td>
                            <td style="width:160px"><a href="torrents.php?taglist=<?= $ParentTagName ?>" ><?= $ParentTagName ?></a>&nbsp;(<?= $Uses ?>)</td>
                        </tr>
                        <?
                        $LastParentTagName = $ParentTagName;
                    }
                    $Row = $Row == 'b' ? 'a' : 'b';
                    ?>
                    <tr class="row<?= $Row ?>">
                        <td style="width:20px;text-align:right;"><input type="checkbox" name="oldsyns[]" value="<?= $SnID ?>" /></td>
                        <td style="width:160px"><?= $SnName ?></td>
                    </tr>
                    <?
                }

                if ($SnID) { // only finish if something was in list
                    $Row = $Row == 'b' ? 'a' : 'b';
                    ?>
                    <tr class="row<?= $Row ?>">
                        <td class="tag_add" style="text-align:left" colspan="2" >
                            <input type="submit" name="delsynomyns" value="del selected" title="delete selected synomyns for <?= $ParentTagName ?>" />
                        </td>
                    </tr>
    <? $Row = $Row == 'b' ? 'a' : 'b'; ?>
                    <tr class="row<?= $Row ?>">  
                        <td class="tag_add" colspan="2" > 
                            <input type="text" name="newsynname" size="10" />
                            <input type="submit" name="addsynomyn" value="+" title="add new synomyn for <?= $ParentTagName ?>" />

                        </td>
                    </tr>
                </table>
            </form>
<? } ?>

        <br /><br />
        <div class="box pad center">
            <div class="pad" style="text-align:left">This section allows you to add a tag as a synomyn for another tag.
                <br />If the checkbox is unchecked then it will simply add the tag as a synomyn for the parent tag and leave the tag and its current associations with torrents as is in the database. This will prevent it being added as a new tag and searches on it will search on the synomyn as expected, but the original tags already present will show up with the torrents.
                <br /><br />If you check the 'convert' option it will remove the old tag from the database, inserting the tag this is now a synomyn for instead (where it is not already present for that torrent). This might be a preferable state for the database to be in but it is an irreversible operation and you should be certain you want the old tag removed from the torrents it is associated with before proceeding.</div>
            <form  class="tagtable" action="tools.php" method="post">

                <input type="hidden" name="action" value="official_tags_alter" />
                <input type="hidden" name="auth" value="<?= $LoggedUser['AuthKey'] ?>" />
                <input type="checkbox" name="converttag" value="0" <? if (!check_perms('site_convert_tags')) {
                        echo 'disabled=disabled title="You do not have permission to convert tags to synomyns (you can add a tag as a synomyn though)"';
} ?> />  

                <label for="movetag" title="if this is checked then you can select an existing tag to convert into a synomyn for another tag">convert tag to synomyn</label>&nbsp;&nbsp;&nbsp;

                <select name="movetagid">
                    <option value="0" selected="selected">none&nbsp;&nbsp;&nbsp;&nbsp;</option>
                    <?
                    $DB->query("SELECT ID, Name, Uses FROM tags WHERE TagType='other' ORDER BY Name ASC");
                    $AllTags = $DB->to_array();
                    foreach ($AllTags as $Tag) {
                        list($TagID, $TagName, $TagUses) = $Tag;
                        ?>
                        <option value="<?= $TagID ?>"><?= "$TagName ($TagUses)" ?>&nbsp;&nbsp;&nbsp;&nbsp;</option>
                    <? } ?>
                </select>

                <input type="submit" name="tagtosynomyn" value="Add as synomyn for " title="add new synomyn" />&nbsp;&nbsp;

                <select name="parenttagid" >
<?                  foreach ($Tags as $Tag) {
                        list($TagID, $TagName, $TagUses) = $Tag; ?>
                        <option value="<?= $TagID ?>"><?= "$TagName ($TagUses)" ?>&nbsp;&nbsp;&nbsp;&nbsp;</option>
<?                  } ?>
                </select>

            </form>
        </div>

    </div>
</div>
<?
show_footer();
?>



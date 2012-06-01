<?php

enforce_login();
authorize();

if (!check_perms('site_manage_tags')) {
    error(403);
}
include(SERVER_ROOT . '/sections/torrents/functions.php');

$Message = '';
if (isset($_POST['doit'])) {

    if (isset($_POST['oldtags'])) {
        $OldTagIDs = $_POST['oldtags'];
        foreach ($OldTagIDs AS $OldTagID) {
            if (!is_number($OldTagID)) {
                error(403);
            }
        }
        $OldTagIDs = implode(', ', $OldTagIDs);

        $DB->query("UPDATE tags SET TagType = 'other' WHERE ID IN ($OldTagIDs)");

        $Message .= "Removed tags from official list.";
        $Result = 1;
    }

    if ($_POST['newtag']) {
        $Tag = sanitize_tag($_POST['newtag']);
        $TagName = get_tag_synomyn($Tag);

        if ($Tag != $TagName) // this was a synomyn replacement
            $Message .= "$Tag = $TagName. ";

        $DB->query("SELECT t.ID FROM tags AS t WHERE t.Name LIKE '" . $TagName . "'");
        list($TagID) = $DB->next_record();

        if ($TagID) {
            $DB->query("UPDATE tags SET TagType = 'genre' WHERE ID = $TagID");
        } else { // Tag doesn't exist yet - create tag
            $DB->query("INSERT INTO tags (Name, UserID, TagType, Uses) VALUES ('" . $TagName . "', " . $LoggedUser['ID'] . ", 'genre', 0)");
            $TagID = $DB->inserted_id();
            $Message .= "Created $TagName. ";
        }
        $Message .= "Added $TagName to official list.";
        $Result = 1;
    }
    $Cache->delete_value('genre_tags');
}



// ======================================  del synomyn

if (isset($_POST['delsynomyns'])) {

    if (isset($_POST['oldsyns'])) {
        $OldSynomyns = $_POST['oldsyns'];
        $DeleteCache = array();
        foreach ($OldSynomyns AS $OldSynID) {
            if (!is_number($OldSynID)) {
                error(403);
            }
            $DB->query("SELECT Synomyn FROM tag_synomyns WHERE ID = $OldSynID");
            list($SynName) = $DB->next_record();
            if ($SynName)
                $DeleteCache[] = $SynName;
        }
        $OldSynomyns = implode(', ', $OldSynomyns);
        $DB->query("DELETE FROM tag_synomyns WHERE ID IN ($OldSynomyns)");
        $Cache->delete_value('all_synomyns');
        foreach ($DeleteCache AS $Del) {
            $Cache->delete_value('synomyn_for_' . $Del);
        }
        $Message .= "Deleted synomyns: " . implode(', ', $DeleteCache);
        $Result = 1;
    }
}




// ======================================  convert/add tag to/as synomyn

if (isset($_POST['tagtosynomyn'])) {

    $TagID = (int) $_POST['movetagid'];
    $ParentTagID = (int) $_POST['parenttagid'];
    if ($TagID) {
        $DB->query("SELECT Name FROM tags WHERE ID=$TagID");
        list($TagName) = $DB->next_record();
    }
    if ($ParentTagID) {
        $DB->query("SELECT Name FROM tags WHERE ID=$ParentTagID");
        list($ParentTagName) = $DB->next_record();
    }

    if ($TagName && $ParentTagName) {

        // check this synomyn is not already in syn table 
        $DB->query("SELECT ID FROM tag_synomyns WHERE Synomyn LIKE '" . $TagName . "'");
        list($SynID) = $DB->next_record();

        if ($SynID) {
            $Message .= "$TagName already exists as a synomyn for " . get_tag_synomyn($TagName);
            $Result = 0;
        } else {

            $DB->query("INSERT INTO tag_synomyns (Synomyn, TagID, UserID) 
                                                 VALUES ('" . $TagName . "', " . $ParentTagID . ", " . $LoggedUser['ID'] . " )");
            $Cache->delete_value('synomyn_for_' . $TagName); // in case there is a 'not_found' value cached 
            $Cache->delete_value('all_synomyns');
            $Result = 1;
            // if we are just adding a tag as a synomyn and not converting there is nothing more to do

            if (isset($_POST['converttag'])) {
                // convert a synomyn to a tag properly
                if (!check_perms('site_convert_tags')) {
                    $Message .= "(You do not have permission to convert an exisiting tag) Added tag $TagName as synomyn for $ParentTagName";
                } else {
                    // 'convert refrences to the original tag to parenttag and cleanup db 

                    $DB->query("SELECT ts.GroupID, ts.PositiveVotes, ts.NegativeVotes
                                                  FROM torrents_tags AS ts
                                                 WHERE ts.TagID=$TagID  
                                                   AND (SELECT COUNT(*) 
                                                               FROM torrents_tags 
                                                              WHERE torrents_tags.TagID=$ParentTagID
                                                                AND torrents_tags.GroupID=ts.GroupID)=0");
                    $GroupInfos = $DB->to_array(false, MYSQLI_BOTH);
                    //$Message .= " count groupinfos=".count($GroupInfos) . "  ";
                    $NumAffectedTorrents = count($GroupInfos);
                    if ($NumAffectedTorrents > 0) {
                        $SQL = 'INSERT IGNORE INTO torrents_tags 
                                              (TagID, GroupID, PositiveVotes, NegativeVotes, UserID) VALUES';
                        $Div = '';
                        $MsgGroups = "torrents ";
                        foreach ($GroupInfos as $Group) {
                            list($GroupID, $PVotes, $NVotes) = $Group;
                            $SQL .= "$Div ('$ParentTagID', '$GroupID', '$PVotes', '$NVotes', '{$LoggedUser['ID']}')";
                            $MsgGroups .= "$Div$GroupID";
                            $Div = ',';
                            // fix taglist in each torrent as we go
                            $DB->query("SELECT TagList FROM torrents_group WHERE ID=$GroupID");
                            list($TagList) = $DB->next_record();
                            $TagList = trim(str_replace('_', '.', $TagList));
                            $Tags = explode(' ', $TagList);
                            foreach ($Tags as &$Tag) {
                                if ($Tag == $TagName) {
                                    //$Message .= "   [ changed $Tag to $ParentTagName in id=$GroupID ] \n";
                                    $Tag = $ParentTagName;
                                    break;
                                }
                            }
                            unset($Tag);
                            $NewTagList = implode(' ', $Tags);
                            $NewTagList = db_string(trim(str_replace('.', '_', $NewTagList)));
                            $DB->query("UPDATE torrents_group 
                                                           SET TagList='$NewTagList' WHERE ID=$GroupID");
                        }
                        //$MsgGroups .= ") ";
                        //$Message .= "   SQL= [ $SQL ] \n";
                        // update torrents_tags with entries for parentTagID
                        $DB->query($SQL);
                        // update the Uses where parenttag has been added as a replacement for tag
                        $DB->query("UPDATE tags SET Uses=Uses+$NumAffectedTorrents WHERE ID='$ParentTagID'");
                        // remove old entries for tagID
                        $DB->query("DELETE FROM torrents_tags WHERE TagID = '$TagID'");
                        $DB->query("DELETE FROM tags WHERE ID = '$TagID'");
                    }

                    $Message .= "Converted tag $TagName to synomyn for $ParentTagName";
                    // probably we should log this action in some way
                    write_log("Tag $TagName converted to synomyn for tag $ParentTagName, $NumAffectedTorrents tag-torrent links updated $MsgGroups by " . $LoggedUser['Username']);
                }
            } else {
                $Message .= "Added tag $TagName as synomyn for $ParentTagName";
            }
        }
    }
}


// ======================================  add synomyn

if (isset($_POST['addsynomyn'])) {

    $ParentTagID = (int) $_POST['parenttagid'];

    if (isset($_POST['newsynname']) && $ParentTagID) {

        $TagName = sanitize_tag(trim($_POST['newsynname']));
        if ($TagName != '') {
            // check this synomyn is not already in syn table or tag table
            $DB->query("SELECT ID FROM tag_synomyns WHERE Synomyn LIKE '" . $TagName . "'");
            list($SynID) = $DB->next_record();
            if ($SynID) {
                $Message .= "$TagName already exists as a synomyn for " . get_tag_synomyn($TagName);
                $Result = 0;
            } else {
                $DB->query("SELECT ID FROM tags WHERE Name LIKE '" . $TagName . "'");
                list($SynID) = $DB->next_record();
                if ($SynID) {
                    $Message .= "Cannot add $TagName as a synomyn - already exists as a tag.";
                    $Result = 0;
                } else { // Synomyn doesn't exist yet - create
                    $DB->query("INSERT INTO tag_synomyns (Synomyn, TagID, UserID) 
                                                        VALUES ('" . $TagName . "', " . $ParentTagID . ", " . $LoggedUser['ID'] . " )");
                    $Cache->delete_value('synomyn_for_' . $TagName); // in case there is a 'not_found' value cached 
                    $Cache->delete_value('all_synomyns');
                    $Result = 1;
                    $Message .= "$TagName created as a synomyn for " . get_tag_synomyn($TagName);
                }
            }
        }
    }
}


if ($Message != '') {
    header("Location: tools.php?action=official_tags&rst=$Result&msg=" . htmlentities($Message));
} else {
    header('Location: tools.php?action=official_tags');
}
?>

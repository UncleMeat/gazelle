<?
/*********************************************************************\
//--------------Mod thread-------------------------------------------//

This page gets called if we're editing a thread. 

Known issues:
If multiple threads are moved before forum activity occurs then 
threads will linger with the 'Moved' flag until they're knocked off 
the front page.

\*********************************************************************/

// Quick SQL injection check
if(!is_number($_POST['threadid'])) { error(404); }
if($_POST['title'] == ''){ error(0); }
// End injection check
// Make sure they are moderators
if(!check_perms('site_moderate_forums')) { error(403); }
authorize();

// Variables for database input

$TopicID = (int)$_POST['threadid'];
$Sticky = (isset($_POST['sticky'])) ? 1 : 0;
$Locked = (isset($_POST['locked'])) ? 1 : 0;
$Title = db_string($_POST['title']);
$ForumID = (int)$_POST['forumid'];
$Page = (int)$_POST['page'];

if ($Locked == 1) {
	$DB->query("DELETE FROM forums_last_read_topics WHERE TopicID='$TopicID'");
}

$DB->query("SELECT
	t.ForumID,
          t.Title,
	f.MinClassWrite,
	COUNT(p.ID) AS Posts,
          Max(p.ID) AS LastPostID
	FROM forums_topics AS t
	LEFT JOIN forums_posts AS p ON p.TopicID=t.ID
	LEFT JOIN forums AS f ON f.ID=.t.ForumID
	WHERE t.ID='$TopicID'
	GROUP BY p.TopicID");
if ($DB->record_count()==0) error("Error: Could not find thread with id=$TopicID");
list($OldForumID, $OldTitle, $MinClassWrite, $Posts, $OldLastPostID) = $DB->next_record();

if($MinClassWrite > $LoggedUser['Class']) { error(403); }


// If we're moving
$Cache->delete_value('forums_'.$ForumID);
$Cache->delete_value('forums_'.$OldForumID);






function update_forum_info($ForumID, $AdjustNumTopics = 0, $BeginEndTransaction = true) {
    global $DB, $Cache;
    
    if ($BeginEndTransaction) $Cache->begin_transaction('forums_list');
        
    $DB->query("SELECT 
			t.ID,
			t.LastPostID,
			t.Title,
			p.AuthorID,
			um.Username,
			p.AddedTime, 
			(SELECT COUNT(pp.ID) FROM forums_posts AS pp JOIN forums_topics AS tt ON pp.TopicID=tt.ID WHERE tt.ForumID='$ForumID'),
			t.IsLocked,
			t.IsSticky
			FROM forums_topics AS t 
			JOIN forums_posts AS p ON p.ID=t.LastPostID 
			LEFT JOIN users_main AS um ON um.ID=p.AuthorID
			WHERE t.ForumID='$ForumID'
			GROUP BY t.ID
			ORDER BY t.LastPostID DESC LIMIT 1");
    list($NewLastTopic, $NewLastPostID, $NewLastTitle, $NewLastAuthorID, $NewLastAuthorName, $NewLastAddedTime, $NumPosts, $NewLocked, $NewSticky) = $DB->next_record(MYSQLI_BOTH, false);
		
    $UpdateArray = array(
			'NumPosts'=>$NumPosts,
			'LastPostID'=>$NewLastPostID,
			'LastPostAuthorID'=>$NewLastAuthorID,
			'Username'=>$NewLastAuthorName,
			'LastPostTopicID'=>$NewLastTopic,
			'LastPostTime'=>$NewLastAddedTime,
			'Title'=>$NewLastTitle,
			'IsLocked'=>$NewLocked,
			'IsSticky'=>$NewSticky
			);
            
    $AdjustNumTopics=(int)$AdjustNumTopics;
    if ($AdjustNumTopics !=0) {
                $AdjustNumTopics = $AdjustNumTopics>0?"+$AdjustNumTopics":$AdjustNumTopics;
                $AdjustNumTopics = "NumTopics=NumTopics$AdjustNumTopics,";
                $UpdateArray['NumTopics']='-1';
    }
    else $AdjustNumTopics ='';
            
    $SQL = "UPDATE forums SET $AdjustNumTopics
                    NumPosts='$NumPosts',
                    LastPostTopicID='$NewLastTopic',
                    LastPostID='$NewLastPostID',
                    LastPostAuthorID='$NewLastAuthorID',
                    LastPostTime='$NewLastAddedTime'
                    WHERE ID='$ForumID'";
            
    $DB->query($SQL);
		
    $Cache->update_row($ForumID, $UpdateArray);
    if ($BeginEndTransaction) $Cache->commit_transaction(0);
    
    return $NumPosts;
}





// If we're merging a thread
if (isset($_POST['merge'])) {
    if(!check_perms('site_admin_forums')) error(403);
       
    if(!is_number($_POST['mergethreadid'])) error("merge thread id is not a number!");
    $MergeTopicID = (int)$_POST['mergethreadid'];
    if($MergeTopicID == $TopicID) error("Merge failed: merge thread id cannot be the same as source thread!"); 
            
    $DB->query("SELECT
          t.ForumID,
          t.Title,
          f.MinClassWrite,
          Max(p.ID) AS LastPostID
          FROM forums_topics AS t
          LEFT JOIN forums_posts AS p ON p.TopicID=t.ID
          LEFT JOIN forums AS f ON f.ID=.t.ForumID
          WHERE t.ID='$MergeTopicID'
          GROUP BY p.TopicID");
    if ($DB->record_count()==0) error("Merge failed: Could not find thread with id=$MergeTopicID");
    list($NewForumID, $MergeTitle, $NFMinClassWrite, $NFLastPostID) = $DB->next_record();
    
    if($NFMinClassWrite > $LoggedUser['Class']) error(403); 
   
    $MergeTitle = "$MergeTitle (merged with $OldTitle)";
    if($OldLastPostID>$NFLastPostID) $NFLastPostID = $OldLastPostID;
    
    $DB->query("UPDATE forums_polls SET TopicID='$MergeTopicID' WHERE TopicID='$TopicID'");
    $DB->query("UPDATE forums_polls_votes SET TopicID='$MergeTopicID' WHERE TopicID='$TopicID'");
    
    $DB->query("UPDATE forums_posts SET TopicID='$MergeTopicID', Body=CONCAT_WS( '\n\n', Body, '[align=right][size=0][i]merged from thread[/i][br]\'$OldTitle\'[/size][/align]') WHERE TopicID='$TopicID'");
    $DB->query("UPDATE forums_topics SET Title='$MergeTitle',LastPostID='$NFLastPostID',NumPosts=(NumPosts+$Posts) WHERE ID='$MergeTopicID'");
    
    $DB->query("DELETE FROM forums_topics WHERE ID='$TopicID'");
    
    $Cache->begin_transaction('forums_list');

    if($NewForumID==$OldForumID) { 
        
        $NumPosts = update_forum_info($OldForumID,0,false);
 
    } else { // $NewForumID!=$ForumID  // If we're moving posts into a new forum, change the forum stats
	
        update_forum_info($OldForumID, -1,false);
        $NumPosts = update_forum_info($NewForumID, 0,false);
 
        $Cache->delete_value('forums_'.$NewForumID);
    }
      
    $Cache->commit_transaction(0);
    $Cache->delete_value('thread_'.$TopicID.'_info');
    $Cache->delete_value('thread_'.$MergeTopicID.'_info');
    
    $CatalogueID = floor($NumPosts/THREAD_CATALOGUE);
    for($i=0;$i<=$CatalogueID;$i++) {
        $Cache->delete_value('thread_'.$TopicID.'_catalogue_'.$i);
        $Cache->delete_value('thread_'.$MergeTopicID.'_catalogue_'.$i);
    }
            
    update_latest_topics();
    header('Location: forums.php?action=viewthread&threadid='.$MergeTopicID.'&page='.$Page);
      
}
// If we're deleting a thread
elseif(isset($_POST['delete'])) {
	if(check_perms('site_admin_forums')) {
		$DB->query("DELETE FROM forums_posts WHERE TopicID='$TopicID'");
		$DB->query("DELETE FROM forums_topics WHERE ID='$TopicID'");
            $DB->query("DELETE FROM forums_polls WHERE TopicID='$TopicID'");
            $DB->query("DELETE FROM forums_polls_votes WHERE TopicID='$TopicID'");
    
		update_forum_info($ForumID, -1);
       
		$Cache->delete_value('thread_'.$TopicID.'_info');
                
            update_latest_topics();
		header('Location: forums.php?action=viewforum&forumid='.$ForumID);
	} else {
		error(403);
	}

} else { // If we're just editing it
	$Cache->begin_transaction('thread_'.$TopicID.'_info');
	$UpdateArray = array(
		'IsSticky'=>$Sticky,
		'IsLocked'=>$Locked,
		'Title'=>cut_string($_POST['title'], 150, 1, 0),
		'ForumID'=>$ForumID
		);
	$Cache->update_row(false, $UpdateArray);
	$Cache->commit_transaction(0);
	
	$DB->query("UPDATE forums_topics SET
		IsSticky = '$Sticky',
		IsLocked = '$Locked',
		Title = '$Title',
		ForumID ='$ForumID' 
		WHERE ID='$TopicID'");
	
	
	if($ForumID!=$OldForumID) { // If we're moving a thread, change the forum stats
		
		$DB->query("SELECT MinClassRead, MinClassWrite, Name FROM forums WHERE ID='$ForumID'");
		list($MinClassRead, $MinClassWrite, $ForumName) = $DB->next_record();
		$Cache->begin_transaction('thread_'.$TopicID.'_info');
		$UpdateArray = array(
			'ForumName'=>$ForumName,
			'MinClassRead'=>$MinClassRead,
			'MinClassWrite'=>$MinClassWrite
			);
		$Cache->update_row(false, $UpdateArray);
		$Cache->commit_transaction(3600*24*5);
		
		$Cache->begin_transaction('forums_list');
		// Forum we're moving from
		update_forum_info($OldForumID, -1, false);
		// Forum we're moving to
		update_forum_info($ForumID, 1, false);
		$Cache->commit_transaction(0);
            
	} else { // Editing 
		$DB->query("SELECT LastPostTopicID FROM forums WHERE ID='$ForumID'");
		list($LastTopicID) = $DB->next_record();
		if($LastTopicID == $TopicID) {
			$UpdateArray = array(
				'Title'=>$_POST['title'],
				'IsLocked'=>$Locked,
				'IsSticky'=>$Sticky
			);
			$Cache->begin_transaction('forums_list');
			$Cache->update_row($ForumID, $UpdateArray);
			$Cache->commit_transaction(0);
		}
	}
	if($Locked) {
		$CatalogueID = floor($NumPosts/THREAD_CATALOGUE);
		for($i=0;$i<=$CatalogueID;$i++) {
			$Cache->expire_value('thread_'.$TopicID.'_catalogue_'.$i,3600*24*7);
		}
		$Cache->expire_value('thread_'.$TopicID.'_info',3600*24*7);
		
		$DB->query('UPDATE forums_polls SET Closed=\'0\' WHERE TopicID=\''.$TopicID.'\'');
		$Cache->delete_value('polls_'.$TopicID);
	}
      update_latest_topics();
	header('Location: forums.php?action=viewthread&threadid='.$TopicID.'&page='.$Page);
}




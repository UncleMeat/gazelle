<?
if(!check_perms('site_torrents_notify')){ error(403); }
authorize();

$TagList = '';
$NotTagList = '';
$CategoryList = '';
$FormatList = '';
$EncodingList = '';
$MediaList = '';
$HasFilter = false;

if($_POST['newgroupsonly']){
	$NewGroupsOnly = '1';
	$HasFilter = true;
} else {
	$NewGroupsOnly = '0';
}

if($_POST['tags']){
	$TagList = '|';
	$Tags = explode(',', $_POST['tags']);
	foreach($Tags as $Tag){
		$TagList.=db_string(trim($Tag)).'|';
	}
	$HasFilter = true;
}

if($_POST['nottags']){
	$NotTagList = '|';
	$Tags = explode(',', $_POST['nottags']);
	foreach($Tags as $Tag){
		$NotTagList.=db_string(trim($Tag)).'|';
	}
	$HasFilter = true;
}

if($_POST['categories']){
	$CategoryList = '|';
	foreach($_POST['categories'] as $Category){
		$CategoryList.=db_string(trim($Category)).'|';
	}
	$HasFilter = true;
}

if($_POST['formats']){
	$FormatList = '|';
	foreach($_POST['formats'] as $Format){
		$FormatList.=db_string(trim($Format)).'|';
	}
	$HasFilter = true;
}


if($_POST['bitrates']){
	$EncodingList = '|';
	foreach($_POST['bitrates'] as $Bitrate){
		$EncodingList.=db_string(trim($Bitrate)).'|';
	}
	$HasFilter = true;
}

if($_POST['media']){
	$MediaList = '|';
	foreach($_POST['media'] as $Medium){
		$MediaList.=db_string(trim($Medium)).'|';
	}
	$HasFilter = true;
}

if(!$HasFilter){
	$Err = 'You must add at least one criterion to filter by';
} elseif(!$_POST['label'] && !$_POST['id']) {
	$Err = 'You must add a label for the filter set';
}

if($Err){
	error($Err);
	header('Location: user.php?action=notify');
	die();
}

$TagList = str_replace('||','|',$TagList);
$NotTagList = str_replace('||','|',$NotTagList);

if($_POST['id'] && is_number($_POST['id'])){
	$DB->query("UPDATE users_notify_filters SET
		NewGroupsOnly='$NewGroupsOnly',
		Tags='$TagList',
		NotTags='$NotTagList',
		Categories='$CategoryList',
		Formats='$FormatList',
		Encodings='$EncodingList',
		Media='$MediaList',
		WHERE ID='".db_string($_POST['id'])."' AND UserID='$LoggedUser[ID]'");
} else {
	$DB->query("INSERT INTO users_notify_filters 
		(UserID, Label, NewGroupsOnly, Tags, NotTags, Categories, Formats, Encodings, Media)
		VALUES
		('$LoggedUser[ID]','".db_string($_POST['label'])."','$NewGroupsOnly','$TagList', '$NotTagList', '$CategoryList','$FormatList','$EncodingList','$MediaList')");
}

$Cache->delete_value('notify_filters_'.$LoggedUser['ID']);

header('Location: user.php?action=notify');
?>

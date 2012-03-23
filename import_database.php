<?php

define('SERVER_ROOT', '/home/lanz/www/gazelle');
define('EMDB', 'emtest');
define('TORRENT_PATH', '/home/lanz/www/empornium.me/torrents');

function is_number($Str) {
    $Return = true;
    if ($Str < 0) {
        $Return = false;
    }
    // We're converting input to a int, then string and comparing to original
    $Return = ($Str == strval(intval($Str)) ? true : false);
    return $Return;
}

function make_secret2($Length = 32) {
    $Secret = '';
    $Chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
    for ($i = 0; $i < $Length; $i++) {
        $Rand = mt_rand(0, strlen($Chars) - 1);
        $Secret .= substr($Chars, $Rand, 1);
    }
    return str_shuffle($Secret);
}

require(SERVER_ROOT . '/classes/class_torrent.php');

$time_start = microtime(true);

echo "connecting to database\n";
mysql_connect('localhost', 'root', 'password');


$result = mysql_query('select count(*) as c from gazelle.users_info') or die(mysql_error());
$count = mysql_result($result, 0);

echo "creating new authkey strings and the invite_tree table for $count users (this will take a long time)\n";

$result = mysql_query('select userid from gazelle.users_info') or die(mysql_error());
$i = 0;
$TreeIndex = 2;
echo "0.00% ";
while ($row = mysql_fetch_assoc($result)) {
    $auth_key = make_secret2();

    mysql_query("update gazelle.users_info set AuthKey='$auth_key' where userid={$row['userid']}") or die(mysql_error());
    mysql_query("insert into gazelle.invite_tree values ({$row['userid']}, 0, $TreeIndex, 0, 2)") or die(mysql_error());
    $TreeIndex++;

    $i++;
    if ($i % 1000 == 0)
        echo "\n" . number_format($i / $count * 100, 2) . "% ";
    elseif ($i % 100 == 0)
        echo ".";
}


$result = mysql_query("select count(*) as c from " . EMDB . ".torrents") or die(mysql_error());
$count = mysql_result($result, 0);
echo "Moving $count torrents... (be prepared for another long wait)\n";
$i = 0;
$result = mysql_query("select * from " . EMDB . ".torrents") or die(mysql_error());
while ($row = mysql_fetch_assoc($result)) {
    $File = fopen(TORRENT_PATH . '/' . $row['id'] . '.torrent', 'rb'); // open file for reading
    $Contents = fread($File, 10000000);
    $Tor = new TORRENT($Contents); // New TORRENT object

    $Tor->set_announce_url('ANNOUNCE_URL'); // We just use the string "ANNOUNCE_URL"
    $Tor->make_private();

    list($TotalSize, $FileList) = $Tor->file_list();

    $TmpFileList = array();

    foreach ($FileList as $File) {
        list($Size, $Name) = $File;
        $TmpFileList [] = $Name . '{{{' . $Size . '}}}'; // Name {{{Size}}}
    }

    $FilePath = $Tor->Val['info']->Val['files'] ? mysql_real_escape_string($Tor->Val['info']->Val['name']) : "";
    // Name {{{Size}}}|||Name {{{Size}}}|||Name {{{Size}}}|||Name {{{Size}}}
    $FileString = "'" . mysql_real_escape_string(implode('|||', $TmpFileList)) . "'";
    $NumFiles = count($FileList);
    $TorrentText = $Tor->enc();
    $InfoHash = pack("H*", sha1($Tor->Val['info']->enc()));

    mysql_query("INSERT INTO gazelle.torrents_group
		(ID, CategoryID, NewCategoryID, Name, TagList, Time, WikiBody, SearchText) VALUES
		(" . $row['id'] . ", 2, " . $row['category'] . ", '" . mysql_real_escape_string($row['name']) . "', '" . mysql_real_escape_string($row['tags']) . "', from_unixtime('" . $row['added'] . "'), '" . mysql_real_escape_string($row['descr']) . "', '" . mysql_real_escape_string($row['name']) . "')") or die(mysql_error());

    $Tags = explode(' ', $row['tags']);
    foreach ($Tags as $Tag) {
        if (!empty($Tag)) {

            $r = mysql_query("
                                INSERT INTO gazelle.tags
				(Name, UserID) VALUES
				('" . $Tag . "', '" . $row['owner'] . "')
				ON DUPLICATE KEY UPDATE Uses=Uses+1;
			") or die(mysql_error());
            
            $TagID = mysql_insert_id();
            
            mysql_query("INSERT INTO gazelle.torrents_tags
				(TagID, GroupID, UserID, PositiveVotes) VALUES
				($TagID, " . $row['id'] . ", " . $row['owner'] . ", 10)
				ON DUPLICATE KEY UPDATE PositiveVotes=PositiveVotes+1;
			") or die(mysql_error());
        }
    }

    $r = mysql_query("
	INSERT INTO gazelle.torrents
		(GroupID, UserID, info_hash, FileCount, FileList, FilePath, Size, Time) 
	VALUES
		(" . $row['id'] . ", " . $row['owner'] . ", 
		'" . mysql_real_escape_string($InfoHash) . "', " . $NumFiles . ", " . $FileString . ", '" . $FilePath . "', " . $TotalSize . ", from_unixtime('" . $row['added'] . "'))"
            ) or die(mysql_error());

    $TorrentID = mysql_insert_id();
    mysql_query("INSERT INTO gazelle.torrents_files (TorrentID, File) VALUES ($TorrentID, '" . mysql_real_escape_string($Tor->dump_data()) . "')");


// Update sphinx search     
    mysql_query("UPDATE gazelle.torrents_group SET TagList=(SELECT REPLACE(GROUP_CONCAT(tags.Name SEPARATOR ' '),'.','_')
		FROM gazelle.torrents_tags AS t
		INNER JOIN gazelle.tags ON tags.ID=t.TagID
		WHERE t.GroupID='" . $row['id'] . "'
		GROUP BY t.GroupID)
		WHERE ID='" . $row['id'] . "'") or die(mysql_error());

    mysql_query("REPLACE INTO gazelle.sphinx_delta (ID, GroupName, TagList, Year, CategoryID, Time, ReleaseType, CatalogueNumber, Size, Snatched, Seeders, Leechers, LogScore, Scene, HasLog, HasCue, FreeTorrent, Media, Format, Encoding, RemasterTitle, FileList)
		SELECT
		g.ID AS ID,
		g.Name AS GroupName,
		g.TagList,
		g.Year,
		g.CategoryID,
		UNIX_TIMESTAMP(g.Time) AS Time,
		g.ReleaseType,
		g.CatalogueNumber,
		MAX(CEIL(t.Size/1024)) AS Size,
		SUM(t.Snatched) AS Snatched,
		SUM(t.Seeders) AS Seeders,
		SUM(t.Leechers) AS Leechers,
		MAX(t.LogScore) AS LogScore,
		MAX(t.Scene) AS Scene,
		MAX(t.HasLog) AS HasLog,
		MAX(t.HasCue) AS HasCue,
		BIT_OR(t.FreeTorrent-1) AS FreeTorrent,
		GROUP_CONCAT(DISTINCT t.Media SEPARATOR ' ') AS Media,
		GROUP_CONCAT(DISTINCT t.Format SEPARATOR ' ') AS Format,
		GROUP_CONCAT(DISTINCT t.Encoding SEPARATOR ' ') AS Encoding,
		GROUP_CONCAT(DISTINCT t.RemasterTitle SEPARATOR ' ') AS RemasterTitle,
		GROUP_CONCAT(REPLACE(REPLACE(FileList, '|||', '\n '), '_', ' ') SEPARATOR '\n ') AS FileList
		FROM gazelle.torrents AS t
		JOIN gazelle.torrents_group AS g ON g.ID=t.GroupID
		WHERE g.ID=" . $row['id'] . "
		GROUP BY g.ID") or die(mysql_error());

    mysql_query("INSERT INTO gazelle.sphinx_delta
		(ID, ArtistName)
		SELECT
		GroupID,
		GROUP_CONCAT(aa.Name separator ' ')
		FROM gazelle.torrents_artists AS ta
		JOIN gazelle.artists_alias AS aa ON aa.AliasID=ta.AliasID
		JOIN gazelle.torrents_group AS tg ON tg.ID=ta.GroupID
		WHERE ta.GroupID=" . $row['id'] . " AND ta.Importance IN ('1', '4', '5', '6')
		GROUP BY tg.ID
		ON DUPLICATE KEY UPDATE ArtistName=values(ArtistName)") or die(mysql_error());

    $i++;
    if ($i % 1000 == 0)
        echo "\n" . number_format($i / $count * 100, 2) . "% ";
    elseif ($i % 100 == 0)
        echo ".";
}

echo "Moving torrent comments.\n";
mysql_query("INSERT INTO gazelle.torrents_comments (GroupID, AuthorID, AddedTime, Body, EditedUserID, EditedTime)
        SELECT torrent, user, FROM_UNIXTIME( added ) AS added, ori_text, editedby, FROM_UNIXTIME( editedat ) AS edited
        FROM ".EMDB.".comments    
        ") or die(mysql_error());

$time = microtime(true) - $time_start;
echo "\nexecution time: $time seconds\n";
?>

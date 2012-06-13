<?php 
       
error_reporting(0);

define('SERVER_ROOT', '/home/lanz/www/gazelle');
define('EMDB', 'emp');
define('TORRENT_PATH', '/home/lanz/www/empornium.me/torrents');

$smilies = array(
  ":smile1:" => "smile1.gif",
  ":smile2:" => "smile2.gif",
  ":grin:" => "grin.gif",
  ":laugh:" => "laugh.gif",
  ":w00t:" => "w00t.gif",
  ":tongue:" => "tongue.gif",
  ":wink:" => "wink.gif",
  ":noexpression:" => "noexpression.gif",
  ":confused:" => "confused.gif",
  ":sad:" => "sad.gif",
  ":cry:" => "cry.gif",
  ":weep:" => "weep.gif",
  ":ohmy:" => "ohmy.gif",
  ":clown:" => "clown.gif",
  ":cool1:" => "cool1.gif",
  ":sleeping:" => "sleeping.gif",
  ":innocent:" => "innocent.gif",
  ":whistle:" => "whistle.gif",
  ":unsure:" => "unsure.gif",
  ":closedeyes:" => "closedeyes.gif",
  ":cool2:" => "cool2.gif",
  ":fun:" => "fun.gif",
  ":thumbsup:" => "thumbsup.gif",
  ":thumbsdown:" => "thumbsdown.gif",
  ":blush:" => "blush.gif",
  ":yes:" => "yes.gif",
  ":no:" => "no.gif",
  ":love:" => "love.gif",
  ":question:" => "question.gif",
  ":excl:" => "excl.gif",
  ":idea:" => "idea.gif",
  ":arrow:" => "arrow.gif",
  ":arrow2:" => "arrow2.gif",
  ":hmm:" => "hmm.gif",
  ":hmmm:" => "hmmm.gif",
  ":huh:" => "huh.gif",
  ":geek:" => "geek.gif",
  ":look:" => "look.gif",
  ":rolleyes:" => "rolleyes.gif",
  ":kiss:" => "kiss.gif",
  ":shifty:" => "shifty.gif",
  ":blink:" => "blink.gif",
  ":smartass:" => "smartass.gif",
  ":sick:" => "sick.gif",
  ":crazy:" => "crazy.gif",
  ":wacko:" => "wacko.gif",
  ":alien:" => "alien.gif",
  ":wizard:" => "wizard.gif",
  ":wave:" => "wave.gif",
  ":wavecry:" => "wavecry.gif",
  ":baby:" => "baby.gif",
  ":angry:" => "angry.gif",
  ":ras:" => "ras.gif",
  ":sly:" => "sly.gif",
  ":devil:" => "devil.gif",
  ":evil:" => "evil.gif",
  ":evilmad:" => "evilmad.gif",
  ":sneaky:" => "sneaky.gif",

  ":slap:" => "slap.gif",
  ":wall:" => "wall.gif",
  ":yucky:" => "yucky.gif",
  ":nugget:" => "nugget.gif",
  ":smart:" => "smart.gif",
  ":shutup:" => "shutup.gif",
  ":shutup2:" => "shutup2.gif",
  ":crockett:" => "crockett.gif",
  ":zorro:" => "zorro.gif",
  ":snap:" => "snap.gif",
  ":beer:" => "beer.gif",
  ":beer2:" => "beer2.gif",
  ":drunk:" => "drunk.gif",
  ":strongbench:" => "strongbench.gif",
  ":weakbench:" => "weakbench.gif",
  ":dumbells:" => "dumbells.gif",
  ":music:" => "music.gif",
  
    ":rant:" => "rant.gif",
  ":jump:" => "jump.gif",
  ":stupid:" => "stupid.gif",
  ":dots:" => "dots.gif",
  ":offtopic:" => "offtopic.gif",
  ":spam:" => "spam.gif",
  ":oops:" => "oops.gif",
  ":lttd:" => "lttd.gif",
  ":please:" => "please.gif",
  ":sorry:" => "sorry.gif",
  ":hi:" => "hi.gif",
  ":yay:" => "yay.gif",
  ":cake:" => "cake.gif",
  ":hbd:" => "hbd.gif",
  ":band:" => "band.gif",
  ":punk:" => "punk.gif",
	":rofl:" => "rofl.gif",
  ":bounce:" => "bounce.gif",
  ":mbounce:" => "mbounce.gif",
  ":thankyou:" => "thankyou.gif",
  ":gathering:" => "gathering.gif",


  ":whip:" => "whip.gif",
  ":judge:" => "judge.gif",
  ":chair:" => "chair.gif",
  ":tease:" => "tease.gif",
  ":box:" => "box.gif",
  ":boxing:" => "boxing.gif",
  ":guns:" => "guns.gif",
  ":shoot:" => "shoot.gif",
  ":shoot2:" => "shoot2.gif",
  ":flowers:" => "flowers.gif",
  ":wub:" => "wub.gif",
  ":lovers:" => "lovers.gif",
  ":kissing:" => "kissing.gif",
  ":kissing2:" => "kissing2.gif",
  ":console:" => "console.gif",
  ":group:" => "group.gif",
  ":hump:" => "hump.gif",
  ":hooray:" => "hooray.gif",
  ":happy2:" => "happy2.gif",
  ":clap:" => "clap.gif",
  ":clap2:" => "clap2.gif",
	":weirdo:" => "weirdo.gif",
  ":yawn:" => "yawn.gif",
  ":bow:" => "bow.gif",
	":dawgie:" => "dawgie.gif",
	":cylon:" => "cylon.gif",
  ":book:" => "book.gif",
  ":fish:" => "fish.gif",
  ":mama:" => "mama.gif",
  ":pepsi:" => "pepsi.gif",
  ":medieval:" => "medieval.gif",
  ":rambo:" => "rambo.gif",
  ":ninja:" => "ninja.gif",

  ":party:" => "party.gif",
  ":snorkle:" => "snorkle.gif",

  ":king:" => "king.gif",
  ":chef:" => "chef.gif",
  ":mario:" => "mario.gif",

  ":fez:" => "fez.gif",
  ":cap:" => "cap.gif",
  ":cowboy:" => "cowboy.gif",
  ":pirate:" => "pirate.gif",
  ":pirate2:" => "pirate2.gif",
  ":rock:" => "rock.gif",
  ":cigar:" => "cigar.gif",
  ":icecream:" => "icecream.gif",
  ":oldtimer:" => "oldtimer.gif",
	":trampoline:" => "trampoline.gif",
	":bananadance:" => "bananadance.gif",
  ":smurf:" => "smurf.gif",
  ":yikes:" => "yikes.gif",

  ":santa:" => "santa.gif",
  ":indian:" => "indian.gif",
  ":pimp:" => "pimp.gif",
  ":nuke:" => "nuke.gif",
  ":jacko:" => "jacko.gif",

  ":greedy:" => "greedy.gif",
	":super:" => "super.gif",
  ":wolverine:" => "wolverine.gif",
  ":spidey:" => "spidey.gif",
  ":spider:" => "spider.gif",
  ":bandana:" => "bandana.gif",
  ":construction:" => "construction.gif",
  ":sheep:" => "sheep.gif",
  ":police:" => "police.gif",
	":detective:" => "detective.gif",
  ":bike:" => "bike.gif",
	":fishing:" => "fishing.gif",
  ":clover:" => "clover.gif",

  ":shit:" => "shit.gif",

);

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

function cleansearch($s)
{
    global $smilies;

    foreach ($smilies as $key => $value)
    {
        $remove[] = "/$key/i";
    }
    $remove[] = '/\[img\].*?\[\/img\]/i';
    $remove[] = '/\[img=.*?\].*?\[\/img\]/i';
    $remove[] = '/\[url=.*?\].*?\[\/url\]/i';
    $remove[] = '/\[url\].*?\[\/url\]/i';
    $remove[] = '/\[flash\].*?\[\/flash\]/i';
    $remove[] = '/\[audio\].*?\[\/audio\]/i';
    $remove[] = '/\[thumb\].*?\[\/thumb\]/i';
    $remove[] = '/\[banner\].*?\[\/banner\]/i';
    $remove[] = '/\[media=.*?\].*?\[\/media\]/i';
    $remove[] = '/\[video=.*?\]/i';
    $remove[] = '/\[spoiler\]/i';
    $remove[] = '/\[\/spoiler\]/i';
    $remove[] = '/\[quote\]/i';
    $remove[] = '/\[\/quote\]/i';
    $remove[] = '/\[b\]/i';
    $remove[] = '/\[\/b\]/i';
    $remove[] = '/\[i\]/i';
    $remove[] = '/\[\/i\]/i';
    $remove[] = '/\[u\]/i';
    $remove[] = '/\[\/u\]/i';
    $remove[] = '/\[s\]/i';
    $remove[] = '/\[\/s\]/i';

    $s = preg_replace($remove, '', $s);
    return $s;
}

require(SERVER_ROOT . '/classes/class_torrent.php');

$time_start = microtime(true);

echo "connecting to database\n";
mysql_connect('localhost', 'root', 'password');
/*
echo "Creating new authkeys for users\n";
mysql_query("UPDATE gazelle.users_info
	SET AuthKey =
		MD5(
			CONCAT(
				AuthKey, RAND(), '".mysql_real_escape_string(make_secret2())."',
				SHA1(
					CONCAT(
						RAND(), RAND(), '".mysql_real_escape_string(make_secret2())."'
					)
				)
			)
		);"
	) or die(mysql_error());

echo "creating new invite_tree table for users\n";

$result = mysql_query('select ID from gazelle.users_main') or die(mysql_error());

$TreeIndex = 2;
$values = array();
$comma = "";
while (($row = mysql_fetch_assoc($result))) {
    $values[] = "(".$row["ID"].", 0, $TreeIndex, 0, 2)";
    $TreeIndex++;
}

mysql_query("insert into gazelle.invite_tree values ".implode(',',$values)) or die(mysql_error());
*/
$result = mysql_query("select count(*) as c from " . EMDB . ".torrents") or die(mysql_error());
$count = mysql_result($result, 0);
echo "Importing $count torrents to database... (this will take a while)\n";
echo "Each dot is 50 torrents, an x means a torrent with an info hash that is already in the table.\n";

// Get the categories from the gazelle db
$result = mysql_query("select * from gazelle.categories") or die(mysql_error());
$categories = array();
while ($row = mysql_fetch_assoc($result)) {
    $categories[$row['id']] = $row;
}

$info_hash_array = array();
$i = 0;
$TagIDCounter = 0;
$TorrentID = 0;
$result = mysql_query("select * from " . EMDB . ".torrents") or die(mysql_error());

$torrents_group_rows = array();
$tagids = array();
$tags_row = array();
$torrents_tags_row = array();
$torrents_row = array();
$torrents_files_row = array();

echo "0.00% ";
while (($row = mysql_fetch_assoc($result))) {
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

    // Check for duplicated info_hash values and skip if found since they can not be added.
    if (in_array($InfoHash, $info_hash_array)) {
        echo "x"; // just so we can see how many..
        continue;        
    }
    $info_hash_array[] = $InfoHash;
        
    // Make sure that the tags are all lowercase and unique and insert the category tag here.
    $OriginalTags = strtolower($categories[$row['category']]['tag']." ".$row['tags']);
    $Tags = str_replace('.', '_', $OriginalTags); 
    $Tags = explode(' ', $Tags);
    $Tags = array_unique($Tags);

    $TagList = implode(' ', $Tags);
    
    $torrents_group_rows[] .= "(" . $row['id'] . ", " . $row['category'] . ", '" . mysql_real_escape_string($row['name']) . "', '" . mysql_real_escape_string($TagList) . "', from_unixtime('" . $row['added'] . "'), '" . mysql_real_escape_string($row['descr']) . "', '" . mysql_real_escape_string($row['name']) . " " . mysql_real_escape_string(cleansearch($row['descr'])) . "')";
    
    $Tags = explode(' ', $OriginalTags);
    $Tags = array_unique($Tags);
    foreach ($Tags as $Tag) {
        if (!empty($Tag)) {
            
            if (isset($tagids[$Tag])) {
                $TagID = $tagids[$Tag];
            } else {
                $TagIDCounter++;
                $tagids[$Tag] = $TagIDCounter;
                $TagID = $TagIDCounter;
            }          

            $tags_row[] = "('".$TagID."', '" . $Tag . "', '" . $row['owner'] . "')";          
            $torrents_tags_row[] = "($TagID, " . $row['id'] . ", " . $row['owner'] . ", 10)";            
        }
    }

    $torrents_row[] = "(" . $row['id'] . ", " . $row['owner'] . ", 
		'" . mysql_real_escape_string($InfoHash) . "', " . $NumFiles . ", " . $FileString . ", '" . $FilePath . "', " . $TotalSize . ", from_unixtime('" . $row['added'] . "'), from_unixtime('". $row['last_action']."'), '".$row['hits']."', '".$row['times_completed']."')";

   
    $TorrentID++;
    $torrents_files_row[] = "($TorrentID, '" . mysql_real_escape_string($Tor->dump_data()) . "')";
    
    
    $i++;
    if ($i % 1000 == 0) {
        echo "\n" . number_format($i / $count * 100, 2) . "% ";        
    }
    elseif ($i % 5 == 0) {
/*        mysql_query("INSERT INTO gazelle.torrents_group
                    (ID, NewCategoryID, Name, TagList, Time, Body, SearchText) VALUES " . implode(',', $torrents_group_rows)) or die(mysql_error());
        $torrents_group_rows = array();

         mysql_query("
                            INSERT INTO gazelle.tags
                            (ID, Name, UserID) VALUES ". implode(',', $tags_row) .
                            " ON DUPLICATE KEY UPDATE Uses=Uses+1;
                    ") or die(mysql_error());
         $tags_row = array();
         
        mysql_query("INSERT INTO gazelle.torrents_tags
                            (TagID, GroupID, UserID, PositiveVotes) VALUES " . implode(',', $torrents_tags_row)
                   ) or die(mysql_error());
        $torrents_tags_row = array();
  */    
        echo "INSERT INTO gazelle.torrents
                            (GroupID, UserID, info_hash, FileCount, FileList, FilePath, Size, Time, last_action, Snatched, completed) 
                        VALUES " . implode(',', $torrents_row);
        die();
        mysql_query("INSERT INTO gazelle.torrents
                            (GroupID, UserID, info_hash, FileCount, FileList, FilePath, Size, Time, last_action, Snatched, completed) 
                        VALUES " . implode(',', $torrents_row)
                ) or die(mysql_error());
        $torrents_row = array();
        
        mysql_query("INSERT INTO gazelle.torrents_files (TorrentID, File) VALUES " . implode(',', $torrents_files_row)
                ) or die(mysql_error());
        $torrents_files_row = array();
       
        echo ".";
    }
}

// flush anything that is left...
if (count($torrents_group_rows) > 0) {
    mysql_query("INSERT INTO gazelle.torrents_group
                (ID, NewCategoryID, Name, TagList, Time, Body, SearchText) VALUES " . implode(',', $torrents_group_rows)) or die(mysql_error());
}

if (count($tags_row) > 0) {
    mysql_query("
                        INSERT INTO gazelle.tags
                        (ID, Name, UserID) VALUES ". implode(',', $tags_row) .
                        " ON DUPLICATE KEY UPDATE Uses=Uses+1;
                ") or die(mysql_error());
}

if (count($torrents_tags_row) > 0) {
    mysql_query("INSERT INTO gazelle.torrents_tags
                        (TagID, GroupID, UserID, PositiveVotes) VALUES " . implode(',', $torrents_tags_row)
                ) or die(mysql_error());
}

if (count($torrents_row) > 0) {
    mysql_query("INSERT INTO gazelle.torrents
                        (GroupID, UserID, info_hash, FileCount, FileList, FilePath, Size, Time, last_action, Snatched, completed) 
                    VALUES " . implode(',', $torrents_row)
            ) or die(mysql_error());
}

if (count($torrents_files_row) > 0) {
    mysql_query("INSERT INTO gazelle.torrents_files (TorrentID, File) VALUES " . implode(',', $torrents_files_row)
            ) or die(mysql_error());
}

echo "\n\nCopying torrent comments.\n";
mysql_query("INSERT INTO gazelle.torrents_comments (GroupID, AuthorID, AddedTime, Body, EditedUserID, EditedTime)
        SELECT torrent, user, FROM_UNIXTIME( added ) AS added, ori_text, editedby, FROM_UNIXTIME( editedat ) AS edited
        FROM ".EMDB.".comments    
        ") or die(mysql_error());

$time = microtime(true) - $time_start;
echo "\nexecution time: $time seconds\n";

?>

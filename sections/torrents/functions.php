<?
include(SERVER_ROOT.'/sections/requests/functions.php'); // get_request_tags()

function get_group_info($GroupID, $Return = true) {
	global $Cache, $DB;
	$TorrentCache=$Cache->get_value('torrents_details_'.$GroupID);
	
	//TODO: Remove LogInDB at a much later date.
	if(!is_array($TorrentCache) || !isset($TorrentCache[1][0]['LogInDB'])) {
		// Fetch the group details

		$SQL = "SELECT
                    g.Body,
                    g.Image,
			g.ID,
			g.Name,
			g.NewCategoryID,
			g.Time,
			GROUP_CONCAT(DISTINCT tags.Name SEPARATOR '|'),
			GROUP_CONCAT(DISTINCT tags.ID SEPARATOR '|'),
			GROUP_CONCAT(tt.UserID SEPARATOR '|'),
			GROUP_CONCAT(tt.PositiveVotes SEPARATOR '|'),
			GROUP_CONCAT(tt.NegativeVotes SEPARATOR '|')
			FROM torrents_group AS g
			LEFT JOIN torrents_tags AS tt ON tt.GroupID=g.ID
			LEFT JOIN tags ON tags.ID=tt.TagID
			WHERE g.ID='".db_string($GroupID)."'
			GROUP BY NULL";

		$DB->query($SQL);
		$TorrentDetails=$DB->to_array();

		// Fetch the individual torrents

		$DB->query("
			SELECT
			t.ID,
			t.FileCount,
			t.Size,
			t.Seeders,
			t.Leechers,
			t.Snatched,
			t.FreeTorrent,
                        t.double_seed,
			t.Time,
			t.FileList,
			t.FilePath,
			t.UserID,
			um.Username,
			t.last_action,
			tbt.TorrentID,
			tbf.TorrentID,
			tfi.TorrentID,
			t.LastReseedRequest,
			tln.TorrentID AS LogInDB,
			t.ID AS HasFile,
                        tr.ID AS ReviewID,
                        tr.Status,
                        tr.ConvID,
                        tr.Time AS StatusTime,
                        tr.KillTime,
                        IF(tr.ReasonID = 0, tr.Reason, rr.Description) AS StatusDescription,
                        tr.UserID AS StatusUserID,
                        su.Username AS StatusUsername
			FROM torrents AS t
			LEFT JOIN users_main AS um ON um.ID=t.UserID
                        LEFT JOIN torrents_reviews AS tr ON tr.GroupID=t.GroupID
                        LEFT JOIN review_reasons AS rr ON rr.ID=tr.ReasonID
                        LEFT JOIN users_main AS su ON su.ID=tr.UserID
			LEFT JOIN torrents_bad_tags AS tbt ON tbt.TorrentID=t.ID
			LEFT JOIN torrents_bad_folders AS tbf on tbf.TorrentID=t.ID
			LEFT JOIN torrents_bad_files AS tfi on tfi.TorrentID=t.ID
			LEFT JOIN torrents_logs_new AS tln ON tln.TorrentID=t.ID
			WHERE t.GroupID='".db_string($GroupID)."' 
                        AND (tr.Time IS NULL OR tr.Time=(SELECT MAX(torrents_reviews.Time) 
                                                              FROM torrents_reviews 
                                                              WHERE torrents_reviews.GroupID=t.GroupID))
			AND flags != 1
			GROUP BY t.ID
			ORDER BY t.ID");

            
		$TorrentList = $DB->to_array();
		if(count($TorrentList) == 0) {
			//error(404,'','','',true);
			if(isset($_GET['torrentid']) && is_number($_GET['torrentid'])) {
				error("Cannot find the torrent with the ID ".$_GET['torrentid']);
				header("Location: log.php?search=Torrent+".$_GET['torrentid']);
			} else {
				error(404);
			}
			die();
		}
		if(in_array(0, $DB->collect('Seeders'))) {
			$CacheTime = 600;
		} else {
			$CacheTime = 3600;
		}
		// Store it all in cache
            $Cache->cache_value('torrents_details_'.$GroupID,array($TorrentDetails,$TorrentList),$CacheTime);

	} else { // If we're reading from cache
		$TorrentDetails=$TorrentCache[0];
		$TorrentList=$TorrentCache[1];
	}

	if($Return) {
		return array($TorrentDetails,$TorrentList);
	}
}

function get_status_icon($Status){
    if ($Status == 'Warned' || $Status == 'Pending') return '<span title="This torrent will be automatically deleted unless the uploader fixes it" class="icon icon_warning"></span>';
    elseif ($Status == 'Okay') return '<span title="This torrent has been checked by staff and is okay" class="icon icon_okay"></span>';
    else return '';
}

//Check if a givin string can be validated as a torrenthash
function is_valid_torrenthash($Str) {
	//6C19FF4C 6C1DD265 3B25832C 0F6228B2 52D743D5
	$Str = str_replace(' ', '', $Str);
	if(preg_match('/^[0-9a-fA-F]{40}$/', $Str))
		return $Str;
	return false;
}

function get_group_requests($GroupID) {
	global $DB, $Cache;
	
	$Requests = $Cache->get_value('requests_group_'.$GroupID);
	if ($Requests === FALSE) {
		$DB->query("SELECT ID FROM requests WHERE GroupID = $GroupID AND TimeFilled = '0000-00-00 00:00:00'");
		$Requests = $DB->collect('ID');
		$Cache->cache_value('requests_group_'.$GroupID, $Requests, 0);
	}
	$Requests = get_requests($Requests);
	return $Requests['matches'];
}


function get_tag_synonym($Tag, $Sanitise = true){
        global $Cache, $DB;

        if ($Sanitise) $Tag = sanitize_tag($Tag);

        // Lanz: yeah the caching was a bit too much here imo.
        $DB->query("SELECT t.Name 
                    FROM tag_synomyns AS ts JOIN tags as t ON t.ID = ts.TagID 
                    WHERE Synomyn LIKE '".db_string($Tag)."'");
        if ($DB->record_count() > 0) { // should only ever be one but...
            list($TagName) = $DB->next_record();       
            return $TagName;
        } else {
            return $Tag; 
        }
}


/**
 * Return whether $Tag is a valid tag - more than 2** char long and not a stupid word
 * (** unless is 'hd','dp','bj','ts','sd','69','mf','3d','hj','bi')
 * 
 * @param $Tag. The prospective tag to be evaluated
 * @return Boolean representing whether the tag is valid format (not banned)
 */
function is_valid_tag($Tag){
    static $Good2charTags;
    $len = strlen($Tag);
    if ( $len < 2 ) return false;
    if ( $len == 2 ) {  
        if(!$Good2charTags) $Good2charTags = array('hd','dp','bj','ts','sd','69','mf','3d','hj','bi','tv','dv','da');
        if ( !in_array($Tag, $Good2charTags) ) return false;
    }
    return true;
}

/*  // some research on tags...
 * +-------+------+--------------+----------------+
| TagID | Name | Length(Name) | Count(GroupID) |
+-------+------+--------------+----------------+
|   182 | hd   |            2 |           1988 |
|   257 | dp   |            2 |           1052 |
|    66 | bj   |            2 |            673 |
|   316 | ts   |            2 |            309 |
|  2525 | sd   |            2 |            227 |
|   711 | 69   |            2 |            169 |
|   495 | on   |            2 |            114 |
|  1372 | mf   |            2 |            108 |
|   221 | in   |            2 |            100 |
|   184 | gf   |            2 |             85 |
|   913 | to   |            2 |             72 |
|  1501 | 3d   |            2 |             69 |
|  3828 | hj   |            2 |             49 |
|  4448 | uk   |            2 |             49 |
|   336 | s    |            1 |             49 |
|   322 | 18   |            2 |             46 |
|  3111 | bi   |            2 |             36 |
|   635 | -    |            1 |             35 |
|  1483 | 2    |            1 |             31 |
|  3533 | 30   |            2 |             29 |
|  4944 | rk   |            2 |             26 |
|  6859 | ir   |            2 |             26 |
|   428 | ff   |            2 |             24 |
|  6627 | pd   |            2 |             23 |
|  2079 | is   |            2 |             21 |
|   328 | my   |            2 |             21 |
|  2172 | jo   |            2 |             20 |
|  3294 | cd   |            2 |             19 |
|  2360 | of   |            2 |             19 |
|  5885 | 3    |            1 |             19 |
|   681 | a    |            1 |             18 |
|   973 | i    |            1 |             16 |
|   979 | x    |            1 |             15 |
|   603 | it   |            2 |             15 |
|  1568 | 1    |            1 |             14 |
|  4859 | tv   |            2 |             13 |
|  2156 | fm   |            2 |             12 |
| 14099 | gg   |            2 |             12 |
|  5462 | 4    |            1 |             11 |
|  1780 | by   |            2 |             10 |
|  3341 | 7    |            1 |             10 |
|   636 | no   |            2 |             10 |
|   652 | up   |            2 |             10 |
|  1122 | m    |            1 |             10 |
|  1378 | me   |            2 |              9 |
|   660 | b    |            1 |              9 |
|  4486 | ex   |            2 |              8 |
|   742 | 6    |            1 |              7 |
|   653 | d    |            1 |              7 |
| 11997 | .    |            1 |              7 |
|  1405 | 5    |            1 |              7 |
|  8550 | cj   |            2 |              7 |
|   553 | le   |            2 |              7 |
| 16538 | da   |            2 |              6 |
|  4179 | xl   |            2 |              6 |
|   670 | at   |            2 |              6 |
| 13858 | t    |            1 |              5 |
| 16999 | av   |            2 |              5 |
| 11402 | na   |            2 |              5 |
| 14553 | dv   |            2 |              5 |
|  7293 | 8    |            1 |              5 |
|   295 | c    |            1 |              5 |
| 14707 | 90   |            2 |              5 |
|  1735 | l    |            1 |              5 |
| 11068 | 10   |            2 |              5 |
| 15255 | n    |            1 |              5 |
| 17603 | jt   |            2 |              4 |
|  3182 | f    |            1 |              4 |
|  7199 | dc   |            2 |              4 |
|   342 | o    |            1 |              4 |
|   529 | sg   |            2 |              4 |
| 21014 | de   |            2 |              4 |
|  3174 | 21   |            2 |              4 |
|  7783 | sm   |            2 |              4 |
|  3152 | k    |            1 |              4 |
|  2228 | 45   |            2 |              4 |
|  4453 | an   |            2 |              4 |
|   175 | di   |            2 |              3 |
|    15 | r    |            1 |              3 |
|  2408 | id   |            2 |              3 |
|  6214 | la   |            2 |              3 |
| 13583 | tp   |            2 |              3 |
| 12825 | 70   |            2 |              3 |
|  2594 | j    |            1 |              3 |
|  2431 | be   |            2 |              3 |
|   947 | cp   |            2 |              3 |
|  9560 | dj   |            2 |              3 |
|  2086 | or   |            2 |              3 |
| 13024 | p    |            1 |              3 |
|  4551 | bg   |            2 |              3 |
|  2090 | as   |            2 |              3 |
|  1527 | 80   |            2 |              3 |
| 21075 | tg   |            2 |              3 |
|   942 | fi   |            2 |              3 |
| 15200 | we   |            2 |              3 |
| 18619 | mr   |            2 |              3 |
| 20954 | 50   |            2 |              3 |
|  5484 | et   |            2 |              3 |
| 19157 | jb   |            2 |              3 |
|  1365 | q    |            1 |              3 |
| 21575 | hc   |            2 |              2 |
|  2315 | nn   |            2 |              2 |
| 17315 | 44   |            2 |              2 |
|   659 | 13   |            2 |              2 |
|   956 | g    |            1 |              2 |
| 10519 | 99   |            2 |              2 |
|  4031 | tb   |            2 |              2 |
| 19174 | jc   |            2 |              2 |
|    51 | do   |            2 |              2 |
|  8124 | mm   |            2 |              2 |
|   339 | pe   |            2 |              2 |
|  8265 | oz   |            2 |              2 |
|  1360 | z    |            1 |              2 |
| 18218 | 12   |            2 |              2 |
|  4346 | 15   |            2 |              2 |
|  8412 | bb   |            2 |              2 |
| 22376 | 19   |            2 |              2 |
| 20086 | im   |            2 |              2 |
| 20662 | bf   |            2 |              2 |
|  1338 | ai   |            2 |              2 |
|  2886 | 11   |            2 |              2 |
| 17841 | oh   |            2 |              2 |
| 14419 | cg   |            2 |              2 |
|  1479 | st   |            2 |              2 |
|  8234 | ma   |            2 |              2 |
| 17912 | h    |            1 |              2 |
| 19879 | 07   |            2 |              2 |
|  1649 | 20   |            2 |              2 |
| 25764 | b.   |            2 |              2 |
|  7294 | 9    |            1 |              2 |
|  3886 | 3p   |            2 |              2 |
| 16339 | dt   |            2 |              2 |
|   229 | ho   |            2 |              2 |
|   694 | po   |            2 |              1 |
| 23814 | om   |            2 |              1 |
| 18220 | 22   |            2 |              1 |
| 24073 | lj   |            2 |              1 |
| 23328 | ol   |            2 |              1 |
| 24329 | dh   |            2 |              1 |
|  8862 | em   |            2 |              1 |
| 12006 | fj   |            2 |              1 |
| 27166 | ik   |            2 |              1 |
|   672 | fa   |            2 |              1 |
|  5875 | gq   |            2 |              1 |
| 10404 | ro   |            2 |              1 |
| 21243 | dl   |            2 |              1 |
| 11002 | tj   |            2 |              1 |
|  1462 | 14   |            2 |              1 |
| 22561 | ba   |            2 |              1 |
|   230 | es   |            2 |              1 |
| 21138 | e    |            1 |              1 |
|  1715 | mz   |            2 |              1 |
|  3714 | lb   |            2 |              1 |
|  3151 | zi   |            2 |              1 |
| 23668 | ni   |            2 |              1 |
| 27167 | ga   |            2 |              1 |
| 24100 | mi   |            2 |              1 |
|   448 | go   |            2 |              1 |
| 24602 | u    |            1 |              1 |
|  6618 | ie   |            2 |              1 |
| 16389 | s1   |            2 |              1 |
|  9631 | rs   |            2 |              1 |
| 17985 | wa   |            2 |              1 |
|  5243 | ac   |            2 |              1 |
| 21759 | du   |            2 |              1 |
| 20998 | so   |            2 |              1 |
|  5419 | hp   |            2 |              1 |
| 11998 | v    |            1 |              1 |
| 17691 | 23   |            2 |              1 |
| 16802 | aa   |            2 |              1 |
|   769 | w    |            1 |              1 |
| 23448 | 61   |            2 |              1 |
|   600 | mo   |            2 |              1 |
| 15753 | b3   |            2 |              1 |
| 18379 | lt   |            2 |              1 |
| 18219 | 03   |            2 |              1 |
|  9526 | ae   |            2 |              1 |
|  8768 | am   |            2 |              1 |
| 15961 | bt   |            2 |              1 |
|   436 | se   |            2 |              1 |
| 17375 | rq   |            2 |              1 |
| 11199 | bo   |            2 |              1 |
| 12555 | ob   |            2 |              1 |
| 27520 | hq   |            2 |              1 |
| 15747 | ed   |            2 |              1 |
|   888 | 59   |            2 |              1 |
| 21824 | mb   |            2 |              1 |
| 26858 | ea   |            2 |              1 |
|  2292 | re   |            2 |              1 |
| 16825 | 25   |            2 |              1 |
|  1163 | wd   |            2 |              1 |
| 21242 | ab   |            2 |              1 |
| 10419 | 24   |            2 |              1 |
| 23401 | --   |            2 |              1 |
| 21290 | 05   |            2 |              1 |
| 27159 | dd   |            2 |              1 |
|  2222 | 36   |            2 |              1 |
| 20804 | .f   |            2 |              1 |
| 17350 | 67   |            2 |              1 |
|   946 | nt   |            2 |              1 |
|  4075 | mv   |            2 |              1 |
|  8529 | ty   |            2 |              1 |
| 26737 | wm   |            2 |              1 |
| 14174 | 16   |            2 |              1 |
|   633 | co   |            2 |              1 |
+-------+------+--------------+----------------+

+-------+------+------+-------+
| TagID | Name | len  | count |
+-------+------+------+-------+
|    62 | pov  |    3 |  1126 |
|    13 | big  |    3 |   920 |
|    28 | sex  |    3 |   860 |
|  4318 | mp4  |    3 |   648 |
|    49 | ass  |    3 |   636 |
|    69 | bbw  |    3 |   636 |
|    64 | cum  |    3 |   588 |
|  1630 | a2m  |    3 |   510 |
|   544 | jav  |    3 |   480 |
|    27 | all  |    3 |   417 |
|  1646 | wmv  |    3 |   357 |
|    99 | ffm  |    3 |   310 |
|   785 | avi  |    3 |   306 |
|   647 | oil  |    3 |   301 |
|    35 | ftv  |    3 |   275 |
|   918 | mmf  |    3 |   234 |
|  1939 | gag  |    3 |   186 |
|   968 | atm  |    3 |   184 |
|   666 | hot  |    3 |   181 |
|    98 | mff  |    3 |   150 |
|    72 | fat  |    3 |   139 |
|   219 | pee  |    3 |   139 |
|   619 | gay  |    3 |   122 |
|   164 | com  |    3 |   115 |
|  1121 | job  |    3 |   114 |
|   552 | toy  |    3 |   106 |
|  4710 | atk  |    3 |   105 |
|   608 | wet  |    3 |   100 |
|  4060 | bbc  |    3 |    91 |
|   105 | ggg  |    3 |    86 |
|  1652 | emo  |    3 |    77 |
|  1265 | the  |    3 |    67 |
|  4311 | dap  |    3 |    63 |
|  1831 | cam  |    3 |    62 |
|   745 | art  |    3 |    59 |
|     9 | mom  |    3 |    56 |
|   760 | xxx  |    3 |    54 |
|  4203 | fmm  |    3 |    52 |
|  4508 | joi  |    3 |    52 |
|  7428 | otk  |    3 |    50 |
|   667 | and  |    3 |    49 |
|   839 | cbt  |    3 |    48 |
| 11901 | joe  |    3 |    47 |
|  1564 | 720  |    3 |    44 |
|   324 | old  |    3 |    43 |
|   714 | alt  |    3 |    41 |
|  1058 | eva  |    3 |    40 |
|    10 | son  |    3 |    40 |
|   740 | tit  |    3 |    39 |
|  1125 | mia  |    3 |    39 |
|  3855 | a2p  |    3 |    38 |
|  1129 | amy  |    3 |    36 |
|  4833 | ddf  |    3 |    36 |
|   775 | wax  |    3 |    35 |
|  6562 | fit  |    3 |    34 |
|   408 | dvd  |    3 |    33 |
|  5905 | hsp  |    3 |    32 |
|  3426 | tan  |    3 |    30 |
|  4168 | mpg  |    3 |    30 |
|  6076 | mix  |    3 |    30 |
| 12228 | spy  |    3 |    30 |
|  3422 | cim  |    3 |    29 |
|  1605 | lee  |    3 |    29 |
|  1086 | pie  |    3 |    28 |
|  1978 | kat  |    3 |    27 |
|  9099 | rct  |    3 |    26 |
|   626 | red  |    3 |    26 |
|  1138 | new  |    3 |    26 |
|   135 | car  |    3 |    26 |
|  4592 | bts  |    3 |    26 |
|   494 | one  |    3 |    25 |
|  2638 | ecg  |    3 |    24 |
|  4571 | ppv  |    3 |    24 |
|   630 | ann  |    3 |    23 |
|  8005 | lez  |    3 |    22 |
|  1296 | boy  |    3 |    22 |
|  2792 | ira  |    3 |    21 |
|  1614 | ivy  |    3 |    21 |
|  4763 | mfc  |    3 |    21 |
|  1900 | shy  |    3 |    21 |
|  6803 | dpp  |    3 |    21 |
| 16610 | psp  |    3 |    20 |
|  5169 | zip  |    3 |    20 |
|  8765 | usa  |    3 |    20 |
|   559 | dee  |    3 |    19 |
|  1070 | gow  |    3 |    18 |
|  1441 | fox  |    3 |    18 |
|   855 | asa  |    3 |    18 |
|  1968 | ava  |    3 |    17 |
|  1238 | pvc  |    3 |    17 |
|  1353 | gym  |    3 |    17 |
|  3275 | ifm  |    3 |    17 |
|  7010 | jap  |    3 |    17 |
| 12456 | wam  |    3 |    17 |
|  1323 | zoe  |    3 |    16 |
|   796 | flv  |    3 |    16 |
|  4393 | fbb  |    3 |    15 |
|   884 | 90s  |    3 |    15 |
|  7191 | nun  |    3 |    15 |
|  1532 | but  |    3 |    15 |
|   284 | 666  |    3 |    15 |
|  3231 | rip  |    3 |    15 |
|  6948 | cof  |    3 |    14 |
| 14670 | dgg  |    3 |    14 |
|  1104 | bed  |    3 |    14 |
|  5737 | faq  |    3 |    14 |
|   611 | bra  |    3 |    14 |
|  7640 | bgg  |    3 |    14 |
|  4565 | cei  |    3 |    13 |
|  1346 | eve  |    3 |    13 |
|  6624 | bun  |    3 |    13 |
|  9615 | fff  |    3 |    13 |
|  3716 | rae  |    3 |    13 |
|  1203 | mya  |    3 |    12 |
|  1816 | jay  |    3 |    12 |
|  3322 | bus  |    3 |    12 |
|  1182 | lea  |    3 |    12 |
|   932 | tia  |    3 |    12 |
|  3113 | nda  |    3 |    12 |
|  3911 | ggw  |    3 |    12 |
|   712 | ana  |    3 |    12 |
|  1040 | rio  |    3 |    12 |
|  1600 | gia  |    3 |    12 |
|  6167 | m.f  |    3 |    11 |
|  2766 | joy  |    3 |    11 |
|  9209 | sub  |    3 |    11 |
|  7999 | bbg  |    3 |    11 |
+-------+------+------+-------+
+-------+------+------+-------+
| TagID | Name | len  | count |
+-------+------+------+-------+
|     1 | anal |    4 |  7003 |
|    30 | oral |    4 |  3975 |
|    31 | teen |    4 |  3792 |
|    33 | bdsm |    4 |  1577 |
|   147 | solo |    4 |  1333 |
|    67 | milf |    4 |  1280 |
|   183 | 720p |    4 |  1219 |
|   430 | toys |    4 |  1104 |
|    20 | tits |    4 |  1032 |
|  1769 | 1on1 |    4 |   821 |
|   391 | orgy |    4 |   429 |
|   296 | gape |    4 |   401 |
|    60 | piss |    4 |   390 |
|   440 | cute |    4 |   313 |
|   186 | fuck |    4 |   243 |
|    73 | scat |    4 |   222 |
|   628 | kink |    4 |   205 |
|   352 | rape |    4 |   200 |
|   833 | euro |    4 |   192 |
|   551 | girl |    4 |   173 |
|   573 | feet |    4 |   168 |
|  4950 | 480p |    4 |   150 |
|    41 | sexy |    4 |   140 |
|  1120 | blow |    4 |   138 |
|  1280 | spit |    4 |   134 |
|  1887 | thai |    4 |   118 |
|   180 | pain |    4 |   109 |
|  1276 | rope |    4 |   108 |
|   744 | nude |    4 |   107 |
|   526 | punk |    4 |   102 |
|  1638 | cock |    4 |   102 |
|   503 | foot |    4 |   102 |
|    22 | deep |    4 |    99 |
|   698 | huge |    4 |    97 |
| 11848 | kotr |    4 |    97 |
|  3048 | slim |    4 |    95 |
|   596 | slut |    4 |    91 |
|   525 | goth |    4 |    86 |
|  4083 | pawg |    4 |    82 |
|   489 | puke |    4 |    82 |
|   780 | fake |    4 |    81 |
|   801 | butt |    4 |    80 |
|  1482 | pics |    4 |    80 |
|  4748 | 540p |    4 |    78 |
|  5082 | abby |    4 |    76 |
|   685 | high |    4 |    74 |
|  1522 | bang |    4 |    72 |
|   604 | rose |    4 |    69 |
|  1801 | tied |    4 |    67 |
|  1763 | 2on1 |    4 |    66 |
|   580 | legs |    4 |    64 |
|  1228 | dick |    4 |    64 |
|   266 | dvdr |    4 |    63 |
|   700 | suck |    4 |    62 |
|   656 | wife |    4 |    61 |
|    79 | shit |    4 |    60 |
|   817 | plot |    4 |    59 |
|  5270 | amwf |    4 |    59 |
|   438 | gang |    4 |    58 |
|  1756 | fist |    4 |    57 |
|   938 | pack |    4 |    57 |
|  2580 | pale |    4 |    56 |
|   191 | love |    4 |    54 |
|   928 | pool |    4 |    54 |
|   614 | porn |    4 |    52 |
|   564 | game |    4 |    52 |
|  4895 | xvid |    4 |    51 |
|   337 | cfnm |    4 |    51 |
|   498 | male |    4 |    50 |
|   605 | hard |    4 |    48 |
|  2454 | milk |    4 |    45 |
|  5218 | mmmf |    4 |    43 |
|  2582 | shot |    4 |    43 |
|  1291 | maid |    4 |    41 |
|  1105 | bath |    4 |    41 |
|  4627 | tall |    4 |    41 |
|   910 | lexi |    4 |    39 |
|   727 | cane |    4 |    39 |
|    76 | lisa |    4 |    38 |
|  5241 | fffm |    4 |    38 |
|   953 | jade |    4 |    37 |
|  1275 | whip |    4 |    36 |
| 11102 | mshf |    4 |    36 |
|  1954 | vera |    4 |    36 |
|  1162 | mask |    4 |    35 |
|   663 | tiny |    4 |    33 |
|   887 | club |    4 |    33 |
|  5158 | slap |    4 |    33 |
|   658 | live |    4 |    32 |
|  3545 | clip |    4 |    32 |
|   192 | lily |    4 |    31 |
|  3532 | over |    4 |    31 |
|   915 | play |    4 |    31 |
|  1734 | anna |    4 |    30 |
|  1375 | face |    4 |    30 |
|  2300 | jobs |    4 |    30 |
|   487 | star |    4 |    30 |
|  1047 | head |    4 |    29 |
|  1661 | bush |    4 |    29 |
|   982 | with |    4 |    28 |
|  2382 | rare |    4 |    28 |
|  1561 | abdl |    4 |    28 |
|  1374 | lynn |    4 |    27 |
|   329 | real |    4 |    27 |
|  2753 | kate |    4 |    27 |
|  5604 | idol |    4 |    26 |
|  2577 | jane |    4 |    26 |
|  1057 | jada |    4 |    25 |
|  1141 | blue |    4 |    25 |
|  3351 | roxy |    4 |    25 |
|  5540 | x264 |    4 |    24 |
|  4051 | asia |    4 |    24 |
|  2054 | babe |    4 |    24 |
| 15030 | gilf |    4 |    24 |
|  4870 | hair |    4 |    24 |
|  6616 | 2012 |    4 |    24 |
|  1233 | emma |    4 |    23 |
|  1329 | sara |    4 |    23 |
|   348 | dana |    4 |    23 |
|  5219 | mmff |    4 |    23 |
|  7818 | inna |    4 |    23 |
|   584 | mwhf |    4 |    23 |
|   410 | xart |    4 |    23 |
|   451 | brcc |    4 |    22 |
|  4880 | lena |    4 |    22 |
|   759 | kiss |    4 |    22 |
|  6845 | bald |    4 |    22 |
|  1545 | lola |    4 |    21 |
|  1666 | hand |    4 |    21 |
|  6560 | moan |    4 |    21 |
|   576 | toes |    4 |    21 |
|  2845 | anya |    4 |    20 |
|  9376 | 0day |    4 |    20 |
|  2078 | this |    4 |    20 |
| 16609 | ipod |    4 |    20 |
|  4314 | ffmm |    4 |    20 |
|  2557 | yuri |    4 |    19 |
|  1491 | tina |    4 |    19 |
|  2968 | alex |    4 |    19 |
|  1393 | pink |    4 |    19 |
|  4375 | ebbi |    4 |    19 |
|  9102 | riri |    4 |    19 |
|  1188 | gina |    4 |    19 |
|  9103 | koda |    4 |    19 |
|  4211 | ball |    4 |    18 |
|   631 | view |    4 |    18 |
|   528 | poop |    4 |    18 |
|  7645 | nata |    4 |    18 |
|  1547 | lucy |    4 |    17 |
|  1995 | pony |    4 |    17 |
| 13886 | siri |    4 |    17 |
|  5013 | neil |    4 |    17 |
|  1388 | aliz |    4 |    17 |
|  5168 | zips |    4 |    17 |
|  3649 | tips |    4 |    17 |
|  8514 | mary |    4 |    17 |
|  1469 | nina |    4 |    17 |
|  7256 | 1080 |    4 |    17 |
|  5998 | mila |    4 |    17 |
| 18945 | preg |    4 |    16 |
|  3352 | raye |    4 |    16 |
|  4792 | sofa |    4 |    16 |
| 11120 | arab |    4 |    16 |
|  1127 | jana |    4 |    16 |
|  3444 | cuck |    4 |    16 |
|  2767 | lara |    4 |    16 |
|   194 | mira |    4 |    16 |
|   808 | zoey |    4 |    16 |
|  2648 | nuru |    4 |    15 |
|  5589 | adbl |    4 |    15 |
|  9302 | hood |    4 |    15 |
|  1368 | lube |    4 |    15 |
|  1051 | nice |    4 |    15 |
| 11236 | rico |    4 |    14 |
|  1523 | food |    4 |    14 |
|  2632 | nika |    4 |    14 |
|  2587 | cruz |    4 |    14 |
|  7151 | lana |    4 |    14 |
|  1530 | home |    4 |    14 |
|  4860 | epic |    4 |    14 |
|  1227 | grey |    4 |    13 |
|  6625 | oven |    4 |    13 |
| 14387 | mfff |    4 |    13 |
|  2896 | zara |    4 |    13 |
|  1694 | tori |    4 |    13 |
|  5117 | 320p |    4 |    13 |
|   983 | fire |    4 |    13 |
|  9121 | load |    4 |    13 |
|  6096 | 2011 |    4 |    13 |
| 15068 | nerd |    4 |    13 |
| 11214 | cuff |    4 |    13 |
|  1922 | toon |    4 |    13 |
|  2250 | mygf |    4 |    13 |
| 10548 | loud |    4 |    13 |
|  7499 | gags |    4 |    13 |
|  1872 | more |    4 |    12 |
|  1606 | west |    4 |    12 |
| 12431 | maya |    4 |    12 |
|   687 | gyno |    4 |    12 |
|  3454 | plug |    4 |    12 |
+-------+------+------+-------+











+-------+--------------------+-------+
| TagID | Name               | count |
+-------+--------------------+-------+
|     6 | hardcore           |  7659 |
|     1 | anal               |  7003 |
|    45 | blowjob            |  4555 |
|    34 | big.tits           |  4038 |
|    30 | oral               |  3975 |
|    31 | teen               |  3792 |
|   187 | cumshot            |  3701 |
|    46 | facial             |  3483 |
|     5 | straight           |  3065 |
|    32 | lesbian            |  2868 |
|   118 | brunette           |  2671 |
|    21 | blonde             |  2514 |
|    84 | asian              |  2109 |
|   182 | hd                 |  1988 |
|   231 | shemale            |  1938 |
|    37 | masturbation       |  1916 |
|   146 | amateur            |  1892 |
|    55 | fetish             |  1803 |
|   414 | natural.tits       |  1792 |
|   103 | interracial        |  1733 |
|    33 | bdsm               |  1577 |
|   147 | solo               |  1333 |
|    67 | milf               |  1280 |
|    19 | black              |  1257 |
|    68 | amature            |  1232 |
|   183 | 720p               |  1219 |
|   154 | threesome          |  1215 |
|   259 | tranny             |  1142 |
|    62 | pov                |  1126 |
|    92 | creampie           |  1125 |
|   430 | toys               |  1104 |
|   374 | big.ass            |  1102 |
|     7 | mature             |  1061 |
|   257 | dp                 |  1052 |
|    20 | tits               |  1032 |
|   235 | shaved             |  1023 |
|   167 | bondage            |  1014 |
|     2 | homemade           |   994 |
|   463 | small.tits         |   971 |
|  3107 | after.cheggit      |   958 |
|    44 | latina             |   935 |
|   315 | deepthroat         |   920 |
|    13 | big                |   920 |
|    28 | sex                |   860 |
|   115 | cowgirl            |   858 |
|  1769 | 1on1               |   821 |
|  2132 | cum.in.mouth       |   807 |
|   690 | dildo              |   784 |
|   589 | fake.tits          |   772 |
|   258 | transsexual        |   766 |
|   333 | stockings          |   749 |
|   123 | swallow            |   736 |
|   799 | doggy              |   720 |
|    18 | gangbang           |   715 |
|   201 | mega.pack          |   699 |
|   117 | fingering          |   680 |
|    66 | bj                 |   673 |
|    52 | images             |   668 |
|   113 | handjob            |   663 |
|    26 | classic            |   662 |
|   361 | natural            |   655 |
|  4318 | mp4                |   648 |
|   116 | reverse.cowgirl    |   646 |
|    69 | bbw                |   636 |
|    49 | ass                |   636 |
|  1738 | ass.to.mouth       |   635 |
|    90 | japanese           |   627 |
|   197 | all.girl           |   606 |
|  1078 | skinny             |   604 |
|    64 | cum                |   588 |
|   368 | pictures           |   573 |
|   163 | brazzers           |   564 |
|   168 | double.penetration |   562 |
|   111 | doggystyle         |   545 |
|    17 | gang.bang          |   545 |
|   218 | softcore           |   538 |
|  1529 | missionary         |   532 |
|   456 | redhead            |   522 |
|    14 | boobs              |   521 |
|   458 | cunnilingus        |   519 |
|   550 | russian            |   515 |
|   110 | cumshots           |   514 |
|   335 | group              |   512 |
|   715 | tattoos            |   511 |
|   401 | femdom             |   510 |
|  1630 | a2m                |   510 |
|  1867 | cum.on.tits        |   491 |
|    25 | siterip            |   488 |
|  2217 | 1080p              |   488 |
|   544 | jav                |   480 |
|   311 | censored           |   472 |
|   661 | tattoo             |   470 |
|    53 | lingerie           |   466 |
|   939 | young              |   465 |
|  1077 | petite             |   464 |
|  2475 | rimming            |   451 |
|   455 | heels              |   437 |
|    91 | uncensored         |   432 |
|   391 | orgy               |   429 |
|   240 | compilation        |   425 |
|   841 | natural.boobs      |   417 |
|    27 | all                |   417 |
|  3105 | single.scene       |   414 |
|   296 | gape               |   401 |
|   169 | bukkake            |   397 |
|    60 | piss               |   390 |
|    50 | gonzo              |   386 |
|   465 | teens              |   380 |
|   515 | hairy              |   377 |
|  1863 | girl.girl          |   372 |
|    59 | fisting            |   369 |
|   697 | gagging            |   367 |
|   581 | female.completion  |   366 |
|  2129 | tit.fuck           |   365 |
|    36 | squirting          |   362 |
|  1646 | wmv                |   357 |
|   108 | ebony              |   354 |
|  2482 | hairy.pussy        |   347 |
|  2064 | big.natural.tits   |   343 |
|   244 | humiliation        |   343 |
|   129 | public             |   338 |
|   488 | spanking           |   335 |
|  1052 | chubby             |   333 |
|   427 | strap.on           |   328 |
|  1010 | male.on.shemale    |   325 |
|   200 | strapon            |   324 |
|   317 | bareback           |   320 |
|   937 | european           |   319 |
|  1084 | bangbros           |   316 |
|   153 | hentai             |   314 |
|   440 | cute               |   313 |
|    99 | ffm                |   310 |
|   316 | ts                 |   309 |
|  2514 | ass.licking        |   306 |
|   785 | avi                |   306 |
|   647 | oil                |   301 |
|   454 | busty              |   296 |
|  1874 | high.heels         |   293 |
|   148 | squirt             |   291 |
|    93 | vibrator           |   290 |
|  1795 | kink.com           |   283 |
|  2052 | rough.sex          |   282 |
|   665 | rough              |   279 |
|    35 | ftv                |   275 |
|   507 | latex              |   269 |
|  2135 | deep.throat        |   263 |
|   112 | glasses            |   260 |
|  3130 | british            |   258 |
|  1207 | white              |   253 |
|   617 | massage            |   251 |
|   800 | piercings          |   249 |
|   172 | german             |   249 |
|  1261 | orgasm             |   247 |
|   186 | fuck               |   243 |
|   181 | other              |   241 |
|   256 | megapack           |   235 |
|   679 | pussy              |   235 |
|   918 | mmf                |   234 |
|     8 | incest             |   229 |
|   646 | latin              |   228 |
|  4320 | high.definition    |   227 |
|  2525 | sd                 |   227 |
|   280 | shemale.on.male    |   226 |
|   412 | pantyhose          |   222 |
|    73 | scat               |   222 |
|    24 | pornstar           |   220 |
|  3826 | blow.job           |   217 |
|  1847 | evil.angel         |   217 |
|   492 | titfuck            |   217 |
|   234 | naughty.america    |   217 |
|   811 | swallowing         |   214 |
|   126 | outdoor            |   214 |
|  2819 | facials            |   212 |
|  1908 | cum.on.face        |   211 |
|    81 | parody             |   209 |
|  1687 | shaved.pussy       |   208 |
|   319 | ladyboy            |   208 |
|  1822 | brazilian          |   207 |
|   586 | big.dick           |   206 |
|   628 | kink               |   205 |
|   352 | rape               |   200 |
|  1103 | webcam             |   199 |
|  1653 | masturbate         |   198 |
|   749 | gaping             |   198 |
|   513 | big.butt           |   196 |
|    38 | voyeur             |   196 |
|  9438 | blockboy           |   194 |
|   803 | asslicking         |   193 |
|   833 | euro               |   192 |
|   457 | big.cock           |   192 |
|  4315 | web-dl             |   188 |
|  1257 | riding             |   187 |
|   716 | domination         |   186 |
|  1939 | gag                |   186 |
|  1232 | naughtyamerica     |   185 |
|   968 | atm                |   184 |
|   620 | blond              |   184 |
|   334 | blowjobs           |   183 |
|   666 | hot                |   181 |
|   641 | tease              |   180 |
+-------+--------------------+-------+


+-------+-----------------------------+-------+
| TagID | Name                        | count |
+-------+-----------------------------+-------+
|   356 | slave                       |   179 |
|  1576 | socks                       |   178 |
|   551 | girl                        |   173 |
|  2101 | kissing                     |   172 |
|  5510 | huge.tits                   |   171 |
|   496 | small                       |   170 |
|   449 | spanish                     |   169 |
|   711 | 69                          |   169 |
|   573 | feet                        |   168 |
|   131 | a.l.o.m                     |   167 |
|  4600 | hispanic                    |   165 |
|   677 | pregnant                    |   164 |
|   241 | cuckold                     |   164 |
|   682 | licking                     |   163 |
|   393 | schoolgirl                  |   161 |
|  3104 | blowbang                    |   160 |
|   593 | transexual                  |   159 |
|  1080 | pigtails                    |   157 |
|    16 | double                      |   153 |
|  2516 | brazzers.com                |   153 |
|  4313 | rimjob                      |   151 |
|   637 | condom                      |   150 |
|  7169 | atk.hairy                   |   150 |
|    98 | mff                         |   150 |
|  4950 | 480p                        |   150 |
|   294 | shower                      |   149 |
|   519 | reality.kings               |   149 |
|  1190 | french                      |   148 |
|  1017 | full.movie                  |   147 |
|  4014 | pictureset                  |   147 |
|   642 | fucking                     |   147 |
|  2212 | fishnets                    |   144 |
|  3459 | cumpilation                 |   142 |
|   269 | brazil                      |   142 |
|   134 | pissing                     |   142 |
|    41 | sexy                        |   140 |
|   206 | paysite                     |   139 |
|    72 | fat                         |   139 |
|   219 | pee                         |   139 |
|  1120 | blow                        |   138 |
|   128 | extreme                     |   138 |
|  3041 | bobbi.starr                 |   137 |
|   741 | uniform                     |   135 |
|  2335 | anal.creampie               |   135 |
|  1280 | spit                        |   134 |
|  7170 | hairy.ass                   |   133 |
|  3417 | cheggit                     |   132 |
|   571 | footjob                     |   132 |
|  2211 | dirty.talk                  |   131 |
|   783 | site.rip                    |   131 |
|  2511 | titty.fuck                  |   131 |
|   566 | outdoors                    |   130 |
|   493 | lesbians                    |   129 |
|  2337 | mike.adriano                |   128 |
|  4262 | throatfucking               |   127 |
|   825 | smoking                     |   126 |
|  2006 | piercing                    |   125 |
|    96 | lexi.belle                  |   123 |
|  4094 | split.scenes                |   123 |
|  4576 | plumper                     |   122 |
|   619 | gay                         |   122 |
|  7449 | natural.breasts             |   121 |
|  1655 | public-nudity               |   121 |
|  1514 | enema                       |   121 |
|   102 | penetration                 |   120 |
|   222 | mouth                       |   119 |
|  2569 | crying                      |   118 |
|   572 | foot.fetish                 |   118 |
|  1887 | thai                        |   118 |
|  1686 | foursome                    |   117 |
|   358 | torture                     |   117 |
|   164 | com                         |   115 |
|  1691 | cum.in.face                 |   115 |
|  1121 | job                         |   114 |
|   495 | on                          |   114 |
|  3108 | searchforsandy1312posts     |   114 |
|   502 | caning                      |   113 |
|   537 | bikini                      |   113 |
|   556 | 3some                       |   112 |
|   940 | boots                       |   112 |
|   461 | roleplay                    |   111 |
|   433 | panties                     |   110 |
|   856 | asa.akira                   |   110 |
|   597 | gokkun                      |   110 |
|   587 | cum.on.ass                  |   109 |
|  1285 | czech                       |   109 |
|  2344 | kristina.rose               |   109 |
|   180 | pain                        |   109 |
|  1283 | tears                       |   109 |
|   301 | pornpros                    |   108 |
|  1372 | mf                          |   108 |
|  1276 | rope                        |   108 |
|   744 | nude                        |   107 |
|  3203 | chunky                      |   107 |
|  4212 | group.sex                   |   107 |
|   552 | toy                         |   106 |
|  3520 | no.condom                   |   105 |
|   161 | hardcore.ebony              |   105 |
|  4710 | atk                         |   105 |
|  4116 | japan                       |   105 |
|   541 | dvdrip                      |   103 |
|   505 | forced                      |   103 |
|    23 | throat                      |   103 |
|   450 | casting                     |   103 |
|  2854 | big.breasts                 |   102 |
|  1081 | girls                       |   102 |
|  4539 | forced.orgasm               |   102 |
|   710 | deepthroating               |   102 |
|   503 | foot                        |   102 |
|  1638 | cock                        |   102 |
|   526 | punk                        |   102 |
|   843 | doggie                      |   101 |
|   114 | point.of.view               |   101 |
|   370 | collection                  |   101 |
|   221 | in                          |   100 |
|   353 | comic                       |   100 |
|   784 | movies                      |   100 |
|  7341 | short.hair                  |   100 |
|   608 | wet                         |   100 |
|   267 | trans                       |    99 |
|    22 | deep                        |    99 |
|   802 | cougar                      |    99 |
|  3148 | interracial.blowjobs.facial |    98 |
|   501 | whipping                    |    97 |
| 11848 | kotr                        |    97 |
|   698 | huge                        |    97 |
|   790 | vaginal                     |    96 |
|  1420 | nurse                       |    96 |
|  2057 | tiny.tits                   |    96 |
|  2066 | bouncing.boobs              |    95 |
|  3048 | slim                        |    95 |
|   185 | revenge                     |    93 |
|  4054 | playboy                     |    93 |
|   854 | fchof                       |    92 |
|   951 | punishment                  |    92 |
|  2839 | manga                       |    92 |
|  4060 | bbc                         |    91 |
|   816 | feature                     |    91 |
|   596 | slut                        |    91 |
|  5088 | searchforishirogposts       |    91 |
|  4887 | all.sex                     |    90 |
|  1889 | english                     |    90 |
|   721 | private                     |    90 |
|   732 | rubber                      |    90 |
|  5728 | score                       |    90 |
|   747 | erotic                      |    89 |
|   588 | curvy                       |    89 |
|   464 | straight.sex                |    89 |
|   765 | strip                       |    88 |
|   413 | nylons                      |    88 |
|  1413 | breasts                     |    88 |
|  1534 | threesomes                  |    88 |
|   695 | gloryhole                   |    87 |
|   863 | handjob.to.completion       |    87 |
|   525 | goth                        |    86 |
|   105 | ggg                         |    86 |
|  4312 | double.anal                 |    85 |
|  2364 | big.dicks                   |    85 |
|   104 | older                       |    85 |
|  8464 | forced.orgasms              |    85 |
|   184 | gf                          |    85 |
|  1281 | choking                     |    84 |
|  3996 | phoenix.marie               |    83 |
|  8696 | mydadshotgirlfriend         |    83 |
|   678 | lactation                   |    83 |
|  1915 | cream.pie                   |    83 |
|  2939 | alexis.texas                |    83 |
|  3090 | pussy.eating                |    82 |
|  4083 | pawg                        |    82 |
|   489 | puke                        |    82 |
|  2130 | no.anal                     |    81 |
|   780 | fake                        |    81 |
|   424 | everythingbutt              |    81 |
|  1538 | 1280x720                    |    81 |
|  6872 | discipline                  |    81 |
|  3448 | cum.eating                  |    80 |
|   801 | butt                        |    80 |
|  3997 | chastity.lynn               |    80 |
|  1482 | pics                        |    80 |
|  1481 | submission                  |    79 |
|  6584 | bang.bros                   |    79 |
|  4430 | hd.porn                     |    79 |
|   914 | killergram                  |    78 |
|   405 | bubble.butt                 |    78 |
|  4748 | 540p                        |    78 |
|   560 | 21sextury                   |    78 |
|  2136 | painal                      |    78 |
|   264 | hardcore.big                |    77 |
|  2227 | x-art                       |    77 |
|  1652 | emo                         |    77 |
|   903 | beach                       |    77 |
|  3252 | lisa.ann                    |    76 |
|  4323 | ball.licking                |    76 |
|  5082 | abby                        |    76 |
|   886 | angel                       |    76 |
|  3466 | sperm                       |    76 |
|  2074 | buttplug                    |    76 |
|   237 | music.videos                |    76 |
|  2882 | gracie.glam                 |    76 |
|  2869 | jenna.haze                  |    75 |
+-------+-----------------------------+-------+

+-------+-----------------------------------+-------+
| TagID | Name                              | count |
+-------+-----------------------------------+-------+
|  2667 | lily.carter                       |    75 |
|  2095 | sloppy                            |    75 |
|  4158 | face.fuck                         |    75 |
|  1890 | sasha.grey                        |    75 |
|   846 | abuse                             |    75 |
|  5341 | oral.sex                          |    74 |
|  3796 | public.nudity                     |    74 |
|  2649 | girl.on.girl                      |    74 |
|  2646 | pegging                           |    74 |
|   685 | high                              |    74 |
|   290 | hogtied                           |    74 |
|   404 | booty                             |    74 |
|  4109 | face.fucking                      |    74 |
|  1752 | pussy.licking                     |    74 |
|   362 | nylon                             |    74 |
|   188 | reality                           |    73 |
|  4972 | lily.labeau                       |    73 |
|  2347 | amy.brooke                        |    73 |
|  1522 | bang                              |    72 |
|   313 | school                            |    72 |
|   913 | to                                |    72 |
|   355 | fantasy                           |    71 |
|  4277 | tori.black                        |    71 |
|  1718 | photos                            |    71 |
|  4324 | black.hair                        |    71 |
|  4535 | thick                             |    71 |
|   119 | college                           |    71 |
|  2349 | manuel.ferrara                    |    71 |
|   509 | party                             |    70 |
|  3910 | red.head                          |    70 |
|  5711 | ass.smacking                      |    69 |
|  1501 | 3d                                |    69 |
|   847 | facesitting                       |    69 |
|   466 | big.but                           |    69 |
|   431 | maledom                           |    69 |
|  1509 | skin.diamond                      |    69 |
|   604 | rose                              |    69 |
|   262 | realitykings                      |    69 |
|   429 | anal.fisting                      |    69 |
|  4808 | culioneros                        |    68 |
|   508 | rocco                             |    68 |
|  2955 | rocco.siffredi                    |    68 |
|  2718 | dana.dearmond                     |    68 |
| 13550 | sucker1                           |    67 |
|  1899 | lactating                         |    67 |
|  2034 | striptease                        |    67 |
|   491 | bigtits                           |    67 |
|  1801 | tied                              |    67 |
|  4483 | no.toys                           |    67 |
|  1265 | the                               |    67 |
|  1251 | leather                           |    66 |
|  1763 | 2on1                              |    66 |
|   394 | blondes                           |    65 |
| 11908 | freeleech                         |    65 |
|  8640 | huge.boobs                        |    65 |
|  5172 | shemale.on.female                 |    65 |
|    83 | model                             |    65 |
|  5176 | girlfriends.films                 |    65 |
|  2906 | cum.swapping                      |    65 |
|   227 | foreign                           |    64 |
|  6919 | publicdisgrace                    |    64 |
|   580 | legs                              |    64 |
|   302 | eva.angelina                      |    64 |
|   684 | preggo                            |    64 |
|  1228 | dick                              |    64 |
|  3393 | mofos                             |    64 |
|  5124 | india.summer                      |    64 |
|   426 | strap-on                          |    63 |
|  6592 | multiple.cumshots                 |    63 |
|  3441 | nacho.vidal                       |    63 |
|  2123 | jules.jordan                      |    63 |
|    47 | office                            |    63 |
|   720 | legal                             |    63 |
|  4514 | playmates                         |    63 |
|  4311 | dap                               |    63 |
|  2164 | facefuck                          |    63 |
|   166 | diaper                            |    63 |
|  1226 | sasha                             |    63 |
|   266 | dvdr                              |    63 |
|  2346 | chanel.preston                    |    62 |
|  1831 | cam                               |    62 |
|  6237 | widescreen                        |    62 |
|   357 | comix                             |    62 |
|  7397 | francesca.le                      |    62 |
|   700 | suck                              |    62 |
|  3447 | cum.shot                          |    62 |
|  1895 | indian                            |    61 |
|  4697 | public.disgrace                   |    61 |
| 10324 | standard.definition               |    61 |
|  1537 | picset                            |    61 |
|   656 | wife                              |    61 |
|   791 | tgirl                             |    61 |
|   137 | watersports                       |    61 |
|  2725 | mother                            |    61 |
|  2285 | prolapse                          |    61 |
|  3313 | girls.do.porn                     |    60 |
|  1643 | fishnet                           |    60 |
|   441 | teacher                           |    60 |
|    79 | shit                              |    60 |
|  2856 | school.girl                       |    60 |
|  2367 | penthouse                         |    60 |
|  5270 | amwf                              |    59 |
|   373 | suspension                        |    59 |
|   745 | art                               |    59 |
|  2643 | cosplay                           |    59 |
|  4272 | kagney.linn.karter                |    59 |
|  2345 | katsuni                           |    59 |
|  4768 | split.scene                       |    59 |
|   817 | plot                              |    59 |
|  5590 | gianna.michaels                   |    58 |
|   238 | music.video                       |    58 |
|   434 | teasing                           |    58 |
|  1928 | couples                           |    58 |
|   438 | gang                              |    58 |
|  8470 | titty.fucking                     |    58 |
|    94 | doggy.style                       |    58 |
|  1844 | sensual                           |    58 |
|   771 | slapping                          |    58 |
|  1756 | fist                              |    57 |
|  2936 | brooklyn.lee                      |    57 |
|  3206 | vomit                             |    57 |
|  1298 | doctor                            |    57 |
|   460 | one-on-one                        |    57 |
|   938 | pack                              |    57 |
|  1539 | joymii                            |    57 |
|   476 | tiffany                           |    56 |
|  1761 | italian                           |    56 |
|  5588 | elegant.angel                     |    56 |
|     9 | mom                               |    56 |
|  3468 | sophie.dee                        |    56 |
|  2580 | pale                              |    56 |
|   917 | bisexual                          |    56 |
|  4280 | london.keyes                      |    55 |
|  5157 | facial.abuse                      |    55 |
|  2703 | julia.ann                         |    55 |
|  4355 | jennifer.white                    |    55 |
|   928 | pool                              |    54 |
|  2026 | spitting                          |    54 |
|  2930 | jynx.maze                         |    54 |
|  4278 | katja.kassin                      |    54 |
|   760 | xxx                               |    54 |
|   191 | love                              |    54 |
|  8909 | scoreland                         |    53 |
|  1920 | isis.love                         |    53 |
| 14300 | cybernet                          |    53 |
|  2120 | interview                         |    53 |
|  5666 | bf.wm                             |    53 |
|   392 | groupsex                          |    53 |
|  4290 | jayden.jaymes                     |    53 |
|   369 | videos                            |    53 |
|  3882 | james.deen                        |    53 |
|  4294 | tory.lane                         |    53 |
|  2943 | nicole.aniston                    |    52 |
|  4149 | belladonna                        |    52 |
|  8785 | cum.covered.faces                 |    52 |
|  4203 | fmm                               |    52 |
|  1011 | shemale.on.shemale                |    52 |
|  8185 | tittyfuck                         |    52 |
|  3880 | faye.reagan                       |    52 |
|   564 | game                              |    52 |
|   916 | closeup                           |    52 |
|   614 | porn                              |    52 |
|  1300 | speculum                          |    52 |
|  3920 | tit.fucking                       |    52 |
|  4508 | joi                               |    52 |
|  1354 | outside                           |    52 |
|  1447 | blindfold                         |    51 |
| 15572 | t-girls.on.film                   |    51 |
|  4167 | hungarian                         |    51 |
|   423 | amber.rayne                       |    51 |
|  1700 | mistress                          |    51 |
|   239 | music                             |    51 |
|  4691 | jigsawhb                          |    51 |
|  1260 | insertion                         |    51 |
|  4895 | xvid                              |    51 |
|  3236 | magazines                         |    51 |
|    12 | daughter                          |    51 |
|  1271 | corset                            |    51 |
|  3126 | interracial.blowjobs.bukkake.gang |    51 |
|  5805 | voluptuous                        |    51 |
| 10563 | anissa.kate                       |    51 |
|  2515 | krissy.lynn                       |    51 |
|  5585 | trannypack.com                    |    51 |
|  6623 | belly                             |    51 |
|   899 | couple                            |    51 |
|  3127 | bang.facial                       |    51 |
|   892 | vintage                           |    51 |
|   337 | cfnm                              |    51 |
|  5526 | cum.swallowing                    |    50 |
|   498 | male                              |    50 |
|  1327 | julia                             |    50 |
|  1224 | megan                             |    50 |
|  7428 | otk                               |    50 |
|  1797 | whippedass                        |    50 |
|   407 | face.sitting                      |    50 |
|  4002 | jessie.rogers                     |    50 |
|   482 | dicks                             |    50 |
| 12416 | doggstyle                         |    50 |
|    42 | hidden                            |    50 |
|  4448 | uk                                |    49 |
+-------+-----------------------------------+-------+

 */
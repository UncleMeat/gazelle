<?php
function can_bookmark($Type)
{
    return in_array($Type, array('torrent', 'collage', 'request'));
}

function bookmarks_header_link($SortKey, $DefaultWay = "desc")
{
    global $Type, $OrderBy, $OrderWay;
    if ($SortKey == $OrderBy) {
        if ($OrderWay == "desc") {
            $NewWay = "asc";
        } else {
            $NewWay = "desc";
        }
    } else {
        $NewWay = $DefaultWay;
    }

    return "bookmarks.php?type=$Type&amp;order_way=$NewWay&amp;order_by=$SortKey&amp;" . get_url(array('action', 'order_way', 'order_by'));
}

// Recommended usage:
// list($Table, $Col) = bookmark_schema('torrent');
function bookmark_schema($Type)
{
    switch ($Type) {
        case 'torrent':
            return array('bookmarks_torrents', 'GroupID');
            break;
        case 'collage':
            return array('bookmarks_collages', 'CollageID');
            break;
        case 'request':
            return array('bookmarks_requests', 'RequestID');
            break;
        default:
            die('HAX');
    }
}

function has_bookmarked($Type, $ID)
{
    return in_array($ID, all_bookmarks($Type));
}

function all_bookmarks($Type, $UserID = false)
{
    global $DB, $Cache, $LoggedUser;
    if ($UserID === false) { $UserID = $LoggedUser['ID']; }
    $CacheKey = 'bookmarks_'.$Type.'_'.$UserID;
    if (($Bookmarks = $Cache->get_value($CacheKey)) === FALSE) {
        list($Table, $Col) = bookmark_schema($Type);
        $DB->query("SELECT $Col FROM $Table WHERE UserID = '$UserID'");
        $Bookmarks = $DB->collect($Col);
        $Cache->cache_value($CacheKey, $Bookmarks, 0);
    }

    return $Bookmarks;
}

<?php
// The "order by x" links on columns headers
function header_link($SortKey, $DefaultWay="desc", $Anchor="")
{
    global$Document, $OrderBy, $OrderWay;
    if ($SortKey==$OrderBy) {
        if ($OrderWay=="desc") {
            $NewWay="asc";
        } else {
            $NewWay="desc";
        }
    } else {
        $NewWay=$DefaultWay;
    }
    return "$Document.php?order_way=$NewWay&amp;order_by=$SortKey&amp;".get_url(array('order_way', 'order_by')).$Anchor;
}
?>

<?
enforce_login();

include(SERVER_ROOT.'/classes/class_text.php');
$Text = new TEXT;

if (isset($_REQUEST['topic'])) {
    $TopicID = db_string($_REQUEST['topic']);
} else {
    error(404);
}

if (empty($Page)) {
    $DB->query("SELECT Category, Title, Body, Time FROM articles WHERE TopicID='$TopicID'");
    if (!list($Category, $Title, $Body, $Time) = $DB->next_record()) {
        error(404);
    }
}

$Body = $Text->full_format($Body);

// Deal with special article tags.
if (preg_match("/\[clientlist\]/i", $Body)) {
    if (!$WhitelistedClients = $Cache->get_value('whitelisted_clients')) {
        $DB->query('SELECT vstring FROM xbt_client_whitelist WHERE vstring NOT LIKE \'//%\' ORDER BY vstring ASC');
        $WhitelistedClients = $DB->to_array(false,MYSQLI_NUM,false);
        $Cache->cache_value('whitelisted_clients',$WhitelistedClients,604800);
    }

    $list = '<table cellpadding="5" cellspacing="1" border="0" class="border" width="100%">
                <tr class="colhead">
        		<td style="width:150px;"><strong>Allowed Clients</strong></td>
		</tr>';                                        

    $Row = 'a';
    foreach($WhitelistedClients as $Client) {
        //list($ClientName,$Notes) = $Client;
        list($ClientName) = $Client;
        $Row = ($Row == 'a') ? 'b' : 'a';
        $list .= "<tr class=row$Row>
                        <td>$ClientName</td>
                  </tr>";
    }
    $list .= "</table>";
    $Body = preg_replace("/\[clientlist\]/i", $list, $Body);
}

show_header($Page['Topic'], 'browse,overlib');
?>

<div class="thin">
    <h2 class="center"><?= $Title ?></h2>
    <div class="box pad" style="padding:10px 10px 10px 20px;">
        <?=$Body?>
    </div>

<h3 id="jump">Other <?=strtolower($ArticleCats[$Category])?></h3>
<div class="box pad" style="padding:10px 10px 10px 20px;">
	<table width="100%">
		<tr class="colhead">
			<td style="width:150px;">Title</td>
			<td style="width:400px;">Additional Info</td>
		</tr>
<?
    $Row = 'a';
    $DB->query("SELECT TopicID, Title, Description FROM articles WHERE Category='$Category' AND TopicID<>'$TopicID'");
    while(list($TopicID, $Title, $Description) = $DB->next_record()) {
        $Row = ($Row == 'a') ? 'b' : 'a';
?>
		<tr class="row<?=$Row?>">

                        <td class="nobr">
				<a href="articles.php?topic=<?=$TopicID?>"><?=$Title?></a>
			</td>
			<td class="nobr">
				<?=$Description?>
			</td>
		</tr>
<?  } ?>
        </table>
</div>
    
</div>


<?
show_footer();

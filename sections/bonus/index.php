<?
enforce_login();
show_header('Bonus Shop');

if(empty($_REQUEST['actionID'])) { $_REQUEST['actionID']=''; }

$ActionID = $_REQUEST['actionID'];


include(SERVER_ROOT.'/sections/bonus/functions.php');
$ShopItems = get_shop_items();
//$LoggedUser['LastBonusTime'] = time();
?>
<div class="thin">
	<h2>Bonus Shop</h2>
		<div class="box pad">
                <h3 class="center">You have <?=$LoggedUser['Credits']?> credits to spend</h3> 
                <p class="center">Next bonus update: <?=strftime("%e %b %Y  %r", strtotime("+1 week", $LoggedUser['LastBonusTime']))?></p>
            </div>
            <br/>
		<table>
			<tr class="colhead">
				<td width="150px">Title</td>
				<td width="490px">Description</td>
				<td width="50px">Price</td>
				<td width="50px">Buy</td>
			</tr>
<?
	$Row = 'a';
	foreach($ShopItems as $BonusItem) {
		list($ItemID, $Title, $Description, $Action, $Value, $Cost) = $BonusItem;
            $CanAfford = is_number($LoggedUser['Credits']) ? $LoggedUser['Credits'] >= $Cost: false;
		$Row = ($Row == 'a') ? 'b' : 'a';
?> 
			<tr class="row<?=$Row.($CanAfford ? ' itembuy' : ' itemnotbuy')?>">
				<td><strong><?=display_str($Title) ?></strong></td>
				<td><?=display_str($Description) ?></td>
				<td><strong><?=display_str($Cost) ?>c</strong></td>
				<td>
                            <form method="post" action="">  
                                <input type="hidden" name="actionID" value="<?=$ItemID?>" />
                                <input type="hidden" name="otheruser" value="" />
                                <input class="shopbutton" name="submit" value="<?=($CanAfford?'Buy':'x')?>" type="submit"<?=($CanAfford ? '' : ' disabled="disabled"')?> />
                            </form>
				</td>
			</tr>
<?	} ?>
		</table>
	
</div>
<?
show_footer();
?>

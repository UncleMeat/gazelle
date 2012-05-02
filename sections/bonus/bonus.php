<?
enforce_login();
show_header('Bonus Shop');

$ShopItems = get_shop_items();
?>
<div class="thin">
	<h2>Bonus Shop</h2>
 <?         if(!empty($_REQUEST['result'])){  ?>
                <div class="box pad">
                    <h3 class="center"><?=display_str($_REQUEST['result'])?></h3> 
                </div>
<?          }  ?>
            
		<div class="box pad">
                <h3 class="center">You have <?=$LoggedUser['Credits']?> credits to spend</h3> 
             <? //   <p class="center">Next bonus update: <?=get_next_bonus_update($LoggedUser['LastBonusTime'])?\></p> ?>
            </div>
            
		<table>
			<tr class="colhead">
				<td width="120px">Title</td>
				<td width="530px">Description</td>
				<td width="90px" colspan="2">Price</td>
				<!--<td width="50px"></td>-->
			</tr>
<?
	$Row = 'a';
	foreach($ShopItems as $BonusItem) {
		list($ItemID, $Title, $Description, $Action, $Cost) = $BonusItem;
            $CanAfford = is_number($LoggedUser['Credits']) ? $LoggedUser['Credits'] >= $Cost: false;
		$Row = ($Row == 'a') ? 'b' : 'a';
?> 
			<tr class="row<?=$Row.($CanAfford ? ' itembuy' : ' itemnotbuy')?>">
				<td width="120px"><strong><?=display_str($Title) ?></strong></td>
				<td width="530px"><?=display_str($Description) ?></td>
				<td width="40px" style="text-align: center;"><strong><?=display_str($Cost) ?>c</strong></td>
				<td width="50px" style="text-align: center;">
                            <form method="post" action="">  
                                <input type="hidden" name="action" value="buy" />
                                <input type="hidden" id="othername<?=$ItemID?>" name="othername" value="" />
                                <input type="hidden" name="shopaction" value="<?=$Action?>" />
                                <input type="hidden" name="userid" value="<?=$LoggedUser['ID']?>" />
                                <input type="hidden" name="auth" value="<?=$LoggedUser['AuthKey']?>" />
                                <input type="hidden" name="itemid" value="<?=$ItemID?>" />
                                <input <?=(strpos($Action, 'give') !==false ? 'onclick="SetUsername(\'othername'.$ItemID.'\'); "':'')?>class="shopbutton<?=($CanAfford ? ' itembuy' : ' itemnotbuy')?>" name="submit" value="<?=($CanAfford?'Buy':'x')?>" type="submit"<?=($CanAfford ? '' : ' disabled="disabled"')?> />
                            </form>
    <script type="text/javascript">
        function SetUsername(itemID){
            var name= prompt("Enter the username of the person you wish to give a gift to")
            if (name!=null && name!="") {
                $('#' + itemID).raw().value = name;
            }
        }
    </script>
				</td>
			</tr>
<?	} ?>
		</table>
            <div class="box pad" style="max-width: 100%; margin: 35px auto 5px;">
                <h3>What is a credit?</h3>
                <p>Credits are distributed on a weekly basis as a bonus to people who have seeded torrents during that week. You can find your total credit amount and the next credit update at the top of this page, or on your user details page.</p><br/>
                <h4>How is the credit calculated?</h4>
                <p>You get 1.0 credit for every 1 hour of every torrent you seed. Every torrent is counted, so 2 torrents seeded for 1 hour will give you 2 credits etc.<br/>No credits are awarded for leeching torrents.</p>
                <h4>Okay!</h4>
                If you seed...<br/>
                ...1 torrent for 10 hours, you will get 10 credits.<br/>
                ...5 torrents for 20 hours, you will get 100 credits.<br/>
                ...10 torrents 24/7 for a week, you will get 1680 credits.<br/>
                ...60 torrents 24/7 for a week, you will get 10,080 credits.<br/>
                but no more than 60 torrents at once are counted; some users may abuse :P
            </div>
</div>
<?
show_footer();
?>

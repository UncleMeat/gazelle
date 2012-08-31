<?
include(SERVER_ROOT.'/classes/class_text.php');
$Text = new TEXT;

enforce_login();
show_header('Bonus Shop','bonus');
  
            
$ShopItems = get_shop_items($LoggedUser['ID']);
?>
<div class="thin">
	<h2>Bonus shop</h2>
            <div class="box pad shadow">
                <h3>What is a credit?</h3>
                <p>Credits are distributed as a bonus to people who are seeding torrents. You can find your total credit amount at the top of this page, or on your user details page.</p><br/>
                <h4>How is the credit calculated?</h4>
<? 
                $creditinfo = get_article('creditsinline');
                if($creditinfo) echo $Text->full_format($creditinfo, true); 
 
                /*
                <p>You get 0.25 credits for every 15 minutes of every torrent you seed. Every torrent is counted, so 2 torrents seeded for 1 hour will give you 2 credits etc.<br/>No credits are awarded for leeching torrents.</p>
                <h4>Okay!</h4>
                If you seed...<br/>
                ...1 torrent for 10 hours, you will get 10 credits.<br/>
                ...5 torrents for 20 hours, you will get 100 credits.<br/>
                ...10 torrents 24/7 for a week, you will get 1680 credits.<br/>
                ...60 torrents 24/7 for a week, you will get 10,080 credits.<br/>
                but no more than 60 torrents at once are counted; some users may abuse :P */
                    
?>
            </div>
 <?         if(!empty($_REQUEST['result'])){  ?>
                <div class="box pad">
                    <h3 class="center"><?=display_str($_REQUEST['result'])?></h3> 
                </div>
<?          }  ?>
            
	<div class="head">Bonus Shop</div>
            
		<table class="bonusshop">
			<tr class="smallhead">
				<td width="120px">Title</td>
				<td width="530px" colspan="2">Description</td>
				<td width="90px" colspan="2">Price</td>
			</tr>
<?
	$Row = 'a';
      $UserBadgeIDs = get_user_shop_badges_ids($LoggedUser['ID']);
	foreach($ShopItems as $BonusItem) {
		list($ItemID, $Title, $Description, $Action, $Value, $Cost, $Image, $Badge, $Rank, $UserRank) = $BonusItem;
            $IsBadge = $Action=='badge'; 
            $IsBuyGB = $Action=='gb'; 
            $DescExtra='';
            // if user already has badge item dont allow buy
            if ($IsBadge && in_array($Value, $UserBadgeIDs)) {
                $CanBuy = false;
                $BGClass= ' itemduplicate';
            } elseif ($IsBuyGB && $LoggedUser['BytesDownloaded'] <=0) {
                $CanBuy = false;
                $BGClass= ' itemnotbuy';
            } else { //
                $CanBuy = is_float((float)$LoggedUser['Credits']) ? $LoggedUser['Credits'] >= $Cost: false;
                $BGClass= ($CanBuy?' itembuy' :' itemnotbuy');
                if ($IsBuyGB && $LoggedUser['BytesDownloaded'] < get_bytes($Value.'gb') ) {
                    $DescExtra = "<br/>(WARNING: will only remove ".get_size($LoggedUser['BytesDownloaded']) .")"; // get_size(get_bytes($Value.'gb') - 
                }
                if($IsBadge ) {
                    if ($LastBadge==$Badge) {
                        $CanBuy = false;
                        $BGClass = ' itemnotbuy';
                    } elseif($Rank < $UserRank) {
                        $CanBuy = false;
                        $BGClass = ' itemduplicate';
                    } else 
                        $LastBadge=$Badge;
                }
            }
		$Row = ($Row == 'a') ? 'b' : 'a';
?> 
			<tr class="row<?=$Row.$BGClass?>">
				<td width="160px"><strong><?=display_str($Title) ?></strong></td>
				<td style="border-right:none;" <? if(!$Image) { echo 'colspan="2"'; } ?>><?=display_str($Description).$DescExtra?></td>
                    <?  if ($Image) {  ?>
                        <td style="border-left:none;width:160px;text-align:center;">
                            <div class="badge">
                                <img src="<?=STATIC_SERVER.'common/badges/'.$Image?>" title="<?=$Title?>" alt="<?=$Title?>" />
                            </div>
                        </td>
                   <?   } ?>
				<td width="60px" style="text-align: center;"><strong><?=number_format($Cost) ?>c</strong></td>
				<td width="60px" style="text-align: center;">
                            <form method="post" action="">  
                                <input type="hidden" name="action" value="buy" />
                                <input type="hidden" id="othername<?=$ItemID?>" name="othername" value="" />
                                <input type="hidden" name="shopaction" value="<?=$Action?>" />
                                <input type="hidden" name="userid" value="<?=$LoggedUser['ID']?>" />
                                <input type="hidden" name="auth" value="<?=$LoggedUser['AuthKey']?>" />
                                <input type="hidden" name="itemid" value="<?=$ItemID?>" />
                                <input <?=(strpos($Action, 'give') !==false ? 'onclick="SetUsername(\'othername'.$ItemID.'\'); "':'')?><?=($Action == 'title' ? 'onclick="SetTitle(\'title'.$ItemID.'\'); "':'')?>class="shopbutton<?=($CanBuy ? ' itembuy' : ' itemnotbuy')?>" name="submit" value="<?=($CanBuy?'Buy':'x')?>" type="submit"<?=($CanBuy ? '' : ' disabled="disabled"')?> />
                                <?=($Action == 'title' ? '<input type="hidden" id="title'.$ItemID.'" name="title" value="" />':'')?>
                            </form>
				</td>
			</tr>
<?	} ?>
		</table> 
</div>
<?
show_footer();
?>

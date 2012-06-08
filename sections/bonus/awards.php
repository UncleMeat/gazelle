<?
enforce_login();
show_header('Medals and Awards');
  
$DB->query("SELECT b.Name, b.Type, b.Description, b.Cost, b.Image, 
                (CASE WHEN Type='Shop' THEN 0 
                      WHEN ba.ID IS NOT NULL THEN 1
                      ELSE 2 
                 END) AS Sorter
              FROM badges AS b
              LEFT JOIN badges_auto AS ba ON b.ID=ba.BadgeID
              WHERE ba.ID IS NULL OR ba.Active = 1
              ORDER BY Sorter, b.Sort"); // b.Type,

$Awards = $DB->to_array(false, MYSQLI_BOTH);


?>

<div class="thin">
	<h2>Medals and Awards</h2>
<?
	$Row = 'a';
      $LastType='';
	foreach($Awards as $Award) {
		list($Name, $Type, $Desc, $Cost, $Image, $Sorter) = $Award;
           
            if ($LastType != $Sorter) {     // && $Type != 'Unique'){
                if ($LastType!=''){  ?>
      </div>
<?
                }
?>
      <div class="box" style="width:40%;float:right;margin:0 4% 20px 4%;display:inline-block;">
            <div class="colhead pad">
                <?  
                switch($Sorter){
                    case 0:
                        echo "Medals available for purchase in the bonus shop";
                        break;
                    case 1:
                        echo "Medals automatically awarded by the system";
                        break;
                    case 2:
                        echo "Medals awarded by the staff";
                        break;
                }
                ?>
            </div>
<?             
                $Row = 'a';
                $LastType=$Sorter;
            }
            
		$Row = ($Row == 'a') ? 'b' : 'a';
?> 
		<div class="row<?=$Row?> pad">
                <h3 class="pad" style="float:left;"><?=display_str($Name)?></h3>
<?              if ($Cost) echo '<strong style="float:right;margin-top:2px;">Cost: '.number_format($Cost).'</strong>'; ?>
                <div class="badge" style="width:100%;height:40px;clear:both;">
                    <img style="text-align:center" src="<?=STATIC_SERVER.'common/badges/'.$Image?>" title="<?=$Desc?>" alt="<?=$Name?>" />
                </div>
                <div class="pad" style="width:100%;">
                    <p><?=$Desc?></p>
<?              if ($Sorter==2) echo "<p style=\"float:right;margin-right:20px;\">$Type</p>";  ?>
                </div>
		</div>
<?	}  ?>
	</div>
</div>

<?




show_footer();







/*
?>
<div class="thin">
	<h2>Medals and Awards</h2>
            <div class="box pad" style="max-width: 100%; margin: 35px auto 5px;border: 4px solid green">
                <h3>What is a  ?</h3>
               
            </div>
            
            
                  
<?
	$Row = 'a';
      $LastType='';
	foreach($Awards as $Award) {
		list($ID, $Name, $Type, $Action, $Desc, $Cost, $Image, $Active) = $Award;
           
            if ($LastType != $Type && $Type != 'Unique'){
                if ($LastType==''){
                    ?>
            </table>
      <?
                }
?>
		<table class="bonusshop">
               
			<tr class="colhead">
				<td width="200px"></td>
				<td width="100%"><?=$Type?></td>
			</tr> 
                
<?             
                $LastType=$Type;
            }
            
		$Row = ($Row == 'a') ? 'b' : 'a';
?> 
			<tr class="row<?=$Row?>">
				<td>
                            <div class="badge">
                                <img src="<?=STATIC_SERVER.'common/badges/'.$Image?>" title="<?=$Desc?>" alt="<?=$Name?>" />
                            </div>
                        </td>
				<td>
                            <h3><?=display_str($Name)?></h3>
                            <p><strong>type: <?=$Type?></strong>  action: <?=$Action?>  cost: <?=number_format($Cost)?>  </p>
                            <p><?=$Desc?></p>
                        </td>
				 
			</tr>
<?	}  ?>
		</table>
</div>
<?
*/

?>

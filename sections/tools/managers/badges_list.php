<?
if(!check_perms('site_manage_badges')) { error(403); }
 
// get all images in badges directory for drop down
$imagefiles = scandir(STATIC_SERVER.'common/badges');
$imagefiles= array_diff($imagefiles, array('.','..'));


function print_select_image($ElementID, $CurrentImage=''){
    global $imagefiles;
?>
    <select name="image" id="imagesrc<?=$ElementID?>" onchange="Select_Image(<?=$ElementID?>)" title="Select Image">
<?      foreach ($imagefiles as $image) {    ?>
            <option value="<?=$image?>"<?=($image==$CurrentImage?' selected="selected"':'')?>><?=$image?>&nbsp;</option>
<?      } ?>
    </select>
<?
}

show_header('Badges','badges');

?>
<div class="thin">
<h2>Badges</h2>
<table>
    <tr>
        <td colspan="9" class="head">Add badge</td>
    </tr> 
    <tr class="colhead">
		<td width="50px" rowspan="2">Image</td>
		<td>Title</td>
		<td colspan="5">Description</td>
		<td width="60px" rowspan="2"></td>
    </tr>
    <tr class="colhead">
		<td width="260px">Select Image</td>
		<td width="18%">Badge Set</td>
		<td width="12%">Rank</td>
		<td width="12%">Sort</td>
		<td width="80px">Type</td>
		<td width="12%">Cost</td>
    </tr> 
    <form action="tools.php" method="post">
            <input type="hidden" name="action" value="badges_alter" />
            <input type="hidden" name="auth" value="<?=$LoggedUser['AuthKey']?>" />
            <input type="hidden" name="id" value="<?=$ID?>" />
                
        <tr class="rowb">
		<td rowspan="2" class="center" id="image0" style="vertical-align: top;width:40px"> <a id="<?=$ID?>"></a>
                <img src="<?=STATIC_SERVER.'common/badges/'.$Image?>" title="<?=$Image?>" alt="<?=$Image?>" />
            </td>
		<td>
			<input class="medium" type="text" name="title" value="new title"  title="Title"/>
		</td>
		<td colspan="5">
			<input class="long" type="text" name="desc" value="awarded for XXXXXX. This user has doneY/achievedZ"  title="Description"/>
		</td>
		<td rowspan="2">
			<input type="submit" value="Create" />
		</td>
            
        </tr>
        <tr class="rowb">
		<td>
<?                  print_select_image(0); ?> 
		</td>
		<td>
			<input class="medium" type="text" name="badge" value="new set" title="Set Name (Users can only have one badge from a set, rank determines which badge replaces which when awarded)"/>
		</td>
		<td>
			<input class="medium" type="text" name="rank" value="1" title="Rank (Within a set badges with a higher rank will displace badges with a lower rank)"/>
		</td>
		<td>
			<input class="medium" type="text" name="sort" value="0" title="Sort"/>
		</td>
		<td>
                <select name="type"  title="Badge Type">
<?                  foreach ($BadgeTypes as $valtype) {   ?>
                        <option value="<?=$valtype?>"><?=$valtype?>&nbsp;&nbsp;</option>
<?                  } ?>
                </select>
		</td>
		<td>
			<input class="medium" type="text" name="cost" value="" title="Cost (Only used if item is a shop item)"/>
		</td>
        </tr>
    </form>
</table>



<br/><br/>
<div class="box pad">
    <h3>Image</h3>
    <ul><li>Images are listed from the common/badges/ directory</li></ul>
    <h3>Type</h3>
    <ul>
        <li>Unique   = Can only be awarded to one user on the site at once.</li>
        <li>Single   = Can be awarded once to each user ** Only single type badges can be selected to be awarded automatically.</li>
        <li>Multiple = Can be awarded multiple times to each user.</li>
        <li>Shop     = Can be bought in the shop *** (needs a seperate entry in bonus_shop_actions to appear in shop - this value is used to both build that entry automatically and filters the entry from other actions.</li>
    </ul>
    All badges except those with 'Shop' type can be awarded by staff (who have 'users_edit_badges' permission)<br /><br />
    <h3>Sort</h3>
    <ul><li>the sort order defines what order badges are displayed in on a users profile and posts</li></ul>
    <h3>Please Note</h3>
    <ul>
        <li>Deleting an award will remove it from all the users who currently have the award.</li>
        <li>To set up automatic awards use the <a href="/tools.php?action=awards_auto">Automatic Awards Manager</a></li>
        <li>To add 'shop' type badges to the shop use the <a href="/tools.php?action=shop_list">Bonus Shop Manager</a></li>
    </ul>
</div><br/>
<div class="head">available images<span style="float:right;"><a href="#" onclick="$('#badgeimages').toggle(); this.innerHTML=(this.innerHTML=='(Hide)'?'(View)':'(Hide)'); return false;">(View)</a></span></div>
<div id="badgeimages" class="box pad hidden">
<?      foreach ($imagefiles as $image) {    ?>
    <div style="display: inline-block;margin: 3px;">
        <img src="<?=STATIC_SERVER.'common/badges/'.$image?>" title="<?=$image?>" alt="<?=$image?>" />
        <br/><?=$image?>
    </div>
<?      } ?>
</div>
<br/>
<table>
    
    <tr class="colhead">
		<td width="10px" rowspan="2">ID</td>
		<td width="40px" rowspan="2">Image</td>
		<td>Title</td>
		<td colspan="5">Description</td>
		<td width="60px" rowspan="2"></td>
    </tr>
    <tr class="colhead">
		<td width="260px">Select Image</td>
		<td width="18%">Badge Set</td>
		<td width="12%">Rank</td>
		<td width="12%">Sort</td>
		<td width="80px">Type</td>
		<td width="12%">Cost</td>
    </tr> 
<? 

$DB->query("SELECT ID, Badge, Rank, Type, Sort, Cost, Title, Description, Image
              FROM badges ORDER BY Sort, Rank");

while(list($ID, $Badge, $Rank, $Type, $Sort, $Cost, $Title, $Description, $Image) = $DB->next_record()){
    $Row = ($Row === 'a' ? 'b' : 'a');  
?>
    <form action="tools.php" method="post">
            <input type="hidden" name="action" value="badges_alter" />
            <input type="hidden" name="auth" value="<?=$LoggedUser['AuthKey']?>" />
            <input type="hidden" name="id" value="<?=$ID?>" />
               
        <tr class="rowb" style="border-top: 1px solid;">
		<td rowspan="2" style="vertical-align: top">
			<a id="<?=$ID?>"></a>#<?=$ID?>
		</td>
		<td  rowspan="2" class="center" id="image<?=$ID?>">
                <img src="<?=STATIC_SERVER.'common/badges/'.$Image?>" title="<?=$Image?>" alt="<?=$Image?>" />
            </td>
		<td>
			<input class="medium" type="text" name="title" value="<?=display_str($Title)?>" title="Title"/>
		</td>
		<td colspan="5">
			<input class="long" type="text" name="desc" value="<?=display_str($Description)?>" title="Description"/>
		</td>
		<td rowspan="2">
                <input type="submit" name="submit" value="Edit" />
                <input type="submit" name="submit" value="Delete" />
		</td>
        </tr>
        <tr class="rowb">
		<td >
<?                  print_select_image($ID, $Image); ?> 
		</td>
		<td>
			<input class="medium" type="text" name="badge" value="<?=display_str($Badge)?>" title="Set Name (Users can only have one badge from a set, rank determines which badge replaces which when awarded)"/>
		</td>
		<td>
			<input class="medium" type="text" name="rank" value="<?=display_str($Rank)?>" title="Rank (Within a set badges with a higher rank will displace badges with a lower rank)"/>
		</td>
		<td>
			<input class="medium" type="text" name="sort" value="<?=display_str($Sort)?>" title="Sort"/>
		</td>
		<td>
                <select name="type" title="Badge Type">
<?                  foreach ($BadgeTypes as $valtype) {   ?>
                        <option value="<?=$valtype?>"<?=($valtype==$Type?' selected="selected"':'')?>><?=$valtype?>&nbsp;&nbsp;</option>
<?                  } ?>
                </select>
		</td>
		<td>
			<input class="medium" type="text" name="cost" value="<?=display_str($Cost)?>" title="Cost (Only used if item is a shop item)"/>
		</td>
        </tr>
        <tr class="rowa"><td colspan="9" class="noborder"></td></tr>
    </form>
<? }  ?>
</table>
</div>
<? show_footer(); ?>

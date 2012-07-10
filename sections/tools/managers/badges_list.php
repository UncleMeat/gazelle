<?
if(!check_perms('site_manage_badges')) { error(403); }
 
// get all images in badges directory for drop down
$imagefiles = scandir(STATIC_SERVER.'common/badges');
$imagefiles= array_diff($imagefiles, array('.','..'));


function print_select_image($ElementID, $CurrentImage=''){
    global $imagefiles;
?>
    <select name="image" id="imagesrc<?=$ElementID?>" onchange="Select_Image(<?=$ElementID?>)">
<?      foreach ($imagefiles as $image) {    ?>
            <option value="<?=$image?>"<?=($image==$CurrentImage?' selected="selected"':'')?>><?=$image?>&nbsp;&nbsp;</option>
<?      } ?>
    </select>
<?
}

show_header('Badges','badges');

?>
<h2>Badges</h2>
<div>
<table>
    <tr>
        <td colspan="9" class="colhead">Add badge</td>
    </tr>
    <tr class="colhead">
		<td width="40px"></td>
		<td width="100px">Select Image</td>
		<td width="120px">Name</td>
		<td>Description</td>
		<td width="30px">Sort</td>
		<td width="80px">Type</td>
		<td width="70px">Cost</td>
		<td width="120px"></td>
    </tr>
    <tr class="rowa">
	<form action="tools.php" method="post">
		<input type="hidden" name="action" value="badges_alter" />
		<input type="hidden" name="auth" value="<?=$LoggedUser['AuthKey']?>" />
		<td class="center" id="image0">
		</td>
		<td>
<?                  print_select_image(0); ?> 
		</td>
		<td>
			<input class="medium" type="text" name="name" value="new name" />
		</td>
		<td>
			<input class="long" type="text" name="desc" value="awarded for XXXXXX. This user has doneY/achievedZ" />
		</td>
		<td>
			<input class="medium" type="text" name="sort" value="0" />
		</td>
		<td>
                <select name="type" >
<?                  foreach ($BadgeTypes as $valtype) {   ?>
                        <option value="<?=$valtype?>"><?=$valtype?>&nbsp;&nbsp;</option>
<?                  } ?>
                </select>
		</td>
		<td>
			<input class="medium" type="text" name="cost" value="" title="Only used if item is a shop item"/>
		</td>
		<td>
			<input type="submit" value="Create" />
		</td>
	</form>
    </tr>
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
		<td width="8px">ID</td>
		<td width="40px"></td>
		<td width="100px">Select Image</td>
		<td width="120px">Name</td>
		<td>Description</td>
		<td width="20px">Sort</td>
		<td width="80px">Type</td>
		<td width="70px">Cost</td>
		<td width="120px"></td>
    </tr>
<? 

$DB->query("SELECT ID, Type, Sort, Cost, Name, Description, Image
              FROM badges ORDER BY Sort");
$Row = 'b';
while(list($ID, $Type, $Sort, $Cost, $Name, $Description, $Image) = $DB->next_record()){  
	$Row = ($Row === 'a' ? 'b' : 'a');
?>
    <tr class="row<?=$Row?>">
	  <form action="tools.php" method="post">
                <input type="hidden" name="action" value="badges_alter" />
                <input type="hidden" name="auth" value="<?=$LoggedUser['AuthKey']?>" />
                <input type="hidden" name="id" value="<?=$ID?>" />
                
		<td>
			#<?=$ID?>
		</td>
		<td class="center" id="image<?=$ID?>">
                <img src="<?=STATIC_SERVER.'common/badges/'.$Image?>" title="<?=$Image?>" alt="<?=$Image?>" />
            </td>
		<td>
<?                  print_select_image($ID, $Image); ?> 
		</td>
		<td>
			<input class="medium" type="text" name="name" value="<?=display_str($Name)?>" />
		</td>
		<td>
			<input class="long" type="text" name="desc" value="<?=display_str($Description)?>" />
		</td>
		<td>
			<input class="medium" type="text" name="sort" value="<?=display_str($Sort)?>" />
		</td>
		<td>
                <select name="type" >
<?                  foreach ($BadgeTypes as $valtype) {   ?>
                        <option value="<?=$valtype?>"<?=($valtype==$Type?' selected="selected"':'')?>><?=$valtype?>&nbsp;&nbsp;</option>
<?                  } ?>
                </select>
		</td>
		<td>
			<input class="medium" type="text" name="cost" value="<?=display_str($Cost)?>" title="Only used if item is a shop item"/>
		</td>
		<td>
                <input type="submit" name="submit" value="Edit" />
                <input type="submit" name="submit" value="Delete" />
		</td>
	  </form>
    </tr>
<? }  ?>
</table>
</div>
<? show_footer(); ?>

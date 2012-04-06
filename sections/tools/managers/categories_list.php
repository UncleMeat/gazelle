<?

if(!check_perms('admin_manage_categories')){ error(403); }

show_header('Manage news','bbcode');
$images = scandir(SERVER_ROOT.'/static/common/caticons');
unset($images[0], $images[1]);

$DB->query("SELECT
        id,
        name,
        image,
        cat_desc
        FROM categories");
?>

<script src="/static/functions/jquery.js"></script>
<script type="text/javascript">//<![CDATA[
function change_image(display_image, cat_image) {
    $(display_image).html('<img src="/static/common/caticons/'+$(cat_image).val()+'"/>');
}
//]]></script>

<h2>Categories</h2>
<strong>Observe!</strong> You must upload new images to the <?=SERVER_ROOT?>/static/common/caticons/ folder before you can use it here.<br /><br />
<table>
<tr>
	<td colspan="4" class="colhead">Add a new category</td>
</tr>
<tr>
<tr class="colhead">
        <td>Image</td>
        <td>Name</td>
        <td>Description</td>
        <td>Submit</td>
</tr>

        <form action="tools.php" method="post">
            <td>
                    <input type="hidden" name="action" value="categories_alter" />
                    <input type="hidden" name="auth" value="<?=$LoggedUser['AuthKey']?>" />
                    <span id="display_image0">
                        <img src="/static/common/caticons/<?=$images[2]?>   " />
                    </span>
                    <select id="cat_image0" name="image" onchange="change_image('#display_image0', '#cat_image0');">
                    <?foreach($images as $key=>$value) {?>
                        <option value="<?=display_str($value)?>"><?=$value?></option>
                    <?}?>
                    </select>   
            </td>
            <td>
                    <input type="text" name="name" size="50" />
            </td>
            <td>
                    <input type="text" name="cat_desc" size="70" />
            </td>                
            <td>
                    <input type="submit" value="Create" />
            </td>
        </form>      
</tr>
</table>
<br />
<table>
<tr class="colhead">
        <td>Image</td>
        <td>Name</td>
        <td>Description</td>
        <td>Submit</td>
</tr>
<?while(list($id, $name, $image, $cat_desc) = $DB->next_record()) { ?>        
<tr>
        <form action="tools.php" method="post">
            <td>
                <input type="hidden" name="action" value="categories_alter" />
                <input type="hidden" name="auth" value="<?=$LoggedUser['AuthKey']?>" />
                <input type="hidden" name="id" value="<?=$id?>" />
                <span id="display_image<?=$id?>">
                    <img src="/static/common/caticons/<?=$image?>" />
                </span>
                <select id="cat_image<?=$id?>" name="image" onchange="change_image('#display_image<?=$id?>', '#cat_image<?=$id?>');">
                <?foreach($images as $key=>$value) {?>
                    <option value="<?=display_str($value)?>"<?=($image == $value) ? 'selected="selected"' : '';?>><?=$value?></option>
                <?}?>
                </select>
            </td>
            <td>
                <input type="text" name="name" size="50" value="<?=display_str($name)?>" />
            </td>
            <td>
                <input type="text" name="cat_desc" size="70" value="<?=display_str($cat_desc)?>" />
            </td>                
            <td>
                <input type="submit" name="submit" value="Edit" />
                <input type="submit" name="submit" value="Delete" />
            </td>
        </form>
</tr>
<? } ?>        
</table>


<? show_footer();?>
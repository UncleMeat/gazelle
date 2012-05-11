<?

/********************************************************************************
 ************ Torrent form class *************** upload.php and torrents.php ****
 ********************************************************************************
 ** This class is used to create both the upload form, and the 'edit torrent'  **
 ** form. It is broken down into several functions - head(), foot(),           **
 ** music_form() [music], audiobook_form() [Audiobooks and comedy], and	       **
 ** simple_form() [everything else].                                           **
 **                                                                            **
 ** When it is called from the edit page, the forms are shortened quite a bit. **
 **                                                                            **
 ********************************************************************************/
 
class TORRENT_FORM {
        var $NewCategories = array();
	var $Media = array();
	var $NewTorrent = false;
	var $Torrent = array();
	var $Error = false;
	var $TorrentID = false;
	var $Disabled = '';
	
	function TORRENT_FORM($Torrent = false, $Error = false, $NewTorrent = true) {
		
		$this->NewTorrent = $NewTorrent;
		$this->Torrent = $Torrent;
		$this->Error = $Error;
		
		global $NewCategories, $Media, $TorrentID;
		
                $this->NewCategories = $NewCategories;
		$this->Media = $Media;
		$this->TorrentID = $TorrentID;
		
		if($this->Torrent && $this->Torrent['GroupID']) {
			$this->Disabled = ' disabled="disabled"';
		}
	}


	function head() {
		global $LoggedUser;
?>
<div class="thin">
<?		if($this->NewTorrent) { ?>
	<p style="text-align: center;">
		Your personal announce url is:<br />
		<input type="text" value="<?= ANNOUNCE_URL.'/'.$LoggedUser['torrent_pass'].'/announce'?>" size="71" onfocus="this.select()" />
	</p>
<?		}
		if($this->Error) {
			echo '<p style="color: red;text-align:center;">'.$this->Error.'</p>';
		}
            //for testing form vars set action="http://www.tipjar.com/cgi-bin/test"
?>
	<form action="" enctype="multipart/form-data" method="post" id="upload_table" onsubmit="$('#post').raw().disabled = 'disabled'">
		<div>
			<input type="hidden" name="submit" value="true" />
			<input type="hidden" name="auth" value="<?=$LoggedUser['AuthKey']?>" />
<?		if(!$this->NewTorrent) { ?>
			<input type="hidden" name="action" value="takeedit" />
			<input type="hidden" name="torrentid" value="<?=display_str($this->TorrentID)?>" />
<?		} else {
			if($this->Torrent && $this->Torrent['GroupID']) { ?>
			<input type="hidden" name="groupid" value="<?=display_str($this->Torrent['GroupID'])?>" />
<?			} 
			if($this->Torrent && $this->Torrent['RequestID']) { ?>
			<input type="hidden" name="requestid" value="<?=display_str($this->Torrent['RequestID'])?>" />
<?			}
		} ?>
		</div>
<?		if($this->NewTorrent) { ?>
		<table cellpadding="3" cellspacing='1' border='0' class='border' width="100%">
			<tr>
				<td class="label">
					Torrent file
				</td>
				<td>
					<input id="file" type="file" name="file_input" size="60" />
				</td>
                        </tr>
                        <tr>
                                <td class="label">
                                    Category
                                </td>
                                <td>
                                    <select name="category">
                                    <? foreach($this->NewCategories as $category) { ?>
                                    <option value="<?=$category['id']?>"><?=$category['name']?></option>
                                    <? } ?>
                                    </select>
                                </td>
			</tr>
		</table>
<?		}//if ?>
		<div id="dynamic_form">
<?	} // function head

	
	function foot() {
		$Torrent = $this->Torrent;
?>
		</div>
	
		<table cellpadding="3" cellspacing="1" border="0" class="border slice" width="100%">
<?		if(!$this->NewTorrent) {
			if(check_perms('torrents_freeleech')) {
?>
			<tr id="freetorrent">
				<td class="label">Freeleech</td>
				<td>
					<select name="freeleech">
<?	$FL = array("Normal", "Free", "Neutral");
	foreach($FL as $Key => $Name) { ?>	
						<option value="<?=$Key?>" <?=($Key == $Torrent['FreeTorrent'] ? ' selected="selected"' : '')?>><?=$Name?></option>
<?	} ?>
					</select>
					 because 
					<select name="freeleechtype">
<?	$FL = array("N/A", "Staff Pick", "Perma-FL", "Vanity House");
	foreach($FL as $Key => $Name) { ?>	
						<option value="<?=$Key?>" <?=($Key == $Torrent['FreeLeechType'] ? ' selected="selected"' : '')?>><?=$Name?></option>
<?	} ?>
					</select>
				</td>
			</tr>
<?
			}
		}
?>
			<tr>
				<td colspan="2" style="text-align: center;">
					<p>Be sure that your torrent is approved by the <a href="articles.php?topic=upload">rules</a>. Not doing this will result in a <strong>warning</strong> or <strong>worse</strong>.</p>
<?		if($this->NewTorrent) { ?>
					<p>After uploading the torrent, you will have a one hour grace period during which no one other than you can fill requests with this torrent. Make use of this time wisely, and search the requests. </p>
 
                              <input id="post_preview" type="button" value="Preview" onclick="if(this.preview){Upload_Quick_Edit();}else{Upload_Quick_Preview();}" />
    <?		} ?>	
					<input id="post" type="submit" <? if($this->NewTorrent) { echo "value=\"Upload torrent\""; } else { echo "value=\"Edit torrent\"";} ?> />
				</td>
			</tr>
		</table>
	</form>
</div>
<?	} //function foot
	
	  


	

	function simple_form($OfficialTags = '', $num_smilies = 0) {
            global $Text; 
		$Torrent = $this->Torrent; 
?>		<table cellpadding="3" cellspacing="1" border="0" class="border slice" width="100%">
			<tr id="name">
<?		if ($this->NewTorrent) {  ?>
				<td class="label">Title</td>
				<td>
					<input type="text" id="title" name="title" class="long" value="<?=display_str($Torrent['Title']) ?>" />
				</td>
			</tr>
			<tr>
				<td class="label">Tags</td>
				<td>
<?			if($OfficialTags) { ?>
					<select id="genre_tags" name="genre_tags" onchange="add_tag();return false;" value="<?=display_str($Torrent['TagList']) ?>" <?=$this->Disabled?>>
						<option>---</option>
<?				foreach(display_array($OfficialTags) as $Tag) { ?>
						<option value="<?=$Tag ?>"><?=$Tag ?></option>
<?				} ?>
					</select>
<?			} ?> 
					<input type="text" id="tags" name="tags" class="medium" value="<?=display_str($Torrent['TagList']) ?>" <?=$this->Disabled?>/>
					<br />
					Tags should be comma separated, and you should use a period ('.') to separate words inside a tag.
					<br /><br />
					There is a list of official tags to the left of the text box. Please use these tags instead of 'unofficial' tags.  <strong>Please note that the '2000s' tag refers to produced between 2000 and 2009.</strong>
					<br /><br />
					Avoid abbreviations if at all possible. So instead of tagging an album as '<strong style="color:red;">hc</strong>', tag it as '<strong style="color:green;">hardcore</strong>'. Make sure that you use correct spelling. 
					<br /><br />
					Avoid using multiple synonymous tags.  
					<br /><br />
					Don't use 'useless' tags, such as '<strong style="color:red;">awesome</strong>', etc.
					<br /><br />
					<strong>You should be able to build up a list of tags using only the official tags to the left of the text box besides porn star names. If you are in any doubt about whether or not a tag is acceptable, do not add it.</strong>
				</td>
			</tr>
		</table> 
        <div id="uploadpreviewbody">
		<div id="contentpreview" style="text-align:left;"></div>
        </div>
        <div id="uploadbody"> 
 		<table cellpadding="3" cellspacing="1" border="0" class="border slice" width="100%">
                 
			<tr>
				<td class="label">Cover Image</td>
				<td>  
                             <input type="text" id="image" class="long" name="image" value="<?=display_str($Torrent['Image']) ?>" <?=$this->Disabled?>/>
                        </td>
			</tr> 
			<tr>
				<td class="label">Description</td>
				<td> 
                            <? $Text->display_bbcode_assistant("desc", $num_smilies); ?>
                             <textarea name="desc" id="desc" class="long" rows="36"><?=display_str($Torrent['GroupDescription']); ?></textarea>
                        </td>
			</tr> 
<?		} ?>

		</table>
         </div>
<?	}//function simple_form
}//class
?>

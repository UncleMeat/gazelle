<?
 
include(SERVER_ROOT.'/classes/class_text.php');
$Text = new TEXT;

 
$Body=get_article('connchecker');

if (!isset($_GET['checkip'])) $_GET['checkip'] = $_SERVER['REMOTE_ADDR'];

if (isset($_GET['checkuser']) && ( check_perms('users_mod') || !empty($SupportFor) )) {
    $UserID = $_GET['checkuser'];
} else {
    $UserID = $LoggedUser['ID'];
}

show_header('Connectability Checker');
?>
<div class="thin">
	<h2><a href="user.php?id=<?=$LoggedUser['ID']?>"><?=$LoggedUser['Username']?></a> &gt; Connectability Checker</h2>
<?  if ($Body){ ?>
	<div class="head"></div>
      <div class="box pad" style="padding:10px 10px 10px 20px;">
            <?=$Text->full_format($Body, true)?>
      </div>
<?  }   ?>
	<div class="head">Check IP address and port</div>
      <form action="javascript:check_ip('<?=$UserID?>');" method="get">
		<table>
			<tr>
				<td class="label">IP</td>
				<td>
					<input type="text" id="ip" name="ip" value="<?=$_GET['checkip']?>" size="20" />
				</td>
				<td class="label">Port</td>
				<td>
					<input type="text" id="port" name="port" value="<?=$_GET['checkport']?>" size="10" />
				</td>
				<td>
					<input type="submit" value="Check" />
				</td>
			</tr>
		</table>
	</form><br />
	<div class="head">results</div>
	<div class="box pad"><div id="result" class="messagebar checking"></div></div>
</div>

<script type="text/javascript">

function check_ip(user_id) {
    var result = $('#result');
	var intervalid = setInterval("$('#result').raw().innerHTML += '.';",1499);
    result.remove_class('alert');
    result.add_class('checking');
	result.raw().innerHTML = 'Checking.';
	ajax.get('ajax.php?action=connchecker&ip=' 
                            + $('#ip').raw().value 
                            + '&port=' + $('#port').raw().value
                            + '&userid=' + user_id, function (response) {
		clearInterval(intervalid);
        result.remove_class('checking');
        var x = json.decode(response); 
        if ( is_array(x)){
            if ( x[0] !== true){
                result.add_class('alert');
            }
            result.raw().innerHTML = x[1];
        } else {    // error from ajax
            //alert(x);
            result.add_class('alert');
            result.raw().innerHTML = 'Invalid response: An error occured';
        } 
	});
}
</script>

<? show_footer(); ?>

<?
//TODO: Move to somewhere more appropriate, doesn't really belong under users, tools maybe but we don't have that page publicly accessible.
/*
if(isset($_GET['ip']) && isset($_GET['port'])){
	$Octets = explode(".", $_GET['ip']);
	if(
		empty($_GET['ip']) ||
		!preg_match('/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/', $_GET['ip']) ||
		$Octets[0] < 0 ||
		$Octets[0] > 255 ||
		$Octets[1] < 0 ||
		$Octets[1] > 255 ||
		$Octets[2] < 0 ||
		$Octets[2] > 255 ||
		$Octets[3] < 0 ||
		$Octets[3] > 255 ||
		$Octets[0] == 127 ||
		$Octets[0] == 192
	) {
		die('-3'); //'Invalid IP');
	}
	
	if (empty($_GET['port']) || !is_number($_GET['port']) ||  $_GET['port']<1 || $_GET['port']>65535){
		die('-2');    //'Invalid Port');
	}

	//Error suppression, ugh.	
	if(@fsockopen($_GET['ip'], $_GET['port'], $Errno, $Errstr, 20)){
        // save results to users_connectable_status here ?
		die('1');     //'Port '.$_GET['port'].' on '.$_GET['ip'].' connected successfully.');
	} else {
		die('-1');     //'Port '.$_GET['port'].' on '.$_GET['ip'].' failed to connect.');
	}
}
*/


include(SERVER_ROOT.'/classes/class_text.php');
$Text = new TEXT;

 
$Body=get_article('connchecker');

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
      <form action="javascript:check_ip('<?=$LoggedUser['ID']?>');" method="get">
		<table>
			<tr>
				<td class="label">IP</td>
				<td>
					<input type="text" id="ip" name="ip" value="<?=$_SERVER['REMOTE_ADDR']?>" size="20" />
				</td>
				<td class="label">Port</td>
				<td>
					<input type="text" id="port" name="port" size="10" />
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
            if ( x[0] == true){
                
            } else {
                result.add_class('alert');
            }
            result.raw().innerHTML = x[1];
        } else {    // error from ajax
            alert(x);
        } 
	});
}
</script>

<?
/*
<script type="text/javascript">

function check_ip() {
      var result = $('#result');
	var intervalid = setInterval("$('#result').raw().innerHTML += '.';",1499);
      result.remove_class('alert');
      result.add_class('checking');
	result.raw().innerHTML = 'Checking.';
	ajax.get('user.php?action=connchecker&ip=' + $('#ip').raw().value + '&port=' + $('#port').raw().value, function (response) {
		clearInterval(intervalid);
            result.remove_class('checking');
            if(response == '-3') {
                result.add_class('alert');
                result.raw().innerHTML = 'Invalid IP';
            } else if(response == '-2') {
                result.add_class('alert');
                result.raw().innerHTML = 'Invalid Port';
            }else if(response == '-1'){
                result.add_class('alert');
                result.raw().innerHTML = 'Port '+$('#port').raw().value+' on '+$('#ip').raw().value+' failed to connect.';
            }else if(response == '1'){
                result.raw().innerHTML = 'Port '+$('#port').raw().value+' on '+$('#ip').raw().value+' connected successfully.';
            }else{
                result.add_class('alert');
                result.raw().innerHTML = 'Invalid response: An error occured';
            }
	});
}
</script> */  ?>

<? show_footer(); ?>

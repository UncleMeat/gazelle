<?php

function make_secret($Length = 32) {
	$Secret = '';
	$Chars='abcdefghijklmnopqrstuvwxyz0123456789';
	for($i=0; $i<$Length; $i++) {
		$Rand = mt_rand(0, strlen($Chars)-1);
		$Secret .= substr($Chars, $Rand, 1);
	}
	return str_shuffle($Secret);
}

$time_start = microtime(true);

echo "connecting to database\n";
mysql_connect('localhost', 'root', 'password');

echo "creating new authkey strings. (this will take a long time)\n";
$result = mysql_query('select count(*) as c from gazelle.users_info');
$count = mysql_result($result, 0);

$result = mysql_query('select userid from gazelle.users_info');
$i = 0;
echo "0.00% ";
while ($row = mysql_fetch_assoc($result))
{
    $auth_key = make_secret();
    
    mysql_query("update gazelle.users_info set AuthKey='$auth_key' where userid={$row['userid']}");
    
    $i++;
    if ($i % 1000 == 0) echo "\n".number_format ($i/$count*100, 2)."% ";
    elseif ($i % 100 == 0) echo ".";
}   

$time = microtime(true) - $time_start;
echo "\nexecution time: $time seconds\n";

?>

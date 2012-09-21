
<?
/*
for($fid=1;$fid<=25;$fid++){
    
    $DB->query("INSERT INTO `xbt_files_users`(`uid`, `active`, `announced`, `completed`, `downloaded`, `remaining`, `uploaded`, `upspeed`, `downspeed`, `corrupt`, `timespent`, `useragent`, `connectable`, `peer_id`, `fid`, `mtime`, `ip`)
            SELECT ID, '1', '1', '1','1','0','1','1','1','1', '1','1','0',ID,'$fid','1','1' FROM users_main WHERE ID<50000");

}

$DB->query("SELECT COUNT(*) FROM xbt_files_users ");
list($count)= $DB->next_record();

echo "did $fid loops: $count records in xbt_files_users";
*/

       // $num = round( ( sqrt( 8.0 * ( $count / 20  ) + 1.0 ) - 1.0  )  / 2.0 *20 );


//echo "dont press that!<br/>";
$a = isset($_REQUEST['a'])?$_REQUEST['a']:0.4;
$b = isset($_REQUEST['b'])?$_REQUEST['b']:1;
$c = isset($_REQUEST['c'])?$_REQUEST['c']:10;
$d = isset($_REQUEST['d'])?$_REQUEST['d']:0;

?>

<html>
    <head>
        
    </head>
    <body>
        <table style="width:100%">
            <tr>
                <td colspan="3">
                    <form action="" method="post">
                        <input type="hidden" name="action" value="sandbox1" />
                        <label for="a" >a:</label>
                        <input type="text" name="a" value="<?=$a?>" />
                        <label for="b" >b:</label>
                        <input type="text" name="b" value="<?=$b?>" />
                        <label for="c" >c:</label>
                        <input type="text" name="c" value="<?=$c?>" />
                        <label for="d" >d:</label>
                        <input type="text" name="d" value="<?=$d?>" />
                        <input type="submit" value="calculate"/>
                    </form>
                    <h3>round( ( sqrt( ( a * count ) + b ) - 1.0  ) *c ) + d </h3>
                </td>
            </tr>
            <tr>
                <td style="width:33%">
                    <h3>your formula</h3>
                    <?=get_seed_values($a, $b, $c, $d);?>
                </td>
                <td style="width:33%">
                    <h3>Current formula</h3>
                    <?=get_seed_values(2/5, 1, 10);?>
                </td>
                <td style="width:33%">
                    <h3>formula 3</h3>
                    <?=get_seed_values(4, 3, 2, 1);?>
                </td>
                <? /*
                <td>
                    <?=get_seed_values(8, 6, 1.5);?>
                </td>
                <td>
                    <?=get_seed_values(12, 16, 1 );?>
                </td> */
                ?>
            </tr>
        </table>
    </body>
</html>



<?

function get_bonus_points($count, $a = 8.0, $b = 1, $c=10, $d=0){
    
    ////$num = round( ( sqrt( $a * ( $count / $b  ) + 1.0 ) - 1.0  ) *$c );
    
    //$num = round( ( sqrt( ( $a *  $count * $b  ) + 1.0 ) - 1.0  ) *$c );
    
    $num = round( ( sqrt( ( $a *  $count ) + $b ) - 1.0  ) *$c )+$d;
    
    return $num;
}


            //   ROUND( ( SQRT( 8.0 * ( COUNT( * ) /20 ) + 1.0 ) - 1.0 ) / 2.0 *20 ) 

function get_seed_values($a = 8.0, $b = 1, $c=10, $d=0){
   //$b = 1 / $b;
    echo "round( ( sqrt( ( $a * count ) + $b ) - 1.0  ) *$c ) + $d <br/>";
    echo "<pre><br/>";
    echo "+----------+---------+<br/>";
    echo "| torrents | credits |<br/>";
    echo "+----------+---------+<br/>";
    $lastnum=-1;
    for($count=1;$count< 50;$count++){
            //$num = round( ( sqrt( $a * ( $count / $b  ) + 1.0 ) - 1.0  ) *$c );
            
            $num = get_bonus_points($count, $a, $b, $c, $d);
            if ($count==10 || $count==20 || $count==30 || $count==40 || $count==50 || $lastnum !== $num) {
                echo "| " . str_pad($count, 8)." | ". str_pad($num, 7)." |<br/>"; 
                $lastnum=$num;
            }
    }
    
    for($i=0;$i<=20000;$i++){

        if ($i <= 20)
            $count = 50 + ( $i * 10);
        elseif ($i <= 40)
            $count = -250 + ( $i * 25);
        elseif ($i <= 80)
            $count = -3300 + ( $i * 100);
 
        $num = get_bonus_points($count, $a, $b, $c, $d);
        
        if ($lastnum != $num) {
            echo "| " . str_pad($count, 8)." | ". str_pad($num, 7)." |<br/>"; 
            $lastnum=$num;
        }
        if ($count >= 3000) break;
    } 

    $count=5000; 
    $num = get_bonus_points($count, $a, $b, $c, $d);
    echo "| " . str_pad($count, 8)." | ". str_pad($num, 7)." |<br/>"; 

    $count=10000; 
    $num = get_bonus_points($count, $a, $b, $c, $d);
    echo "| " . str_pad($count, 8)." | ". str_pad($num, 7)." |<br/>"; 

    $count=15000;
    $num = get_bonus_points($count, $a, $b, $c, $d);
    echo "| " . str_pad($count, 8)." | ". str_pad($num, 7)." |<br/>"; 

    $count=20000;
    $num = get_bonus_points($count, $a, $b, $c, $d);
    echo "| " . str_pad($count, 8)." | ". str_pad($num, 7)." |<br/>"; 

    echo "+----------+---------+<br/>";
    echo"</pre>";
 
}

?>
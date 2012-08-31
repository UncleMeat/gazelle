
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

?>

<html>
    <head>
        
    </head>
    <body>
        <table>
            <tr>
                <td>
                    <?=get_seed_values(8,20,10);?>
                </td>
                <td>
                    <?=get_seed_values(3,2,4);?>
                </td>
                <td>
                    <?=get_seed_values(4,2,4);?>
                </td>
                <td>
                    <?=get_seed_values(6, 20,8);?>
                </td>
            </tr>
        </table>
    </body>
</html>



<?



function get_seed_values($a = 8.0, $b = 20, $c=10){
   
    echo "round( ( sqrt( $a * ( count / $b  ) + 1.0 ) - 1.0  ) *$c )<br/>";
    echo "<pre><br/>";
    echo "+----------+---------+<br/>";
    echo "| torrents | credits |<br/>";
    echo "+----------+---------+<br/>";
    $lastnum=-1;
    for($count=1;$count<=100;$count++){
            $num = round( ( sqrt( $a * ( $count / $b  ) + 1.0 ) - 1.0  ) *$c );
            //if ($lastnum !== $num) {
                echo "| " . str_pad($count, 8)." | ". str_pad($num, 7)." |<br/>"; 
                //$lastnum=$num;
            //}
    }
    for($i=0;$i<=20000;$i++){

        if ($i < 40)
            $count = 100 + ( $i * 10);
        elseif ($i <= 90)
            $count = -1500 + ( $i * 50);

        //$num = round( ( sqrt( 8.0 * ( $count / 20  ) + 1.0 ) - 1.0  )  / 2.0 *20 );
            $num = round( ( sqrt( $a * ( $count / $b  ) + 1.0 ) - 1.0  ) * $c );
        if ($lastnum !== $num) {
            echo "| " . str_pad($count, 8)." | ". str_pad($num, 7)." |<br/>"; 
            $lastnum=$num;
        }
        if ($count >= 10000) break;
    }

    $count=5000;
   // $num = round( ( sqrt( 8.0 * ( $count / 20  ) + 1.0 ) - 1.0  )  / 2.0 *20 );
            $num = round( ( sqrt( $a * ( $count / $b  ) + 1.0 ) - 1.0  ) * $c );
    echo "| " . str_pad($count, 8)." | ". str_pad($num, 7)." |<br/>"; 

    $count=10000;
   // $num = round( ( sqrt( 8.0 * ( $count / 20  ) + 1.0 ) - 1.0  )  / 2.0 *20 );
            $num = round( ( sqrt( $a * ( $count / $b  ) + 1.0 ) - 1.0  )  * $c );
    echo "| " . str_pad($count, 8)." | ". str_pad($num, 7)." |<br/>"; 

    $count=15000;
    //$num = round( ( sqrt( 8.0 * ( $count / 20  ) + 1.0 ) - 1.0  )  / 2.0 *20 );
            $num = round( ( sqrt( $a * ( $count / $b  ) + 1.0 ) - 1.0  )  * $c );
    echo "| " . str_pad($count, 8)." | ". str_pad($num, 7)." |<br/>"; 

    $count=20000;
    //$num = round( ( sqrt( 8.0 * ( $count / 20  ) + 1.0 ) - 1.0  )  / 2.0 *20 );
            $num = round( ( sqrt( $a * ( $count / $b  ) + 1.0 ) - 1.0  )  * $c );
    echo "| " . str_pad($count, 8)." | ". str_pad($num, 7)." |<br/>"; 

    echo "+----------+---------+<br/>";
    echo"</pre>";
 
}

            //   ROUND( ( SQRT( 8.0 * ( COUNT( * ) /20 ) + 1.0 ) - 1.0 ) / 2.0 *20 ) 
?>
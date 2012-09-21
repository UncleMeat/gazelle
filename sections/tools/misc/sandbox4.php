<?

 //error("dont press that!");



set_time_limit(0);

include(SERVER_ROOT.'/classes/class_text.php');
$Text = new TEXT;

$num_users = isset($_REQUEST['numusers'])?(int)$_REQUEST['numusers']:10;

if($num_users<=0)$num_users=1;

$done='--';

if ($_REQUEST['submit']=='process'){
    $done= 'done';
    $DB->query("SELECT ID, IP, Username FROM users_main WHERE ipcc='' AND IP!='0.0.0.0' ORDER BY ID DESC LIMIT $num_users");
    $Users = $DB->to_array();
    
        
    $ret = "[code]";
    $ret .= "+--------+---------------+----+\n";
    $ret .= "|   ID   |    username   | cc |\n";
    $ret .= "+--------+---------------+----+\n";
    
    
    foreach ($Users as $User) {
        list($UserID, $IP, $Username) = $User;
        
        // mifune: auto set if we have an ip to work with and data is missing
        if($IP) {
            $ipcc = geoip($IP);
            $DB->query("UPDATE users_main SET ipcc='$ipcc' WHERE ID='$UserID'"); 
            $Results[] = "| " . str_pad($UserID, 7)."| ". str_pad($Username, 14)."| ".str_pad($ipcc,2)." |"; //  ($IP)
        }
    }

    $ret .= implode("\n", $Results)."\n";
    $ret .= "+--------+---------------+----+\n";
    $ret .="[/code]\n";
}
else if ($_REQUEST['submit2']=='fill users_geo_distribution'){
    
    $done= 'filled users_geo_distribution';
    $DB->query("INSERT IGNORE INTO users_geodistribution (Code, Users) 
                       SELECT ipcc, COUNT(ID) AS Users 
                         FROM users_main 
                        WHERE Enabled='1' AND ipcc != ''
                        GROUP BY ipcc 
                     ORDER BY Users DESC");
      
    $numinserted = $DB->affected_rows();
    $ret = "inserted $numinserted records";
}


show_header('sandbox four');

?>
<div class="thin">
    <h2>sandbox four</h2>
        <table style="width:100%">
            <tr>
                <td class="center">
                    <form action="" method="post">
                        <input type="hidden" name="action" value="sandbox4" />
                        <label for="numusers" >num:</label>
                        <input size="6" type="text" name="numusers" value="<?=$num_users?>" />
                        <input type="submit" name="submit" value="process"/>
                    </form><br/>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top">
                    status: <?=$done?><br/>
                    <?=$Text->full_format( $ret );?>
                </td> 
            </tr>
            <tr>
                <td class="center">
                    <form action="" method="post">
                        <input type="hidden" name="action" value="sandbox4" /> 
                        <input type="submit" name="submit2" value="fill users_geo_distribution"/>
                    </form><br/>
                </td>
            </tr>
        </table>
 
</div>
     
<?

        show_footer();

?>



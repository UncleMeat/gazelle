<?php
 

if(isset($_POST['builddata']) && check_perms('site_debug')){
    
    $date = new DateTime('2011-02-01');
    $end = new DateTime("2012-08-25");
    
    $DB->query("DELETE FROM site_stats_history WHERE TimeAdded <= '".$end->format('Y-m-d H:i:s')."'");
    
    do {  
        $time = $date->format('Y-m-d H:i:s');
        $DB->query("INSERT INTO site_stats_history ( TimeAdded, Users, Torrents, Seeders, Leechers )
                       VALUES ('$time', 
                                (SELECT Count(UserID) AS Users FROM users_info WHERE JoinDate < '$time'),
                                (SELECT Count(ID) AS NumT FROM torrents WHERE Time < '$time'),
                                '0','0' )");
        $date->add(new DateInterval('PT6H'));
        if ($date>$end) break;
    } while(true);
 
}



$SiteStats = $Cache->get_value('site_stats');

if ($SiteStats === false) {
 
    $DB->query("SELECT DATE_FORMAT(TimeAdded,'%d %b %y') AS Label, 
                       CAST(AVG(Users) AS SIGNED) AS Users, 
                       CAST(AVG(Torrents) AS SIGNED) AS Torrents, 
                       CAST(AVG(Seeders) AS SIGNED) AS Seeders, 
                       CAST(AVG(Leechers) AS SIGNED) AS Leechers
                    FROM site_stats_history 
                GROUP BY DATE_FORMAT(TimeAdded,'%d %b %y')
                  HAVING Count(ID)=4
                ORDER BY TimeAdded DESC
                   LIMIT 365");

    $SiteStats = array_reverse($DB->to_array(MYSQLI_ASSOC));
    $Cache->cache_value('site_stats',$SiteStats, 3600*12 ); 
}

if (count($SiteStats)>0) {
 
    $cols = "cols: [{id: 'date', label: 'Date', type: 'string'},
                    {id: 'users', label: 'Users', type: 'number'},
                    {id: 'torrents', label: 'Torrents', type: 'number'},
                    {id: 'seeders', label: 'Seeders', type: 'number'},
                    {id: 'leechers', label: 'Leechers', type: 'number'}] ";
     
    $rows = array();        
    foreach ($SiteStats as $data)  {  
        list($Label, $Users, $Torrents, $Seeders, $Leechers) = $data;
        $rows[] = " {c:[{v: '$Label'}, {v: $Users}, {v: $Torrents}, {v: $Seeders}, {v: $Leechers}]} ";
    }
    $data = " { $cols, rows: [" . implode(",", $rows) . "] }"; 
}

show_header('Site Statistics', 'charts');

?>
<div class="thin">
    <div class="head">Site statistics</div>
    <div class="box pad center">
<?
    if ($data) {
?>    
        <div id="chart_div"></div>
        <script type="text/javascript">
            var chartdata = <?=$data?>; 
            Start_Sitestats();
        </script>
<?
    } else { ?>
        <p>No site data found</p>
<?  }  ?>
    </div>
    <br/>
<?
    if (check_perms('site_debug')) {
?>      
        <br/>
        <div class="box pad center">
            <form method="post" action="">
                <input type="submit" name="builddata" value="Create old torrent and user data" />
            </form>
            <h3>Debug Info:</h3>
        <br/>
            <?=$data?>
        </div>
<?  }  ?>
</div>
<?
show_footer();

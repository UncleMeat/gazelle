<?php
 
if (!check_perms('site_view_stats')) error(403);


if(isset($_POST['builddata']) && check_perms('site_debug')){
    
    $date = new DateTime('2011-02-01');
    $end = new DateTime("2012-08-25");
    
    $deleteend = date('Y-m-d H:i:s', strtotime( "$_POST[year]-$_POST[month]-$_POST[day]" )  ); 
    if($deleteend===false) error("Error in End date input");
    if (strtotime($deleteend)<strtotime("2011-02-01")) error("End date is before data range ($deleteend < 2011-02-01)");
    //if (strtotime($deleteend)>time()) $deleteend = sqltime();
    
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
    
    $Cache->delete_value('site_stats');
}


if (isset($_POST['view']) && check_perms('site_stats_advanced')) {
    
    $start = date('Y-m-d H:i:s', strtotime( "$_POST[year1]-$_POST[month1]-$_POST[day1]" )  );
    $end = date('Y-m-d H:i:s', strtotime( "$_POST[year2]-$_POST[month2]-$_POST[day2]" )  ); 
   // error("$start --> $end");
    if($start===false) error("Error in start time input");
    if($end===false) error("Error in end time input");
    if (strtotime($start)<strtotime("2011-02-01")) $start = "2011-02-01 00:00:00";
    if (strtotime($end)>time()) $end = sqltime();
    if ($start>=$end) error("Start date ($start) cannot be after end date ($end)");
    
    $DB->query("SELECT DATE_FORMAT(TimeAdded,'%d %b %y') AS Label, 
                       CAST(AVG(Users) AS SIGNED) AS Users, 
                       CAST(AVG(Torrents) AS SIGNED) AS Torrents, 
                       CAST(AVG(Seeders) AS SIGNED) AS Seeders, 
                       CAST(AVG(Leechers) AS SIGNED) AS Leechers
                    FROM site_stats_history 
                   WHERE TimeAdded >= '$start' AND TimeAdded <= '$end'
                GROUP BY DATE_FORMAT(TimeAdded,'%d %b %y')
                  HAVING Count(ID)=4
                ORDER BY TimeAdded DESC");

    $SiteStats = array_reverse($DB->to_array(MYSQLI_ASSOC));
    
} 

if (!$SiteStats) $SiteStats = $Cache->get_value('site_stats');

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
    if (check_perms('site_stats_advanced')) {
        if (isset($_POST[year1])){
            $start = array ($_POST[year1],$_POST[month1],$_POST[day1]);
            $end = array ($_POST[year2],$_POST[month2],$_POST[day2]);
        } else {
            $start = array (2011,02,01);
            $end =  date('Y-m-d');
            $end = explode('-', $end);
        }
?>      
        <br/>
        <div class="head"></div>
        <div class="box pad center">
            <form method="post" action="">
                <input type="text" style="width:30px" title="day" name="day1" value="<?=$start[2]?>" />
                <input type="text" style="width:30px" title="month" name="month1"  value="<?=$start[1]?>" />
                <input type="text" style="width:50px" title="year" name="year1"  value="<?=$start[0]?>" />
                &nbsp;&nbsp;To&nbsp;&nbsp;
                <input type="text" style="width:30px" title="day" name="day2"  value="<?=$end[2]?>" />
                <input type="text" style="width:30px" title="month" name="month2"  value="<?=$end[1]?>" />
                <input type="text" style="width:50px" title="year" name="year2"  value="<?=$end[0]?>" />
                &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="submit" name="view" value="View stats" />
            </form>
        </div>
<?  }  ?>
        
    
<?
    if (check_perms('site_debug')) { 
?>      
        <br/>
        <div class="head">debug info</div>
        <div id="debuginfo" class="box pad center">
            <form method="post" action="">
                <input type="submit" name="builddata" value="Create old torrent and user data - CAUTION - deletes data before end date" title="basically this a button marked 'Dont press!' ... please resist temptation" />
                &nbsp;&nbsp;&nbsp;End Date:&nbsp;
                <input type="text" style="width:30px" title="day" name="day"  value="01" />
                <input type="text" style="width:30px" title="month" name="month"  value="08" />
                <input type="text" style="width:50px" title="year" name="year"  value="2012" />
            </form>    
            <span style="float:left">
                <a href="#debuginfo" onclick="$('#databox').toggle(); this.innerHTML=(this.innerHTML=='(Hide chart data)'?'(View chart data)':'(Hide chart data)'); return false;">(View chart data)</a>
            </span>&nbsp;
            
            <div id="databox" class="box pad hidden">
            <?=$data?>
            </div>
        </div>
<?  }  ?>
</div>
<?
show_footer();

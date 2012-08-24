<?php
/*
  $Values = array();
  $date = new DateTime('2011-01-01');

  for($i = 0;$i<1000;$i++) { //calculate the max
  $Time = $date->format('Y-m-d H:i:s');
  $date->add(new DateInterval('PT6H'));
  $Users = $i * 200;
  $Torrents = $i * 19;
  $Seeders = $i * 440;
  $Leechers = $i * 52;
  $Values[] = "( '$Time', '$Users', '$Torrents', '$Seeders', '$Leechers' )";
  }

  $Values = implode(',', $Values);

  $DB->query("INSERT INTO site_stats_history ( TimeAdded, Users, Torrents, Seeders, Leechers )
  VALUES $Values");

 */

if (!$SiteStats = $Cache->get_value('site_stats')) {
    /*
      $DB->query("SELECT DATE_FORMAT(TimeAdded,'%d %b \\'%y') AS Label, Users, Torrents, Seeders, Leechers
      FROM site_stats_history
      ORDER BY TimeAdded DESC
      LIMIT 50"); */
/*
    $DB->query("SELECT DATE_FORMAT(TimeAdded,'%d %b \\'%y') AS Label, AVG(Users), AVG(Torrents), AVG(Seeders), AVG(Leechers)
                    FROM site_stats_history 
                GROUP BY DATE_FORMAT(TimeAdded,'%d %b \\'%y')
                ORDER BY TimeAdded DESC
                   LIMIT 50");

    $Rawdata = array_reverse($DB->to_array());
    $SMax = 0;
    $SLabels = array();
    $NumUsers = array();
    $NumTorrents = array();
    $NumSeeders = array();
    $NumLeechers = array();
    //$numInX = count($Rawdata);
    foreach ($Rawdata as $data) { //calculate the max
        list($Label, $Users, $Torrents, $Seeders, $Leechers) = $data;
        if ($Users > $SMax)
            $SMax = $Users;
        if ($Torrents > $SMax)
            $SMax = $Torrents;
        if ($Seeders > $SMax)
            $SMax = $Seeders;
        if ($Leechers > $SMax)
            $SMax = $Leechers;
    }
    reset($Rawdata);
    $j = 0;
    foreach ($Rawdata as $data) { //calculate the max 
        list($Label, $Users, $Torrents, $Seeders, $Leechers) = $data;

        $j++;
        if ($j % 7 == 0)
            $SLabels[] = $Label;
        $NumUsers[] = number_format(($Users / $SMax) * 100, 4);   // number_format($Users);
        $NumTorrents[] = number_format(($Torrents / $SMax) * 100, 4);   // number_format($Torrents);
        $NumSeeders[] = number_format(($Seeders / $SMax) * 100, 4);   // number_format($Seeders);
        $NumLeechers[] = number_format(($Leechers / $SMax) * 100, 4);   // number_format($Leechers);
    }
*/
    // SQL Quary                 
    //$rows = array();

    $DB->query("SELECT DATE_FORMAT(TimeAdded,'%d %b %y') AS Label, 
                       CAST(AVG(Users) AS SIGNED) AS Users, 
                       CAST(AVG(Torrents) AS SIGNED) AS Torrents, 
                       CAST(AVG(Seeders) AS SIGNED) AS Seeders, 
                       CAST(AVG(Leechers) AS SIGNED) AS Leechers
                    FROM site_stats_history 
                GROUP BY DATE_FORMAT(TimeAdded,'%d %b \\'%y')
                ORDER BY TimeAdded DESC
                   LIMIT 365");

    $Rawdata = array_reverse($DB->to_array(MYSQLI_ASSOC));
    
    $cols = "['Date', 'Users', 'Torrents', 'Seeders', 'Leechers']";
    $rows = array();        
    foreach ($Rawdata as $data)  {  
        list($Label, $Users, $Torrents, $Seeders, $Leechers) = $data;
        $rows[] = " ['$Label', $Users, $Torrents, $Seeders, $Leechers] ";
    }
    $data = "[ $cols, " . implode(",", $rows) . "]";
    
}

show_header('Site Statistics', 'charts');

?>
<div class="thin">
    <div class="head">Site statistics</div>
    <div class="box pad center">
        <div id="chart_div"></div>
    </div> 
    <br/>
<?
    if (check_perms('site_debug')) {
?>      <br/>
        <div class="box pad center">
            <?=$data?>
        </div> 
<?
    }
?>
</div>
<script type="text/javascript">
    var chartdata = <?=$data?>; 
    Start_GChart();
</script>
<?
show_footer();

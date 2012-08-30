
<?

for($fid=1;$fid<=25;$fid++){
    
    $DB->query("INSERT INTO `xbt_files_users`(`uid`, `active`, `announced`, `completed`, `downloaded`, `remaining`, `uploaded`, `upspeed`, `downspeed`, `corrupt`, `timespent`, `useragent`, `connectable`, `peer_id`, `fid`, `mtime`, `ip`)
            SELECT ID, '1', '1', '1','1','0','1','1','1','1', '1','1','0',ID,'$fid','1','1' FROM users_main WHERE ID<50000");

}

$DB->query("SELECT COUNT(*) FROM xbt_files_users ");
list($count)= $DB->next_record();

echo "did $fid loops: $count records in xbt_files_users";


?>
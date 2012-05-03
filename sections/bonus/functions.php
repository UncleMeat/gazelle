<?php
function get_shop_items(){ 
	global $Cache, $DB;
	static $ShopItems;
	if(is_array($ShopItems)) return $ShopItems;
	if(($ShopItems = $Cache->get_value('shop_items')) === false) {
		$DB->query("SELECT
                        ID, 
                        Title, 
                        Description, 
                        Action, 
                        Cost
			FROM bonus_shop_actions
			ORDER BY ID");
		$ShopItems = $DB->to_array(false, MYSQLI_BOTH);     //, array(3,'Paranoia'));
		$Cache->cache_value('shop_items', $ShopItems);
	}
	return $ShopItems;
}
function get_shop_item($ItemID){
	global $Cache, $DB;
	$ItemID = (int)$ItemID;
	if(($ShopItem = $Cache->get_value('shop_item_' + $ItemID)) === false) {
		$DB->query("SELECT
                        ID, 
                        Title, 
                        Description, 
                        Action, 
                        Value, 
                        Cost
			FROM bonus_shop_actions
			WHERE ID='$ItemID'");
		$ShopItem = $DB->to_array(false, MYSQLI_BOTH);     //, array(3,'Paranoia'));
		$Cache->cache_value('shop_item_' + $ItemID, $ShopItem);
	}
	return $ShopItem;
}
function get_user_stats($UserID){
	global $Cache, $DB;
	$UserID = (int)$UserID;
	$UserStats = $Cache->get_value('user_stats_'.$UserID);
	if(!is_array($UserStats)) {
		$DB->query("SELECT Uploaded AS BytesUploaded, Downloaded AS BytesDownloaded, RequiredRatio FROM users_main WHERE ID='$UserID'");
		$UserStats = $DB->next_record(MYSQLI_ASSOC);
		$Cache->cache_value('user_stats_'.$UserID, $UserStats, 900);
	}
      return $UserStats;
}
?>

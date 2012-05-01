<?php
function get_shop_items(){ 
	global $Cache, $DB;
	static $ShopItems;
	if(is_array($ShopItems)) {
		return $ShopItems;
	}
	if(($ShopItems = $Cache->get_value('shop_items')) === false) {
          // SELECT `ID`, `Title`, `Description`, `Action`, `Value`, `Cost` FROM `bonus_shop_actions` WHERE 1
		$DB->query("SELECT
                        ID,
                        Title,
                        Description, 
                        Action, 
                        Value,
                        Cost
			FROM bonus_shop_actions
			ORDER BY ID");
		$ShopItems = $DB->to_array(false, MYSQLI_BOTH);     //, array(3,'Paranoia'));
		$Cache->cache_value('shop_items', $ShopItems);
	}
	return $ShopItems;
}

?>

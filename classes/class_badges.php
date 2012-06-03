<?

class BADGES {
    // a harcoded array of shiney stuff
	private $Badges = array(   
           
           'usb_award'        =>  array('usb_award.png', 'The USB Fairy Godmother Award','Awarded to USB for services to users above and beyond the call of duty.','Unique',0),
           
           'starred'           =>  array('star_red.png','Red Star','Red Star. This is a placeholder! we need better text & gfx!', 'Shop',30000),
           'starblue'          =>  array('star_blue.png', 'Blue Star','Blue Star. This is a placeholder! we need better text & gfx!', 'Shop',30000),
           'stargreen'         =>  array('star_green.png', 'Green Star','Green Star. This is a placeholder! we need better text & gfx!', 'Shop',40000),
           'staryellow'        =>  array('star_yellow.png', 'Yellow Star','Yellow Star. This is a placeholder! we need better text & gfx!', 'Shop',40000),
           
          
           'bronze_star'           =>  array('bronze-icon.png','Bronze Star','Bronze Star. This is a placeholder! we need better text & gfx!', 'Shop',60000),
           'silver_star'          =>  array('silver-icon.png', 'Silver Star','Silver Star. This is a placeholder! we need better text & gfx!', 'Shop',70000),
           'gold_star'         =>  array('gold-icon.png', 'Gold Star','Gold Star. This is a placeholder! we need better text & gfx!', 'Shop',80000),
           'diamond_star'         =>  array('diamond-icon.png', 'Diamond','Diamond. This is a placeholder! we need better text & gfx!', 'Shop',100000),
           
           'award_bronze'       =>  array('award_bronze.png','Bronze Heart','Awarded for XXXXXX. This is a placeholder! we need better text & gfx!', 'Multiple',0),
           'award_silver'       =>  array('award_silver.png', 'Silver Heart','Awarded for XXXXXX. This is a placeholder! we need better text & gfx!', 'Multiple',0),
           'award_gold'         =>  array('award_gold.png', 'Gold Heart','Awarded for XXXXXX. This is a placeholder! we need better text & gfx!', 'Multiple',0),
           
           'bronze_small'           =>  array('bronze_small.png','Bronze Cup','Awarded for XXXXXX. This is a placeholder! we need better text & gfx!', 'Multiple',0),
           'silver_small'          =>  array('silver_small.png', 'Silver Cup','Awarded for XXXXXX. This is a placeholder! we need better text & gfx!', 'Multiple',0),
           'gold_small'         =>  array('gold_small.png', 'Gold Cup','Awarded for XXXXXX. This is a placeholder! we need better text & gfx!', 'Multiple',0),
           
           'medalbronze'           =>  array('medalbronze.png','Bronze Medal','Awarded for XXXXXX. This is a placeholder! we need better text & gfx!', 'Single',0),
           'medalsilver'          =>  array('medalsilver.png', 'Silver Medal','Awarded for XXXXXX. This is a placeholder! we need better text & gfx!', 'Single',0),
           'medalgold'         =>  array('medalgold.png', 'Gold Medal','Awarded for XXXXXX. This is a placeholder! we need better text & gfx!', 'Single',0),
           
          
           'wealthy_wanker'           =>  array('wealthy_wanker.png','Wealthy Wanker','Plaque of Wealth. This user is a wealthy wanker. This is a placeholder! we need better text & gfx!', 'Shop',200000),
           'filthy_rich'          =>  array('filthy_rich.png', 'Filthy Rich','Plaque of Richness. This user is filthy rich. This is a placeholder! we need better text & gfx!', 'Shop',400000),
           'awesome_mutha'        =>  array('awesome_mutha.png', 'Awesome Muthafucka','Plaque of Awesomeness. This user is an awesome muthafucka. This is a placeholder! we need better text & gfx!', 'Shop',600000),
           'mill_club'         =>  array('mill_club.png', 'Millionaires Club','Millionaires Plaque. This user is a millionaire. This is a placeholder! we need better text & gfx!', 'Shop',1000000),
           
          
          /* 
award_bronze_film.png
award_gold_film.png
award_silver_film.png
          */
	);
      
	 
	function __construct() {
          
		foreach($this->Badges as $Key=>$Val) {
			$this->Badges[$Key][0] = '<img src="'.STATIC_SERVER.'common/badges/'.$Val[0].'" title="'.$Val[2].'" alt="'.$Val[1].'" />';
            }
		reset($this->Badges);  
      }
      
      /*
      function insert_into_db(){
            global $DB;
            
            $SQL = 'INSERT INTO badges 
                            (Type, Sort, Cost, Name, Description, Image) VALUES';
            $Div = '';
                        //$MsgGroups = "torrents ";
            foreach($this->Badges as $Key=>$Val) {
                            
                $SQL .= "$Div ('{$Val[3]}', '$i', '{$Val[4]}', '{$Val[1]}', '{$Val[2]}', '{$Val[0]}')";
                $i++;
                //$MsgGroups .= "$Div$GroupID";
                $Div = ',';
            }
            
            $DB->query($SQL);
               
            
		foreach($this->Badges as $Key=>$Val) {
			$this->Badges[$Key][0] = '<img src="'.STATIC_SERVER.'common/badges/'.$Val[0].'" title="'.$Val[2].'" alt="'.$Val[1].'" />';
            }
		reset($this->Badges);
      } */
      
      
      
      //gets a valid badge array for storage from the passed array
      function get_user_badge_array($BadgeKeys){
            $Badges = array();
		foreach($this->Badges as $Key=>$Val) { // do the loop the long way round to get them in proper order
                  if (in_array($Key, $BadgeKeys )) {
                        $Badges[] = $Key;
                  }
            }
            return $Badges;
      }
      
      // gets the imgs html for the passed badge keys
      function get_badges($BadgeKeys){
            $Str ='';
		foreach($BadgeKeys as $Key) {
			$Str .= $this->Badges[$Key][0]."&nbsp;";
            }
            return $Str;
      }
      
      function get_title($Badge){
          return $this->Badges[$Badge][1];
      }
      
      // for manage user page 
      function print_badges_admin($UserBadges){
		foreach($this->Badges as $Key=>$Badge) {
?>
                <div class="badge">
                    <?=$Badge[0]?> <br />
                    <input type="checkbox" name="badge[]" value="<?=$Key?>" <? //
                                if (in_array($Key, $UserBadges)) { ?>checked="checked"<? } ?> />
                            <label for="badge[]"> <?=$Badge[1]?></label>
                </div>
<?
            }
      }
       
}

?>

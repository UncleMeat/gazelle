<?

class BADGES {
    // a harcoded array of shiney stuff
	private $Badges = array(   
           
           'usb_award'        =>  array('usb_award.png', 'The USB Fairy Godmother Award','Awarded to USB for services to users above and beyond the call of duty.'),
           
           'starred'           =>  array('star_red.png','Red Star','Red Star. This is a placeholder! we need better text & gfx!'),
           'starblue'          =>  array('star_blue.png', 'Blue Star','Blue Star. This is a placeholder! we need better text & gfx!'),
           'stargreen'         =>  array('star_green.png', 'Green Star','Green Star. This is a placeholder! we need better text & gfx!'),
           'staryellow'        =>  array('star_yellow.png', 'Yellow Star','Yellow Star. This is a placeholder! we need better text & gfx!'),
           
          
           'bronze_star'           =>  array('bronze-icon.png','Bronze Star','Bronze Star. This is a placeholder! we need better text & gfx!'),
           'silver_star'          =>  array('silver-icon.png', 'Silver Star','Silver Star. This is a placeholder! we need better text & gfx!'),
           'gold_star'         =>  array('gold-icon.png', 'Gold Star','Gold Star. This is a placeholder! we need better text & gfx!'),
           'diamond_star'         =>  array('diamond-icon.png', 'Diamond','Diamond. This is a placeholder! we need better text & gfx!'),
           
           'award_bronze'       =>  array('award_bronze.png','Bronze Heart','Awarded for XXXXXX. This is a placeholder! we need better text & gfx!'),
           'award_silver'       =>  array('award_silver.png', 'Silver Heart','Awarded for XXXXXX. This is a placeholder! we need better text & gfx!'),
           'award_gold'         =>  array('award_gold.png', 'Gold Heart','Awarded for XXXXXX. This is a placeholder! we need better text & gfx!'),
           
           'bronze_small'           =>  array('bronze_small.png','Bronze Cup','Awarded for XXXXXX. This is a placeholder! we need better text & gfx!'),
           'silver_small'          =>  array('silver_small.png', 'Silver Cup','Awarded for XXXXXX. This is a placeholder! we need better text & gfx!'),
           'gold_small'         =>  array('gold_small.png', 'Gold Cup','Awarded for XXXXXX. This is a placeholder! we need better text & gfx!'),
           
           'medalbronze'           =>  array('medalbronze.png','Bronze Medal','Awarded for XXXXXX. This is a placeholder! we need better text & gfx!'),
           'medalsilver'          =>  array('medalsilver.png', 'Silver Medal','Awarded for XXXXXX. This is a placeholder! we need better text & gfx!'),
           'medalgold'         =>  array('medalgold.png', 'Gold Medal','Awarded for XXXXXX. This is a placeholder! we need better text & gfx!'),
           
          
           'wealthy_wanker'           =>  array('wealthy_wanker.png','Wealthy Wanker','Plaque of Wealth. This user is a wealthy wanker. This is a placeholder! we need better text & gfx!'),
           'filthy_rich'          =>  array('filthy_rich.png', 'Filthy Rich','Plaque of Richness. This user is filthy rich. This is a placeholder! we need better text & gfx!'),
           'awesome_mutha'        =>  array('awesome_mutha.png', 'Awesome Muthafucka','Plaque of Awesomeness. This user is an awesome muthafucka. This is a placeholder! we need better text & gfx!'),
           'mill_club'         =>  array('mill_club.png', 'Millionaires Club','Millionaires Plaque. This user is a millionaire. This is a placeholder! we need better text & gfx!'),
           
          
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

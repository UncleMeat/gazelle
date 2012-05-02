<?
include(SERVER_ROOT.'/sections/bonus/functions.php');

	include(SERVER_ROOT.'/sections/bonus/bonus.php');
      
/*
if(!isset($_REQUEST['action'])) {
	include(SERVER_ROOT.'/sections/bonus/bonus.php');
}
else
{
    switch ($_REQUEST['action']){
          case 'buy':
               
                $forother = strpos($Post['shopaction'], 'give');
                if ($forother!==false){
                    $OtherID = empty($Post['otherid']) ? '' : $Post['otherid'];
                    if (!$OtherID || !is_number($OtherID)) {
                        include(SERVER_ROOT.'/sections/bonus/getotheruser.php');
                        break;
                    }
                }
                include(SERVER_ROOT.'/sections/bonus/takebonus.php');
                break;
            
            default:
                include(SERVER_ROOT.'/sections/bonus/bonus.php');
                break;
    }
} */
 
?>

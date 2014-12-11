<?php
include(SERVER_ROOT.'/classes/class_text.php');
if ( !check_perms('site_give_specialgift') ) {
    error(404);
}
$Text = new TEXT;

// check if their credits need updating (if they have been online whilst creds are accumalting)
$DB->query("SELECT Credits FROM users_main WHERE ID='$LoggedUser[ID]'");
list($TotalCredits) = $DB->next_record();
if ($TotalCredits != $LoggedUser['TotalCredits']) {
    $LoggedUser['TotalCredits'] = $TotalCredits; // for interface below
    $Cache->delete_value('user_stats_' . $LoggedUser['ID']);
}

enforce_login();
show_header('Special Gift','bonus,bbcode');
global $Classes;

?>
<div class="thin">
    <h2>Special Gift</h2>
            <div class="box pad shadow">
<?php
                $creditinfo = get_article('creditsinline');
                if($creditinfo) echo $Text->full_format($creditinfo, true);
?>
            </div>
<?php       if (!empty($_REQUEST['result'])) {  ?>
                <div class="box pad shadow">
                    <h3 class="center"><?=display_str($_REQUEST['result'])?></h3>
                </div>
<?php       }
$DB->query("SELECT BonusLog from users_info WHERE UserID = '".$LoggedUser['ID']."'");
list($BonusLog) = $DB->next_record();
$BonusCredits = $LoggedUser['TotalCredits'];
?>

        <div class="head">
            <span style="float:left;">Bonus Credits</span>
        </div>
        <div class="box">
            <div class="pad" id="bonusdiv">
                <h4 class="center">Credits: <?=(!$BonusCredits ? '0.00' : number_format($BonusCredits,2))?></h4>
                <span style="float:right;"><a href="#" onclick="$('#bonuslogdiv').toggle(); this.innerHTML=(this.innerHTML=='(Show Log)'?'(Hide Log)':'(Show Log)'); return false;">(Show Log)</a></span>&nbsp;

                <div class="hidden" id="bonuslogdiv" style="padding-top: 10px;">
                    <div id="bonuslog" class="box pad scrollbox">
                        <?=(!$BonusLog ? 'no bonus history' :$Text->full_format($BonusLog))?>
                    </div>
<?php
                    $UserResults = $Cache->get_value('sm_sum_history_'.$UserID);
                    if ($UserResults === false) {
                        $DB->query("SELECT Count(ID), SUM(Spins), SUM(Won),SUM(Bet*Spins),(SUM(Won)/SUM(Bet*Spins))
                                  FROM sm_results WHERE UserID = $UserID");
                        $UserResults = $DB->next_record();
                        $Cache->cache_value('sm_sum_history_'.$UserID, $UserResults, 86400);
                    }
                    if (is_array($UserResults) && $UserResults[0] > 0) {

                        list($Num, $NumSpins, $TotalWon, $TotalBet, $TotalReturn) = $UserResults;
?>
                        <div class="box pad" title="<?="spins: $NumSpins ($Num) | -$TotalBet | +$TotalWon | return: $TotalReturn"?>">
                            <strong>Slot Machine:</strong> <?= ($TotalWon-$TotalBet)?> credits
                        </div>
<?php
                    }
?>
                </div>
           </div>
        </div>
    <div class="head">Special Gift</div>
<?php
if ($LoggedUser['TotalCredits'] >= 600) { ?>
    <form method="post" action="bonus.php" method="post" class="bonusshop" id="giftform">
        <input type="hidden" name="action" value="givegift" />
        <input type="hidden" name="UserID" value="<?=$LoggedUser['ID']?>" />
         <input type="hidden" name="auth" value="<?=$LoggedUser['AuthKey']?>" />

        <table class="bonusshop">
            <tr class="smallhead">
                <td>Donation</td>
                <td>Class</td>
                <td>Ratio</td>
                <td>Credits</td>
                <td>Last Seen</td>
            </tr>
            <tr>
                <td>
        <select name="donate">
                    <option value="600">600</option>
<?php     if ($LoggedUser['TotalCredits'] >= 3000) { ?>
                    <option value="3000">3000</option>
<?php     } if ($LoggedUser['TotalCredits'] >= 6000) { ?>
                    <option value="6000">6000</option>
<?php     } ?>
        </select>
                </td>
                <td>
        <select name="class">
                    <option value="<= ".<?=$Classes[SMUT_PEDDLER]['Level']?>>any</option>
                    <option value="<= ".<?=$Classes[APPRENTICE]['Level']?>>Apprentice</option>
                    <option value="<= ".<?=$Classes[PERV]['Level']?>>Perv or lower</option>
                    <option value="<= ".<?=$Classes[GOOD_PERV]['Level']?>>Good Perv or lower</option>
                    <option value=">= ".<?=$Classes[GOOD_PERV]['Level']?>>Good Perv or higher</option>
                    <option value=">= ".<?=$Classes[SEXTREME_PERV]['Level']?>>Sextreme Perv or higher</option>
        </select>
                </td>
                <td>
        <select name="ratio">
                    <option value="> 0.0">any</option>
                    <option value="< 0.5">very low (below 0.5)</option>
                    <option value="< 1.0">low (below 1.0)</option>
                    <option value="> 1.0">good (above 1.0)</option>
                    <option value="> 5.0">excellent (above 5.0)</option>
        </select>
                </td>
                <td>
        <select name="credits">
                    <option value=">= 0">any</option>
                    <option value="< 3000">poor (3,000 or less)</option>
                    <option value="< 12000">has some (12,000 or less)</option>
                    <option value="> 12000">rich (12,000 or more)</option>
        </select>
                </td>
                <td>
        <select name="last_seen">
                    <option value="1">now (within the last hour)</option>
                    <option value="24">today (within the last 24 hours)</option>
                    <option value="3*24">recently (within the last 3 days)</option>
                    <option value="7*24">not too long ago (within the last week)</option>
        </select>
                </td>
            </tr>
            <tr>
                <td colspan=5>
                    <div class="box pad cener" style="text-align:center;">
                        <input type="submit" class=" center" style="font-weight:bold;font-size:1.8em;" value="  Give Gift  " />
                    </div>
                </td>
            </tr>
        </table>
        </form>

<?php } else { ?>
        <div class="box pad shadow">
            <strong>You have insufficient credits to give a gift.</strong>
        </div>
<?php } ?>
    </div>
<?php
show_footer();

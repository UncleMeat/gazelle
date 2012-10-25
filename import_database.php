<?php 
       
set_time_limit(0);
error_reporting(0);

define('EMDB', 'emp');
define('TORRENT_PATH', '/home/tracker/gazelle/torrents');


$smilies = array(
           ':smile1:'           => 'smile1.gif',
           ':smile2:'           => 'smile2.gif',
           ':D'           => 'biggrin.gif',
           ':grin:'           => 'grin.gif',
           ':laugh:'           => 'laugh.gif',
           ':w00t:'           => 'w00t.gif',
           ':tongue:'           => 'tongue.gif',
           ':wink:'           => 'wink.gif',
           ':noexpression:'           => 'noexpression.gif',
           ':confused:'           => 'confused.gif',
           ':sad:'           => 'sad.gif',
           ':cry:'           => 'cry.gif',
           ':weep:'           => 'weep.gif',
           ':voodoo:'           => 'voodoo.gif',
           ':yaydance:'           => 'yaydance.gif',
           ':lol:'           => 'lol.gif',
           ':gjob:'           => 'thumbup.gif',
          
          
           ':mad:'           => 'mad2.gif',
           ':banghead:'           => 'banghead.gif',
           ':gunshot:'           => 'gunshot.gif',
           ':no2:'           => 'no2.gif',
           ':yes2:'           => 'yes2.gif',
           ':wanker:'           => 'wanker.gif',
           ':sorry:'           => 'sorry.gif',
          
          
          //===========================================
          
           ':borg:'           => 'borg.gif',
           ':nasher:'           => 'gnasher.gif',
           ':panic:'           => 'panic.gif',
           ':worm:'           => 'worm2.gif',
          
           ':evilbunny:'           => 'evilimu.gif',
          
          //=============================================
          
           ':ohmy:'           => 'ohmy.gif',
           ':sleeping:'           => 'sleeping.gif',
           ':innocent:'           => 'innocent.gif',
           ':whistle:'           => 'whistle.gif',
           ':unsure:'           => 'unsure.gif',
           ':closedeyes:'           => 'closedeyes.gif',
           ':cool:'           => 'cool.gif',
           ':cool1:'           => 'cool2.gif',
           ':cool2:'           => 'cool1.gif',
           ':fun:'           => 'fun.gif',
           ':thumbsup:'           => 'thumbsup.gif',
           ':thumbsdown:'           => 'thumbsdown.gif',
           ':blush:'           => 'blush.gif',
           ':yes:'           => 'yes.gif',
           ':no:'           => 'no.gif',
           ':love:'           => 'love.gif',
           ':question:'           => 'question.gif',
           ':excl:'           => 'excl.gif',
           ':idea:'           => 'idea.gif',
           ':arrow:'           => 'arrow.gif',
           ':arrow2:'           => 'arrow2.gif',
           ':hmm:'           => 'hmm.gif',
           ':hmmm:'           => 'hmmm.gif',
          
           ':tiphat:'           => 'tiphat.gif',
          
           ':huh:'           => 'huh.gif',
           ':dunno:'           => 'dunno.gif',
           ':geek:'           => 'geek.gif',
           ':look:'           => 'look.gif',
           ':rolleyes:'           => 'rolleyes.gif',
           ':punk:'           => 'punk.gif',
           ':shifty:'           => 'shifty.gif',
           ':blink:'           => 'blink.gif',
           ':smart:'           => 'smartass.gif',
           ':sick:'           => 'sick.gif',
           ':crazy:'           => 'crazy.gif',
           ':wacko:'           => 'wacko.gif',
           ':wave:'           => 'wave.gif',
           ':wavecry:'           => 'wavecry.gif',
           ':baby:'           => 'baby.gif',
           ':angry:'           => 'angry.gif',
           ':ras:'           => 'ras.gif',
           ':sly:'           => 'sly.gif',
           ':devil:'           => 'devil.gif',
           ':evil:'           => 'evil.gif',
           ':evilmad:'           => 'evilmad.gif',
           ':sneaky:'           => 'sneaky.gif',
           ':icecream:'           => 'icecream.gif',
           ':hooray:'           => 'hooray.gif',
           ':slap:'           => 'slap.gif',
           ':sigh:'           => 'facepalm.gif',
           ':wall:'           => 'wall.gif',
           ':yucky:'           => 'yucky.gif',
           ':nugget:'           => 'nugget.gif',
           ':smartass:'           => 'smart.gif',
           ':shutup:'           => 'shutup.gif',
           ':shutup2:'           => 'shutup2.gif',
           ':weirdo:'           => 'weirdo.gif',
           ':yawn:'           => 'yawn.gif',
           ':snap:'           => 'snap.gif',
           ':strongbench:'           => 'strongbench.gif',
           ':weakbench:'           => 'weakbench.gif',
           ':dumbells:'           => 'dumbells.gif',
           ':music:'           => 'music.gif',
           ':guns:'           => 'guns.gif',
           ':clap2:'           => 'clap2.gif',
           ':kiss:'           => 'kiss.gif',
           ':clown:'           => 'clown.gif',
           ':cake:'           => 'cake.gif',
           ':alien:'           => 'alien.gif',
           ':wizard:'           => 'wizard.gif',
           ':beer:'           => 'beer.gif',
           ':beer2:'           => 'beer2.gif',
           ':drunken:'           => 'drunk.gif',
           ':rant:'           => 'rant.gif',
           ':tease:'           => 'tease.gif',
           ':box:'           => 'box.gif', 
          
           ':daisy:'           => 'daisy.gif',
           ':demon:'           => 'demon.gif',
           ':fdevil:'           => 'flamingdevil.gif',
           ':flipa:'           => 'flipa.gif',
           ':flirty:'           => 'flirtysmile1.gif',
           ':lollol:'           => 'lolalot.gif',
           ':lovelove:'           => 'lovelove.gif',
           ':ninja1:'           => 'ninja1.gif',
           ':nom:'           => 'nom.gif',
           ':samurai:'           => 'samurai.gif',
           ':sasmokin:'           => 'sasmokin.gif',
          
           ':smallprint:'         =>  'deal.gif',
          //----------------------------
          
           ':happydancing:'           => 'happydancing.gif',
           ':argh:'           => 'frustrated.gif',
           ':tumble:'           => 'tumbleweed.gif',
          
           ':popcorn:'           => 'popcorn.gif',
          
           ':fishing:'           => 'fishing.gif',
           ':clover:'           => 'clover.gif',
           ':shit:'           => 'shit.gif',
           ':whip:'           => 'whip.gif',
           ':judge:'           => 'judge.gif',
           ':chair:'           => 'chair.gif',
          
           ':pythfoot:'           => 'pythfoot.gif',
          
          
           ':boxing:'           => 'boxing.gif',
           ':shoot:'           => 'shoot.gif',
           ':shoot2:'           => 'shoot2.gif',
           ':flowers:'           => 'flowers.gif',
           ':wub:'           => 'wub.gif',
           ':lovers:'           => 'lovers.gif',
           ':kissing:'           => 'kissing.gif',
           ':kissing2:'           => 'kissing2.gif',
           ':console:'           => 'console.gif',
           ':group:'           => 'group.gif',
           ':hump:'           => 'hump.gif',
           ':happy2:'           => 'happy2.gif',
           ':clap:'           => 'clap.gif',
           ':crockett:'           => 'crockett.gif',
           ':zorro:'           => 'zorro.gif',
           ':bow:'           => 'bow.gif',
           ':dawgie:'           => 'dawgie.gif',
           ':cylon:'           => 'cylon.gif',
           ':book:'           => 'book.gif',
           ':fish:'           => 'fish.gif',
           ':mama:'           => 'mama.gif',
           ':pepsi:'           => 'pepsi.gif',
           ':medieval:'           => 'medieval.gif',
           ':rambo:'           => 'rambo.gif',
           ':ninja:'           => 'ninja.gif',
           ':party:'           => 'party.gif',
           ':snorkle:'           => 'snorkle.gif',
           ':king:'           => 'king.gif',
           ':chef:'           => 'chef.gif',
           ':mario:'           => 'mario.gif',
           ':fez:'           => 'fez.gif',
           ':cap:'           => 'cap.gif',
           ':cowboy:'           => 'cowboy.gif',
           ':gunslinger:'           => 'cowboygun.gif',
           ':pirate:'           => 'pirate.gif',
           ':pirate2:'           => 'pirate2.gif',
           ':piratehook:'           => 'piratehook.gif',
           ':piratewhistle:'           => 'pirate_whistle.gif',
          
           ':punk:'           => 'punk.gif',
           ':rock:'           => 'rock.gif', 
           ':rocker:'           => 'rock-smiley.gif',
          
           ':cigar:'           => 'cigar.gif',
           ':oldtimer:'           => 'oldtimer.gif',
           ':trampoline:'           => 'trampoline.gif',
           ':bananadance:'           => 'bananadance.gif',
           ':smurf:'           => 'smurf.gif',
           ':yikes:'           => 'yikes.gif',
          
          //----------------------------
          //----------------------------
           ':sing:'           => 'singing.gif',
           ':sing1:'           => 'smiley_singing.gif',
           ':sing2:'           => 'blobsing.gif',
           ':singrain:'           => 'singrain.gif',
           ':choir:'           => 'choir.gif',
          
           ':alarmed:'           => 'alarmed-smiley.gif',
           ':amen:'           => 'amen.gif',
           ':applause:'           => 'appl.gif',
           ':argue:'           => 'argue.gif',
           ':asshole:'           => 'asshole.gif',
           ':backingout:'           => 'backingout.gif',
           ':badday:'           => 'badday.gif',
           ':bann:'           => 'bann.gif',
           ':banstamp:'           => 'banned.gif',
           ':blahblah:'           => 'blahblah.gif',
           ':coffee:'           => 'coffee1.gif',
           ':coffee1:'           => 'coffee3.gif',
           ':coffee2:'           => 'coffee4.gif',
           ':coffee3:'           => 'coffee5.gif',
           ':coffee4:'           => 'bulbar-smiley.gif',
           ':bum:'           => 'bum.gif',
           ':bk:'           => 'burgerking.gif',
           ':carryon:'           => 'carryon.gif',
           ':chat:'           => 'chatsmileys.gif',
           ':delete:'           => 'delete1-smiley.gif',
           ':drooling:'           => 'drooling_smiley.gif',
           ':drunk:'           => 'drunk2.gif',
          
           ':rain:'           => 'rain.gif',
           ':cheer:'           => 'cheerlead.gif',
           ':broccolidance:'    =>  'broccolidance.gif',
           ':bonerdance:'        => 'bonerdance.gif',
          
           ':dupe:'           => 'dupe.gif',
           ':fly:'           => 'fly.gif',
           ':goldstars:'           => 'goldstars.gif',
           ':hangin:'           => 'hangin.gif',
           ':hat:'           => 'hat.gif',
           ':help:'           => 'help.gif',
           ':high5:'           => 'high5.gif',
           ':hungry:'           => 'hungry.gif',
           ':paper:'           => 'icon_paper.gif',
           ':ideabulb:'           => 'ideabulb.gif',
           ':ignore:'           => 'ignore.gif',
           ':impatient:'           => 'impatient.gif',
           ':irule:'           => 'irule.gif',
           ':kickme:'           => 'kickme.gif',
           ':kissass:'           => 'kissass.gif',
           ':lgh:'           => 'lgh.gif',
           ':lurking:'           => 'Lurking.gif',
           ':paranoia:'           => 'paranoia.gif',
           ':paranoid:'           => 'paranoid.gif',
           ':pillowfight:'           => 'pillowfight.gif',
          
           ':pplease:'           => 'pplease.gif',
           ':pray:'           => 'pray.gif',
           ':preach:'           => 'preach.gif',
           ':protected:'           => 'protected.gif',
           ':rantpin:'           => 'rant_pin.gif',
           ':reap:'           => 'reaper2.gif',
           ':run:'           => 'run.gif',
           ':shower:'           => 'Shower.gif',
           ':soapboxrant:'           => 'soapboxrant.gif',
           ':preacher:'           => 'preacher.gif',
           ':talkhand:'           => 'talkhand.gif',
           ':pizza:'           => 'th_smiley_pizza.gif',
           ':therethere:'           => 'therethere.gif',
           ':topicclosed:'           => 'topicclosed.gif',
           ':viking:'           => 'viking.gif',
           ':whatdidimiss:'           => 'whatdidimiss.gif',
           ':ding:'           => 'winnersmiley.gif',
           ':ridicule:'           => 'ridicule.gif',
          
          
          
          //----------------------------
          
          
          
           ':vader-smiley:'           => 'vader-smiley.gif',
           ':lsvader:'           => 'lsvader.gif',
           ':emperor:'           => 'emperor.gif',
          
          //----------------------------
          
          
           ':punish:'           => 'punish.gif',
           ':puppykisses:'           => 'puppykisses.gif',
          
           ':allbetter:'           => 'allbetter.gif',
           ':bitchfight:'           => 'bitchfight.gif',
           ':buddies:'           => 'buddies.gif',
           ':chase:'           => 'chase.gif',
           ':bugchases:'           => 'bugchases.gif',
          
           ':hello:'           => 'hellopink.gif',
          
          //----------------------------
       
           ':bombie:'           => 'bomb_ie.gif',
          
          
           ':alcapone:'           => 'alcapone.gif',
           ':aliendance:'           => 'Aliendance.gif',
           ':badboy:'           => 'badboy.gif',
           ':bash:'           => 'bash.gif',
           ':bashfutile:'           => 'bashfutile.gif',
           ':bath:'           => 'bath.gif',
           ':bolt:'           => 'Bolt.gif',
          
          
           ':boxerko:'           => 'boxerknockedout.gif',
           ':bunnysmiley:'           => 'bunny-smiley.gif',
           ':buttshake:'           => 'buttshake.gif',
           ':buttlicker:'           => 'sfun_butt-biting.gif',
          
           ':cavitysearch:'           => 'cavitysearch.gif',
           ':cheerleader:'           => 'cheerleader.gif',
           ':cigarpuff:'           => 'cigar-smiley.gif',
           ':climbing:'           => 'climbing-smiley.gif',
           ':clownhat:'           => 'clown-smiley.gif',
          
           ':computerpunch:'           => 'computer_punch_smiley.gif',
        
           ':dancelessons:'           => 'Dance_lessons.gif',
           ':dancing:'           => 'dancing-smiley.gif',
           ':diggin:'           => 'digg-in-smiley.gif',
           ':drool:'           => 'drool.gif',
           ':egyptdance:'           => 'egyptdance.gif',
           ':usb:'           => 'fairy-smiley.gif',
           ':fiesta:'           => 'fiesta-smiley.gif',
           ':flirty2:'           => 'flirty2-smiley.gif',
           ':flirty3:'           => 'flirty3-smiley.gif',
           ':flirty4:'           => 'flirty4-smiley.gif',
           ':flower1:'           => 'flower1-smiley.gif',
           ':flower2:'           => 'flower2-smiley.gif',
           ':flower3:'           => 'flower3-smiley.gif',
           ':flowerrow:'           => 'flowersrow.gif',
           ':swede:'           => 'free_swe34.gif',
           ':freezin:'           => 'freez-in1-smiley.gif',
          
          
           ':ghost:'           => 'ghost.gif',
           ':ghostie:'           => 'ghostie.gif',
           ':giraffe:'           => 'giraffe-smiley.gif',
           ':giveup:'           => 'giveup.gif',
           ':goldmedal:'           => 'gold-medalist-smiley.gif',
           ':star:'           => 'goldstar.gif',
           ':goldstar:'           => 'gold-star-smiley.gif',
           ':greenchilli:'           => 'greenchilli.gif',
           ':tinfoil:'           => 'hat-tin-foil-smiley.gif',
           ':tinfoilhat:'           => 'tinfoilhatsmile.gif',
        
           ':hooked:'           => 'hooked.gif',
           ':horsie:'           => 'horsiecharge.gif',
           ':chainsaw:'           => 'icon_chainsaw.gif',

           ':inlove:'           => 'inlove.gif',
           ':jeeves:'           => 'jeeves-smiley.gif',
           ':mrdick:'           => 'Mrdick.gif',
           ':sofanap:'           => 'napsmileyff.gif',
          
           ':saw:'           => 'newsaw.gif',
           ':chairspin:'           => 'officechair.gif',
           ':offtobed:'           => 'off-to-bed-smiley.gif',
           ':otpatrol:'           => 'offtopic8mg.gif',
           ':pickme:'           => 'pickme.gif',
           
           ':poker:'           => 'playing poker.gif',
           ':pray:'           => 'pray.gif',
           ':punchballs:'           => 'punchballs.gif',
           ':puzzled:'           => 'puzzled.gif',
           ':ranting:'           => 'ranting.gif',
           ':reaper:'           => 'reaper.gif',
           ':redchilli:'           => 'redchilli.gif',
           ':redx:'           => 'redx-smiley.gif',
           ':robot:'           => 'robot.gif',
           ':rockingchair:'           => 'rocking-chair2-smiley.gif',
         
           ':roman:'           => 'roman-smiley.gif',
           ':rtfm:'           => 'rtfm.gif',
           ':running:'           => 'running-smiley.gif',
          
           ':goodevil:'           => 'samvete-smiley.gif',
           ':savage:'           => 'savage1-smiley.gif',
           ':scorer:'           => 'scorer-smiley.gif',
          
           ':smoking:'           => 'smoking-smiley.gif',
           ':snapoutofit:'           => 'snap-out-of-it-smiley.gif',
           ':sneaking:'           => 'sneaking-smiley.gif',
           ':snooty:'           => 'snooty.gif',
           ':snow:'           => 'snow.gif',
           ':soapbox:'           => 'soapbox.gif',
           ':starescreen:'           => 'stare-screen-smiley.gif',
           ':stir:'           => 'stir.gif',
           ':surrender:'           => 'surrender.gif',
           ':swear1:'           => 'swear2-smiley.gif',
           ':swear2:'           => 'swear1-smiley.gif',
           ':crazyjacket:'           => 'th_crazy2.gif',
          
          
           ':twocents:'           => 'twocents.gif',
          
           ':underweather:'           => 'underweather.gif',
          
           ':why:'           => 'why.gif',
           ':zzz:'           => 'zzz.gif',
          
           
          
          
          //----------------------------
          
          
           ':santa:'           => 'santa.gif',
           ':indian:'           => 'indian.gif',
           ':pimp:'           => 'pimp.gif',
           ':nuke:'           => 'nuke.gif',
           ':jacko:'           => 'jacko.gif',
           ':greedy:'           => 'greedy.gif',
           ':super:'           => 'super.gif',
           ':wolverine:'           => 'wolverine.gif',
           ':spidey:'           => 'spidey.gif',
           ':spider:'           => 'spider.gif',
           ':bandana:'           => 'bandana.gif',
           ':construction:'           => 'construction.gif',
           ':sheep:'           => 'sheep.gif',
           ':police:'           => 'police.gif',
           ':detective:'           => 'detective.gif',
           ':bike:'           => 'bike.gif',
           ':badass:'           => 'badass.gif',
          
          
           ':blind:'           => 'blind.gif',
           ':blah:'           => 'blah.gif',
           ':boner:'           => 'boner.gif',
           ':goodjob:'           => 'gjob.gif',
           ':dist:'           => 'dist.gif',
           ':urock:'           => 'urock.gif',
             ':megarant:'           => 'megarant.gif',
           ':adminpower:'           => 'hitler_admin.gif',
          
           ':wtfsign:'           => 'wtfsign.gif',
           ':stupid:'           => 'stupid.gif',
           ':dots:'           => 'dots.gif',
           ':offtopic:'           => 'offtopic.gif',
           ':spam:'           => 'spam.gif',
           ':oops:'           => 'oops.gif',
           ':lttd:'           => 'lttd.gif',
           ':please:'           => 'please.gif',
           ':imsorry:'           => 'imsorry.gif',
           ':hi:'           => 'hi.gif',
           ':liessign:'           => 'liessign.gif',
           ':goodnight:'           => 'goodnightsign.gif',
           ':respect:'           => 'sign_respect1.gif',
           ':welcome3:'           => 'welcome3.gif',
        
           ':banned:'           => 'banned1-smiley.gif',
           ':hamster:'           => 'hamster.gif',
          
          
           ':elder:'           => 'elder-smiley.gif',
           ':emu:'           => 'Emu.gif',
           ':evilgenius:'           => 'evil-genius-smiley.gif',
           ':lesson:'           => 'explanation-smiley.gif',
          //=======================================================================
          
          
          
           ':lmao:'           => 'lmao.gif',
          
           ':rules:'           => 'rules.gif',
           ':tobi:'           => 'tobi.gif',
          
           ':jump:'           => 'jump.gif',
           ':yay:'           => 'yay.gif',
           ':hbd:'           => 'hbd.gif',
           ':band:'           => 'band.gif',
          
           ':rofl:'           => 'rofl.gif',
           ':bounce:'           => 'bounce.gif',
           ':mbounce:'           => 'mbounce.gif',
           ':thankyou:'           => 'thankyou.gif',
           ':gathering:'           => 'gathering.gif',
           ':colors:'           => 'colors.gif',
           ':oddoneout:'           => 'oddoneout.gif',
          
           ':ufo:'           => 'ufo-smiley.gif',
          
           ':tank:'           => 'tank.gif',
           ':guillotine:'           => 'guillotine.gif',
          
           ':yesno:'           => 'yesno.gif',
           ':erection:'           => 'erection1.gif',
           ':fucku:'           => 'fucku.gif',
           ':spamhammer:'           => 'spamhammer.gif',
           ':atomic:'           => 'atomic.gif',
          
           ':ttiwwp:'           => 'ttiwwp.gif',
           ':fireworks:'           => 'fireworks.gif',
          
           ':genie:'           => 'genie.gif',
          
           ':volleygoal:'           => 'volleygoal.gif',
          
           ':brick:'           => 'brick.gif',
           
           ':banaalien:'           => 'banaAlien.gif',
           ':banababydance:'           => 'banaBabydance.gif',
           ':banabye:'           => 'banaBye.gif',
           ':banacheer:'           => 'banaCheer.gif',
           ':banacomputer:'           => 'banaComputer.gif',
           ':banadoggy:'           => 'banaDoggy.gif',
           ':banadressedup:'           => 'banaDressedup.gif',
           ':banadrinking:'           => 'banaDrinking.gif',
           ':banaelvis:'           => 'banaElvis.gif',
           ':banaevildance:'           => 'banaEvildance.gif',
           ':banaexercise:'           => 'banaExercise.gif',
           ':banagunman:'           => 'banaGunman.gif',
           ':banainvisible:'           => 'banaInvisible.gif',
           ':banarasta:'           => 'banaRasta.gif',
           ':banaskiing:'           => 'banaSkiing.gif',
           ':banawhip:'           => 'banaWhip.gif',
          
          
	);
	

function is_number($Str) {
    $Return = true;
    if ($Str < 0) {
        $Return = false;
    }
    // We're converting input to a int, then string and comparing to original
    $Return = ($Str == strval(intval($Str)) ? true : false);
    return $Return;
}

function make_secret2($Length = 32) {
    $Secret = '';
    $Chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
    for ($i = 0; $i < $Length; $i++) {
        $Rand = mt_rand(0, strlen($Chars) - 1);
        $Secret .= substr($Chars, $Rand, 1);
    }
    return str_shuffle($Secret);
}

/*
function cleansearch($s)
{
    global $smilies;

    foreach ($smilies as $key => $value)
    {
        $remove[] = "/$key/i";
    }
    $remove[] = '/\[img\].*?\[\/img\]/i';
    $remove[] = '/\[img=.*?\].*?\[\/img\]/i';
    $remove[] = '/\[url=.*?\].*?\[\/url\]/i';
    $remove[] = '/\[url\].*?\[\/url\]/i';
    $remove[] = '/\[flash\].*?\[\/flash\]/i';
    $remove[] = '/\[audio\].*?\[\/audio\]/i';
    $remove[] = '/\[thumb\].*?\[\/thumb\]/i';
    $remove[] = '/\[banner\].*?\[\/banner\]/i';
    $remove[] = '/\[media=.*?\].*?\[\/media\]/i';
    $remove[] = '/\[video=.*?\]/i';
    $remove[] = '/\[spoiler\]/i';
    $remove[] = '/\[\/spoiler\]/i';
    $remove[] = '/\[quote\]/i';
    $remove[] = '/\[\/quote\]/i';
    $remove[] = '/\[b\]/i';
    $remove[] = '/\[\/b\]/i';
    $remove[] = '/\[i\]/i';
    $remove[] = '/\[\/i\]/i';
    $remove[] = '/\[u\]/i';
    $remove[] = '/\[\/u\]/i';
    $remove[] = '/\[s\]/i';
    $remove[] = '/\[\/s\]/i';

    $s = preg_replace($remove, '', $s);
    return $s;
} */

        
function cleansearch($Str) {
    global $smilies;
            
                foreach ($smilies as $key => $value)
                {
                    $remove[] = "/$key/i";
                }

                // anchors
                $remove[] = '/\[\#.*?\]/i';
                $remove[] = '/\[\/\#\]/i';
                $remove[] = '/\[anchor.*?\]/i';
                $remove[] = '/\[\/anchor\]/i';
                
                $remove[] = '/\[align.*?\]/i';
                $remove[] = '/\[\/align\]/i';

                $remove[] = '/\[audio\].*?\[\/audio\]/i';

                $remove[] = '/\[b\]/i';
                $remove[] = '/\[\/b\]/i';

                $remove[] = '/\[banner\].*?\[\/banner\]/i';

                $remove[] = '/\[bg.*?\]/i';
                $remove[] = '/\[\/bg\]/i';

                $remove[] = '/\[br\]/i';

                $remove[] = '/\[cast\]/i';

                $remove[] = '/\[center.*?\]/i';
                $remove[] = '/\[\/center\]/i';
                
                $remove[] = '/\[codeblock.*?\]/i';
                $remove[] = '/\[\/codeblock\]/i';

                $remove[] = '/\[code.*?\]/i';
                $remove[] = '/\[\/code\]/i';

                $remove[] = '/\[color.*?\]/i';
                $remove[] = '/\[\/color\]/i';

                $remove[] = '/\[colour.*?\]/i';
                $remove[] = '/\[\/colour\]/i';

                $remove[] = '/\[details\]/i';

                $remove[] = '/\[flash\].*?\[\/flash\]/i';

                $remove[] = '/\[font.*?\]/i';
                $remove[] = '/\[\/font\]/i';

                $remove[] = '/\[link.*?\]/i';
                $remove[] = '/\[\/link\]/i';
                
                $remove[] = '/\[hide\]/i';
                $remove[] = '/\[\/hide\]/i';

                $remove[] = '/\[hr\]/i';

                $remove[] = '/\[i\]/i';
                $remove[] = '/\[\/i\]/i';

                $remove[] = '/\[img.*?\].*?\[\/img\]/i';

                $remove[] = '/\[important\]/i';
                $remove[] = '/\[\/important\]/i';

                $remove[] = '/\[info\]/i';

                $remove[] = '/\[list\]/i';
                $remove[] = '/\[\/list\]/i';

                $remove[] = '/\[mcom\]/i';
                $remove[] = '/\[\/mcom\]/i';

                $remove[] = '/\[media.*?\].*?\[\/media\]/i';

                $remove[] = '/\[plain\]/i';
                $remove[] = '/\[\/plain\]/i';

                $remove[] = '/\[plot\]/i';

                $remove[] = '/\[pre\]/i';
                $remove[] = '/\[\/pre\]/i';

                $remove[] = '/\[quote\]/i';
                $remove[] = '/\[\/quote\]/i';

                $remove[] = '/\[s\]/i';
                $remove[] = '/\[\/s\]/i';

                $remove[] = '/\[screens\]/i';

                $remove[] = '/\[size.*?\]/i';
                $remove[] = '/\[\/size\]/i';

                $remove[] = '/\[spoiler\]/i';
                $remove[] = '/\[\/spoiler\]/i';

                // Table elements
                $remove[] = '/\[table.*?\]/i';
                $remove[] = '/\[\/table\]/i';
                $remove[] = '/\[tr.*?\]/i';
                $remove[] = '/\[\/tr\]/i';
                $remove[] = '/\[th.*?\]/i';
                $remove[] = '/\[\/th\]/i';
                $remove[] = '/\[td.*?\]/i';
                $remove[] = '/\[\/td\]/i';

                $remove[] = '/\[tex\].*?\[\/tex\]/i';

                $remove[] = '/\[thumb\].*?\[\/thumb\]/i';

                $remove[] = '/\[torrent\].*?\[\/torrent\]/i';

                $remove[] = '/\[u\]/i';
                $remove[] = '/\[\/u\]/i';

                $remove[] = '/\[url.*?\].*?\[\/url\]/i';

                $remove[] = '/\[user\]/i';
                $remove[] = '/\[\/user\]/i';

                $remove[] = '/\[vid.*?\]/i';
                $remove[] = '/\[video.*?\]/i';

                $remove[] = '/\[you\]/i';
                
                $Str = preg_replace($remove, '', $Str);
                $Str = preg_replace('/[\r\n]+/', ' ', $Str);
                
                return $Str;
        }

//define('SERVER_ROOT', '/home/tracker/gazelle');
require('/home/tracker/gazelle/classes/config.php');
require('/home/tracker/gazelle/classes/class_torrent.php');

$time_start = microtime(true);

echo "connecting to database<br/>";
mysql_connect(SQLHOST, SQLLOGIN, SQLPASS);
/*
echo "Creating new authkeys for users\n";
mysql_query("UPDATE gazelle.users_info
	SET AuthKey =
		MD5(
			CONCAT(
				AuthKey, RAND(), '".mysql_real_escape_string(make_secret2())."',
				SHA1(
					CONCAT(
						RAND(), RAND(), '".mysql_real_escape_string(make_secret2())."'
					)
				)
			)
		);"
	) or die(mysql_error());
*/

if (isset($_GET['skipkeys'])){
    echo "\$_GET['skipkeys'] so skipping adding authkeys for users (for if they have already been generated)<br/>";
}else {
    
    // Added setting CatchupTime for forums - UNTESTED in situ - unaltered code above
    echo "Update users: generate new authkeys, CatchupTime=UTC_TIMESTAMP()<br/>";
    //$sqltime = sqltime();
    $sqltime = date('Y-m-d H:i:s', time());

    mysql_query("UPDATE gazelle.users_info
        SET AuthKey =
            MD5(
                CONCAT(
                    AuthKey, RAND(), '".mysql_real_escape_string(make_secret2())."',
                    SHA1(
                        CONCAT(
                            RAND(), RAND(), '".mysql_real_escape_string(make_secret2())."'
                        )
                    )
                )
            ), CatchupTime='$sqltime';"
        ) or die(mysql_error());
}


echo "creating new invite_tree table for users<br/>";

$result = mysql_query('select ID from gazelle.users_main') or die(mysql_error());

$TreeIndex = 2;
$values = array();
$comma = "";
while (($row = mysql_fetch_assoc($result))) {
    $values[] = "(".$row["ID"].", 0, $TreeIndex, 0, 2)";
    $TreeIndex++;
}


mysql_query("TRUNCATE TABLE gazelle.invite_tree;") or die(mysql_error());;

mysql_query("insert into gazelle.invite_tree values ".implode(',',$values)) or die(mysql_error());

$result = mysql_query("select count(*) as c from " . EMDB . ".torrents") or die(mysql_error());
$count = mysql_result($result, 0);
echo "Importing $count torrents to database... (this will take a while)<br/>";
echo "Each dot is 50 torrents, an x means a torrent with an info hash that is already in the table.<br/>";

// Get the categories from the gazelle db
$result = mysql_query("select * from gazelle.categories") or die(mysql_error());
$categories = array();
while ($row = mysql_fetch_assoc($result)) {
    $categories[$row['id']] = $row;
}

$info_hash_array = array();
$i = 0;
$TagIDCounter = 0;
$TorrentID = 0;
$result = mysql_query("select * from " . EMDB . ".torrents ORDER BY id") or die(mysql_error());

$torrents_group_rows = array();
$tagids = array();
$tags_row = array();
$torrents_tags_row = array();
$torrents_row = array();
$torrents_files_row = array();

$numemptorrents = mysql_num_rows($result);
echo "selected $numemptorrents torrents for import...<br/>";
        
mysql_query("TRUNCATE TABLE gazelle.torrents_group;") or die(mysql_error());;
mysql_query("TRUNCATE TABLE gazelle.torrents;") or die(mysql_error());;
mysql_query("TRUNCATE TABLE gazelle.torrents_files;") or die(mysql_error());;
mysql_query("TRUNCATE TABLE gazelle.tags;") or die(mysql_error());;
mysql_query("TRUNCATE TABLE gazelle.torrents_tags;") or die(mysql_error());;
        
if (isset($_REQUEST['logafter'])){
    $LogAfter = (int)$_REQUEST['logafter'];
    echo "[Logging ID's after $LogAfter]";
}

echo "0.00% <br/>";
while (($row = mysql_fetch_assoc($result))) {
    if ($LogAfter > 0){ // use sparingly... only for bug hunting
        if ($row['id'] >= $LogAfter ){
            echo ",$row[id]";
        }
    }
    $File = fopen(TORRENT_PATH . '/' . $row['id'] . '.torrent', 'rb'); // open file for reading
    $Contents = fread($File, 10000000);
    $Tor = new TORRENT($Contents); // New TORRENT object

    $Tor->set_announce_url('ANNOUNCE_URL'); // We just use the string "ANNOUNCE_URL"
    $Tor->make_private();

    list($TotalSize, $FileList) = $Tor->file_list();

    $TmpFileList = array();

    foreach ($FileList as $File) {
        list($Size, $Name) = $File;
        $TmpFileList [] = $Name . '{{{' . $Size . '}}}'; // Name {{{Size}}}
    }

    $FilePath = $Tor->Val['info']->Val['files'] ? mysql_real_escape_string($Tor->Val['info']->Val['name']) : "";
    // Name {{{Size}}}|||Name {{{Size}}}|||Name {{{Size}}}|||Name {{{Size}}}
    $FileString = "'" . mysql_real_escape_string(implode('|||', $TmpFileList)) . "'";
    $NumFiles = count($FileList);
    $TorrentText = $Tor->enc();
    $InfoHash = pack("H*", sha1($Tor->Val['info']->enc()));

    // Check for duplicated info_hash values and skip if found since they can not be added.
    if (in_array($InfoHash, $info_hash_array)) {
        echo $row['id'];    //"x"; // just so we can see how many..
        continue;        
    }
    $info_hash_array[] = $InfoHash;
        
    // Make sure that the tags are all lowercase and unique and insert the category tag here.
    $OriginalTags = strtolower($categories[$row['category']]['tag']." ".$row['tags']);
    $Tags = str_replace('.', '_', $OriginalTags); 
    $Tags = explode(' ', $Tags);
    $Tags = array_unique($Tags);

    $TagList = implode(' ', $Tags);
    
    $torrents_group_rows[] .= "(" . $row['id'] . ", " . $row['category'] . ", '" . mysql_real_escape_string($row['name']) . "', '" . mysql_real_escape_string($TagList) . "', from_unixtime('" . $row['added'] . "'), '" . mysql_real_escape_string($row['descr']) . "', '" . mysql_real_escape_string($row['name']) . " " . mysql_real_escape_string(cleansearch($row['descr'])) . "')";
    
    $Tags = explode(' ', $OriginalTags);
    $Tags = array_unique($Tags);
    foreach ($Tags as $Tag) {
        if (!empty($Tag)) {
            
            if (isset($tagids[$Tag])) {
                $TagID = $tagids[$Tag];
            } else {
                $TagIDCounter++;
                $tagids[$Tag] = $TagIDCounter;
                $TagID = $TagIDCounter;
            }          

            $tags_row[] = "('".$TagID."', '" . $Tag . "', '" . $row['owner'] . "')";          
            $torrents_tags_row[] = "($TagID, " . $row['id'] . ", " . $row['owner'] . ", 8)";            
        }
    }

    $torrents_row[] = "(" . $row['id'] . ", " . $row['owner'] . ", 
		'" . mysql_real_escape_string($InfoHash) . "', " . $NumFiles . ", " . $FileString . ", '" . $FilePath . "', " . $TotalSize . ", from_unixtime('" . $row['added'] . "'), from_unixtime('". $row['last_action']."'), '".$row['hits']."', '".$row['times_completed']."', '".($row['freeleech'] == 'yes' ? '1' : '0')."')";

   
    $TorrentID++;
    $torrents_files_row[] = "($TorrentID, '" . mysql_real_escape_string($Tor->dump_data()) . "')";
    
    
    $i++;
    if ($i % 1001 == 0) {
        echo "\n" . number_format($i / $count * 100, 2) . "%  - (@ $row[id])<br/>";        
    }
    elseif ($i % 50 == 0) {
        mysql_query("INSERT INTO gazelle.torrents_group
                    (ID, NewCategoryID, Name, TagList, Time, Body, SearchText) VALUES " . implode(',', $torrents_group_rows)) or die(mysql_error());
        $torrents_group_rows = array();

         mysql_query("
                            INSERT INTO gazelle.tags
                            (ID, Name, UserID) VALUES ". implode(',', $tags_row) .
                            " ON DUPLICATE KEY UPDATE Uses=Uses+1;
                    ") or die(mysql_error());
         $tags_row = array();
         
        mysql_query("INSERT INTO gazelle.torrents_tags
                            (TagID, GroupID, UserID, PositiveVotes) VALUES " . implode(',', $torrents_tags_row)
                   ) or die(mysql_error());
        $torrents_tags_row = array();

        mysql_query("INSERT INTO gazelle.torrents
                            (GroupID, UserID, info_hash, FileCount, FileList, FilePath, Size, Time, last_action, Snatched, completed, FreeTorrent) 
                        VALUES " . implode(',', $torrents_row)
                ) or die(mysql_error());
        $torrents_row = array();
        
        mysql_query("INSERT INTO gazelle.torrents_files (TorrentID, File) VALUES " . implode(',', $torrents_files_row)
                ) or die(mysql_error());
        $torrents_files_row = array();
       
        echo ".";
    }
}

// flush anything that is left...
if (count($torrents_group_rows) > 0) {
    mysql_query("INSERT INTO gazelle.torrents_group
                (ID, NewCategoryID, Name, TagList, Time, Body, SearchText) VALUES " . implode(',', $torrents_group_rows)) or die(mysql_error());
}

if (count($tags_row) > 0) {
    mysql_query("
                        INSERT INTO gazelle.tags
                        (ID, Name, UserID) VALUES ". implode(',', $tags_row) .
                        " ON DUPLICATE KEY UPDATE Uses=Uses+1;
                ") or die(mysql_error());
}

if (count($torrents_tags_row) > 0) {
    mysql_query("INSERT INTO gazelle.torrents_tags
                        (TagID, GroupID, UserID, PositiveVotes) VALUES " . implode(',', $torrents_tags_row)
                ) or die(mysql_error());
}

if (count($torrents_row) > 0) {
    mysql_query("INSERT INTO gazelle.torrents
                        (GroupID, UserID, info_hash, FileCount, FileList, FilePath, Size, Time, last_action, Snatched, completed, FreeTorrent) 
                    VALUES " . implode(',', $torrents_row)
            ) or die(mysql_error());
}

if (count($torrents_files_row) > 0) {
    mysql_query("INSERT INTO gazelle.torrents_files (TorrentID, File) VALUES " . implode(',', $torrents_files_row)
            ) or die(mysql_error());
}

echo "\n\nCopying torrent comments.\n";
mysql_query("INSERT INTO gazelle.torrents_comments (GroupID, AuthorID, AddedTime, Body, EditedUserID, EditedTime)
        SELECT torrent, user, FROM_UNIXTIME( added ) AS added, ori_text, editedby, FROM_UNIXTIME( editedat ) AS edited
        FROM ".EMDB.".comments    
        ") or die(mysql_error());

$time = microtime(true) - $time_start;
echo "<br/>execution time: $time seconds\n";

?>

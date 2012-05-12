<?
class TEXT {
	// tag=>max number of attributes
	private $ValidTags = array('mcom'=>0, 'table'=>1, 'th'=>1, 'tr'=>1, 'td'=>1,  'bg'=>1, 'cast'=>0, 'details'=>0, 'info'=>0, 'plot'=>0, 'screens'=>0, 'br'=>0, 'hr'=>0, 'font'=>1, 'center'=>0, 'spoiler'=>1, 'b'=>0, 'u'=>0, 'i'=>0, 's'=>0, '*'=>0, '#'=>0, 'artist'=>0, 'user'=>0, 'n'=>0, 'inlineurl'=>0, 'inlinesize'=>1, 'align'=>1, 'color'=>1, 'colour'=>1, 'size'=>1, 'url'=>1, 'img'=>1, 'quote'=>1, 'pre'=>1, 'code'=>1, 'tex'=>0, 'hide'=>1, 'plain'=>0, 'important'=>0, 'torrent'=>0
	);
	private $Smileys = array(
           ':smile1:'           => 'smile1.gif',
           ':smile2:'           => 'smile2.gif',
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
          
          
          //=============================================
          
           ':ohmy:'           => 'ohmy.gif',
           ':cool1:'           => 'cool1.gif',
           ':sleeping:'           => 'sleeping.gif',
           ':innocent:'           => 'innocent.gif',
           ':whistle:'           => 'whistle.gif',
           ':unsure:'           => 'unsure.gif',
           ':closedeyes:'           => 'closedeyes.gif',
           ':cool2:'           => 'cool2.gif',
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
           ':huh:'           => 'huh.gif',
           ':geek:'           => 'geek.gif',
           ':look:'           => 'look.gif',
           ':rolleyes:'           => 'rolleyes.gif',
           ':punk:'           => 'punk.gif',
           ':shifty:'           => 'shifty.gif',
           ':blink:'           => 'blink.gif',
           ':smartass:'           => 'smartass.gif',
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
           ':wall:'           => 'wall.gif',
           ':yucky:'           => 'yucky.gif',
           ':nugget:'           => 'nugget.gif',
           ':smart:'           => 'smart.gif',
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
           ':drunk:'           => 'drunk.gif',
           ':rant:'           => 'rant.gif',
           ':tease:'           => 'tease.gif',
           /* ':box:'           => 'box.gif', */
          
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
          
          
          
          //----------------------------
          
           ':sigh:'           => 'facepalm.gif',
           ':happydancing:'           => 'happydancing.gif',
           ':emperor:'           => 'emperor.gif',
           ':argh:'           => 'frustrated.gif',
           ':tumble:'           => 'tumbleweed.gif',
          
           ':popcorn:'           => 'popcorn.gif',
          
          
           ':lsvader:'           => 'lsvader.gif',
          
          
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
           ':pirate:'           => 'pirate.gif',
           ':pirate2:'           => 'pirate2.gif',
           ':rock:'           => 'rock.gif',
           ':cigar:'           => 'cigar.gif',
           ':oldtimer:'           => 'oldtimer.gif',
           ':trampoline:'           => 'trampoline.gif',
           ':bananadance:'           => 'bananadance.gif',
           ':smurf:'           => 'smurf.gif',
           ':yikes:'           => 'yikes.gif',
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
           ':fishing:'           => 'fishing.gif',
           ':clover:'           => 'clover.gif',
           ':shit:'           => 'shit.gif',
           ':cheer:'           => 'cheerlead.gif',
           ':whip:'           => 'whip.gif',
           ':judge:'           => 'judge.gif',
           ':chair:'           => 'chair.gif',
          
           ':pythfoot:'           => 'pythfoot.gif',
           ':rain:'           => 'rain.gif',
          
           ':blind:'           => 'blind.gif',
           ':blah:'           => 'blah.gif',
           ':boner:'           => 'boner.gif',
           ':goodjob:'           => 'gjob.gif',
           ':dist:'           => 'dist.gif',
           ':urock:'           => 'urock.gif',
          
          
           ':stupid:'           => 'stupid.gif',
           ':dots:'           => 'dots.gif',
           ':offtopic:'           => 'offtopic.gif',
           ':spam:'           => 'spam.gif',
           ':oops:'           => 'oops.gif',
           ':lttd:'           => 'lttd.gif',
           ':please:'           => 'please.gif',
           ':imsorry:'           => 'imsorry.gif',
           ':hi:'           => 'hi.gif',
          
          
           ':punish:'           => 'punish.gif',
           ':puppykisses:'           => 'puppykisses.gif',
          
           ':allbetter:'           => 'allbetter.gif',
           ':bitchfight:'           => 'bitchfight.gif',
           ':buddies:'           => 'buddies.gif',
           ':chase:'           => 'chase.gif',
          
           ':hello:'           => 'hellopink.gif',
           ':lmao:'           => 'lmao.gif',
          
           ':rules:'           => 'rules.gif',
           ':tobi:'           => 'tobi.gif',
          
           ':jump:'           => 'jump.gif',
           ':yay:'           => 'yay.gif',
           ':hbd:'           => 'hbd.gif',
           ':band:'           => 'band.gif',
           ':punk:'           => 'punk.gif',
           ':rofl:'           => 'rofl.gif',
           ':bounce:'           => 'bounce.gif',
           ':mbounce:'           => 'mbounce.gif',
           ':thankyou:'           => 'thankyou.gif',
           ':gathering:'           => 'gathering.gif',
           ':colors:'           => 'colors.gif',
           ':oddoneout:'           => 'oddoneout.gif',
          
           ':tank:'           => 'tank.gif',
           ':guillotine:'           => 'guillotine.gif',
          
           ':yesno:'           => 'yesno.gif',
           ':erection:'           => 'erection1.gif',
           ':fucku:'           => 'fucku.gif',
           ':spamhammer:'           => 'spamhammer.gif',
           ':atomic:'           => 'atomic.gif',
          
           
	);
	
      //  font name (display) => fallback fonts (css)
	private $Fonts = array(
           'Arial'                  => "Arial, 'Helvetica Neue', Helvetica, sans-serif;",
           'Arial Black'            => "'Arial Black', 'Arial Bold', Gadget, sans-serif;",
           'Comic Sans MS'          => "'Comic Sans MS', cursive, sans-serif;",
           'Courier New'            => "'Courier New', Courier, 'Lucida Sans Typewriter', 'Lucida Typewriter', monospace;",
           'Franklin Gothic Medium' => "'Franklin Gothic Medium', 'Franklin Gothic', 'ITC Franklin Gothic', Arial, sans-serif;",
           'Georgia'                => "Georgia, Times, 'Times New Roman', serif;",
           'Helvetica'              => "'Helvetica Neue', Helvetica, Arial, sans-serif;",
           'Impact'                 => "Impact, Haettenschweiler, 'Franklin Gothic Bold', Charcoal, 'Helvetica Inserat', 'Bitstream Vera Sans Bold', 'Arial Black', sans-serif;",
           'Lucida Console'         => "'Lucida Console', Monaco, monospace;",
           'Lucida Sans Unicode'    => "'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Geneva, Verdana, sans-serif;",
           'Microsoft Sans Serif'   => "'Microsoft Sans Serif', Helvetica, sans-serif;",
           'Palatino Linotype'      => "Palatino, 'Palatino Linotype', 'Palatino LT STD', 'Book Antiqua', Georgia, serif;",
           'Tahoma'                 => "Tahoma, Verdana, Segoe, sans-serif;",
           'Times New Roman'        => "TimesNewRoman, 'Times New Roman', Times, Baskerville, Georgia, serif;",
           'Trebuchet MS'           => "'Trebuchet MS', 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', Tahoma, sans-serif;",
           'Verdana'                => "Verdana, Geneva, sans-serif;"
          );
 
      //  icon tag => img  //[cast][details][info][plot][screens] 
	private $Icons = array(
           'cast'                  => "cast11.png",
           'details'               => "details11.png",
           'info'                  => "info11.png",
           'plot'                  => "plot11.png",
           'screens'               => "screens11.png"
          );
      
	private $NoImg = 0; // If images should be turned into URLs
	private $Levels = 0; // nesting level
	private $Advanced = false; // allow advanced tags to be printed
      
	function __construct() {
		foreach($this->Smileys as $Key=>$Val) {
			$this->Smileys[$Key] = '<img src="'.STATIC_SERVER.'common/smileys/'.$Val.'" alt="'.$Key.'" />';
		}
		reset($this->Smileys);
            // asort($this->Smileys, SORT_STRING | SORT_FLAG_CASE); // do not uncomment - just for printing in a-z order in dev
	
		foreach($this->Icons as $Key=>$Val) {
			$this->Icons[$Key] = '<img src="'.STATIC_SERVER.'common/icons/'.$Val.'" alt="'.$Key.'" />';
		}
		reset($this->Icons);
      }
	
	function full_format($Str, $AdvancedTags = false) {
            $this->Advanced = $AdvancedTags;
		$Str = display_str($Str);
		//Inline links
		$URLPrefix = '(\[url\]|\[url\=|\[img\=|\[img\])';
		$Str = preg_replace('/'.$URLPrefix.'\s+/i', '$1', $Str);
		$Str = preg_replace('/(?<!'.$URLPrefix.')http(s)?:\/\//i', '$1[inlineurl]http$2://', $Str);
		// For anonym.to and archive.org links, remove any [inlineurl] in the middle of the link
		$callback = create_function('$matches', 'return str_replace("[inlineurl]","",$matches[0]);');
		$Str = preg_replace_callback('/(?<=\[inlineurl\]|'.$URLPrefix.')(\S*\[inlineurl\]\S*)/m', $callback, $Str);

		$Str = preg_replace('/\=\=\=\=([^=].*)\=\=\=\=/i', '[inlinesize=3]$1[/inlinesize]', $Str);
		$Str = preg_replace('/\=\=\=([^=].*)\=\=\=/i', '[inlinesize=5]$1[/inlinesize]', $Str);
		$Str = preg_replace('/\=\=([^=].*)\=\=/i', '[inlinesize=7]$1[/inlinesize]', $Str);
		
		$Str = $this->parse($Str);
		
		$HTML = $this->to_html($Str);
		
		$HTML = nl2br($HTML);
		return $HTML;
	}
	
	function strip_bbcode($Str) {
		$Str = display_str($Str);
		
		//Inline links
		$Str = preg_replace('/(?<!(\[url\]|\[url\=|\[img\=|\[img\]))http(s)?:\/\//i', '$1[inlineurl]http$2://', $Str);
		
		$Str = $this->parse($Str);
		
		$Str = $this->raw_text($Str);
		
		$Str = nl2br($Str);
		return $Str;
	}
	
	
	function valid_url($Str, $Extension = '', $Inline = false) {
		$Regex = '/^';
		$Regex .= '(https?|ftps?|irc):\/\/'; // protocol
		$Regex .= '(\w+(:\w+)?@)?'; // user:pass@
		$Regex .= '(';
		$Regex .= '(([0-9]{1,3}\.){3}[0-9]{1,3})|'; // IP or...
		$Regex .= '(([a-z0-9\-\_]+\.)+\w{2,6})'; // sub.sub.sub.host.com
		$Regex .= ')';
		$Regex .= '(:[0-9]{1,5})?'; // port
		$Regex .= '\/?'; // slash?
		$Regex .= '(\/?[0-9a-z\-_.,&=@~%\/:;()+|!#]+)*'; // /file
		if(!empty($Extension)) {
			$Regex.=$Extension;
		}

		// query string
		if ($Inline) {
			$Regex .= '(\?([0-9a-z\-_.,%\/\@~&=:;()+*\^$!#|]|\[\d*\])*)?';
		} else {
			$Regex .= '(\?[0-9a-z\-_.,%\/\@[\]~&=:;()+*\^$!#|]*)?';
		}

		$Regex .= '(#[a-z0-9\-_.,%\/\@[\]~&=:;()+*\^$!]*)?'; // #anchor
		$Regex .= '$/i';
		
		return preg_match($Regex, $Str, $Matches);
	}
	
	function local_url($Str) {
		$URLInfo = parse_url($Str);
		if(!$URLInfo) { return false; }
		$Host = $URLInfo['host'];
		// If for some reason your site does not require subdomains or contains a directory in the SITE_URL, revert to the line below.
		//if($Host == NONSSL_SITE_URL || $Host == SSL_SITE_URL || $Host == 'www.'.NONSSL_SITE_URL) {
		if(preg_match('/(\S+\.)*'.NONSSL_SITE_URL.'/', $Host)) {
			$URL = $URLInfo['path'];
			if(!empty($URLInfo['query'])) {
				$URL.='?'.$URLInfo['query'];
			}
			if(!empty($URLInfo['fragment'])) {
				$URL.='#'.$URLInfo['fragment'];
			}
			return $URL;
		} else {
			return false;
		}
		
	}
	 
         
/* How parsing works

Parsing takes $Str, breaks it into blocks, and builds it into $Array. 
Blocks start at the beginning of $Str, when the parser encounters a [, and after a tag has been closed.
This is all done in a loop. 

EXPLANATION OF PARSER LOGIC

1) Find the next tag (regex)
	1a) If there aren't any tags left, write everything remaining to a block and return (done parsing)
	1b) If the next tag isn't where the pointer is, write everything up to there to a text block.
2) See if it's a [[wiki-link]] or an ordinary tag, and get the tag name
3) If it's not a wiki link:
	3a) check it against the $this->ValidTags array to see if it's actually a tag and not [bullshit]
		If it's [not a tag], just leave it as plaintext and move on
	3b) Get the attribute, if it exists [name=attribute]
4) Move the pointer past the end of the tag
5) Find out where the tag closes (beginning of [/tag])
	5a) Different for different types of tag. Some tags don't close, others are weird like [*]
	5b) If it's a normal tag, it may have versions of itself nested inside - eg:
		[quote=bob]*
			[quote=joe]I am a redneck!**[/quote]
			Me too!
		***[/quote]
	If we're at the position *, the first [/quote] tag is denoted by **. 
	However, our quote tag doesn't actually close there. We must perform 
	a loop which checks the number of opening [quote] tags, and make sure 
	they are all closed before we find our final [/quote] tag (***). 

	5c) Get the contents between [open] and [/close] and call it the block. 
	In many cases, this will be parsed itself later on, in a new parse() call.
	5d) Move the pointer past the end of the [/close] tag. 
6) Depending on what type of tag we're dealing with, create an array with the attribute and block.
	In many cases, the block may be parsed here itself. Stick them in the $Array.
7) Increment array pointer, start again (past the end of the [/close] tag)

*/
	function parse($Str) {
		$i = 0; // Pointer to keep track of where we are in $Str
		$Len = strlen($Str);
		$Array = array();
		$ArrayPos = 0;

		while($i<$Len) {
			$Block = '';
			
			// 1) Find the next tag (regex)
			// [name(=attribute)?]|[[wiki-link]]
			$IsTag = preg_match("/((\[[a-zA-Z*#]+)(=(?:[^\n'\"\[\]]|\[\d*\])+)?\])|(\[\[[^\n\"'\[\]]+\]\])/", $Str, $Tag, PREG_OFFSET_CAPTURE, $i);
			
			// 1a) If there aren't any tags left, write everything remaining to a block
			if(!$IsTag) {
				// No more tags
				$Array[$ArrayPos] = substr($Str, $i);
				break;
			}
			
			// 1b) If the next tag isn't where the pointer is, write everything up to there to a text block.
			$TagPos = $Tag[0][1];
			if($TagPos>$i) {
				$Array[$ArrayPos] = substr($Str, $i, $TagPos-$i);
				++$ArrayPos;
				$i=$TagPos;
			}
			
			// 2) See if it's a [[wiki-link]] or an ordinary tag, and get the tag name
			if(!empty($Tag[4][0])) { // Wiki-link
				$WikiLink = true;
				$TagName = substr($Tag[4][0], 2, -2);
				$Attrib = '';
			} else { // 3) If it's not a wiki link:
				$WikiLink = false;
				$TagName = strtolower(substr($Tag[2][0], 1));
				
				//3a) check it against the $this->ValidTags array to see if it's actually a tag and not [bullshit]
				if(!isset($this->ValidTags[$TagName])) {
					$Array[$ArrayPos] = substr($Str, $i, ($TagPos-$i)+strlen($Tag[0][0]));
					$i=$TagPos+strlen($Tag[0][0]);
					++$ArrayPos;
					continue;
				}
				
				$MaxAttribs = $this->ValidTags[$TagName];
				
				// 3b) Get the attribute, if it exists [name=attribute]
				if(!empty($Tag[3][0])) {
					$Attrib = substr($Tag[3][0], 1);
				} else {
					$Attrib='';
				}
			}
			
			// 4) Move the pointer past the end of the tag
			$i=$TagPos+strlen($Tag[0][0]);
			
			// 5) Find out where the tag closes (beginning of [/tag])
			
			// Unfortunately, BBCode doesn't have nice standards like xhtml
			// [*], [img=...], and http:// follow different formats
			// Thus, we have to handle these before we handle the majority of tags
			
			
			//5a) Different for different types of tag. Some tags don't close, others are weird like [*]
			if($TagName == 'img' && !empty($Tag[3][0])) { //[img=...]
				$Block = ''; // Nothing inside this tag
				// Don't need to touch $i
			} elseif($TagName == 'inlineurl') { // We did a big replace early on to turn http:// into [inlineurl]http://
				
				// Let's say the block can stop at a newline or a space
				$CloseTag = strcspn($Str, " \n\r", $i);
				if($CloseTag === false) { // block finishes with URL
					$CloseTag = $Len;
				}
				if(preg_match('/[!;,.?:]+$/',substr($Str, $i, $CloseTag), $Match)) {
					$CloseTag -= strlen($Match[0]);
				}
				$URL = substr($Str, $i, $CloseTag);
				if(substr($URL, -1) == ')' && substr_count($URL, '(') < substr_count($URL, ')')) {
					$CloseTag--;
					$URL = substr($URL, 0, -1);
				}
				$Block = $URL; // Get the URL
				
				// strcspn returns the number of characters after the offset $i, not after the beginning of the string
				// Therefore, we use += instead of the = everywhere else
				$i += $CloseTag; // 5d) Move the pointer past the end of the [/close] tag. 
			} elseif($WikiLink == true || $TagName == 'n' || $TagName == 'br' || $TagName == 'hr' || $TagName == 'cast' || $TagName == 'details' || $TagName == 'info' || $TagName == 'plot' || $TagName == 'screens') { 
				// Don't need to do anything - empty tag with no closing 
			} elseif($TagName === '*' || $TagName === '#') {
				// We're in a list. Find where it ends
				$NewLine = $i;
				do { // Look for \n[*]
					$NewLine = strpos($Str, "\n", $NewLine+1);
				} while($NewLine!== false && substr($Str, $NewLine+1, 3) == '['.$TagName.']');
				
				$CloseTag = $NewLine;
				if($CloseTag === false) { // block finishes with list
					$CloseTag = $Len;
				}
				$Block = substr($Str, $i, $CloseTag-$i); // Get the list
				$i = $CloseTag; // 5d) Move the pointer past the end of the [/close] tag. 
			} else {
				//5b) If it's a normal tag, it may have versions of itself nested inside
				$CloseTag = $i-1;
				$InTagPos = $i-1;
				$NumInOpens = 0;
				$NumInCloses = -1;
				
				$InOpenRegex = '/\[('.$TagName.')';
				if($MaxAttribs>0) {
					$InOpenRegex.="(=[^\n'\"\[\]]+)?";
				}
				$InOpenRegex.='\]/i';
				
				
				// Every time we find an internal open tag of the same type, search for the next close tag 
				// (as the first close tag won't do - it's been opened again)
				do {
					$CloseTag = stripos($Str, '[/'.$TagName.']', $CloseTag+1);
					if($CloseTag === false) {
						$CloseTag = $Len;
						break;
					} else {
						$NumInCloses++; // Majority of cases
					}
					
					// Is there another open tag inside this one?
					$OpenTag = preg_match($InOpenRegex, $Str, $InTag, PREG_OFFSET_CAPTURE, $InTagPos+1);
					if(!$OpenTag || $InTag[0][1]>$CloseTag) {
						break;
					} else {
						$InTagPos = $InTag[0][1];
						$NumInOpens++;
					}
					
				} while($NumInOpens>$NumInCloses);
				
				
				// Find the internal block inside the tag
				$Block = substr($Str, $i, $CloseTag-$i); // 5c) Get the contents between [open] and [/close] and call it the block.
				
				$i = $CloseTag+strlen($TagName)+3; // 5d) Move the pointer past the end of the [/close] tag. 
				
			}
			
			// 6) Depending on what type of tag we're dealing with, create an array with the attribute and block.
			switch($TagName) {
				case 'br':
				case 'hr':
				case 'cast':
				case 'details':
				case 'info':
				case 'plot':
				case 'screens':
					$Array[$ArrayPos] = array('Type'=>$TagName, 'Val'=>'');
					break;
				case 'font':
					$Array[$ArrayPos] = array('Type'=>'font', 'Attr'=>$Attrib, 'Val'=>$this->parse($Block));
					break;
				case 'center': // lets just swap a center tag for an [align=center] tag
					$Array[$ArrayPos] = array('Type'=>'align', 'Attr'=>'center', 'Val'=>$this->parse($Block));
					break;
				case 'inlineurl':
					$Array[$ArrayPos] = array('Type'=>'inlineurl', 'Attr'=>$Block, 'Val'=>'');
					break;
				case 'url':
					$Array[$ArrayPos] = array('Type'=>'img', 'Attr'=>$Attrib, 'Val'=>$Block);
					if(empty($Attrib)) { // [url]http://...[/url] - always set URL to attribute
						$Array[$ArrayPos] = array('Type'=>'url', 'Attr'=>$Block, 'Val'=>'');
					} else {
						$Array[$ArrayPos] = array('Type'=>'url', 'Attr'=>$Attrib, 'Val'=>$this->parse($Block));
					}
					break;
				case 'quote':
					$Array[$ArrayPos] = array('Type'=>'quote', 'Attr'=>$this->Parse($Attrib), 'Val'=>$this->parse($Block));
					break;
				case 'img':
				case 'image':
					if(empty($Block)) {
						$Block = $Attrib;
					}
					$Array[$ArrayPos] = array('Type'=>'img', 'Val'=>$Block);
					break;
				case 'aud':
				case 'mp3':
				case 'audio':
					if(empty($Block)) {
						$Block = $Attrib;
					}
					$Array[$ArrayPos] = array('Type'=>'aud', 'Val'=>$Block);
					break;
				case 'user':
					$Array[$ArrayPos] = array('Type'=>'user', 'Val'=>$Block);
					break;
				case 'artist':
					$Array[$ArrayPos] = array('Type'=>'artist', 'Val'=>$Block);
					break;
				case 'torrent':
					$Array[$ArrayPos] = array('Type'=>'torrent', 'Val'=>$Block);
					break;
				case 'tex':
					$Array[$ArrayPos] = array('Type'=>'tex', 'Val'=>$Block);
					break;
				case 'pre':
				case 'code':
				case 'plain':
					$Block = strtr($Block, array('[inlineurl]'=>''));
					$Block = preg_replace('/\[inlinesize\=3\](.*?)\[\/inlinesize\]/i', '====$1====', $Block);
					$Block = preg_replace('/\[inlinesize\=5\](.*?)\[\/inlinesize\]/i', '===$1===', $Block);
					$Block = preg_replace('/\[inlinesize\=7\](.*?)\[\/inlinesize\]/i', '==$1==', $Block);
					
					$Array[$ArrayPos] = array('Type'=>$TagName, 'Val'=>$Block);
					break;
				case 'hide':
				case 'spoiler':
					$Array[$ArrayPos] = array('Type'=>'hide', 'Attr'=>$Attrib, 'Val'=>$this->parse($Block));
					break;
				case '#':
				case '*':
						$Array[$ArrayPos] = array('Type'=>'list');
						$Array[$ArrayPos]['Val'] = explode('['.$TagName.']', $Block);
						$Array[$ArrayPos]['ListType'] = $TagName === '*' ? 'ul' : 'ol';
						$Array[$ArrayPos]['Tag'] = $TagName;
						foreach($Array[$ArrayPos]['Val'] as $Key=>$Val) {
							$Array[$ArrayPos]['Val'][$Key] = $this->parse(trim($Val));
						}
					break;
				case 'n':
					$ArrayPos--;
					break; // n serves only to disrupt bbcode (backwards compatibility - use [pre])
				default:
					if($WikiLink == true) {
						$Array[$ArrayPos] = array('Type'=>'wiki','Val'=>$TagName);
					} else { 
						
						// Basic tags, like [b] or [size=5]
						
						$Array[$ArrayPos] = array('Type'=>$TagName, 'Val'=>$this->parse($Block));
						if(!empty($Attrib) && $MaxAttribs>0) {
							$Array[$ArrayPos]['Attr'] = strtolower($Attrib);
						}
					}
			}
			
			$ArrayPos++; // 7) Increment array pointer, start again (past the end of the [/close] tag)
		}
		return $Array;
	}
	
       
      function is_color_attrib($Attrib) {
            static $ColorAttribs;
            if (!$ColorAttribs) // only build it once per page  
                $ColorAttribs = array('aqua', 'aquamarine', 'magenta', 'darkmagenta', 'slategrey', 'pink', 'hotpink', 'black', 'wheat', 'midnightblue', 'forestgreen', 'blue', 'lightblue', 'fuchsia', 'lightgreen', 'green', 'grey', 'lightgrey', 'lime', 'maroon', 'navy', 'olive', 'khaki', 'darkkhaki', 'gold', 'goldenrod', 'darkgoldenrod', 'purple', 'violet', 'red', 'crimson', 'firebrick', 'gainsboro', 'silver', 'teal', 'linen', 'aliceblue', 'lavender', 'white', 'whitesmoke', 'lightyellow', 'yellow');
		
            return (in_array($Attrib, $ColorAttribs) || preg_match('/^#([0-9a-f]{3}|[0-9a-f]{6})$/', $Attrib));
      }
      
      function get_color_width_attributes($Attrib) {
            $InlineStyle = '';
            if ( isset($Attrib) ) {
                $attributes = explode(",", $Attrib);
                if ($attributes) {
                    $InlineStyle = ' style="';
                    foreach($attributes as $att) {
                        if($this->is_color_attrib($att)) {
                            $InlineStyle .= 'background-color:'.$att.';';
                        } elseif (preg_match('/^[0-9]{1,3}$/', $att)) {
                            if ( (int)$att > 100 ) $att = '100';
                            $InlineStyle .= 'width:'.$att.'%;';
                        } else {
                            return FALSE;
                        }
                    }
                    $InlineStyle .= '"';
                }
            }
            return $InlineStyle;
      }
      
    
      function remove_text_between_tags(&$Array, $MatchTagRegex = false){
            $count = count($Array);
            for ($i = 0; $i <= $count; $i++) {
                if ( is_string($Array[$i]) ){
                    $Array[$i] = '';
                } elseif ( $MatchTagRegex !== false && !preg_match($MatchTagRegex, $Array[$i]['Type']) ) {
                    $Array[$i] = '';
                }
            }
      }
      
      
	function to_html($Array) {
		$this->Levels++;
		if($this->Levels>10) { return $Block['Val']; } // Hax prevention
		$Str = '';
            
		foreach($Array as $Block) {
			if(is_string($Block)) {
				$Str.=$this->smileys($Block);
				continue;
			}
			switch($Block['Type']) {
                        case 'mcom':  // doh! cannot be advanced if we want to mod comment normal users posts
                              $Str.='<div class="modcomment">'.$this->to_html($Block['Val']).'<div class="after">[ <a href="forums.php?action=viewforum&forumid=17">Help</a> | <a href=""articles.php?topic=rules">Rules</a> ]</div><div class="clear"></div></div>';
                              break;
				case 'table':
                              $InlineStyle = $this->Advanced ? $this->get_color_width_attributes($Block['Attr']) : FALSE;
					if ($InlineStyle === FALSE) {
                                  	$Str.='['.$Block['Type'].'='.$Block['Attr'].']'.$this->to_html($Block['Val']).'[/'.$Block['Type'].']';
                              } else  {
                                    $this->remove_text_between_tags($Block['Val'], "/^tr$/");
                                    $Str.='<table class="bbcode"'.$InlineStyle.'><tbody>'.$this->to_html($Block['Val']).'</tbody></table>';
                              }
					break;
				case 'tr':
                              if (!$this->Advanced)
                                    $InlineStyle = FALSE;
                              else if($this->is_color_attrib( $Block['Attr']))
                                    $InlineStyle = ' style="background-color:'.$Block['Attr'].';"';
                              else $InlineStyle = '';
					if ($InlineStyle === FALSE) {
                                  	$Str.='['.$Block['Type'].'='.$Block['Attr'].']'.$this->to_html($Block['Val']).'[/'.$Block['Type'].']';
                              } else  {
                                  $this->remove_text_between_tags($Block['Val'], "/^th$|^td$/");
                                  $Str.='<'.$Block['Type'].' class="bbcode"'.$InlineStyle.'>'.$this->to_html($Block['Val']).'</'.$Block['Type'].'>';
                              }
					break;
				case 'th':
				case 'td':
                              $InlineStyle = $this->Advanced ? $this->get_color_width_attributes($Block['Attr']) : FALSE;
					if ($InlineStyle === FALSE) {
                                  	$Str.='['.$Block['Type'].'='.$Block['Attr'].']'.$this->to_html($Block['Val']).'[/'.$Block['Type'].']';
                              } else  
                                  $Str.='<'.$Block['Type'].' class="bbcode"'.$InlineStyle.'>'.$this->to_html($Block['Val']).'</'.$Block['Type'].'>';
					break;
				case 'bg':
                              $InlineStyle = $this->Advanced ? $this->get_color_width_attributes($Block['Attr']) : FALSE;
					if (!$InlineStyle || $InlineStyle =='') {
                                  	$Str.='[bg='.$Block['Attr'].']'.$this->to_html($Block['Val']).'[/bg]';
                              } else  
                                  $Str.='<div class="bbcode"'.$InlineStyle.'>'.$this->to_html($Block['Val']).'</div>';
                              break;
				case 'cast':
				case 'details':
				case 'info':
				case 'plot':
				case 'screens': // [cast] [details] [info] [plot] [screens]
                              if(!isset($this->Icons[$Block['Type']])) { 
                                  $Str.='['.$Block['Type'].']'; 
					} else  { 
                                  $Str.= $this->Icons[$Block['Type']]; 
                              }
					break;
				case 'br':
					$Str.='<br />';
					break;
				case 'hr':
					$Str.='<hr />'; 
					break;
				case 'font':
                              if(!isset($this->Fonts[$Block['Attr']])) {
                                    $Str.='[font='.$Block['Attr'].']'.$this->to_html($Block['Val']).'[/font]';
                              } else {
						$Str.='<span style="font-family: '.$this->Fonts[$Block['Attr']].'">'.$this->to_html($Block['Val']).'</span>';
                              }
					break;
				case 'b':
					$Str.='<strong>'.$this->to_html($Block['Val']).'</strong>';
					break;
				case 'u':
					$Str.='<span style="text-decoration: underline;">'.$this->to_html($Block['Val']).'</span>';
					break;
				case 'i':
					$Str.='<em>'.$this->to_html($Block['Val'])."</em>";
					break;
				case 's':
					$Str.='<span style="text-decoration: line-through">'.$this->to_html($Block['Val']).'</span>';
					break;
				case 'important':
					$Str.='<strong class="important_text">'.$this->to_html($Block['Val']).'</strong>';
					break;
				case 'user':
					$Str.='<a href="user.php?action=search&amp;search='.urlencode($Block['Val']).'">'.$Block['Val'].'</a>';
					break;
				case 'torrent':
					$Pattern = '/('.NONSSL_SITE_URL.'\/torrents\.php.*[\?&]id=)?(\d+)($|&|\#).*/i';
					$Matches = array();
					if (preg_match($Pattern, $Block['Val'], $Matches)) {
						if (isset($Matches[2])) {
							$Groups = get_groups(array($Matches[2]), true, false);
							if (!empty($Groups['matches'][$Matches[2]])) {
								$Group = $Groups['matches'][$Matches[2]];
								$Str .= '<a href="torrents.php?id='.$Matches[2].'">'.$Group['Name'].'</a>';
							} else {
								$Str .= '[torrent]'.str_replace('[inlineurl]','',$Block['Val']).'[/torrent]';
							}
						}
					} else {
						$Str .= '[torrent]'.str_replace('[inlineurl]','',$Block['Val']).'[/torrent]';
					}
					break;
				case 'wiki':
					$Str.='<a href="wiki.php?action=article&amp;name='.urlencode($Block['Val']).'">'.$Block['Val'].'</a>';
					break;
				case 'tex':
					$Str.='<img style="vertical-align: middle" src="'.STATIC_SERVER.'blank.gif" onload="if (this.src.substr(this.src.length-9,this.src.length) == \'blank.gif\') { this.src = \'http://chart.apis.google.com/chart?cht=tx&amp;chf=bg,s,FFFFFF00&amp;chl='.urlencode(mb_convert_encoding($Block['Val'],"UTF-8","HTML-ENTITIES")).'&amp;chco=\' + hexify(getComputedStyle(this.parentNode,null).color); }" />';
					break;
				case 'plain':
					$Str.=$Block['Val'];
					break;
				case 'pre':
					$Str.='<pre>'.$Block['Val'].'</pre>';
					break;
				case 'code':
					$Str.='<code>'.$Block['Val'].'</code>';
					break;
				case 'list':
					$Str .= '<'.$Block['ListType'].'>';
					foreach($Block['Val'] as $Line) {
						
						$Str.='<li>'.$this->to_html($Line).'</li>';
					}
					$Str.='</'.$Block['ListType'].'>';
					break;
				case 'align':
					$ValidAttribs = array('left', 'center', 'justify', 'right');
					if(!in_array($Block['Attr'], $ValidAttribs)) {
						$Str.='[align='.$Block['Attr'].']'.$this->to_html($Block['Val']).'[/align]';
					} else {
						$Str.='<div style="text-align:'.$Block['Attr'].'">'.$this->to_html($Block['Val']).'</div>';
					}
					break;
				case 'color':
				case 'colour':
					//$ValidAttribs = array('aqua', 'black', 'blue', 'fuchsia', 'green', 'grey', 'lime', 'maroon', 'navy', 'olive', 'purple', 'red', 'silver', 'teal', 'white', 'yellow');
					if(!$this->is_color_attrib($Block['Attr'])) { 
					//if(!is_color_attrib($Block['Attr'])) {
                                  	$Str.='[color='.$Block['Attr'].']'.$this->to_html($Block['Val']).'[/color]';
					} else {
						$Str.='<span style="color:'.$Block['Attr'].'">'.$this->to_html($Block['Val']).'</span>';
					}
					break;
				case 'inlinesize':
				case 'size':
					$ValidAttribs = array('1','2','3','4','5','6','7','8','9','10');
					if(!in_array($Block['Attr'], $ValidAttribs)) {
						$Str.='[size='.$Block['Attr'].']'.$this->to_html($Block['Val']).'[/size]';
					} else {
						$Str.='<span class="size'.$Block['Attr'].'">'.$this->to_html($Block['Val']).'</span>';
					}
					break;
				case 'quote':
					$this->NoImg++; // No images inside quote tags
					if(!empty($Block['Attr'])) {
						$Str.= '<strong>'.$this->to_html($Block['Attr']).'</strong> wrote: ';
					}
					$Str.='<blockquote>'.$this->to_html($Block['Val']).'</blockquote>';
					$this->NoImg--;
					break;
				case 'hide':
					$Str.='<strong>'.(($Block['Attr']) ? $Block['Attr'] : 'Hidden text').'</strong>: <a href="javascript:void(0);" onclick="BBCode.spoiler(this);">Show</a>';
					$Str.='<blockquote class="hidden spoiler">'.$this->to_html($Block['Val']).'</blockquote>';
					break;
				case 'img':
					if($this->NoImg>0 && $this->valid_url($Block['Val'])) {
						$Str.='<a rel="noreferrer" target="_blank" href="'.$Block['Val'].'">'.$Block['Val'].'</a> (image)';
						break;
					}
					if(!$this->valid_url($Block['Val'])) {
						$Str.='[img]'.$Block['Val'].'[/img]';
					} else {
						$Str.='<img class="scale_image" onclick="lightbox.init(this,500);" alt="'.$Block['Val'].'" src="'.$Block['Val'].'" />';
					}
					break;
					
				case 'aud':
					if($this->NoImg>0 && $this->valid_url($Block['Val'])) {
						$Str.='<a rel="noreferrer" target="_blank" href="'.$Block['Val'].'">'.$Block['Val'].'</a> (audio)';
						break;
					}
					if(!$this->valid_url($Block['Val'], '\.(mp3|ogg|wav)')) {
						$Str.='[aud]'.$Block['Val'].'[/aud]';
					} else {
						//TODO: Proxy this for staff?
						$Str.='<audio controls="controls" src="'.$Block['Val'].'"><a rel="noreferrer" target="_blank" href="'.$Block['Val'].'">'.$Block['Val'].'</a></audio>';
					}
					break;
					
				case 'url':
					// Make sure the URL has a label
					if(empty($Block['Val'])) {
						$Block['Val'] = $Block['Attr'];
						$NoName = true; // If there isn't a Val for this
					} else {
						$Block['Val'] = $this->to_html($Block['Val']);
						$NoName = false;
					}
					
					if(!$this->valid_url($Block['Attr'])) {
						$Str.='[url='.$Block['Attr'].']'.$Block['Val'].'[/url]';
					} else {
						$LocalURL = $this->local_url($Block['Attr']);
						if($LocalURL) {
							if($NoName) { $Block['Val'] = substr($LocalURL,1); }
							$Str.='<a href="'.$LocalURL.'">'.$Block['Val'].'</a>';
						} else {
							$Str.='<a rel="noreferrer" target="_blank" href="'.$Block['Attr'].'">'.$Block['Val'].'</a>';
						}
					}
					break;
					
				case 'inlineurl':
					if(!$this->valid_url($Block['Attr'], '', true)) {
						$Array = $this->parse($Block['Attr']);
						$Block['Attr'] = $Array;
						$Str.=$this->to_html($Block['Attr']);
					}
					
					else {
						$LocalURL = $this->local_url($Block['Attr']);
						if($LocalURL) {
							$Str.='<a href="'.$LocalURL.'">'.substr($LocalURL,1).'</a>';
						} else {
							$Str.='<a rel="noreferrer" target="_blank" href="'.$Block['Attr'].'">'.$Block['Attr'].'</a>';
						} 
					}
					
					break;
				
			}
            }
		$this->Levels--;
		return $Str;
	}
	
	function raw_text($Array) {
		$Str = '';
		foreach($Array as $Block) {
			if(is_string($Block)) {
				$Str.=$Block;
				continue;
			}
			switch($Block['Type']) {
			
				case 'b':
				case 'u':
				case 'i':
				case 's':
				case 'color':
				case 'size':
				case 'quote':
				case 'align':
				case 'center':
				
					$Str.=$this->raw_text($Block['Val']);
					break;
				case 'tex': //since this will never strip cleanly, just remove it
					break;
				case 'artist':
				case 'user':
				case 'wiki':
				case 'pre':
				case 'code':
				case 'aud':
				case 'img':
					$Str.=$Block['Val'];
					break;
				case 'list':
					foreach($Block['Val'] as $Line) {
						$Str.=$Block['Tag'].$this->raw_text($Line);
					}
					break;
					
				case 'url':
					// Make sure the URL has a label
					if(empty($Block['Val'])) {
						$Block['Val'] = $Block['Attr'];
					} else {
						$Block['Val'] = $this->raw_text($Block['Val']);
					}
					
					$Str.=$Block['Val'];
					break;
					
				case 'inlineurl':
					if(!$this->valid_url($Block['Attr'], '', true)) {
						$Array = $this->parse($Block['Attr']);
						$Block['Attr'] = $Array;
						$Str.=$this->raw_text($Block['Attr']);
					}
					else {
						$Str.=$Block['Attr'];
					}
					
					break;
			}
		}
		return $Str;
	}
	
	function smileys($Str) {
		global $LoggedUser;
		if(!empty($LoggedUser['DisableSmileys'])) {
			return $Str;
		}
		$Str = strtr($Str, $this->Smileys);
		return $Str;
	}
      
            
      /*
       * --------------------- BBCode assistant -----------------------------
       * added 2012.04.21 - mifune
       * --------------------------------------------------------------------
      // pass in the id of the textarea this bbcode helper affects
      // start_num == num of smilies to load when created
      // $load_increment == number of smilies to add each time user presses load button
      // $load_increment_first == if passed this number of smilies are added the first time user presses load button
      // NOTE: its probably best to call this with default parameters because then the user's browser will cache the 
      // ajax result and all subsequent calls will use the cached result - if differetn pages use different parameters
      // they will not get that benefit
       */
      function display_bbcode_assistant($textarea, $AllowAdvancedTags, $start_num_smilies = 0, $load_increment = 120, $load_increment_first = 30){
        global $LoggedUser;
          if ($load_increment_first == -1) { $load_increment_first = $load_increment; }
        ?>
        <div id="hover_pick<?=$textarea;?>" style="width: auto; height: auto; position: absolute; border: 0px solid rgb(51, 51, 51); display: none; z-index: 20;"></div>

        <table class="bb_holder">
          <tbody><tr>
            <td class="colhead" style="padding: 2px 6px">
                <div class="bb_buttons_left">
             
                    <a class="bb_button" onclick="tag('b', '<?=$textarea;?>')" title="Bold text: [b]text[/b]" alt="B"><b>B</b></a>
                    <a class="bb_button" onclick="tag('i', '<?=$textarea;?>')" title="Italic text: [i]text[/i]" alt="I"><i>I</i></a>
                    <a class="bb_button" onclick="tag('u', '<?=$textarea;?>')" title="Underline text: [u]text[/u]" alt="U"><u>U</u></a>
                    <a class="bb_button" onclick="tag('s', '<?=$textarea;?>')" title="Strikethrough text: [s]text[/s]" alt="S"><s>S</s></a>
                    <a class="bb_button" onclick="clink('<?=$textarea;?>')" title="Insert URL: [url]http://url[/url] or [url=http://url]URL text[/url]" alt="Url">Url</a>
                <!-- <a class="bb_button" onclick="tag('img')" title="Insert image: [img]http://image_url[/img]" alt="Img">Img</a>-->
                    <a class="bb_button" onclick="cimage('<?=$textarea;?>')" title="Insert image: [img]http://image_url[/img]" alt="Image">img</a>
                    <a class="bb_button" onclick="tag('code', '<?=$textarea;?>')" title="Code display: [code]code[/code]" alt="Code">Code</a>
                    <a class="bb_button" onclick="tag('quote', '<?=$textarea;?>')" title="Quote text: [quote]text[/quote]" alt="Quote">Quote</a>

                <select class="bb_button" name="fontfont" id="fontfont<?=$textarea;?>" onchange="font('font',this.value,'<?=$textarea;?>');" title="Font face">
                    <option value="0">Font Type</option>
                <?  foreach($this->Fonts as $Key=>$Val) {
                        echo  '
                            <option value="'.$Key.'"  style="font-family: '.$Val.'">'.$Key.'</option>';
                    }  ?>
                </select>
                    
                    
                <select  class="bb_button" name="fontsize" id="fontsize<?=$textarea;?>" onchange="font('size',this.value,'<?=$textarea;?>');" title="Font size">
                  <option value="0" selected="selected">Font size</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                  <option value="10">10</option>
                </select>
                    
                <a class="bb_button" onclick="colorpicker('<?=$textarea;?>','color');" title="Select Text Color" alt="Colors">Colors</a>
              
              </div>
              <div  class="bb_buttons_right">
                <div> 

               <?   //   isset($LoggedUser['Permissions']['site_advanced_tags']) &&  $LoggedUser['Permissions']['site_advanced_tags']
                  if ( $AllowAdvancedTags ) { ?>

                        <a class="bb_button" onclick="colorpicker('<?=$textarea;?>','bg');" title="Background: [bg=color]text[/bg]" alt="Background">Bg</a>

                        <a class="bb_button" onclick="table('<?=$textarea;?>')" title="Table: [table][tr][td]text[/td][td]text[/td][/tr][/table]" alt="Table">Table</a>
               <? }  ?>


              <?  if(check_perms('site_moderate_forums')) { ?>
                        <a class="bb_button" style="border: 3px solid #600;" onclick="tag('mcom', '<?=$textarea;?>')" title="Staff Comment: [mcom]text[/mcom]" alt="Mod comment">Mod</a>
               <? }  ?>  
                 </div>
                      <img class="bb_icon" src="<?=get_symbol_url('align_center.png') ?>" onclick="wrap('align','','center', '<?=$textarea;?>')" title="Align - center" alt="Center" /> 
                      <img class="bb_icon" src="<?=get_symbol_url('align_left.png') ?>" onclick="wrap('align','','left', '<?=$textarea;?>')" title="Align - left" alt="Left" /> 
                      <img class="bb_icon" src="<?=get_symbol_url('align_justify.png') ?>" onclick="wrap('align','','justify', '<?=$textarea;?>')" title="Align - justify" alt="Justify" />
                      <img class="bb_icon" src="<?=get_symbol_url('align_right.png') ?>" onclick="wrap('align','','right', '<?=$textarea;?>')" title="Align - right" alt="Right" /> 
                      <img class="bb_icon" src="<?=get_symbol_url('text_uppercase.png') ?>" onclick="text('up', '<?=$textarea;?>')" title="To Uppercase" alt="Up" /> 
                      <img class="bb_icon" src="<?=get_symbol_url('text_lowercase.png') ?>" onclick="text('low', '<?=$textarea;?>')" title="To Lowercase" alt="Low" />
              </div> 
              </td>
          </tr> 
          <tr>
            <td>
                <div id="pickerholder<?=$textarea;?>" class="picker_holder"></div>
                <div id="smiley_overflow<?=$textarea;?>" class="bb_smiley_holder">
                    <? if ($start_num_smilies>0) { $this->draw_smilies_from(0, $start_num_smilies, $textarea); }  ?> 
                </div>
                <div class="overflow_button">
                       <a href="#" id="open_overflow<?=$textarea;?>" onclick="if(this.isopen){Close_Smilies('<?=$textarea;?>');}else{Open_Smilies(<?="$start_num_smilies,$load_increment_first,'$textarea'"?>);};return false;">Show smilies</a>
                       <a href="#" id="open_overflow_more<?=$textarea;?>" onclick="Open_Smilies(<?="$start_num_smilies,$load_increment,'$textarea'"?>);return false;"></a>
                       <span id="smiley_count<?=$textarea;?>" class="number" style="float:right;"></span>
                       <span id="smiley_max<?=$textarea;?>" class="number" style="float:left;"></span>
                </div>  
      </td></tr></tbody></table>
        <? 
      }
      
      // output smiley data in xml (we dont just draw the html because we want maxsmilies in js)
      function draw_smilies_from_XML($indexfrom = 0, $indexto = -1){
            $count=0;
            echo "<smilies>";
            foreach($this->Smileys as $Key=>$Val) { 
                if ($indexto >= 0 && $count >= $indexto) { break; }
                if ($count >= $indexfrom){
                    echo '    <smiley>
        <bbcode>'.$Key.'</bbcode>
        <url>'. htmlentities($Val) .'</url>
    </smiley>';
                }
                $count++;
            }
            reset($this->Smileys); 
            echo '    <maxsmilies>' . count ($this->Smileys).'</maxsmilies>
</smilies>';
      }
      
      function draw_smilies_from($indexfrom = 0, $indexto = -1, $textarea){
            $count=0;
            foreach($this->Smileys as $Key=>$Val) { 
                if ($indexto >= 0 && $count >= $indexto) { break; }
                if ($count >= $indexfrom){  // ' &nbsp;' .$Key. - jsut for printing in dev
                    echo '<a class="bb_smiley" title="' .$Key. '" href="javascript:em(\' '.$Key.' \',\''.$textarea.'\');">'.$Val.'</a>';
                }
                $count++;
            }
            reset($this->Smileys); 
      }
      
}
/*
//Uncomment this part to test the class via command line: 
function display_str($Str) {return $Str;}
function check_perms($Perm) {return true;}
$Str = "hello 
[pre]http://anonym.to/?http://whatshirts.portmerch.com/
====hi====
===hi===
==hi==[/pre]
====hi====
hi";
$Text = NEW TEXT;
echo $Text->full_format($Str);
echo "\n"
*/
?>

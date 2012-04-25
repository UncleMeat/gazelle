<?
class TEXT {
	// tag=>max number of attributes
	private $ValidTags = array('b'=>0, 'u'=>0, 'i'=>0, 's'=>0, '*'=>0, '#'=>0, 'artist'=>0, 'user'=>0, 'n'=>0, 'inlineurl'=>0, 'inlinesize'=>1, 'align'=>1, 'color'=>1, 'colour'=>1, 'size'=>1, 'url'=>1, 'img'=>1, 'quote'=>1, 'pre'=>1, 'code'=>1, 'tex'=>0, 'hide'=>1, 'plain'=>0, 'important'=>0, 'torrent'=>0
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
           ':jump:'           => 'jump.gif',
           ':stupid:'           => 'stupid.gif',
           ':dots:'           => 'dots.gif',
           ':offtopic:'           => 'offtopic.gif',
           ':spam:'           => 'spam.gif',
           ':oops:'           => 'oops.gif',
           ':lttd:'           => 'lttd.gif',
           ':please:'           => 'please.gif',
           ':sorry:'           => 'sorry.gif',
           ':hi:'           => 'hi.gif',
           ':yay:'           => 'yay.gif',
           ':hbd:'           => 'hbd.gif',
           ':band:'           => 'band.gif',
           ':punk:'           => 'punk.gif',
           ':rofl:'           => 'rofl.gif',
           ':bounce:'           => 'bounce.gif',
           ':mbounce:'           => 'mbounce.gif',
           ':thankyou:'           => 'thankyou.gif',
           ':gathering:'           => 'gathering.gif',
           ':whip:'           => 'whip.gif',
           ':judge:'           => 'judge.gif',
           ':chair:'           => 'chair.gif',
           ':tease:'           => 'tease.gif',
           ':box:'           => 'box.gif',
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
          
          /*
		':angry:'			=> 'angry.gif',
		':-D'				=> 'biggrin.gif',
		':D'				=> 'biggrin.gif',
		':|'				=> 'blank.gif',
		':-|'				=> 'blank.gif',
		':blush:'			=> 'blush.gif',
		':cool:'			=> 'cool.gif',
		':&#39;('				=> 'crying.gif',
		':crying:'				=> 'crying.gif',
		'&gt;.&gt;'			=> 'eyesright.gif',
		':frown:'			=> 'frown.gif',
		'&lt;3'				=> 'heart.gif',
		':unsure:'			=> 'hmm.gif',
		':\\'			=> 'hmm.gif',
		':whatlove:'		=> 'ilu.gif',
		':lol:'				=> 'laughing.gif',
		':loveflac:'		=> 'loveflac.gif',
		':ninja:'			=> 'ninja.gif',
		':no:'				=> 'no.gif',
		':nod:'				=> 'nod.gif',
		':ohno:'			=> 'ohnoes.gif',
		':ohnoes:'			=> 'ohnoes.gif',
		':omg:'				=> 'omg.gif',
		':o'				=> 'ohshit.gif',
		':O'				=> 'ohshit.gif',
		':paddle:'			=> 'paddle.gif',
		':('				=> 'sad.gif',
		':-('				=> 'sad.gif',
		':shifty:'			=> 'shifty.gif',
		':sick:'			=> 'sick.gif',
		':)'				=> 'smile.gif',
		':-)'				=> 'smile.gif',
		':sorry:'			=> 'sorry.gif',
		':thanks:'			=> 'thanks.gif',
		':P'				=> 'tongue.gif',
		':-P'				=> 'tongue.gif',
		':-p'				=> 'tongue.gif',
		':wave:'			=> 'wave.gif',
		';-)'				=> 'wink.gif',
		':wink:'			=> 'wink.gif',
		':creepy:'			=> 'creepy.gif',
		':worried:'			=> 'worried.gif',
		':wtf:'				=> 'wtf.gif',
		':wub:'				=> 'wub.gif', */
	);
	
	private $NoImg = 0; // If images should be turned into URLs
	private $Levels = 0; // If images should be turned into URLs
	
	function __construct() {
		foreach($this->Smileys as $Key=>$Val) {
			$this->Smileys[$Key] = '<img src="'.STATIC_SERVER.'common/smileys/'.$Val.'" alt="'.$Key.'" />';
		}
		reset($this->Smileys);
	}
	
	function full_format($Str) {
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
			} elseif($WikiLink == true || $TagName == 'n') { 
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
				case 'artist':
					$Str.='<a href="artist.php?artistname='.urlencode(undisplay_str($Block['Val'])).'">'.$Block['Val'].'</a>';
					break;
				case 'torrent':
					$Pattern = '/('.NONSSL_SITE_URL.'\/torrents\.php.*[\?&]id=)?(\d+)($|&|\#).*/i';
					$Matches = array();
					if (preg_match($Pattern, $Block['Val'], $Matches)) {
						if (isset($Matches[2])) {
							$Groups = get_groups(array($Matches[2]), true, true, false);
							if (!empty($Groups['matches'][$Matches[2]])) {
								$Group = $Groups['matches'][$Matches[2]];
								$Str .= display_artists($Group['ExtendedArtists']).'<a href="torrents.php?id='.$Matches[2].'">'.$Group['Name'].'</a>';
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
					$ValidAttribs = array('left', 'center', 'right');
					if(!in_array($Block['Attr'], $ValidAttribs)) {
						$Str.='[align='.$Block['Attr'].']'.$this->to_html($Block['Val']).'[/align]';
					} else {
						$Str.='<div style="text-align:'.$Block['Attr'].'">'.$this->to_html($Block['Val']).'</div>';
					}
					break;
				case 'color':
				case 'colour':
					$ValidAttribs = array('aqua', 'black', 'blue', 'fuchsia', 'green', 'grey', 'lime', 'maroon', 'navy', 'olive', 'purple', 'red', 'silver', 'teal', 'white', 'yellow');
					if(!in_array($Block['Attr'], $ValidAttribs) && !preg_match('/^#[0-9a-f]{6}$/', $Block['Attr'])) { 
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
       * This is in the text class because it makes it simpler to access smilies
       * I suspect a text object will already be instantiated wherever the assistant is needed...
       * If not this could be moved to a better place maybe?
       */
      
      function display_bbcode_assistant($textarea, $start_num_smilies = 0, $extra_num_smilies = 86){
          
        ?>
        <script type="text/javascript">
                var textBBcode = '<?=$textarea; ?>';
        </script>

        <div id="hover_pick" style="width: auto; height: auto; position: absolute; border: 0px solid rgb(51, 51, 51); display: none; z-index: 20;"></div>

        <table class="bb_holder">
          <tbody><tr>
            <td class="colhead" style="padding: 2px 6px">
                <div style="float: left; text-align: left; margin-top: 0px;">
             
                    <a class="bb_button" onclick="tag('b')" title="Bold text: [b]text[/b]" alt="B"><b>&nbsp;B&nbsp;</b></a>
                    <a class="bb_button" onclick="tag('i')" title="Italic text: [i]text[/i]" alt="I"><i>&nbsp;I&nbsp;</i></a>
                    <a class="bb_button" onclick="tag('u')" title="Underline text: [u]text[/u]" alt="U"><u>&nbsp;U&nbsp;</u></a>
                    <a class="bb_button" onclick="tag('s')" title="Strikethrough text: [s]text[/s]" alt="S"><s>&nbsp;S&nbsp;</s></a>
                    <a class="bb_button" onclick="clink()" title="Insert URL: [url]http://url[/url] or [url=http://url]URL text[/url]" alt="Url">Url</a>
                <!-- <a class="bb_button" onclick="tag('img')" title="Insert image: [img]http://image_url[/img]" alt="Img">Img</a>-->
                    <a class="bb_button" onclick="cimage()" title="Insert image: [img]http://image_url[/img]" alt="Image">img</a>
                    <a class="bb_button" onclick="tag('code')" title="Code display: [code]code[/code]" alt="Code">Code</a>
                    <a class="bb_button" onclick="tag('quote')" title="Quote text: [quote]text[/quote]" alt="Quote">Quote</a>

                 <!-- <a class="bb_button" onclick="tag('mcom')" title="Staff Comment" alt="Mod comment">Mod</a> -->
                 
                <select  class="bb_button" name="fontsize" id="fontsize" onchange="font('size',this.value);" title="Font size">
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
                    
                     <a class="bb_button" onclick="colorpicker();" title="Select Color" alt="Colors">Colors</a>
              </div> 

              <div style="float: right; margin-top: 3px;"> 
                  <img class="bb_icon" src="<?=get_symbol_url('align_center.png') ?>" onclick="wrap('align','','center')" title="Align - center" alt="Center" /> 
                  <img class="bb_icon" src="<?=get_symbol_url('align_left.png') ?>" onclick="wrap('align','','left')" title="Align - left" alt="Left" /> 
               <!-- <img class="bb_icon" src="<?=get_symbol_url('align_justify.png') ?>" onclick="wrap('align','','justify')" title="Align - justify" alt="justify" />  -->
                  <img class="bb_icon" src="<?=get_symbol_url('align_right.png') ?>" onclick="wrap('align','','right')" title="Align - right" alt="Right" /> 
                  <img class="bb_icon" src="<?=get_symbol_url('text_uppercase.png') ?>" onclick="text('up')" title="To Uppercase" alt="Up" /> 
                  <img class="bb_icon" src="<?=get_symbol_url('text_lowercase.png') ?>" onclick="text('low')" title="To Lowercase" alt="Low" />
              </div>
                
              </td>
          </tr> 
          <tr>
            <td>
                <div id="pickerholder"></div>
                <div id="smiley_overflow" class="bb_smiley_holder">
                    <?   //  IF this becomes too much of a strain drawing all the smilies everytime 
                        // the bbcode assistant is used it could be put behind an ajax call for when smilies are opened
                    $count=0;
                    foreach($this->Smileys as $Key=>$Val) {  
                        if ($count == $start_num_smilies){
                            break;
                        }
                        echo '<a class="bb_smiley" title="' .$Key. '" href="javascript:em(\' '.$Key.' \');">'.$Val.'</a>';
                        $count++;
                    }
                    reset($this->Smileys); 
                    ?> 
                </div>  
                <!-- <div id="smiley_overflow" class="bb_smiley_holder"></div>  -->
               
                  <div class="overflow_button">
                       <a href="#" id="open_overflow" onclick="if(this.isopen){Close_Smilies();}else{Open_Smilies(<?="$start_num_smilies,$extra_num_smilies"?>);};return false;">Show smilies</a>
                       <a href="#" id="open_overflow_more" onclick="Open_Smilies(<?=$extra_num_smilies?>,9999);return false;"></a>
                  </div>  
      </td></tr></tbody></table>
        <? 
      }
      
      
      function draw_smilies_from($indexfrom = 0, $indexto = -1){
            $count=0;
            foreach($this->Smileys as $Key=>$Val) { 
                if ($indexto >= 0 && $count > $indexto) { break; }
                if ($count >= $indexfrom){
                    echo '<a class="bb_smiley" title="' .$Key. '" href="javascript:em(\' '.$Key.' \');">'.$Val.'</a>';
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

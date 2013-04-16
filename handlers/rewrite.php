<?php

/* Country code
af = Afrikaans
sq = Albanian
ar = Arabic
be = Belarusian
bg = Bulgarian
ca = Catalan
hr = Croatian
cs = Czech
da = Danish
nl = Dutch
en = English
et = Estonian
tl = Filipino
fi = Finnish
fr = French
gl = Galician
de = German
el = Greek
ht = Haitian Creole ALPHA
iw = Hebrew
hi = Hindi
hu = Hungarian
is = Icelandic
id = Indonesian
ga = Irish
it = Italian
ja = Japanese
ko = Korean
lv = Latvian
lt = Lithuanian
mk = Macedonian
ms = Malay
mt = Maltese
no = Norwegian
fa = Persian
pl = Polish
pt = Portuguese
ro = Romanian
ru = Russian
sr = Serbian
sk = Slovak
sl = Slovenian
es = Spanish
sw = Swahili
sv = Swedish
th = Thai
tr = Turkish
uk = Ukrainian
vi = Vietnamese
cy = Welsh
yi = Yiddish
*/

class rewrite {
	
	        function translate($text, $from = '', $to = 'en') {
                $url = 'http://ajax.googleapis.com/ajax/services/language/translate?v=1.0&q='.urlencode($text).'&langpair='.rawurlencode($from.'|'.$to);
                $response = @file_get_contents(
                        $url,
                        null,
                        stream_context_create(
                                array(
                                        'http'=>array(
												'ignore_errors'=>true,
                                                'method'=>"GET",
                                                'header'=>"Referer: http://".$_SERVER['HTTP_HOST']."/\r\n"
                                        )
                                )
                        )
                );
				//echo '<h3>*** '.rawurlencode($text).'</h3>';
				//echo '<h3>+++'.$response.'</h3>';
                if (preg_match("/{\"translatedText\":\"([^\"]+)\"/i", $response, $matches)) {
                        return self::_unescapeUTF8EscapeSeq($matches[1]);
                }
                return false;
        }
        
        /**
         * Convert UTF-8 Escape sequences in a string to UTF-8 Bytes. Old version.
         * @return UTF-8 String
         * @param $str String
         */
        function __unescapeUTF8EscapeSeq($str) {
                return preg_replace_callback("/\\\u([0-9a-f]{4})/i", create_function('$matches', 'return html_entity_decode(\'&#x\'.$matches[1].\';\', ENT_NOQUOTES, \'UTF-8\');'), $str);
        }
        
        /**
         * Convert UTF-8 Escape sequences in a string to UTF-8 Bytes
         * @return UTF-8 String
         * @param $str String
         */
        function _unescapeUTF8EscapeSeq($str) {
                return preg_replace_callback("/\\\u([0-9a-f]{4})/i", create_function('$matches', 'return rewrite::_bin2utf8(hexdec($matches[1]));'), $str);
        }
        
        /**
         * Convert binary character code to UTF-8 byte sequence
         * @return String
         * @param $bin Mixed Interger or Hex code of character
         */
        function _bin2utf8($bin) {
                if ($bin <= 0x7F) {
                        return chr($bin);
                } else if ($bin >= 0x80 && $bin <= 0x7FF) {
                        return pack("C*", 0xC0 | $bin >> 6, 0x80 | $bin & 0x3F);
                } else if ($bin >= 0x800 && $bin <= 0xFFF) {
                        return pack("C*", 0xE0 | $bin >> 11, 0x80 | $bin >> 6 & 0x3F, 0x80 | $bin & 0x3F);
                } else if ($bin >= 0x10000 && $bin <= 0x10FFFF) {
                        return pack("C*", 0xE0 | $bin >> 17, 0x80 | $bin >> 12 & 0x3F, 0x80 | $bin >> 6& 0x3F, 0x80 | $bin & 0x3F);
                }
        }

	
	public static function gen($content,$lang=false)
	{
		//set_time_limit(600); 
		$limit = 1000;
		$trans_text = trim($content);
		
		if($trans_text != "")
		{	
			if(!$lang)
			{
				$lang = array('es','pl','it','fi','fr','de');
				shuffle($lang);
				$lang=array_slice($lang,0,3);
				$lang[]='en';
			}
			$trans_text =  stripslashes($trans_text);	
			$len = strlen($trans_text);
			$str = array();
			if($len <= $limit)
			{
				$strx[] = $trans_text;
			}
			else
			{
				$str = explode(".",$trans_text);
				$st1 = 0;
				$st2 = 0;
				$buff1 = "";
				$strx = array();
				
				foreach($str as $ext)
				{
					if(trim($ext) != "</p>") $ext .= "."; 
					$buff1 .= $ext; 
					if(strlen($buff1) > $limit)
					{
						$c = 0 - strlen($ext);
						$strx[] = substr($buff1,0,$c);
						$buff1 = $ext;
					}
				}
				$strx[] = $buff1;
			}
			
			flush();
			$txtbuff2 = "";
			
			foreach($strx as $txt)
			{
				$l++;
				if($txt ==  "") continue;
				for($i = 0; $i < count($lang); $i++)
				{
					if($txt2 = stripslashes(rewrite::translate($txt, '', $lang[$i])))
					{
						$txt=$txt2;
					}
					sleep(1);
					//echo '<p>--'.$txt .'--</p>';
				}
				$txtbuff2 .= $txt;
			}
			return $txtbuff2;
		}
	}
}
?>
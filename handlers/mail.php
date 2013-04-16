<?php
class mail
{
	public $from='positron.th@gmail.com';
	public $fromname='Positron';
	public $subject='';
	public $message='';
	public $to='';
	public $encoding='utf-8';
	function send()
	{
		if(preg_match('/<(html|font|br|a|img)/i', $this->message)) $html = $this->message;
		else
		{
			$html = preg_replace("/\n/","<br />",$this->message);
			$html = eregi_replace('(((f|ht){1}t(p|ps)://)[-a-zA-Z0-9@:%_\+.~#?&//=]+)',    '<a href="\\1">\\1</a>', $html);
			$html = eregi_replace('([[:space:]()[{}])(www.[-a-zA-Z0-9@:%_\+.~#?&//=]+)',    '\\1<a href="http://\\2">\\2</a>', $html);
			$html = eregi_replace('([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})',    '<a href="mailto:\\1">\\1</a>', $html);
		}
		
		
		$headers= "From: =?".$this->encoding."?B?".base64_encode($this->fromname)."?= <".$this->from.">\n";
		$headers.= "X-Priority: 3\n";
		$headers.= "X-Mailer: LightZr mailer\n";
		$headers.= "MIME-Version: 1.0\n";
		$headers.= "Content-Type: text/html; charset=".$this->encoding."\n";
		$headers.= "Content-Transfer-Encoding: base64\n";
	
		$subject = '=?'.$this->encoding.'?B?'.base64_encode($this->subject).'?=';
		$message = chunk_split(base64_encode(str_replace("\n", "\r\n", str_replace("\r", "\n", str_replace("\r\n", "\n", str_replace("\n\r", "\r", $html))))));



		return @mail($this->to, $subject,$message, $headers);
	}
}
?>
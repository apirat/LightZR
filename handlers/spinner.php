<?php

class spinner
{
	public $connected=false;
	function post($data)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://thebestspinner.com/api.php');
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $this->data($data));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_REFERER, 'http://thebestspinner.com/api.php');
		$html = trim(curl_exec($ch));
		curl_close($ch);
		return $html;
	}

	function data($data)
	{
		$fdata = "";
		foreach($data as $key => $val)
		{
			$fdata .= "$key=" . urlencode($val) . "&";
		}
		return $fdata;
	}
	function connect()
	{
		if(!lz::$c['spuser'] || !lz::$c['sppass']) return false;
		if($this->connected) return $this->connected;
		
		$data = array();
		$data['action'] = 'authenticate';
		$data['format'] = 'php';
		$data['username'] = lz::$c['spuser'];
		$data['password'] = lz::$c['sppass'];
		$output = unserialize($this->post($data));
		if($this->connected=($output['success']=='true'?true:false))
		{
			$this->session = $output['session'];
		}
		return $this->connected;
	}
	
	function rewrite($article)
	{
		if(!$this->connected)return false;
		$data = array();
		$data['session'] = $this->session;
		$data['format'] = 'php'; # You can also specify 'xml' as the format.
		$data['text'] = str_replace("\n", " iiienteriii ", $article);
		$data['action'] = 'rewriteText';
		$data['protectedterms']  = "#%,iiienteriii";
		$output = $this->post($data);
		
		$output = unserialize($output);
		$data['action'] = 'apiQuota';
		$quota = $this->post($data);
		$quota = unserialize($quota);
		
		
		if($output['success']=='true')
		{
			echo '<div style="padding:5px; border:1px solid #ccc; background:#f9f9f9; margin-top:5px;"><h4>The Best Spinner</h4>';
			echo "<p><b>Input:</b><br>".$article."</p>";
			echo "<p><b>Output:</b><br>".str_replace("\r", "<br>", $output['output'])."</p>";
			echo '</div>';
			$final = str_replace("iiienteriii", "\n", stripslashes($output['output'])); // stripslashes($output['output']);
			return $final;
		}
		else
		{
			return false;
		}
	}
}
?>

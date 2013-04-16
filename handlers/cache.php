<?php
/*
+ ----------------------------------------------------------------------------+
|     LightZr Amazon Script
|
|     Positron 2011
|     http://lightzr.com, http://seo.phukettech.com
|     positron.th@gmail.com
|
|     $Revision: 1.4.0 $
|     $Date: 2011/04/04 16:54:00 $
|     $Author: Positron $
+-----------------------------------------------------------------------------+
*/
class cache
{
	public static $log=array('get'=>'','set'=>'');
	function get($key) {
		if($this->exists($key)) {
			cache::$log['get']++;
			$data = $this->_get_cache($key);
			return $data['data'];
		}
		return false;
	}

	function set($key, $value, $life=0) {
		$data = array($key => array('data' => $value, 'life' => intval($life)));
		$cache_file = $this->get_cache_file_path($key);
		$cachedata = "\$data = ".var_export($data, true).";\n";
		cache::$log['set']++;
		if($fp = @fopen($cache_file, 'wb')) {
			fwrite($fp, "<?php\n//LightZr cache file, DO NOT modify me!".
				"\n//Created: ".date("M j, Y, G:i").
				"\n//Identify: ".md5($cache_file)."\n\nif(!defined('LightZr')) {\n\texit('Access Denied');\n}\n\n$cachedata?>");
			fclose($fp);
		} else {
			exit('Can not write to cache files, please check directory ./cache/ .');
		}
		return true;
	}

	function del($key) {
		$cache_file = $this->get_cache_file_path($key);
		if(file_exists($cache_file)) {
			return @unlink($cache_file);
		}
		return true;
	}

	function _get_cache($key) {
		static $data = null;
		if(!isset($data[$key])) {
			include $this->get_cache_file_path($key);
		}
		return $data[$key];
	}

	function exists($key) {
		$cache_file = $this->get_cache_file_path($key);
		if(!file_exists($cache_file)) {
			return false;
		}
		$data = $this->_get_cache($key);
		if($data['life'] && (filemtime($cache_file) < time() - $data['life'])) {
			return false;
		}
		return true;
	}

	function get_cache_file_path($key) {
		static $cache_path = null;
		if(!isset($cache_path[$key])) {
			$dir = str_replace('_',DS,$key);
			$this->mkdir(dirname($cache_path[$key] = FILES.'cache/'.$dir.'.cache.php'));
		}
		return $cache_path[$key];
	}
	
	function mkdir($dir, $mode = 0777)
	{
		if(!is_dir($dir)) 
		{
			$this->mkdir(dirname($dir));
			@mkdir($dir, $mode);
			@chmod($dir, $mode);
		}
		return true;
	}
	
	
	public function clean($path='')
	{
		return $this->_cleanDir('cache/'.($path?str_replace('_',DS,$path).'/':''));
	}
	private function _unlink($file)
	{
		return (file_exists(FILES.$file)&&!@unlink(FILES.$file))?false:true;
	}
	private function _cleanDir($dir)
	{
		if (!is_dir(FILES.$dir)||!($dh=@opendir(FILES.$dir))) return;
		$result=true;
		while($file=readdir($dh))
		{
			if(!in_array($file,array('.','..')))
			{
				$file2=$dir.$file;
				if(is_dir(FILES.$file2))
				{
					$this->_cleanDir($file2.'/');
				}
				else
				{
					if(substr($file,-10)=='.cache.php'&&is_file(FILES.$file2)) $result=($result&&($this->_unlink($file2)));
				}
			}
		}
		return false;
	}
}
?>
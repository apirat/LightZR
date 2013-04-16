<?php
class folder
{
	public function __construct()
	{
		
	}
	public function save($file,$data)
	{
		$this->mkdir(dirname($file));
		if($fp=@fopen($file, "wb"))
		{
			$data=stripslashes($data);
			//@flock($fp,LOCK_EX);
			$len=strlen($data);
			@fwrite($fp, $data, $len);
			//@flock($fp, LOCK_UN);
			@fclose($fp);
			//@chmod($file, 0777);
			return true;
		}
	}
	public function mkdir($dir, $mode = 0777)
	{
		if(!is_dir($dir)) 
		{
			$this->mkdir(dirname($dir));
			@mkdir($dir, $mode);
			@chmod($dir, $mode);
		}
		return true;
	}
	public function clean($type)
	{
		if (!is_dir(FILES.$type)||!($dh=@opendir(FILES.$type))) return;
		$result=true;
		while($file=readdir($dh))
		{
			if(!in_array($file,array('.','..')))
			{
				$file2=$type.'/'.$file;
				if(is_dir(FILES.$file2))
				{
					$this->clean($file2);
				}
				else
				{
					@unlink(FILES.$file2);
				}
			}
		}
		@rmdir(FILES.$type);
        return false;
	}
}
?>
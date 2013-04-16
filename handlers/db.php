<?php
class db
{
	protected $db;
	protected $type;
	protected $install;
	protected $key;
	public function __construct($key="default")
	{
		$this->type=(isset(lz::$cf['db'][$key]['type'])?lz::$cf['db'][$key]['type']:'mysql');
		require_once(dirname(__FILE__).'/db/'.$this->type.'.php');
		$this->db=new $this->type($key);
		$this->key=$key;
	}
	public function __call($func,$param=array())
	{
		return call_user_func_array(array($this->db,$func),$param);
	}
	public function install($sql)
	{
		if($this->type=='mysql')
		{
			if(!$this->install)
			{
				require_once(dirname(__FILE__).'/db/'.$this->type.'.upgrade.php');
				$tb=$this->type.'_upgrade';
				$this->install = new $tb($this->key);
			}
			$this->install->upgrade($sql);
		}
	}
}
?>

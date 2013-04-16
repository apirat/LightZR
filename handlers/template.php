<?php
class template
{
	public function __construct()
	{
		
	}
	public function assign($s)
	{
		if(is_string($s))$this->$s=@func_get_arg(1);
		elseif(is_array($s)) foreach($s as $k=>$v) $this->$k=$v;
	}
	public function display($f='',$type='')
	{
		echo $this->fetch($f,$type);
	}
	public function fetch($f='',$type='')
	{
		ob_start();
		if(!$type)$type=lz::$t;
		if(!$type)$type='admin';
		preg_match('/^([^\.]+)/is',$f,$c);
		$file=$type.'.'.($f?$f.'.':'').'tpl';
		if($type=='admin')
		{
			$to=MODULES.(!in_array($c[1],array('content','error',''))?$c[1].'/':'').'templates/';
		}
		else
		{
			if(lz::$s['theme']&&lz::$s['theme']!=lz::$c['theme'])
			{
				lz::$c['theme']=lz::$s['theme'];
			}
			$to=ROOT.'themes/'.lz::$c['theme'].'/templates/'.(!in_array($c[1],array('content','error',''))?$c[1].'/':'');
			if(!file_exists($to.$file))
			{
				$to=ROOT.'themes/lightzr/templates/'.(!in_array($c[1],array('content','error',''))?$c[1].'/':'');
			}
		}
		if(!file_exists($to.$file))
		{
			echo 'file not exists: from - '.$to.$file;
			exit;
		}
		include($to.$file);
		return ob_get_clean();
	}
}
?>
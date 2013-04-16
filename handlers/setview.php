<?php
class setview
{
	public static $key;
	public static $func;
	public static $allorder=array();
	public static $view=array();
	public static $rows;
	public function set($key,$func)
	{
		setview::$key=$key;
		setview::$func=$func;
	}
	public function ajax()
	{	
		$ajax=lz::h('ajax');
		$ajax->register('setlist');
		$ajax->register('resetlist');
		if(in_array(strval($_POST['ajax']),array('setlist','resetlist')))
		{
			$ajax->process();
		}
	}
	public function get($view,$default)
	{
		$tmp=unserialize(lz::$c[setview::$key]);
		if(!$tmp||!count($tmp['column']))$tmp=array('column'=>$default,'rows'=>20,'order'=>array());
		if(count($view)==count($tmp['order']))
		{
			$k=array();
			for($i=0;$i<count($tmp['order']);$i++)
			{
				setview::$view[$tmp['order'][$i]]=$view[$tmp['order'][$i]];
				$k[$tmp['order'][$i]]=$i;
			}
			array_multisort($k, setview::$view);
		}
		else
		{
			setview::$view=$view;
		}
		setview::$allorder=array();
		for($i=0;$i<count($tmp['column']);$i++)
		{
			if(array_key_exists($tmp['column'][$i],$view))
			{
				setview::$allorder[$tmp['column'][$i]]=$view[$tmp['column'][$i]];
			}
		}
		setview::$rows=$tmp['rows'];
		if(setview::$rows<1)setview::$rows=1;
		return array(setview::$allorder,setview::$rows);
	}
	public function popup()
	{
		$template=lz::h('template');
		return $template->fetch('content.setview');
	}
}


function setlist($frm,$order)
{
	$ajax=lz::h('ajax');
	lz::set(setview::$key,serialize(array('column'=>$frm['column'],'order'=>$order,'rows'=>$frm['rows'])));
	lz::get();
	lz::h('ajax')->assign(setview::$func,'innerHTML',call_user_func(setview::$func));
}
function resetlist()
{
	lz::h('db')->execute('delete from core where name=?',array(setview::$key));
	lz::h('ajax')->assign(setview::$func,'innerHTML',call_user_func(setview::$func));
}
?>
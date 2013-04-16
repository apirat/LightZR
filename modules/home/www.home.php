<?php

if($_SERVER['HTTP_REFERER'])
{
	$p=parse_url($_SERVER['HTTP_REFERER']);
	parse_str($p[ 'query' ],$s);
	if(isset($s['q']))
	{
		if($cl=lz::h('db')->GetOne('select link from product_category where title=?',array($s['q'])))
		{
			
		}
		elseif($cl=lz::h('db')->GetOne('select link from product_category where title like ?',array('%'.str_replace(' ','%',$s['q']).'%')))
		{
			
		}
		if($cl)
		{
			lz::move(lz::$c['sub']==2?'http://'.$cl.'.'.lz::$cf['domain']:QUERY.$cl,true);
		}
	}
}

$template=lz::h('template');

$product=lz::h('product');
$product->set(array('type'=>'home'));
define('PAGE','home');
define('IMAGES',HTTP.'themes/'.lz::$c['theme'].'/images/');

www::$content=$template->fetch('home');

define('NOCONTENT',1);
?>
<?php
if(!lz::$c['sitemap'])
{
	header ('HTTP/1.1 301 Moved Permanently');
	header('Location: '.QUERY);
	exit;
}
header('Content-type: text/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" href="http://'.HOST.HTTP.'themes/'.lz::$c['theme'].'/css/sitemap.xsl"?>';


$cache=lz::h('cache');
if(!$data=$cache->get('sitemap_'.SUB))
{
	if(isset(lz::$s))
	{
		$db=lz::h('db');
		$product=$db->GetAll('select p.asin,p.link,p.brand,p.color,c.link as clink from product as p left join product_category as c on p.category=c.id where p.category=?',array(lz::$s['id']));
		$template=lz::h('template');
		$template->assign('product',$product);
		$data=$template->fetch('sitemap');
	}
	elseif(SUB=='www')
	{
		$db=lz::h('db');
		$site=$db->GetAll('select title,link,domain from product_category');
		$template=lz::h('template');
		$template->assign('site',$site);
		$data=$template->fetch('sitemap.site');
	}
	else
	{
		
		$db=lz::h('db');
		lz::$s=$db->GetRow('select * from product_category where link=?',array(SUB));
		$product=$db->GetAll('select p.asin,p.link,p.brand,p.color,c.link as clink from product as p left join product_category as c on p.category=c.id where p.category=?',array(lz::$s['id']));
		$template=lz::h('template');
		$template->assign('product',$product);
		$data=$template->fetch('sitemap');
	}
	$cache->set('sitemap_'.SUB,$data,0);
}
echo $data;
exit;
?>
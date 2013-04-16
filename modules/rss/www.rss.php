<?php
if(!lz::$c['rss'])
{
	header ('HTTP/1.1 301 Moved Permanently');
	header('Location: '.QUERY);
	exit;
}
header('Content-type: text/xml; charset=utf-8');

$cache=lz::h('cache');
if(!$data=$cache->get('rss_'.SUB))
{
	$db=lz::h('db');
	$template=lz::h('template');
	if(isset(lz::$s))
	{
		$template->assign('product',$db->GetAll("select p.url,p.link,p.title,p.category,p.lastupdate,p.editor,if(p.l2!='',concat('http://".HOST.HTTP."files/photo/',p.category,'/l/',p.l2),p.l) as s,? as ctitle,? as clink from product as p where p.category=? order by p.lastupdate desc limit 0,25",array(lz::$s['title'],lz::$s['link'],lz::$s['id'])));
	}
	elseif(SUB=='www')
	{
		$template->assign('product',$db->GetAll("select p.url,p.link,p.title,p.category,p.lastupdate,p.editor,p.feature,if(p.l2!='',concat('http://www.".lz::$cf['domain'].HTTP."files/photo/',p.category,'/l/',p.l2),p.l) as s,c.title as ctitle,c.link as clink from product as p left join product_category as c on p.category=c.id group by p.asin order by p.lastupdate desc limit 0,25"));
	}
	else
	{
		if(!lz::$s=$db->GetRow('select * from product_category where link=?',array(SUB)))
		{
			header ('HTTP/1.1 301 Moved Permanently');
			header('Location: http://www.'.lz::$cf['domain'].QUERY);
			exit;
		}
		$template->assign('product',$db->GetAll("select p.url,p.link,p.title,p.category,p.lastupdate,p.editor,if(p.l2!='',concat('http://".HOST.HTTP."files/photo/',p.category,'/l/',p.l2),p.l) as s,? as ctitle,? as clink from product as p where p.category=? order by p.lastupdate desc limit 0,25",array(lz::$s['title'],lz::$s['link'],lz::$s['id'])));
	}
	if(lz::$s['mtitle'])lz::$c['title']=lz::$s['mtitle'];
	if(lz::$s['mdescription'])lz::$c['description']=lz::$s['mdescription'];
	if(lz::$s['mkeywords'])lz::$c['keywords']=lz::$s['mkeywords'];
	if(lz::$s['footer'])lz::$c['disclaimer']=lz::$s['footer'];
	
	$product=(lz::$s['title']?lz::$s['title']:'products');
	$sitename=(lz::$s['title']?lz::$s['title']:lz::$c['sitename']);
	lz::$c['title']=((lz::$s['ptitle'])?lz::$s['ptitle'].' - ':'').str_replace(array('{PRODUCT}','{SITENAME}'),array($product,$sitename),lz::$c['title']);
	lz::$c['description']=str_replace(array('{PRODUCT}','{SITENAME}'),array($product,$sitename),lz::$c['description']);
	lz::$c['disclaimer']=str_replace(array('{PRODUCT}','{SITENAME}'),array($product,$sitename),lz::$c['disclaimer']);
	lz::$c['keywords']=str_replace('{KEYWORDS}',(lz::$s['title']?lz::$s['title']:strtolower($sitename)).(lz::$s['title']?', '.str_replace(' ',', ',lz::$s['title']):''),lz::$c['keywords']);
		
	$data=$template->fetch('rss');
	$cache->set('rss',$data,3600);
}
echo $data;
exit;
?>
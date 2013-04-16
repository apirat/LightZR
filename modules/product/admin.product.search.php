<?php

define('ERROR_RELOAD',1);
$allby=array('desc'=>'หลังไปหน้า','asc'=>'หน้าไปหลัง');
$all=array('page','auto');
$split=lz::h('split');
extract($split->get(PATHMIN.SERVICE_LINK.'/'.lz::$f[0].'/',1,$all,$allorder,$allby));
	
$db=lz::h('db');
if(!$c=$db->GetRow("select c.* from product_category as c where id=?",array(lz::$f[0])))
{
	if($auto==2)
	{
		if($cate=$db->GetOne("select id from product_category where id>? order by id asc limit 0,1",array(lz::$f[0])))
		{
			header('Location: '.PATHMIN.SERVICE_LINK.'/'.$cate.'/auto/2');
			exit;
		}
		else
		{
			header('Location: '.PATHMIN.SERVICE_LINK.'/?updated');
			exit;
		}
	}
	header('Location: '.PATHMIN.SERVICE_LINK);
	exit;
}
$template=lz::h('template');
$template->assign('page',$page);
$template->assign('category',$c);
$template->assign('navigator','<li><a href="'.PATHMIN.SERVICE_LINK.'">&larr; หมวดสินค้าทั้งหมด</a></li><li><a href="'.PATHMIN.SERVICE_LINK.'/list/'.lz::$f[0].'">สินค้าที่มีอยู่แล้ว</a></li><li><a href="'.PATHMIN.SERVICE_LINK.'/setting/'.lz::$f[0].'">ตั้งค่าการค้นหาสินค้า</a></li>'.($auto?'<li><a href="'.PATHMIN.SERVICE_LINK.'/'.lz::$f[0].'">ค้นหาสินค้า</a></li>':'<li><a href="'.PATHMIN.SERVICE_LINK.'/'.lz::$f[0].'/auto/1">ค้นหาและเพิ่มสินค้าอัตโนมัติ</a></li>'));
	
if(!$c['searchindex']||!$c['keywords'])
{
	$template->assign('error','ตั้งค่าการค้นหาไม่ถูกต้อง');
}
else
{
	if($page<1)$page=1;
	
	$ajax=lz::h('ajax');
	$ajax->register('addproduct',dirname(__FILE__).'/admin.product.search.ajax.php');
	$ajax->register('avg',dirname(__FILE__).'/admin.product.search.ajax.php');
	$ajax->process();
	
	$group=false;
	if(trim($c['onlygroup']))
	{
		$group=array_map('trim',explode(',',strtolower($c['onlygroup'])));
	}
	$intitle=false;
	if(trim($c['intitle']))
	{
		$intitle=array_map('trim',explode(',',strtolower($c['intitle'])));
	}
	$inalltitle=false;
	if(trim($c['inalltitle']))
	{
		$inalltitle=array_map('trim',explode(',',strtolower($c['inalltitle'])));
	}
	$outtitle=false;
	if(trim($c['outtitle']))
	{
		$outtitle=array_map('trim',explode(',',strtolower($c['outtitle'])));
	}
	$onlymanu=false;
	if(trim($c['onlymanu']))
	{
		$onlymanu=array_map('trim',explode(',',strtolower($c['onlymanu'])));
	}
	
	$item=lz::h('amazon')->search($c['searchindex'],$c['keywords'],$page,$auto,lz::$f[0],$group,$intitle,$outtitle,$inalltitle,$onlymanu,$c['rsort'],$c['node'],$c['rate'],$c['awstag']);
	

	$template->assign('item',$item);
	
	list($pg,$limit)=lz::h('pager')->page(10,$item['TotalResults'],$url,'page/',$page);
	$template->assign('pager',$pg);
	$template->assign('auto',$auto);
}
require(dirname(__FILE__).'/admin.product.config.php');
$template->assign('delay',$delay);
admin::$content=$template->fetch('product.search');

?>
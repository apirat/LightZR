<?php
$db=lz::h('db');
if(!$c=$db->GetRow("select c.* from product_category as c where id=?",array(lz::$f[1])))
{
	header('Location: '.PATHMIN.SERVICE_LINK);
	exit;
}

$ajax=lz::h('ajax');
$ajax->register('save',dirname(__FILE__).'/admin.product.setting.ajax.php');
$ajax->register('newblog',dirname(__FILE__).'/admin.product.setting.ajax.php');
$ajax->register('update',dirname(__FILE__).'/admin.product.setting.ajax.php');
$ajax->register('del',dirname(__FILE__).'/admin.product.setting.ajax.php');
$ajax->process();

$template=lz::h('template');
$template->assign('navigator','<li><a href="'.PATHMIN.SERVICE_LINK.'">&larr; หมวดสินค้าทั้งหมด</a></li><li><a href="'.PATHMIN.SERVICE_LINK.'/list/'.lz::$f[1].'">สินค้าที่มีอยู่แล้ว</a></li><li><a href="'.PATHMIN.SERVICE_LINK.'/'.lz::$f[1].'">ค้นหาสินค้า</a></li><li><a href="'.PATHMIN.SERVICE_LINK.'/'.lz::$f[1].'/auto/1">ค้นหาและเพิ่มสินค้าอัตโนมัติ</a></li>');
$searchindex=array();
$amazon=lz::h('amazon');
foreach($amazon->searchindex as $val)$searchindex[$val]=$val;


require(dirname(__FILE__).'/admin.product.config.php');

$template->assign('ads468',$ads468);
$template->assign('ads120',$ads120);
$template->assign('cmode',$mode);

$pgroup=array();
$p=array_values(array_filter(array_map('trim',explode(',',lz::$c['pgroup']))));
foreach($p as $v)$pgroup[$v]=$v;
$template->assign('pgroup',$pgroup);
	

$theme=array();
$dh=@opendir(ROOT.'themes/');
while($file=readdir($dh))
{
	if(!in_array($file,array('.','..')))
	{
		if(is_dir(ROOT.'themes/'.$file))
		{
			$theme[$file]=ucfirst($file);
		}
	}
}

$template->assign('theme',$theme);
$template->assign('cate',$c);
$template->assign('searchindex',$searchindex);
$template->assign('amazon',$amazon);
$template->assign('html',lz::h('html'));

admin::$content=$template->fetch('product.setting');


?>
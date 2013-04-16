<?php
$ajax = lz::h('ajax');
$ajax->register('delphoto',dirname(__FILE__).'/admin.home.ajax.php');
$ajax->register('getphoto',dirname(__FILE__).'/admin.home.ajax.php');
$ajax->register('password',dirname(__FILE__).'/admin.home.ajax.php');
$ajax->register('save',dirname(__FILE__).'/admin.home.ajax.php');
$ajax->register('setbox',dirname(__FILE__).'/admin.home.ajax.php');
$ajax->register('clearcache',dirname(__FILE__).'/admin.home.ajax.php');
$ajax->process();
$db=lz::h('db');
lz::h('time');
$template=lz::h('template');
$template->assign('navigator','<li>LightZr v. '.VERSION.' - '.time::show(date('Y-m-d H:i:s'),'datetime')).' </li>';
$service=$db->GetAll('select s.id,s.name,s.link,s.icon,s.submenu,m.folder,m.multi,m.detail,m.category,c.key,c.name as cate from service as s left join module as m on s.module=m.id left join module_category as c on m.category=c.id where  m.status in (?,?) order by c.id asc,m.id asc',array('install','paused'));


if(lz::$c['bot'])$template->assign('bot',$db->getone('select count(id) from bot'));
if(lz::$c['referer'])
{
	$template->assign('referer',$db->getone('select count(id) from referer'));
	$template->assign('referer24',$db->getone('select count(id) from referer where unix_timestamp(time)+(60*60*24)>unix_timestamp(now())'));
}
if(lz::$c['click'])
{
	$template->assign('click',$db->getone('select count(id) from click'));
	$template->assign('click24',$db->getone('select count(id) from click where unix_timestamp(time)+(60*60*24)>unix_timestamp(now())'));
}
$template->assign('product',$db->getrow('select count(asin) as allproduct, sum(if(lastbot!=?,1,0)) as indexed from product',array('0000-00-00 00:00:00')));
$template->assign('rewrite',$db->getone('select count(asin) from product where content!=?',array('')));
$template->assign('cate',$db->getone('select count(id) from product_category'));
$template->assign('photo',$db->GetOne('select count(*) from product where l2!=?',array('')));
$template->assign('service',$service);
admin::$content=$template->fetch('home');
?>
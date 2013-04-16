<?php
$db=lz::h('db');
$ajax=lz::h('ajax');
$ajax->register('update',dirname(__FILE__).DS.'admin.service.ajax.php','services');
$ajax->register('setdefault',dirname(__FILE__).DS.'admin.service.ajax.php','services');
$ajax->register('seticon',dirname(__FILE__).DS.'admin.service.ajax.php','services');
$ajax->register('sinstall',dirname(__FILE__).DS.'admin.service.ajax.php','services');
$ajax->register('suninstall',dirname(__FILE__).DS.'admin.service.ajax.php','services');
$ajax->register('createpage',dirname(__FILE__).DS.'admin.service.ajax.php','services');
$ajax->process();
$tmp=ROOT.'images/admin/menu/';
$icon=array();
if(is_dir($tmp))
{
	if($dh=opendir($tmp))
	{
		while(($dir=readdir($dh))!==false)
		{
			if(preg_match("/([a-zA-Z0-9_-]*)(32\.gif)$/iU",$dir,$path))array_push($icon,$path[1]);
			//echo '---'.$dir.'---'.$path[0].'==='.$path[1].'==='.$path[2].'<br>';
		}
		closedir($dh);
	}
}
$template=lz::h('template');
//$template->assign('navigator','<li><a href="javascript:;" onclick="lz.box.open(\'#newservice\')"><img src="'.HTTP.'static/images/add.gif" align="absmiddle">สร้างหน้าเว็บใหม่</a></li>');
$template->assign('services',getservices());
$template->assign('icon',$icon);
$template->assign('modules',$db->GetAll("select m.id,m.name,m.folder from module as m where m.status='install' and m.multi='yes' order by m.name asc"));
admin::$content=$template->fetch('service');
function getservices()
{
	$db=lz::h('db');
	//$services=$db->GetAll("select s.id,s.name as service,s.link,s.menu,s.submenu,s.icon,s.default as setdefault,m.adminonly,m.name as module,m.type,m.folder,m.adminonly,m.core,m.multi from service as s left join module as m on s.module=m.id where m.status=? and s.site=? order by s.name asc",array('install',lz::$s['id']));
	$services=$db->GetAll("select s.id,s.name as service,s.link,s.menu,s.submenu,s.icon,s.default as setdefault,m.id as mid,m.category,m.admin,m.www,m.url,m.name as module,m.type,m.folder,m.multi,m.detail,m.status,c.name as cate from module as m left join service as s on m.id=s.module left join module_category as c on m.category=c.id where m.status in (?,?) and (m.multi=? or s.id is not null) order by m.category asc,s.name asc",array('install','paused','no'));
	$template=lz::h('template');
	$template->assign('services',$services);
	return $template->fetch('service.list');
}
?>
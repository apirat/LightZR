<?php
define('LAYOUTID',1);
$ajax=lz::h('ajax');
$ajax->register('newbox',dirname(__FILE__).'/admin.layout.ajax.php');
$ajax->register('delete',dirname(__FILE__).'/admin.layout.ajax.php');
$ajax->register('position',dirname(__FILE__).'/admin.layout.ajax.php');
$ajax->register('editname',dirname(__FILE__).'/admin.layout.ajax.php');
$ajax->register('option',dirname(__FILE__).'/admin.layout.ajax.php');
$ajax->register('setoption',dirname(__FILE__).'/admin.layout.ajax.php');
$ajax->register('setshow',dirname(__FILE__).'/admin.layout.ajax.php');
$ajax->process();
$template=lz::h('template');
$template->assign('navigator','<li><a href="javascript:;" onclick="$(\'#newbox\').animate({height:\'toggle\',opacity: \'toggle\'},1000,\'easeOutBounce\');"><img src="'.HTTP.'static/images/add.gif" align="absmiddle" /> เพิ่มกล่องข้อมูล</a></li>');
$db=lz::h('db');
$template->assign('module',$db->GetAll('select b.*,m.folder from module_box as b left join module as m on b.module=m.id left join service as s on b.module=s.module order by b.module,b.name'));
$tmp=$db->GetAll('select sb.*,b.func,b.detail,m.folder from service_box as sb left join module_box as b on sb.mbox=b.id left join module as m on b.module=m.id where sb.site=? order by sb.order asc',array(LAYOUTID));
$box=array();
for($i=0;$i<count($tmp);$i++)
{
	$box[$tmp[$i]['position']].='<div class="layout"><div class="layout-header" box="'.$tmp[$i]['id'].'"><span class="ui-icon show-tooltip-s" title="ลบกล่องข้อมูลนี้"></span><span class="ui-icon-edit show-tooltip-s" title="แก้ไขชื่อเมนู"></span><span class="ui-icon-show show-tooltip-s" title="แก้ไขการแสดงผล"></span>'.($tmp[$i]['func']?'<span class="ui-icon-option show-tooltip-s" title="'.$tmp[$i]['detail'].'"></span>':'').'<img src="'.HTTP.'modules/'.$tmp[$i]['folder'].'/images/icon16.gif" class="icon show-tooltip-s" title="ย้ายตำแหน่งกล่องข้อมูลนี้"> <span id="name'.$tmp[$i]['id'].'" show="'.$tmp[$i]['show'].'">'.$tmp[$i]['name'].'</span></div></div>';
}
$template->assign('box',$box);
admin::$content=$template->fetch('layout');
?>
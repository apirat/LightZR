<?php
$module=array();
$module['category']=array('system'=>'ระบบหลักของเว็บไซต์');
$module['name']='บริการ';
$module['url']='service';
$module['author']='Positron';
$module['version']=0.1;
$module['detail']='ระบบจัดการบริการของเว็บไซต์';
$module['compatible']=1.0;
$module['type']='system';  //  enum('system','module')
$module['multi']='no';  //  enum('yes','no') / can create new service / type='module' only
$module['admin']='yes';   //  enum('yes','no')
$module['www']='no';   //  enum('yes','no')
$module['core']='no';   //  enum('yes','no')
// Events
// Module -  function: {folder}_module_install($module_id) , {folder}_module_uninstall($module_id) , {folder}_module_reload($module_id)
// Service - function: {folder}_service_create($service_id) , {folder}_service_remove($service_id)
function service_module_install($module_id)
{
	
}
function service_module_reload($id)
{
	service_module_install($id);
}

function service_database()
{
	$sql="CREATE TABLE IF NOT EXISTS `service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `link` varchar(20) CHARACTER SET utf8 NOT NULL,
  `default` enum('yes','no') CHARACTER SET utf8 NOT NULL DEFAULT 'no',
  `module` int(2) NOT NULL,
  `menu` enum('static','show','hide') CHARACTER SET utf8 NOT NULL DEFAULT 'show',
  `submenu` enum('static','show','hide') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'hide',
  `menu_main` enum('static','show','hide') CHARACTER SET utf8 NOT NULL DEFAULT 'hide',
  `menu_sub` enum('static','show','hide') CHARACTER SET utf8 NOT NULL DEFAULT 'hide',
  `icon` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `site` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
	lz::h('db')->install($sql);
	
	$sql="CREATE TABLE IF NOT EXISTS `service_box` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `mbox` int(11) NOT NULL,
  `site` int(11) NOT NULL,
  `position` enum('menu','bar1','bar2') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'menu',
  `order` int(11) NOT NULL,
  `show` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `option` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
	lz::h('db')->install($sql);
}
?>
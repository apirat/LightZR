<?php
$module=array();
$module['site']=1; // Site ID, 0 = all sites
$module['category']=array('system'=>'ระบบหลักของเว็บไซต์');
$module['name']='โมดูล';
$module['url']='module';
$module['author']='Positron';
$module['version']=0.2;
$module['detail']='ระบบจัดการโมดูล';
$module['compatible']=1.0;
$module['type']='system';  //  enum('system','module')
$module['multi']='no';  //  enum('yes','no') / can create new service / type='module' only
$module['admin']='yes';   //  enum('yes','no')
$module['www']='no';   //  enum('yes','no')
$module['core']='no';   //  enum('yes','no')
// Events
// Module -  function: {folder}_module_install($module_id) , {folder}_module_uninstall($module_id) , {folder}_module_reload($module_id)
// Service - function: {folder}_service_create($service_id) , {folder}_service_remove($service_id)


function module_database()
{
	$sql="CREATE TABLE IF NOT EXISTS `module` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `category` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `folder` varchar(20) CHARACTER SET utf8 NOT NULL,
  `url` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `type` enum('system','module') CHARACTER SET utf8 NOT NULL DEFAULT 'module',
  `site` int(11) NOT NULL,
  `author` varchar(50) CHARACTER SET utf8 NOT NULL,
  `version` decimal(3,1) NOT NULL,
  `detail` text CHARACTER SET utf8 NOT NULL,
  `time` datetime NOT NULL,
  `compatible` decimal(3,1) NOT NULL,
  `multi` enum('yes','no') CHARACTER SET utf8 NOT NULL DEFAULT 'no',
  `admin` enum('yes','no') CHARACTER SET utf8 NOT NULL DEFAULT 'no',
  `www` enum('yes','no','first') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `core` enum('yes','no') CHARACTER SET utf8 NOT NULL DEFAULT 'no',
  `status` enum('install','uninstall','paused') CHARACTER SET utf8 NOT NULL DEFAULT 'uninstall',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
	lz::h('db')->install($sql);
	
	$sql="CREATE TABLE IF NOT EXISTS `module_box` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `file` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `module` int(3) NOT NULL,
  `option` text COLLATE utf8_unicode_ci NOT NULL,
  `detail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `func` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
	lz::h('db')->install($sql);
	
	$sql="CREATE TABLE IF NOT EXISTS `module_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
	lz::h('db')->install($sql);
}
?>
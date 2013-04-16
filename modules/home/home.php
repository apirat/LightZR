<?php
$module=array();
$module['category']=array('system'=>'ระบบหลักของเว็บไซต์');
$module['name']='หน้าแรก';
$module['url']='home';
$module['author']='Positron';
$module['version']=0.1;
$module['detail']='หน้าแรก รูปแบบปรกติ';
$module['compatible']=1.0;
$module['type']='system';  //  enum('system','module')
$module['multi']='no';  //  enum('yes','no') / can create new service / type='module' only
$module['admin']='yes';   //  enum('yes','no')
$module['www']='first';   //  enum('yes','no','first')
$module['core']='no';   //  enum('yes','no')
$module['template']=array('www.content.tpl'=>'html ทั่วๆไปที่ทุกหน้าเว็บนำไปแสดง','www.content.css'=>'css ทั้งหมดของเว็บไซต์','www.home.tpl'=>'html ในหน้าแรก','www.content.border.menu.tpl'=>'html ของกล่องข้อมูลในแถบเมนู','www.content.border.full.tpl'=>'html ของกล่องข้อมูลในหน้าแรกแบบกว้าง','www.content.border.half.tpl'=>'html ของกล่องข้อมูลในหน้าแรกแบบปรกติ');


// Events
// Module -  function: {folder}_module_install($module_id) , {folder}_module_uninstall($module_id) , {folder}_module_reload($module_id)
// Service - function: {folder}_service_create($service_id) , {folder}_service_remove($service_id)


function home_database()
{
	$sql="CREATE TABLE IF NOT EXISTS `core` (
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
	lz::h('db')->install($sql);
	
	$sql="CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `fbid` bigint(20) NOT NULL,
  `username` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `display` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `time` datetime NOT NULL,
  `lasttime` datetime NOT NULL,
  `inbox` int(11) NOT NULL,
  `type` enum('sysop','admin','staff','user','ban') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'user',
  `class` int(1) NOT NULL DEFAULT '1',
  `ip` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `ban` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `firstname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `bid` varchar(13) COLLATE utf8_unicode_ci NOT NULL,
  `gender` enum('male','female') COLLATE utf8_unicode_ci NOT NULL,
  `birthday` date NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `zone` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `district` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `province` int(2) NOT NULL,
  `zipcode` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `fax` varchar(9) COLLATE utf8_unicode_ci NOT NULL,
  `added` datetime NOT NULL,
  `newsletter` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `topic` int(11) NOT NULL,
  `reply` int(11) NOT NULL,
  `secret` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `tmppass` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('pending','confirm') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending',
  `sig` text COLLATE utf8_unicode_ci NOT NULL,
  `point` int(11) NOT NULL,
  `total_topic` int(11) NOT NULL,
  `total_reply` int(11) NOT NULL,
  `site` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
	lz::h('db')->install($sql);
}

?>


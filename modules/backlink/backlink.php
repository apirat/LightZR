<?php
$module=array();
$module['category']=array('general'=>'ระบบทั่วไป');
$module['name']='สร้างแบ็คลิ้งค์';
$module['url']='backlink';
$module['author']='Positron';
$module['version']=0.1;
$module['detail']='ระบบโพสข้อมูลไปยัง wordpress เพื่อสร้าง backlink กลับมายังสินค้า';
$module['compatible']=1.0;
$module['type']='module';  //  enum('system','module')
$module['multi']='no';  //  enum('yes','no') / can create new service / type='module' only
$module['admin']='yes';   //  enum('yes','no')
$module['www']='no';   //  enum('yes','no','first')
$module['core']='no';   //  enum('yes','no')  / options news for config the services


function backlink_database()
{
	$sql="CREATE TABLE IF NOT EXISTS `blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `blogid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `blogtype` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `site` int(11) NOT NULL,
  `lastpost` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
	lz::h('db')->install($sql);
	
	$sql="CREATE TABLE IF NOT EXISTS `blog_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `blog` int(11) NOT NULL,
  `postid` bigint(20) NOT NULL,
  `posturl` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `asin` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `category` int(11) NOT NULL,
  `bcategory` int(11) NOT NULL,
  `pingo` datetime NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
	lz::h('db')->install($sql);
}
?>
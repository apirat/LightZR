<?php
$module=array();
$module['category']=array('general'=>'ระบบทั่วไป');
$module['name']='บอทกูเกิ้ล';
$module['url']='bot';
$module['author']='Positron';
$module['version']=0.1;
$module['detail']='รายงานการเข้ามาเก็บข้อมูลเว็บจากบอทกูเกิ้ล';
$module['compatible']=1.0;
$module['type']='module';  //  enum('system','module')
$module['multi']='no';  //  enum('yes','no') / can create new service / type='module' only
$module['admin']='yes';   //  enum('yes','no')
$module['www']='no';   //  enum('yes','no','first')
$module['core']='no';   //  enum('yes','no')  / options news for config the services



function bot_database()
{
	$sql="CREATE TABLE IF NOT EXISTS `bot` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site` int(11) NOT NULL,
  `bot` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ua` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `refer` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `uri` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `host` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
	lz::h('db')->install($sql);
}
?>
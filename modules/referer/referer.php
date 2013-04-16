<?php
$module=array();
$module['category']=array('general'=>'ระบบทั่วไป');
$module['name']='ผู้เยี่ยมชมจาก google';
$module['url']='referer';
$module['author']='Positron';
$module['version']=0.1;
$module['detail']='รายงานผู้ชมที่เข้ามายังเว็บไซต์จากการเซิสใน google';
$module['compatible']=1.0;
$module['type']='module';  //  enum('system','module')
$module['multi']='no';  //  enum('yes','no') / can create new service / type='module' only
$module['admin']='yes';   //  enum('yes','no')
$module['www']='no';   //  enum('yes','no','first')
$module['core']='no';   //  enum('yes','no')  / options news for config the services


function referer_database()
{
	$sql="CREATE TABLE IF NOT EXISTS `referer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site` int(11) NOT NULL,
  `bot` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ua` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `refer` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `host` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `uri` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `site` (`site`,`ip`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
	lz::h('db')->install($sql);
}
?>
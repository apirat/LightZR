<?php
$module=array();
$module['category']=array('general'=>'ระบบทั่วไป');
$module['name']='คลิกลิ้งค์สินค้า';
$module['url']='click';
$module['author']='Positron';
$module['version']=0.1;
$module['detail']='รายงานคลิกลิ้งค์สินค้าไปยังเว็บอเมซอน';
$module['compatible']=1.0;
$module['type']='module';  //  enum('system','module')
$module['multi']='no';  //  enum('yes','no') / can create new service / type='module' only
$module['admin']='yes';   //  enum('yes','no')
$module['www']='no';   //  enum('yes','no','first')
$module['core']='no';   //  enum('yes','no')  / options news for config the services


function click_database()
{
	$sql="CREATE TABLE IF NOT EXISTS `click` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asin` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `ua` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ip` (`ip`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
	lz::h('db')->install($sql);
}
?>
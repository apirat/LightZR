<?php
$module=array();
$module['category']=array('general'=>'ระบบทั่วไป');
$module['name']='คีย์เวิร์ดที่มีการค้นหา';
$module['url']='searched';
$module['author']='Positron';
$module['version']=0.1;
$module['detail']='รายงานคำหรือคีย์เวิร์ดที่มีการค้นหา';
$module['compatible']=1.0;
$module['type']='module';  //  enum('system','module')
$module['multi']='no';  //  enum('yes','no') / can create new service / type='module' only
$module['admin']='yes';   //  enum('yes','no')
$module['www']='no';   //  enum('yes','no','first')
$module['core']='no';   //  enum('yes','no')  / options news for config the services

function searched_database()
{
	$sql="CREATE TABLE IF NOT EXISTS `searched` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `keyword` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `category` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `lastupdate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
	lz::h('db')->install($sql);
}
?>
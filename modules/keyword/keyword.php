<?php
$module=array();
$module['category']=array('general'=>'ระบบทั่วไป');
$module['name']='กรองคีย์เวิร์ด';
$module['url']='keyword';
$module['author']='Positron';
$module['version']=0.1;
$module['detail']='กรอกคีย์เวิร์ดแล้วเพิ่มข้อมูลเข้าระบบหมวดสินค้าโดยอัตโนมัติ';
$module['compatible']=1.0;
$module['type']='module';  //  enum('system','module')
$module['multi']='no';  //  enum('yes','no') / can create new service / type='module' only
$module['admin']='yes';   //  enum('yes','no')
$module['www']='no';   //  enum('yes','no','first')
$module['core']='no';   //  enum('yes','no')  / options news for config the services


function keyword_database()
{
	$sql="CREATE TABLE IF NOT EXISTS `keyword` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `word` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `category` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `amount` int(11) NOT NULL,
  `lastupdate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
	lz::h('db')->install($sql);
}
?>
<?php
$module=array();
$module['category']=array('general'=>'ระบบทั่วไป');
$module['name']='โพสสินค้าอัตโนมัติ';
$module['url']='autopost';
$module['author']='Positron';
$module['version']=0.1;
$module['detail']='ระบบดึงข้อมูลสินค้ามาโพสลงหมวดสินค้าอัตโนมัติ';
$module['compatible']=1.0;
$module['type']='module';  //  enum('system','module')
$module['multi']='no';  //  enum('yes','no') / can create new service / type='module' only
$module['admin']='yes';   //  enum('yes','no')
$module['www']='no';   //  enum('yes','no','first')
$module['core']='no';   //  enum('yes','no')  / options news for config the services

function autopost_database()
{
	$sql="CREATE TABLE IF NOT EXISTS `autopost` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` datetime NOT NULL,
  `status` int(1) NOT NULL,
  `rew1` int(1) NOT NULL,
  `rew2` int(1) NOT NULL,
  `ping` int(1) NOT NULL,
  `detail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `product` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `category` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
	lz::h('db')->install($sql);
}
?>
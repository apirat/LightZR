<?php
$module=array();
$module['category']=array('general'=>'ระบบทั่วไป');
$module['name']='แบนเนอร์';
$module['url']='banner';
$module['author']='Positron';
$module['version']=0.1;
$module['detail']='ระบบแบนเนอร์';
$module['compatible']=1.0;
$module['type']='module';  //  enum('system','module')
$module['multi']='no';  //  enum('yes','no') / can create new service / type='module' only
$module['admin']='yes';   //  enum('yes','no')
$module['www']='no';   //  enum('yes','no','first')
$module['core']='no';   //  enum('yes','no')  / options news for config the services



function banner_database()
{
	$sql="CREATE TABLE IF NOT EXISTS `banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `s` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `l` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `time` datetime NOT NULL,
  `link` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `click` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
	lz::h('db')->install($sql);
}
?>
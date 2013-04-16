<?php
$module=array();
$module['category']=array('system'=>'ระบบหลักของเว็บไซต์');
$module['name']='ปรับแต่งดีไซน์';
$module['url']='style';
$module['author']='Positron';
$module['version']=0.1;
$module['detail']='ระบบจัดการปรับแต่งดีไซน์';
$module['compatible']=1.0;
$module['type']='system';  //  enum('system','module')
$module['multi']='no';  //  enum('yes','no') / can create new service / type='module' only
$module['admin']='yes';   //  enum('yes','no')
$module['www']='no';   //  enum('yes','no')
$module['core']='no';   //  enum('yes','no')


function style_database()
{
	$sql="CREATE TABLE IF NOT EXISTS `style` (
  `theme` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `css` text COLLATE utf8_unicode_ci NOT NULL,
  `bg_color` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `bg_img` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `bg_fix` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `bg_align` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `bg_repeat` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `head_color` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `head_img` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `head_align` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `head_repeat` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `foot_color` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `foot_img` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `foot_align` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `foot_repeat` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `content_color` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `content_img` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `content_align` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `content_repeat` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `left_color` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `left_img` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `left_align` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `left_repeat` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `right_color` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `right_img` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `right_align` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `right_repeat` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `tab_color` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `tab_bg` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `tab_font` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `tab_hbg` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `tab_hfont` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `tab_border` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `tab_img` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `tab_align` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `tab_repeat` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `text_font` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `text_link` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `lbar_font` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `lbar_color` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `lbar_img` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lbar_align` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `lbar_repeat` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `flip` int(1) NOT NULL,
  UNIQUE KEY `site` (`theme`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
	lz::h('db')->install($sql);
}
?>
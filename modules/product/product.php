<?php
$module=array();
$module['category']=array('general'=>'ระบบทั่วไป');
$module['name']='ระบบสินค้า';
$module['url']='product';
$module['author']='Positron';
$module['version']=0.1;
$module['detail']='ระบบสินค้า';
$module['compatible']=1.0;
$module['type']='module';  //  enum('system','module')
$module['multi']='no';  //  enum('yes','no') / can create new service / type='module' only
$module['admin']='yes';   //  enum('yes','no')
$module['www']='first';   //  enum('yes','no','first')
$module['core']='yes';   //  enum('yes','no')  / options news for config the services


function product_database()
{
	$sql="CREATE TABLE IF NOT EXISTS `product` (
  `asin` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `category` int(11) NOT NULL,
  `avg` decimal(3,1) NOT NULL,
  `tavg` int(11) NOT NULL,
  `salesrank` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `editor` text COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `pricef` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `saleprice` int(11) NOT NULL,
  `salepricef` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `minvar` int(11) NOT NULL,
  `minvarf` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `maxvar` int(11) NOT NULL,
  `maxvarf` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `bestoffer` text COLLATE utf8_unicode_ci NOT NULL,
  `offer` text COLLATE utf8_unicode_ci NOT NULL,
  `minprice` int(11) NOT NULL,
  `minpricef` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `maxprice` int(11) NOT NULL,
  `maxpricef` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `seller` int(11) NOT NULL,
  `pgroup` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `binding` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `brand` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `color` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `feature` text COLLATE utf8_unicode_ci NOT NULL,
  `manu` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `s` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `s2` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `m` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `m2` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `l` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `l2` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `added` datetime NOT NULL,
  `lastupdate` datetime NOT NULL,
  `pingo` datetime NOT NULL,
  `lastbot` datetime NOT NULL,
  `lastreview` datetime NOT NULL,
  `lastrewrite` datetime NOT NULL,
  `lasttwitter` datetime NOT NULL,
  `view` int(11) NOT NULL,
  UNIQUE KEY `asin` (`asin`,`category`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
	lz::h('db')->install($sql);
	
	
	$sql="CREATE TABLE IF NOT EXISTS `product_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `menu` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `link` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `theme` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `autodb` int(1) NOT NULL,
  `thumbnail` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `parent` int(11) NOT NULL,
  `code` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `searchindex` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `keywords` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `added` datetime NOT NULL,
  `lastsearch` datetime NOT NULL,
  `autosearch` int(1) NOT NULL,
  `pgroup` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `cmode` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ads120` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ads468` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `video` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dorder` int(5) NOT NULL,
  `intitle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `outtitle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `onlymanu` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `onlygroup` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `getmax` int(10) NOT NULL,
  `spage` int(11) NOT NULL,
  `scur` int(11) NOT NULL,
  `maxpage` int(3) NOT NULL,
  `asinpost` text COLLATE utf8_unicode_ci NOT NULL,
  `autopost` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `backlink` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `countbl` int(11) NOT NULL,
  `inalltitle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `rsort` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `node` bigint(20) NOT NULL,
  `rate` decimal(3,1) NOT NULL,
  `pingo` datetime NOT NULL,
  `site` int(11) NOT NULL,
  `lastblog` datetime NOT NULL,
  `lastasin` datetime NOT NULL,
  `twitter` datetime NOT NULL,
  `referer` int(11) NOT NULL,
  `domain` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mtitle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mdescription` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mkeywords` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `meta` text COLLATE utf8_unicode_ci NOT NULL,
  `footer` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `awstag` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
	lz::h('db')->install($sql);
	
	$sql="CREATE TABLE IF NOT EXISTS `review` (
  `asin` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `customerid` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `rating` int(1) NOT NULL,
  `date` date NOT NULL,
  `summary` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `dorder` int(3) NOT NULL,
  `category` int(11) NOT NULL,
  `site` int(11) NOT NULL,
  UNIQUE KEY `asin` (`asin`,`customerid`,`date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
	lz::h('db')->install($sql);
}
?>
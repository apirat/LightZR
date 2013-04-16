<?php

if(!defined('NOCONTENT'))
{
	$template=lz::h('template');
	$template->assign('brand',lz::h('db')->GetAll("select p.brand,count(p.asin) as amount from product as p where p.brand!=? and p.category=? group by p.brand order by rand()",array('',lz::$s['id'])));
}
$template->display('layout.brand');

?>
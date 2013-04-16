<?php

if(!defined('NOCONTENT'))
{
	$template=lz::h('template');
	$template->assign('color',lz::h('db')->GetAll("select p.color,count(p.asin) as amount from product as p where p.color!=? and p.category=? group by p.color order by rand()",array('',lz::$s['id'])));
}
$template->display('layout.color');

?>
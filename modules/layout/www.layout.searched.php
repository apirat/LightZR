<?php
if(!defined('NOCONTENT'))
{
	$db=lz::h('db');
	$template=lz::h('template');
	$cf=unserialize($box['option']);
	if($cf['amount']<1)$cf['amount']=5;
	if($cf['count']<1)$cf['count']=5;
	$searched=$db->GetAll("select * from searched where amount>=? and category=? order by amount desc limit 0,".$cf['count'],array($cf['amount'],lz::$s['id']));

	
	$template->assign('searched',$searched);
}
$template->display('layout.searched');
?>
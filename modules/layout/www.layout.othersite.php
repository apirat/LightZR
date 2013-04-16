<?php


$db=lz::h('db');
	
if(defined('NOCONTENT'))
{
	$site=$db->GetAll('select title,link,pgroup from product_category where pgroup!=? order by pgroup asc,title asc limit 0,5',array(''));
}
else
{
	$site=$db->GetAll('select title,link,pgroup from product_category where pgroup!=?  and id>? order by id asc limit 0,5',array('', lz::$s['id']));
	if(!is_array($site))$site=array();
	if(count($site)<5)
	{
		$site2=$db->GetAll('select title,link,pgroup from product_category where pgroup!=?  and id!=? order by id asc limit 0,'.(5-count($site)),array('',lz::$s['id']));
		if(is_array($site2))$site=array_merge($site,$site2);
	}
}

$template=lz::h('template');
$template->assign('site',$site);
$template->display('layout.othersite');
?>
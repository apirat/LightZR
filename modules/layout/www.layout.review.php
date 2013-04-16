<?php
if(!defined('NOCONTENT'))
{
	$template=lz::h('template');
	$cf=unserialize($box['option']);
	if($cf['count']<1)$cf['count']=10;
	$template->assign('review',lz::h('db')->GetAll("select r.*,p.link,p.title from review as r left join product as p on r.asin=p.asin where r.rating>=? and p.category=? group by r.asin order by rand() desc limit 0,".$cf['count'],array(4,lz::$s['id'])));
}
$template->display('layout.review');
?>
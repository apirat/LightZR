<?php
$db=lz::h('db');
$template=lz::h('template');
$cf=unserialize($box['option']);
if(!defined('NOCONTENT'))
{
	if(intval(trim($cf['default']))>0)
	{
		$tmp=$db->GetAll("select p.title from product as p  where p.category=? order by rand() limit 0,100",array(lz::$s['id']));
		$t='';
		for($i=0;$i<count($tmp);$i++)
		{
			$t.=' '.$tmp[$i]['title'];
		}
		if($t)
		{
			$tags=checktag($t);
			if(count($tags))
			{
				shuffle($tags);
				$tags=array_slice($tags,0,intval(trim($cf['default'])));
				$template->assign('tags',$tags);
			}
		}
	}
}
$template->display('layout.tags');


function checktag($tag)
{
	$tags=array();
	$tag=preg_replace('/[^a-zA-Z0-9]/', ' ', $tag);
	$tmp=explode(' ',strip_tags($tag));
	$tmp=array_values(array_unique(array_filter($tmp)));
	for($i=0;$i<count($tmp);$i++)
	{
		$j=mb_strlen($tmp[$i],'utf-8');
		if($j>=4&&$j<=20)$tags[]=trim($tmp[$i]);
	}
	$tag=array_values(array_unique(array_filter(array_map('splitword',$tags))));
	return empty($tag)?array():$tag;	
}
 function splitword($tmp)
{
	return preg_match("/^([a-zA-Z]+)([a-zA-Z0-9]*)$/iU",$tmp)?$tmp:false;
}
?>
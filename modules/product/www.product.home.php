<?php
$template=lz::h('template');
$db=lz::h('db');
$by=(in_array(lz::$c['by'],array('desc','asc'))?lz::$c['by']:'desc');
$order=(in_array(lz::$c['order'],array('avg','title','price','saleprice','added','lastupdate'))?lz::$c['order']:'avg');

$where=array();
$val=array();
$ptitle='';

if(lz::$c['sub']==2)
{
	$start=0;	
	$ipage=lz::$f[0];
}
else
{
	$start=1;
	$ipage=lz::$f[1];
}
if(preg_match('/page\-([0-9]+)$/',lz::$f[$start],$p))
{
	$page=$p[1];
	lz::$f[$start]=preg_replace('/(\-)?page\-([0-9]+)$/','',lz::$f[$start]);
	$ipage=lz::$f[$start];
	lz::$fu[$start]=preg_replace('/(\-)?page\-([0-9]+)$/','',lz::$fu[$start]);
}
if(preg_match('/price\-(.+)$/',lz::$f[$start],$p))
{
	$ep=explode('-',$p[1]);
	$template->assign('price','$'.$ep[0].' - $'.$ep[1]);
	lz::$f[$start]=preg_replace('/(\-)?price\-(.+)$/','',lz::$f[$start]);
	lz::$fu[$start]=preg_replace('/(\-)?price\-(.+)$/','',lz::$fu[$start]);
	array_push($where,'(p.saleprice>=? and p.saleprice<=?)');
	array_push($val,$ep[0]*100,$ep[1]*100);
	$ptitle='Price $'.$ep[0].' - $'.$ep[1];
}
if(preg_match('/color\-(.+)$/',lz::$f[$start],$p))
{
	$template->assign('color',$p[1]);
	lz::$f[$start]=preg_replace('/(\-)?color\-(.+)$/','',lz::$f[$start]);
	lz::$fu[$start]=preg_replace('/(\-)?color\-(.+)$/','',lz::$fu[$start]);
	array_push($where,'p.color=?');
	array_push($val,$p[1]);
	$ptitle='Color '.$p[1];
}
if(preg_match('/brand\-(.+)$/',lz::$f[$start],$p))
{
	$template->assign('brand',$p[1]);
	lz::$f[$start]=preg_replace('/(\-)?brand\-(.+)$/','',lz::$f[$start]);
	lz::$fu[$start]=preg_replace('/(\-)?brand\-(.+)$/','',lz::$fu[$start]);
	array_push($where,'p.brand=?');
	array_push($val,$p[1]);
	$ptitle='Brand '.$p[1];
}

$searched='';
if(preg_match('/search\-(.+)$/',lz::$fu[$start],$p))
{
	$template->assign('search',$p[1]);
	$searched=$p[1];
	$s='%'.str_replace(' ','%',$p[1]).'%';
	lz::$f[$start]=preg_replace('/(\-)?search\-(.+)$/','',lz::$f[$start]);
	array_push($where,'(p.title like ? or p.editor like ?)');
	array_push($val,$s,$s);
	$ptitle='Search '.$p[1];
}
$tag='';
if(preg_match('/tag\-(.+)$/',lz::$fu[$start],$p))
{
	$template->assign('tag',$p[1]);
	$s='%'.str_replace(' ','%',$p[1]).'%';
	lz::$f[$start]=preg_replace('/(\-)?tag\-(.+)$/','',lz::$f[$start]);
	array_push($where,'(p.title like ? or p.editor like ?)');
	array_push($val,$s,$s);
	$ptitle='Tag '.$p[1];
}
	
if(lz::$c['sub']==2)
{
	if(!lz::$s=$db->GetRow('select * from product_category where link=?',array(SUB)))
	{
		lz::move('http://www.'.lz::$cf['domain'].QUERY,true);
	}
	if(lz::$f[$start])
	{
		lz::move(QUERY,true);
	}
}
else
{
	if(!lz::$f[0])
	{
		lz::move(QUERY,true);
	}
	if(!lz::$s=$db->GetRow('select * from product_category where link=?',array(lz::$f[0])))
	{
		lz::move(QUERY,true);
	}
}

if(lz::$s['domain']&&!defined('MAPPING'))	
{
		lz::move('http://www.'.lz::$s['domain'].QUERY,true);
}

array_push($where,'p.category=?');
array_push($val,lz::$s['id']);

$ipage=trim($ipage,'-');
if(lz::$c['sub']!=2)
{
	$gpage=QUERY.lz::$s['link'].($ipage?'/'.$ipage:'');
}
else
{
	$gpage=$ipage;
}
lz::$s['ptitle']=$ptitle;
$product=lz::h('product');
$product->set(array('where'=>$where?' where '.join(' and ',$where):'','val'=>$val,'orderby'=>"order by to_days(p.lastupdate) desc,p.".$order." ".$by.",p.tavg desc",'url'=>$gpage,'iurl'=>$ipage,'page'=>$page));

define('IMAGES',HTTP.'themes/'.lz::$c['theme'].'/images/');

$template->assign('category',array('title'=>lz::$s['title'],'link'=>(lz::$c['sub']==2||lz::$s['domain'])?QUERY:QUERY.lz::$s['link'].'/'));
www::$content=$template->fetch('product.home');

if($count=$product->count)
{
	if($searched)
	{
		if($se=$db->GetRow('select id,category,keyword,lastupdate from searched where keyword=? and category=?',array($searched,lz::$s['id'])))
		{
			if(time()-strtotime($se['lastupdate'])>3600)
			{
				$db->Execute('update searched set category=?,amount=amount+1,lastupdate=now() where id=?',array(lz::$s['id'],$se['id']));
			}
		}
		else
		{
			$db->Execute('insert searched set category=?,keyword=?,amount=?,lastupdate=now()',array(lz::$s['id'],$searched,1));
		}
	}
}
?>
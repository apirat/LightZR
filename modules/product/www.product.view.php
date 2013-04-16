<?php

$db=lz::h('db');
if(!$product=$db->GetRow("select p.* from product as p where p.asin=?",array(substr($param[0],1))))
{
	lz::move(QUERY,true);
}
if(strstr($_SERVER['HTTP_USER_AGENT'],'Googlebot'))
{
	if(lz::$c['antiindex']==2&&$product['lastbot']=='0000-00-00 00:00:00')
	{
		lz::move(QUERY,false);
	}

	$db->Execute('update product set lastbot=now() where asin=?',array($product['asin']));
}


if(isset(lz::$s))
{
	
}
elseif(lz::$c['sub']==2)
{
	if(!lz::$s=$db->GetRow('select * from product_category where link=?',array(SUB)))
	{
		lz::move('http://www.'.lz::$cf['domain'].QUERY,true);
	}	
}
elseif(lz::$c['sub']==1||defined('IN_FIRST_FOLDER'))
{
	if(!lz::$s=$db->GetRow('select * from product_category where id=?',array($product['category'])))
	{
		lz::move(QUERY,true);
	}
	if(defined('IN_FIRST_FOLDER')&&lz::$c['sub']!=1)
	{
		lz::move(QUERY.lz::$s['link'].'/'.$product['link'].'/'.lz::$c['pinfo'],true);
	}
}
else
{
	if(!lz::$s=$db->GetRow('select * from product_category where link=?',array(lz::$f[0])))
	{
		lz::move(QUERY,true);
	}
}

if(lz::$s['domain']&&!defined('MAPPING'))	
{
		lz::move('http://www.'.lz::$s['domain'].QUERY.$product['link'].(lz::$c['pinfo']?'/'.lz::$c['pinfo']:''),true);
}

if(lz::$s['theme'])lz::$c['theme']=lz::$s['theme'];

$review=$db->GetAll('select * from review where asin=? order by dorder',array($product['asin']));

$offer=unserialize($product['offer']);
$max=999999999;
for($i=0;$i<count($offer);$i++)
{
	if($offer[$i]['saleprice']<$max)$max=$offer[$i]['saleprice'];
	if(!$offer[$i]['salepricef'])$offer[$i]['salepricef']='$'.number_format(intval($offer[$i]['saleprice'])/100);
	if(!$offer[$i]['pricef'])$offer[$i]['pricef']='$'.number_format(intval($offer[$i]['price'])/100);
}

define('IMAGES',HTTP.'themes/'.lz::$c['theme'].'/images/');
$product['s']=($product['s2']?HTTP.'files/photo/'.$product['category'].'/s/'.$product['s2']:$product['s']);
$product['m']=($product['m2']?HTTP.'files/photo/'.$product['category'].'/m/'.$product['m2']:$product['m']);
$product['l']=($product['l2']?HTTP.'files/photo/'.$product['category'].'/l/'.$product['l2']:$product['l']);

if($product['content']=trim($product['content']))
{
	$product['content']=nl2br($product['content']);
	$product['feature']='';
}
else
{
	$product['content']=nl2br(trim($product['editor']));
}


if(lz::$c['sub']==2||lz::$c['sub']==1||lz::$s['domain'])
{
	$product['url']=QUERY.$product['link'].'/';
}
else
{
	$product['url']=QUERY.lz::$s['link'].'/'.$product['link'].'/';
}
$title=htmlspecialchars($product['title']);
$product['a']=array(
							'title'=>'title="'.$title.'"',
							'url'=>array(
											'info'=>$product['url'].lz::$c['pinfo'],
											'compare'=>$product['url'].lz::$c['pcompare'],
											'store'=>$product['url'].lz::$c['pstore'],
											'review'=>$product['url'].lz::$c['preview'],
							),
							'rel'=>($product['lastbot']=='0000-00-00 00:00:00'&&lz::$c['antiindex']?'rel="nofollow"':'')
						);
$product['a']['href']=array(
									'info'=>'href="'.$product['a']['url']['info'].'"',
									'compare'=>'href="'.$product['a']['url']['compare'].'"',
									'store'=>'href="'.$product['a']['url']['store'].'"',
									'review'=>'href="'.$product['a']['url']['review'].'"',
									);
$product['img']=array(
							's'=>($product['s']?$product['s']:IMAGES.'noimg.s.gif'),
							'm'=>($product['m']?$product['m']:IMAGES.'noimg.m.gif'),
							'l'=>($product['l']?$product['l']:IMAGES.'noimg.m.gif'),
							'title'=>$product['a']['title'],
							'alt'=>'alt="'.$title.'"',
						);

$product['img']['src']=array(
												's'=>'src="'.$product['img']['s'].'"',
												'm'=>'src="'.$product['img']['m'].'"',
												'l'=>'src="'.$product['img']['l'].'"',
											);


lz::h('product')->set(array('type'=>'relate','where'=>'','val'=>array($product['asin'],lz::$s['id'])));

$template=lz::h('template');
$template->assign(array('lowprice'=>$max,'product'=>$product,'review'=>$review,'bestvalue'=>$max,'offer'=>$offer));

$template->assign('category',array('title'=>lz::$s['title'],'link'=>(lz::$c['sub']==2||lz::$s['domain'])?QUERY:QUERY.lz::$s['link'].'/'));

www::$content=$template->fetch('product.view');
lz::$s['ptitle']=$product['title'];
?>
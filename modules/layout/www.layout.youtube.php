<?php
//Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2.13) Gecko/20101203 Firefox/3.6.13 GTB7.1 ( .NET CLR 3.5.30729)
$template=lz::h('template');
$cf=unserialize($box['option']);
if($cf['amount']<1)$cf['amount']=1;
if($cf['width']<160)$cf['width']=300;
if($cf['height']<100)$cf['height']=230;
if(!defined('NOCONTENT'))
{
	$youtube=array();
	if(trim(lz::$s['video']))
	{
		$youtube=unserialize(lz::$s['video']);
	}
	if(!count($youtube))
	{
		$req=@file_get_contents('http://gdata.youtube.com/feeds/videos?vq='.urlencode(lz::$s['title']).'&start-index=1&max-results=50&orderby=updated',null,stream_context_create(array('http'=>array('ignore_errors'=>true,'method'=>"GET",'header'=>"User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2.13) Gecko/20101203 Firefox/3.6.13 GTB7.1 ( .NET CLR 3.5.30729)\r\n"))));
		//$req = @file_get_contents("http://gdata.youtube.com/feeds/videos?vq=".urlencode(lz::$s['title'])."&start-index=1&max-results=50&orderby=updated");
		$video=lz::h('xml')->process($req);
		
		if(is_array($video['entry']))
		{
			foreach($video['entry'] as $k => $v)
			{
				$id_raw = explode('/',$video['entry'][$k]['id']);
				$y=array();
				$y['id']=array_pop($id_raw);
				$y['title']=$video['entry'][$k]['title'];
				$youtube[]=$y;
			  }
			  shuffle($youtube);
			  $youtube=array_splice($youtube,0,$cf['amount']);
			  lz::h('db')->execute('update product_category set video=? where id=?',array(serialize($youtube),lz::$s['id']));
		}
	}
	$template->assign('cf',$cf);
	$template->assign('youtube',$youtube);
}
elseif(trim($cf['default']))
{
	$youtube=array();
	$_=explode(',',$cf['default']);
	for($i=0;$i<count($_);$i++)
	{
		list($a,$b)=explode('@',$_[$i],2);
		$youtube[]=array('id'=>$a,'title'=>strval($b));
	}
	$template->assign('cf',$cf);
	$template->assign('youtube',$youtube);
}
$template->display('layout.youtube');
?>
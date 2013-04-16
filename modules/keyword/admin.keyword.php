<?php
//define('SETVIEW',true);

lz::h('time');
$setview=lz::h('setview');
$setview->set('admin.keyword','getkeyword');
$setview->ajax();

$db=lz::h('db');
$searchnext=0;
if($_SERVER['QUERY_STRING']=='searching')
{
	if($key=$db->getall('select * from keyword where lastupdate=? order by id asc limit 0,6',array('0000-00-00 00:00:00')))
	{
		$db->close();
		for($i=0;$i<min(count($key),5);$i++)
		{
			list($index,$amount)=getinfo($key[$i]['word']);
			$db->execute('update keyword set category=?,amount=?,lastupdate=now() where id=?',array(strval($index),intval($amount),$key[$i]['id']));
			$db->close();
			sleep(1);
		}
		if(count($key)==6)
		{
			$searchnext=1;
		}
		else
		{
			$searchnext=2;
		}
	}
}
if($_GET['type']=='csv')
{
	$limit=intval($_GET['limit']);
	$amount=intval($_GET['amount']);
	$link=strval($_GET['link']);
	$order=strval($_GET['order']);
	header("Content-Type:text/plain");
	if($key=$db->getall('select * from keyword where amount>=?',array($amount)))
	{
		for($i=0;$i<count($key);$i++)
		{
			echo $key[$i]['word'].','.str_replace(' ',$link,strtolower($key[$i]['word'])).','.convertindex($key[$i]['category'],true).','.$key[$i]['category'].','.$key[$i]['word'].','.$limit.','.$order."\r\n";
		}
	}
	exit;
}
$ajax=lz::h('ajax');
$ajax->register('newkeyword',dirname(__FILE__).'/admin.keyword.ajax.php','getkeyword');
$ajax->register('del',dirname(__FILE__).'/admin.keyword.ajax.php','getkeyword');
$ajax->register('bclear',dirname(__FILE__).'/admin.keyword.ajax.php','getkeyword');
$ajax->process();
$template=lz::h('template');
$template->assign('navigator','<li><a href="javascript:;" onclick="lz.box.open(\'#newkeyword\')"><img src="'.IMAGES_A.'add.gif" alt="new" align="absmiddle" /> เพิ่มคีย์เวิร์ดใหม่</a></li>');
$template->assign('getkeyword',getkeyword());
$template->assign('searchnext',$searchnext);
admin::$content=$template->fetch('keyword');
function getkeyword()
{
	$view=array('id'=>'#','word'=>'คีย์เวิร์ด','category'=>'หมวด','amount'=>'จำนวนสินค้าภายในหมวด','lastupdate'=>'ค้นหาเมื่อ');
	$default=array('id','word','category','amount','lastupdate');
	list($allorder,$rows)=lz::h('setview')->get($view,$default);
	$db=lz::h('db');
	$allby=array('desc'=>'หลังไปหน้า','asc'=>'หน้าไปหลัง');
	$all=array('order','by','search','page','cate');
	$split=lz::h('split');
	extract($split->get(PATHMIN.SERVICE_LINK.'/',0,$all,$allorder,$allby));
	$where=array();
	$val=array();
	$where=$where?' where '.join(' and ',$where):'';
	if($count=$db->GetOne("select count(k.id) from keyword as k ".$where,$val))
	{
		$pager=lz::h('pager');
		list($pg,$limit)=$pager->page($rows,$count,$url,'page-',$page);
		$keyword=$db->GetAll("select k.* from keyword as k ".$where." order by ".$order." ".$by." ".$limit,$val);
	}
	lz::h('time');
	$template=lz::h('template');
	$template->assign('html',lz::h('html'));
	$template->assign(array('keyword'=>$keyword,'view'=>$view,'rows'=>$rows,'pager'=>$pg,'count'=>$count,'allby'=>$allby,'allorder'=>$allorder,'count'=>$count));
	for($i=0;$i<count($all);$i++)if(${$all[$i]}) $template->assign($all[$i],${$all[$i]});
	return $template->fetch('keyword.list');
}

function getinfo($keyword)
{
	if($keyword)
	{
		//$art=@file_get_contents('http://www.amazon.'.lz::$c['zone'].'/s/ref=nb_sb_noss?url=search-alias%3Daps&field-keywords='.urlencode($keyword).'&x=0&y=0',null,stream_context_create(array('http'=>array('ignore_errors'=>true,'method'=>"GET",'header'=>"User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2.13) Gecko/20101203 Firefox/3.6.13 GTB7.1 ( .NET CLR 3.5.30729)\r\nReferer: http://www.amazon.com/\r\n"))));
		$art=@file_get_contents('http://www.amazon.'.lz::$c['zone'].'/s/ref=nb_sb_noss?url=search-alias%3Daps&field-keywords='.urlencode($keyword).'&x=0&y=0',null,stream_context_create(array('http'=>array('ignore_errors'=>true,'method'=>"GET",
		'header'=>"Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8
Accept-Charset:UTF-8,*;q=0.5
Accept-Language:en-US,en;q=0.8
Cache-Control:max-age=0
Connection:keep-alive
Host:www.amazon.com
User-Agent:Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_2) AppleWebKit/535.1 (KHTML, like Gecko) Chrome/14.0.835.202 Safari/535.1
Referer: http://www.amazon.com/
"))));


		require_once(HANDLERS.'simple_html_dom.php');
		
		
		
		$find='<div id="rightContainerATF">';
		$i=strpos($art,$find);
		if($i>1)$art=substr($art,$i);
		$find='<div id="centerBelowStatic">';
		$i=strpos($art,$find);
		if($i>1)$art=substr($art,0,$i);
		
		$html=str_get_html($art);
		$c=$html->find('div.store');
		$cate=array('index'=>'','amount'=>0);
		foreach($c as $v)
		{
			$index=substr($v->find('span',0)->innertext,0,-1);
			$amount=intval(preg_replace('/[^\d]/','',$v->find('a',0)->innertext));
			//echo $index.'---'.$v->find('a',0)->innertext.'--<br>';
			if($amount>$cate['amount'])
			{
				$cate=array('index'=>$index,'amount'=>$amount);
			}
		}
		return array(convertindex($cate['index']),$cate['amount']);
	}
}

function convertindex($name,$c=false)
{
	$cate=array('All'=>'Other',
'Apparel'=>'Apparel',
'Automotive'=>'Automotive',
'Baby'=>'Baby',
'Beauty'=>'Beauty',
'Blended'=>'Blended',
'Books'=>'Books',
'Classical'=>'Classical',
'DVD'=>'DVD',
'DigitalMusic'=>'Digital Music',
'Electronics'=>'Electronics',
'GourmetFood'=>'Gourmet Food',
'Grocery'=>'Grocery',
'HealthPersonalCare'=>'Health Personal Care',
'HomeGarden'=>'Home & Garden',
'Industrial'=>'Industrial',
'Jewelry'=>'Jewelry',
'KindleStore'=>'Kindle Store',
'Kitchen'=>'Kitchen',
'MP3Downloads'=>'MP3 Downloads',
'Magazines'=>'Magazines',
'Merchants'=>'Merchants',
'Miscellaneous'=>'Miscellaneous',
'Music'=>'Music',
'MusicTracks'=>'Music Tracks',
'MusicalInstruments'=>'Musical Instruments',
'OfficeProducts'=>'Office Products',
'OutdoorLiving'=>'Outdoor Living',
'PCHardware'=>'PC Hardware',
'PetSupplies'=>'Pet Supplies',
'Photo'=>'Photo',
'Shoes'=>'Shoes',
'SilverMerchants'=>'Silver Merchants',
'Software'=>'Software',
'SportingGoods'=>'Sporting Goods',
'Tools'=>'Tools',
'Toys'=>'Toys',
'UnboxVideo'=>'Unbox Video',
'VHS'=>'VHS',
'Video'=>'Video',
'VideoGames'=>'Video Games',
'Watches'=>'Watches',
'Wireless'=>'Wireless',
'WirelessAccessories'=>'Wireless Accessories');
	if($c)
	{
		return isset($cate[$name])?$cate[$name]:'Other';
	}
	else
	{
		switch(strtolower($name))
		{
			case 'tools & home improvement':return 'Tools';
			case 'sports & outdoors':return 'SportingGoods';
			case 'appliances':return 'HomeGarden';
			case 'home & kitchen':return 'Kitchen';
			case 'grocery & gourmet food':return 'Grocery';
			case 'video games':return 'VideoGames';
			case 'movies & tv':return 'Video';
			case 'toys & games':return 'Toys';
			default:
				$k=str_replace(array('&',' '),array('',''),$name);
				if(array_key_exists($k,$cate))
				{
					return $k;
				}
				else
				{
					return $name.' - OTHER';
				}
			//public $searchindex=
			
			
			// , Pet Supplies, Photo, Shoes, Silver Merchants, Software, Sporting Goods, Tools, Toys, Unbox Video, VHS, Video, Video Games, Watches, Wireless, Wireless Accessories
			//public $reviewsort=array('SubmissionDate'=>'ใหม่ไปเก่า','-SubmissionDate'=>'เก่าไปใหม่','Rank'=>'Rankมากสุด','-Rank'=>'Rankน้อยสุด');
		
		}
	}
}
?>
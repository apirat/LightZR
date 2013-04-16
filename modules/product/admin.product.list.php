<?php
//define('SETVIEW',true);
$db=lz::h('db');
$ajax=lz::h('ajax');
$ajax->register('setlist',dirname(__FILE__).'/admin.product.list.ajax.php','getproduct');
$ajax->register('del',dirname(__FILE__).'/admin.product.list.ajax.php','getproduct');
$ajax->register('update',dirname(__FILE__).'/admin.product.list.ajax.php');
$ajax->register('newproduct',dirname(__FILE__).'/admin.product.list.ajax.php');
$ajax->register('reload',dirname(__FILE__).'/admin.product.list.ajax.php','getproduct');
$ajax->register('editcontent',dirname(__FILE__).'/admin.product.list.ajax.php');
$ajax->register('delcontent',dirname(__FILE__).'/admin.product.list.ajax.php');
$ajax->register('savecontent',dirname(__FILE__).'/admin.product.list.ajax.php');
$ajax->process();
$template=lz::h('template');
$template->assign('navigator','<li><a href="'.PATHMIN.SERVICE_LINK.'">&larr; หมวดสินค้าทั้งหมด</a></li><li><a href="javascript:;" onclick="lz.box.open(\'#newproduct\')"><img src="'.HTTP.'static/images/add.gif" alt="new" align="absmiddle" /> เพิ่มสินค้าใหม่</a></li><li><a href="'.PATHMIN.SERVICE_LINK.'/setting/'.lz::$f[1].'">ตั้งค่าการค้นหาสินค้า</a></li><li><a href="'.PATHMIN.SERVICE_LINK.'/'.lz::$f[1].'">ค้นหาสินค้า</a></li><li><a href="'.PATHMIN.SERVICE_LINK.'/'.lz::$f[1].'/auto/1">ค้นหาและเพิ่มสินค้าอัตโนมัติ</a></li>');

$template->assign('getproduct',getproduct());
admin::$content=$template->fetch('product.list');
function getproduct()
{
	$view=array('s'=>'รูปภาพ','asin'=>'ASIN','title'=>'ชื่อสินค้า','detail'=>'รายละเอียดสินค้า','price'=>'ราคา','saleprice'=>'ราคาพิเศษ','view'=>'ผู้ชม','added'=>'เพิ่มเมื่อ','content'=>'เนื้อหาใหม่','lastupdate'=>'ข้อมูลล่าสุดเมื่อ');
	$default=array('s','asin','title','price','saleprice','content','lastupdate');
	$db=lz::h('db');
	$tmp=lz::get('product');
	if(!$tmp||!count($tmp['column']))$tmp=array('column'=>$default,'rows'=>20,'thumbnail'=>array(150,225));;
	$allorder=array();
	for($i=0;$i<count($tmp['column']);$i++)if(array_key_exists($tmp['column'][$i],$view))$allorder[$tmp['column'][$i]]=$view[$tmp['column'][$i]];
	$allby=array('desc'=>'หลังไปหน้า','asc'=>'หน้าไปหลัง');
	$all=array('order','by','search','page','cate');
	$split=lz::h('split');
	extract($split->get(PATHMIN.SERVICE_LINK.'/list/'.lz::$f[1].'/',2,$all,$allorder,$allby));
	$where=array('p.category=?');
	$val=array(lz::$f[1]);
	if($tmp['rows']<1)$tmp['rows']=1;
	if($search)
	{
		array_push($where,'(p.title like ?)');
		array_push($val,'%'.$search.'%');
	}
	$where=$where?' where '.join(' and ',$where):'';
	if($count=$db->GetOne("select count(p.asin) from product as p ".$where,$val))
	{
		$pager=lz::h('pager');
		list($pg,$limit)=$pager->page($tmp['rows'],$count,$url,'page-',$page);
		$product=$db->GetAll("select p.* from product as p ".$where." group by p.asin order by ".$order." ".$by." ".$limit,$val);
	}
	lz::h('time');
	$template=lz::h('template');
	$template->assign('html',lz::h('html'));
	$template->assign('category',$db->GetRow('select title,link,domain from product_category where id=?',array(lz::$f[1])));
	$template->assign(array('product'=>$product,'view'=>$view,'rows'=>$tmp['rows'],'thumbnail'=>$tmp['thumbnail'],'pager'=>$pg,'count'=>$count,'allby'=>$allby,'allorder'=>$allorder,'count'=>$count));
	for($i=0;$i<count($all);$i++)if(${$all[$i]}) $template->assign($all[$i],${$all[$i]});
	return $template->fetch('product.list.list');
}
?>
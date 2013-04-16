<?php
//define('SETVIEW',true);
$db=lz::h('db');
$ajax=lz::h('ajax');
$ajax->register('newbanner',dirname(__FILE__).'/admin.banner.ajax.php','getbanner');
$ajax->register('update',dirname(__FILE__).'/admin.banner.ajax.php');
$ajax->register('del',dirname(__FILE__).'/admin.banner.ajax.php','getbanner');
$ajax->process();
$template=lz::h('template');
$template->assign('navigator','<li><a href="javascript:;" onclick="lz.box.open(\'#newbanner\')"><img src="'.HTTP.'static/images/add.gif" alt="new" align="absmiddle" /> เพิ่มแบนเนอร์ใหม่</a></li>');
$template->assign('getbanner',getbanner());
admin::$content=$template->fetch('banner.home');
function getbanner()
{
	$view=array('id'=>'#','s'=>'รูปภาพ','title'=>'หัวข้อแบนเนอร์','link'=>'URL ปลายทาง','time'=>'สร้างเมื่อ');
	$default=array('id','s','title','link','time');
	$db=lz::h('db');
	if(!$tmp||!count($tmp['column']))$tmp=array('column'=>$default,'rows'=>20,'thumbnail'=>array(150,225));;
	$allorder=array();
	for($i=0;$i<count($tmp['column']);$i++)if(array_key_exists($tmp['column'][$i],$view))$allorder[$tmp['column'][$i]]=$view[$tmp['column'][$i]];
	$allby=array('desc'=>'หลังไปหน้า','asc'=>'หน้าไปหลัง');
	$all=array('order','by','search','page','cate');
	$split=lz::h('split');
	extract($split->get(PATHMIN.SERVICE_LINK.'/',0,$all,$allorder,$allby));
	$where=array();
	$val=array();
	if($tmp['rows']<1)$tmp['rows']=1;
	if($search)
	{
		array_push($where,'(title ? or link like ?)');
		array_push($val,'%'.$search.'%','%'.$search.'%');
	}
	$where=$where?' where '.join(' and ',$where):'';
	if($count=$db->GetOne("select count(id) from banner ".$where,$val))
	{
		$pager=lz::h('pager');
		list($pg,$limit)=$pager->page($tmp['rows'],$count,$url,'page-',$page);
		$banner=$db->GetAll("select * from banner ".$where." order by ".$order." ".$by." ".$limit,$val);
	}
	lz::h('time');
	$template=lz::h('template');
	$template->assign('html',lz::h('html'));
	$template->assign(array('banner'=>$banner,'view'=>$view,'rows'=>$tmp['rows'],'pager'=>$pg,'count'=>$count,'allby'=>$allby,'allorder'=>$allorder,'count'=>$count,'btime'=>$btime));
	for($i=0;$i<count($all);$i++)if(${$all[$i]}) $template->assign($all[$i],${$all[$i]});
	return $template->fetch('banner.home.list');
}
?>
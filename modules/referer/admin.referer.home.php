<?php
//define('SETVIEW',true);
$db=lz::h('db');
$ajax=lz::h('ajax');
$ajax->register('bclear',dirname(__FILE__).'/admin.referer.ajax.php','getreferer');
$ajax->process();
$template=lz::h('template');
//$template->assign('navigator','<li><a href="javascript:;" onclick="lz.box.open(\'#newreferer\')"><img src="'.HTTb.'images/admin/add.gif" alt="new" align="absmiddle" /> เพิ่มสินค้าใหม่</a></li>');
$template->assign('getreferer',getreferer());
admin::$content=$template->fetch('referer');
function getreferer()
{
	$view=array('time'=>'เวลา','refer'=>'Keyword','ip'=>'IP','host'=>'โดเมน','uri'=>'หน้าเว็บ');
	$default=array('time','refer','ip','host','uri');
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
		array_push($where,'(b.refer like ? or b.ip like ? or b.host like ? or b.uri like ?)');
		array_push($val,'%'.$search.'%','%'.$search.'%','%'.$search.'%','%'.$search.'%');
	}
	$where=$where?' where '.join(' and ',$where):'';
	if($count=$db->GetOne("select count(b.id) from referer as b ".$where,$val))
	{
		$pager=lz::h('pager');
		list($pg,$limit)=$pager->page($tmp['rows'],$count,$url,'page-',$page);
		$referer=$db->GetAll("select b.* from referer as b ".$where." order by ".$order." ".$by." ".$limit,$val);
	}
	$btime=$db->GetRow("select min(time) as tmin,max(time) as tmax from referer");
	lz::h('time');
	$template=lz::h('template');
	$template->assign('html',lz::h('html'));
	$template->assign(array('referer'=>$referer,'view'=>$view,'rows'=>$tmp['rows'],'pager'=>$pg,'count'=>$count,'allby'=>$allby,'allorder'=>$allorder,'count'=>$count,'btime'=>$btime));
	for($i=0;$i<count($all);$i++)if(${$all[$i]}) $template->assign($all[$i],${$all[$i]});
	return $template->fetch('referer.list');
}
?>
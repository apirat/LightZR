<?php
//define('SETVIEW',true);
$db=lz::h('db');
$ajax=lz::h('ajax');
$ajax->register('newlink',dirname(__FILE__).'/admin.link.ajax.php','getlink');
$ajax->register('update',dirname(__FILE__).'/admin.link.ajax.php');
$ajax->register('del',dirname(__FILE__).'/admin.link.ajax.php','getlink');
$ajax->process();
$template=lz::h('template');
$template->assign('navigator','<li><a href="javascript:;" onclick="lz.box.open(\'#newlink\')"><img src="'.HTTP.'static/images/add.gif" alt="new" align="absmiddle" /> เพิ่มลิงค์ใหม่</a></li>');
$template->assign('getlink',getlink());
admin::$content=$template->fetch('link');
function getlink()
{
	$view=array('id'=>'#','link'=>'Link','url'=>'URL ปลายทาง');
	$default=array('id','link','url');
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
		array_push($where,'(link ? or url like ?)');
		array_push($val,'%'.$search.'%','%'.$search.'%');
	}
	$where=$where?' where '.join(' and ',$where):'';
	if($count=$db->GetOne("select count(id) from link ".$where,$val))
	{
		$pager=lz::h('pager');
		list($pg,$limit)=$pager->page($tmp['rows'],$count,$url,'page-',$page);
		$link=$db->GetAll("select * from link ".$where." order by ".$order." ".$by." ".$limit,$val);
	}
	lz::h('time');
	$template=lz::h('template');
	$template->assign('html',lz::h('html'));
	$template->assign(array('link'=>$link,'view'=>$view,'rows'=>$tmp['rows'],'pager'=>$pg,'count'=>$count,'allby'=>$allby,'allorder'=>$allorder,'count'=>$count,'btime'=>$btime));
	for($i=0;$i<count($all);$i++)if(${$all[$i]}) $template->assign($all[$i],${$all[$i]});
	return $template->fetch('link.list');
}
?>
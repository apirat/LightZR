<?php
//define('SETVIEW',true);
$db=lz::h('db');
$ajax=lz::h('ajax');
$ajax->register('bclear',dirname(__FILE__).'/admin.bot.ajax.php','getbot');
$ajax->process();
$template=lz::h('template');
//$template->assign('navigator','<li><a href="javascript:;" onclick="lz.box.open(\'#newbot\')"><img src="'.HTTb.'images/admin/add.gif" alt="new" align="absmiddle" /> เพิ่มสินค้าใหม่</a></li>');
$template->assign('getbot',getbot());
admin::$content=$template->fetch('bot');
function getbot()
{
	$view=array('time'=>'เวลา','bot'=>'Bot','ip'=>'IP','host'=>'โดเมน','uri'=>'หน้าเว็บ');
	$default=array('time','bot','ip','host','uri');
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
		array_push($where,'(b.bot like ? or b.ip like ? or b.host like ? or b.uri like ?)');
		array_push($val,'%'.$search.'%','%'.$search.'%','%'.$search.'%','%'.$search.'%');
	}
	$where=$where?' where '.join(' and ',$where):'';
	if($count=$db->GetOne("select count(b.id) from bot as b ".$where,$val))
	{
		$pager=lz::h('pager');
		list($pg,$limit)=$pager->page($tmp['rows'],$count,$url,'page-',$page);
		$bot=$db->GetAll("select b.* from bot as b ".$where." order by ".$order." ".$by." ".$limit,$val);
	}
	$btime=$db->GetRow("select min(time) as tmin,max(time) as tmax from bot");
	lz::h('time');
	$template=lz::h('template');
	$template->assign('html',lz::h('html'));
	$template->assign(array('bot'=>$bot,'view'=>$view,'rows'=>$tmp['rows'],'pager'=>$pg,'count'=>$count,'allby'=>$allby,'allorder'=>$allorder,'count'=>$count,'btime'=>$btime));
	for($i=0;$i<count($all);$i++)if(${$all[$i]}) $template->assign($all[$i],${$all[$i]});
	return $template->fetch('bot.list');
}
?>
<?php
//define('SETVIEW',true);
$db=lz::h('db');
$ajax=lz::h('ajax');
$ajax->register('bclear',dirname(__FILE__).'/admin.click.ajax.php','getclick');
$ajax->process();
$template=lz::h('template');
//$template->assign('navigator','<li><a href="javascript:;" onclick="lz.box.open(\'#newclick\')"><img src="'.HTTb.'images/admin/add.gif" alt="new" align="absmiddle" /> เพิ่มสินค้าใหม่</a></li>');
$template->assign('getclick',getclick());
admin::$content=$template->fetch('click');
function getclick()
{
	$view=array('time'=>'เวลา','asin'=>'ASIN','title'=>'สินค้า','ip'=>'IP');
	$default=array('time','asin','title','ip');
	$db=lz::h('db');
	if(!$tmp||!count($tmp['column']))$tmp=array('column'=>$default,'rows'=>20,'thumbnail'=>array(150,225));
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
		array_push($where,'(b.asin like ? or b.ip like ? or p.title like ?)');
		array_push($val,'%'.$search.'%','%'.$search.'%','%'.$search.'%');
	}
	$where=$where?' where '.join(' and ',$where):'';
	if($count=$db->GetOne("select count(distinct b.ip) from click as b left join product as p on b.asin=p.asin ".$where,$val))
	{
		$pager=lz::h('pager');
		list($pg,$limit)=$pager->page($tmp['rows'],$count,$url,'page-',$page);
		$click=$db->GetAll("select b.*,p.title,p.url from click as b left join product as p on b.asin=p.asin ".$where." group by b.ip order by ".$order." ".$by." ".$limit,$val);
	}
	$btime=$db->GetRow("select min(time) as tmin,max(time) as tmax from click");
	lz::h('time');
	$template=lz::h('template');
	$template->assign('html',lz::h('html'));
	$template->assign(array('click'=>$click,'view'=>$view,'rows'=>$tmp['rows'],'pager'=>$pg,'count'=>$count,'allby'=>$allby,'allorder'=>$allorder,'count'=>$count,'btime'=>$btime));
	for($i=0;$i<count($all);$i++)if(${$all[$i]}) $template->assign($all[$i],${$all[$i]});
	return $template->fetch('click.list');
}
?>
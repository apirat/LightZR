<?php
//define('SETVIEW',true);
$db=lz::h('db');
$ajax=lz::h('ajax');
$ajax->register('bclear',dirname(__FILE__).'/admin.autopost.ajax.php','getautopost');
$ajax->process();
$template=lz::h('template');
//$template->assign('navigator','<li><a href="javascript:;" onclick="lz.box.open(\'#newautopost\')"><img src="'.HTTb.'images/admin/add.gif" alt="new" align="absmiddle" /> เพิ่มสินค้าใหม่</a></li>');
$template->assign('getautopost',getautopost());
admin::$content=$template->fetch('autopost');
function getautopost()
{
	$view=array('time'=>'เวลา','title'=>'หมวดสินค้า','product'=>'สินค้า','rew1'=>'Rewrite สินค้า','rew2'=>'Rewrite ความคิดเห็น','ping'=>'Ping','status'=>'สถานะ','detail'=>'รายละเอียด');
	$default=array('time','title','product','rew1','rew2','ping','status','detail');
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
		array_push($where,'(b.detail like ?)');
		array_push($val,'%'.$search.'%');
	}
	$where=$where?' where '.join(' and ',$where):'';
	if($count=$db->GetOne("select count(b.id) from autopost as b ".$where,$val))
	{
		$pager=lz::h('pager');
		list($pg,$limit)=$pager->page($tmp['rows'],$count,$url,'page-',$page);
		$autopost=$db->GetAll("select b.*,c.title,c.link from autopost as b left join product_category as c on b.category=c.id ".$where." order by ".$order." ".$by." ".$limit,$val);
	}
	$btime=$db->GetRow("select min(time) as tmin,max(time) as tmax from autopost");
	lz::h('time');
	$template=lz::h('template');
	$template->assign('html',lz::h('html'));
	$template->assign(array('autopost'=>$autopost,'view'=>$view,'rows'=>$tmp['rows'],'pager'=>$pg,'count'=>$count,'allby'=>$allby,'allorder'=>$allorder,'count'=>$count,'btime'=>$btime));
	for($i=0;$i<count($all);$i++)if(${$all[$i]}) $template->assign($all[$i],${$all[$i]});
	return $template->fetch('autopost.list');
}
?>
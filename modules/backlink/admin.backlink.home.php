<?php
$ajax=lz::h('ajax');
$ajax->register('update',dirname(__FILE__).'/admin.backlink.home.ajax.php');
$ajax->register('newblog',dirname(__FILE__).'/admin.backlink.home.ajax.php');
$ajax->register('newblogs',dirname(__FILE__).'/admin.backlink.home.ajax.php');
$ajax->register('delblog',dirname(__FILE__).'/admin.backlink.home.ajax.php');
//$ajax->register('del',dirname(__FILE__).'/admin.backlink.home.ajax.php','getblog');
$ajax->process();
$template=lz::h('template');
$template->assign('navigator','<li><a href="javascript:;" onclick="lz.box.open(\'#newblog\')"><img src="'.HTTP.'static/images/add.gif" alt="new" align="absmiddle" /> เพิ่มบล็อก</a></li><li><a href="javascript:;" onclick="lz.box.open(\'#newblogs\')"><img src="'.HTTP.'static/images/add.gif" alt="new" align="absmiddle" /> เพิ่มบล็อกจำนวนมาก</a></li>');
$template->assign('getblog',getblog());
admin::$content=$template->fetch('backlink.home');
function getblog()
{
	$view=array('id'=>'#','blogid'=>'URL','email'=>'Username','password'=>'Password','rpass'=>'โพสสำเร็จ','rfail'=>'โพสผิดพลาด','lastpost'=>'โพสล่าสุด');
	$default=array('id','blogid','email','ip','password','rpass','rfail','lastpost');
	$db=lz::h('db');
	if(!$tmp||!count($tmp['column']))$tmp=array('column'=>$default,'rows'=>20);;
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
		array_push($where,'(b.blogid like ? or b.email like ? or b.password like ?)');
		array_push($val,'%'.$search.'%','%'.$search.'%','%'.$search.'%');
	}
	$where=$where?' where '.join(' and ',$where):'';
	if($count=$db->GetOne("select count(b.id) from blog as b ".$where,$val))
	{
		$pager=lz::h('pager');
		list($pg,$limit)=$pager->page($tmp['rows'],$count,$url,'page-',$page);
		$blog=$db->GetAll("select b.*,sum(if(p.postid=0,1,0)) as rfail,sum(if(p.postid!=0,1,0)) as rpass from blog as b left join blog_post as p on b.id=p.blog ".$where." group by b.id order by ".$order." ".$by." ".$limit,$val);
	}
	lz::h('time');
	$template=lz::h('template');
	$template->assign('html',lz::h('html'));
	$template->assign(array('blog'=>$blog,'view'=>$view,'rows'=>$tmp['rows'],'pager'=>$pg,'count'=>$count,'allby'=>$allby,'allorder'=>$allorder,'count'=>$count,'btime'=>$btime));
	for($i=0;$i<count($all);$i++)if(${$all[$i]}) $template->assign($all[$i],${$all[$i]});
	return $template->fetch('backlink.home.list');
}
?>
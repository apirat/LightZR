<?php
//define('SETVIEW',true);
$db=lz::h('db');
$ajax=lz::h('ajax');
$ajax->register('delblogpost',dirname(__FILE__).'/admin.backlink.home.ajax.php','getblogpost');
$ajax->process();
$template=lz::h('template');
//$template->assign('navigator','<li><a href="javascript:;" onclick="lz.box.open(\'#newblog_post\')"><img src="'.HTTb.'images/admin/add.gif" alt="new" align="absmiddle" /> เพิ่มสินค้าใหม่</a></li>');
$template->assign('getblogpost',getblogpost());
admin::$content=$template->fetch('backlink.post');
function getblogpost()
{
	$view=array('blogid'=>'บล็อก','title'=>'คีย์เวิร์ด','asin'=>'สินค้า','time'=>'โพสเมื่อ','postid'=>'สถานะ');
	$default=array('time','blogid','title','asin','postid');
	$db=lz::h('db');
	if(!$tmp||!count($tmp['column']))$tmp=array('column'=>$default,'rows'=>20);;
	$allorder=array();
	for($i=0;$i<count($tmp['column']);$i++)if(array_key_exists($tmp['column'][$i],$view))$allorder[$tmp['column'][$i]]=$view[$tmp['column'][$i]];
	$allby=array('desc'=>'หลังไปหน้า','asc'=>'หน้าไปหลัง');
	$all=array('order','by','search','page','cate');
	$split=lz::h('split');
	extract($split->get(PATHMIN.SERVICE_LINK.'/post/',1,$all,$allorder,$allby));
	$where=array();
	$val=array();
	if($tmp['rows']<1)$tmp['rows']=1;
	if($search)
	{
		array_push($where,'(b.blogid like ? or b.email like ? )');
		array_push($val,'%'.$search.'%','%'.$search.'%');
	}
	$where=$where?' where '.join(' and ',$where):'';
	if($count=$db->GetOne("select count(p.id) from blog_post as p left join blog as b on p.blog=b.id left join product_category as c on p.category=c.id ".$where,$val))
	{
		$pager=lz::h('pager');
		list($pg,$limit)=$pager->page($tmp['rows'],$count,$url,'page-',$page);
		$blogpost=$db->GetAll("select b.blogid,c.title,p.asin,p.time,p.postid,p.posturl from blog_post as p left join blog as b on p.blog=b.id  left join product_category as c on p.category=c.id ".$where." order by ".$order." ".$by." ".$limit,$val);
	}
	lz::h('time');
	$template=lz::h('template');
	$template->assign('html',lz::h('html'));
	$template->assign(array('blogpost'=>$blogpost,'view'=>$view,'rows'=>$tmp['rows'],'pager'=>$pg,'count'=>$count,'allby'=>$allby,'allorder'=>$allorder,'count'=>$count,'btime'=>$btime));
	for($i=0;$i<count($all);$i++)if(${$all[$i]}) $template->assign($all[$i],${$all[$i]});
	return $template->fetch('backlink.post.list');
}
?>
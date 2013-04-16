<?php
if($_FILES['file']['tmp_name'])
{
	$row = 1;
	if (($handle = fopen($_FILES['file']['tmp_name'], "r")) !== false) 
	{
		$fr=array();
		$num=-1;
		$db=lz::h('db');
		$db->connect();
		$success=0;
		while (($data = fgetcsv($handle, 1000, ",")) !== false) 
		{
			if($num<0)$num = count($data);
			if($row==1)
			{
				for ($c=0; $c < $num; $c++)$fr[]=trim($data[$c]);
			}
			else
			{
				$fa=array();
				$sql='update product_category set ';
				for ($c=0; $c < $num; $c++)
				{
					$fa[$fr[$c]]=trim(strval($data[$c]));
					if($fr[$c]!='id')
					{
						$sql.=($fr[$c]."='".mysql_real_escape_string($fa[$fr[$c]])."',");
					}
				}
				if($id=trim($fa['id']))
				{
					$sql=trim($sql,',')." where id='".$id."'";
					unset($fa);
					$success++;
					$db->Execute($sql);
				}
			}
			$row++;
		}
		fclose($handle);
	}	
}


lz::h('time');
$setview=lz::h('setview');
$setview->set('admin.product','getcategory');
$setview->ajax();

$ajax=lz::h('ajax');
$ajax->register('update',dirname(__FILE__).'/admin.product.home.ajax.php');
$ajax->register('autopost',dirname(__FILE__).'/admin.product.home.ajax.php');
$ajax->register('del',dirname(__FILE__).'/admin.product.home.ajax.php');
$ajax->register('newcategory',dirname(__FILE__).'/admin.product.home.ajax.php');
$ajax->register('newcategories',dirname(__FILE__).'/admin.product.home.ajax.php');
$ajax->register('asinpost',dirname(__FILE__).'/admin.product.home.ajax.php');
$ajax->register('asinsave',dirname(__FILE__).'/admin.product.home.ajax.php');
$ajax->register('setlist',dirname(__FILE__).'/admin.product.home.ajax.php');
$ajax->process();
$template=lz::h('template');
$template->assign('navigator','<li><a href="javascript:;" onclick="lz.box.open(\'#newcategory\')"><img src="'.HTTP.'static/images/add.gif" alt="new" align="absmiddle" /> เพิ่มหมวด</a></li><li><a href="javascript:;" onclick="lz.box.open(\'#newcategories\')"><img src="'.HTTP.'static/images/add.gif" alt="new" align="absmiddle" /> เพิ่มหมวดจำนวนมาก</a></li><li><a href="'.PATHMIN.SERVICE_LINK.'/1/auto/2">อัพเดทสินค้าทุกหมวดแบบอัตโนมัติ</a></li>');
$template->assign('getcategory',getcategory());
if(isset($success))$template->assign('success',$success);
admin::$content=$template->fetch('product.home');
function getcategory()
{
	
	$view=array('id'=>'#','title'=>'คีย์เวิร์ด','link'=>'ลิ้งค์','domain'=>'โดเมน(mapping)','amount'=>'จำนวนสินค้า','price'=>'เฉลี่ยราคาสินค้า','asinpost'=>'โพสโดย ASIN','autopost'=>'โพสอัตโนมัติ');
	$default=array('id','title','link','domain','amount','price','asinpost','autopost');
	
	list($allorder,$rows)=lz::h('setview')->get($view,$default);
	
	$db=lz::h('db');
	$allby=array('desc'=>'หลังไปหน้า','asc'=>'หน้าไปหลัง');
	$all=array('order','by','search','page');
	extract(lz::h('split')->get(PATHMIN.SERVICE_LINK.'/',0,$all,$allorder,$allby));
	$where=array();
	$val=array();
	if($search)
	{
		array_push($where,'(c.title like ? or c.link like ? or c.domain like ?)');
		array_push($val,'%'.$search.'%','%'.$search.'%','%'.$search.'%');
	}
	$where=$where?' where '.join(' and ',$where):'';

	lz::h('time');
	$template=lz::h('template');
	$template->assign('html',lz::h('html'));
	if($count=lz::h('db')->GetOne("select count(c.id) from product_category as c ".$where,$val))
	{
		$pager=lz::h('pager');
		list($pg,$limit)=$pager->page($rows,$count,$url,'page-',$page);
		$cate=lz::h('db')->GetAll('select c.*,(select count(asin) from product where category=c.id) as amount,(select avg(price) from product where category=c.id) as price from product_category as c  '.$where.' order by '.$order.' '.$by.'  '.$limit,$val);
	}
	$template->assign(array('cate'=>$cate,'view'=>$view,'pager'=>$pg,'count'=>$count,'allby'=>$allby,'allorder'=>$allorder,'count'=>$count));
	for($i=0;$i<count($all);$i++)if(${$all[$i]}) $template->assign($all[$i],${$all[$i]});
	return $template->fetch('product.home.list');
}
?>
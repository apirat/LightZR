<?php
$module=array();
$module['category']=array('system'=>'ระบบหลักของเว็บไซต์');
$module['name']='ตำแหน่งข้อมูล';
$module['url']='layout';
$module['author']='Positron';
$module['version']=0.1;
$module['detail']='ระบบจัดการตำแหน่งข้อมูลต่างๆภายในเว็บไซต์';
$module['compatible']=1.0;
$module['type']='system';  //  enum('system','module')
$module['multi']='no';  //  enum('yes','no') / can create new service / type='module' only
$module['admin']='yes';   //  enum('yes','no')
$module['www']='no';   //  enum('yes','no')
$module['core']='no';   //  enum('yes','no')

$module['box']=array(
					 'www.layout.discount.php'=>array(
															'name'=>'Amazon Discount Search',
															),
					 'www.layout.recommend.php'=>array(
															'name'=>'Recommended Products',
															'option'=>'recommend',
															'detail'=>'ตั้งค่าการแสดงผล',
															),
					 'www.layout.amazon.1.php'=>array(
															'name'=>'Amazon 1',
															),
					 'www.layout.amazon.2.php'=>array(
															'name'=>'Amazon 2',
															),
					 'www.layout.brand.php'=>array(
															'name'=>'Brand',
															),
					 'www.layout.color.php'=>array(
															'name'=>'Color',
															),
					 'www.layout.price.php'=>array(
															'name'=>'Price',
															),
					 'www.layout.member.php'=>array(
															'name'=>'Member',
															),
					 'www.layout.searched.php'=>array(
															'name'=>'Top Searches',
															'option'=>'minsearch',
															'detail'=>'ตั้งค่าการแสดงผล',
															),
					 'www.layout.allsite.php'=>array(
															'name'=>'All Categories',
															'option'=>'allsite',
															'detail'=>'ตั้งค่าการแสดงผล',
															),
					 'www.layout.html.php'=>array(
															'name'=>'HTML',
															'option'=>'html',
															'detail'=>'แก้ไขโค๊ด html',
															),
					 'www.layout.review.php'=>array(
															'name'=>'Summary Reviews',
															'option'=>'review',
															'detail'=>'ตั้งค่าการแสดงผล',
															),
					 'www.layout.youtube.php'=>array(
															'name'=>'Youtube',
															'option'=>'youtube',
															'detail'=>'ตั้งค่าการแสดงผล',
															),
					 'www.layout.recent.php'=>array(
															'name'=>'Recent Products',
															'option'=>'recent',
															'detail'=>'ตั้งค่าการแสดงผล',
															),
					 'www.layout.tags.php'=>array(
															'name'=>'Tag Cloud',
															'option'=>'tags',
															'detail'=>'ตั้งค่าการแสดงผล',
															),
					 'www.layout.banner.php'=>array(
															'name'=>'Banner',
															),
					 );

function layout_box_minsearch($type,$box,$val)
{
	if($type=='set')	
	{
		return serialize($val);
	}
	else
	{
		$template=lz::h('template');
		$template->assign(array('box'=>$box,'val'=>unserialize($val)));
		return $template->fetch('layout.box.searched');
	}
}
function layout_box_html($type,$box,$val)
{
	if($type=='set')	
	{
		return $val['html'];
	}
	else
	{
		$template=lz::h('template');
		$template->assign(array('box'=>$box,'val'=>$val));
		return $template->fetch('layout.box.html');
	}
}
function layout_box_review($type,$box,$val)
{
	if($type=='set')	
	{
		return serialize($val);
	}
	else
	{
		$template=lz::h('template');
		$template->assign(array('box'=>$box,'val'=>unserialize($val)));
		return $template->fetch('layout.box.review');
	}
}
function layout_box_recommend($type,$box,$val)
{
	if($type=='set')	
	{
		return serialize($val);
	}
	else
	{
		$template=lz::h('template');
		$template->assign(array('box'=>$box,'val'=>unserialize($val)));
		return $template->fetch('layout.box.recommend');
	}
}
function layout_box_allsite($type,$box,$val)
{
	if($type=='set')	
	{
		return serialize($val);
	}
	else
	{
		$template=lz::h('template');
		$template->assign(array('box'=>$box,'val'=>unserialize($val)));
		return $template->fetch('layout.box.allsite');
	}
}
function layout_box_youtube($type,$box,$val)
{
	if($type=='set')	
	{
		return serialize($val);
	}
	else
	{
		$template=lz::h('template');
		$template->assign(array('box'=>$box,'val'=>unserialize($val)));
		return $template->fetch('layout.box.youtube');
	}
}

function layout_box_recent($type,$box,$val)
{
	if($type=='set')	
	{
		return serialize($val);
	}
	else
	{
		$template=lz::h('template');
		$template->assign(array('box'=>$box,'val'=>unserialize($val)));
		return $template->fetch('layout.box.recent');
	}
}
function layout_box_tags($type,$box,$val)
{
	if($type=='set')	
	{
		return serialize($val);
	}
	else
	{
		$template=lz::h('template');
		$template->assign(array('box'=>$box,'val'=>unserialize($val)));
		return $template->fetch('layout.box.tags');
	}
}
?>
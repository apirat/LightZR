<?php
$db=lz::h('db');
$min=intval($db->GetOne('select min(saleprice) from product where category=?',array(lz::$s['id']))/100);
$max=ceil($db->GetOne('select max(saleprice) from product where category=?',array(lz::$s['id']))/100);

$diff=$max-$min;
if($min)$min=$min-1;
$template=lz::h('template');
if($diff>10)
{
	$price=array();
	$r=ceil($diff/5);
	for($i=0;$i<5;$i++)
	{
			$price[]=array('min'=>($min+($r*$i)),'max'=>($min+($r*($i+1))));
	}
	$template->assign('price',$price);
}
$template->display('layout.price');


?>
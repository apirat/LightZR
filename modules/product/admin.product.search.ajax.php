<?php

function addproduct($id)
{
	$ajax=lz::h('ajax');
	$amazon=lz::h('amazon');
	if(is_numeric(lz::$f[0]))
	{
		$db=lz::h('db');
		$awstag=$db->GetOne('select awstag from product_category where id=?',array(lz::$f[0]));
		if($amazon->product($id,lz::$f[0],$awstag))
		{
			$ajax->alert('เพิ่มข้อมูลเรียบร้อยแล้ว');
		}
		else
		{
			$ajax->alert('ไม่สามารถเพิ่มข้อมูลได้');
		}
	}
	else
	{
		$ajax->alert('ไม่มีหมายเลขหมวดสินค้า');
	}
}
function avg($id)
{
	$ajax=lz::h('ajax');
	$amazon=lz::h('amazon');
	list($err,$avg,$tavg)=$amazon->getavg($id,lz::$f[0]);
	if($err)
	{
		$ajax->alert($err);
			
	}
	else
	{
		$ajax->script("\$('#avg'+curavg).html('".$avg."/".$tavg."')");
		$ajax->script('curavg++');
	}
	require(dirname(__FILE__).'/admin.product.config.php');
	$ajax->script('wt='.$delay['rating']);
	$ajax->script('rec()');
}
?>
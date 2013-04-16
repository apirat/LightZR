<?php

function backlink($id,$status)
{
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	$db->Execute('update product_category set backlink=? where id=?',array($status,$id));
	$ajax->assign('getcategory','innerHTML',getcategory());
}
?>
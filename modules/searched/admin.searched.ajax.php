<?php
function del($id)
{
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	$db->execute('delete from searched where id=?',array($id));
	$ajax->assign('getsearched','innerHTML',getsearched());
}
?>

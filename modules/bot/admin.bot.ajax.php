<?php
function bclear()
{
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	$db->execute('TRUNCATE `bot`;');
	$ajax->assign('getbot','innerHTML',getbot());
}
?>

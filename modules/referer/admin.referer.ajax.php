<?php
function bclear()
{
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	$db->execute('TRUNCATE `referer`;');
	$ajax->assign('getreferer','innerHTML',getreferer());
}
?>

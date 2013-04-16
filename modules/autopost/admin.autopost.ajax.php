<?php
function bclear()
{
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	$db->execute('TRUNCATE `autopost`;');
	$ajax->assign('getautopost','innerHTML',getautopost());
}
?>

<?php

	$template=lz::h('template');
	$template->assign('banner',lz::h('db')->GetAll("select * from banner"));
	$template->display('layout.banner');
?>
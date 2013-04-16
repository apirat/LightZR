<?php
$ajax = lz::h('ajax');
$ajax->register('save',dirname(__FILE__).'/admin.pref.ajax.php');
$ajax->process();
$db=lz::h('db');
$theme=array();
$dh=@opendir(ROOT.'themes/');
while($file=readdir($dh))
{
	if(!in_array($file,array('.','..')))
	{
		if(is_dir(ROOT.'themes/'.$file))
		{
			$theme[$file]=ucfirst($file);
		}
	}
}


$template=lz::h('template');
$template->assign('html',lz::h('html'));
$template->assign('pref',lz::$c);
$template->assign('theme',$theme);
$template->assign('star',$star);
$template->assign('button',$button);
admin::$content=$template->fetch('pref');
?>
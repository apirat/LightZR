<?php
$db=lz::h('db');
if(lz::$f[0])
{
	if(is_dir(ROOT.'themes/'.lz::$f[0]))
	{
		define('STYLEID',lz::$f[0]);
		if(!$style=$db->getrow('select * from style where theme=?',array(lz::$f[0])))
		{
			require_once(MODULES.'style/admin.style.function.php');
			restorefile();
		}
	}
	else
	{
		header('Location: '.PATHMIN.SERVICE_LINK);
		exit;
	}
}
else
{
	define('STYLEID',lz::$c['theme']);
}
if(lz::$f[1]=='upload')
{
	if($style=$db->GetRow('select * from style where theme=?',array(STYLEID)))
	{
		if($_FILES['upfile']['tmp_name'])
		{
			if($style[lz::$f[2].'_img'])@unlink(FILES.'style/'.$style[lz::$f[2].'_img']);
			$ext=strtolower(trim(preg_replace('/^.*\./', '', $_FILES['upfile']['name'])));
			if(in_array($ext,array('jpg','gif','png')))
			{
				$n=lz::$f[2].'_'.STYLEID.'.'.$ext;
				lz::h('folder')->mkdir(FILES.'style');
				@copy($_FILES['upfile']['tmp_name'],FILES.'style/'.$n);
				
				if(!$db->GetRow('select * from style where theme=?',array(STYLEID)))
				{
					$db->Execute('insert style set theme=?',array(STYLEID));	
				}
				$db->Execute("update style set ".lz::$f[2]."_img=? where theme=?",array($n,STYLEID));
				require_once(MODULES.'style/admin.style.function.php');
				savefile();
			}
			echo '<html><head><script>window.parent.location.reload();window.parent.lz.box.close();</script></head></html>';
			exit;
		}
		
	}
	$template=lz::h('template');
	$template->display('style.upload');
	exit;
}
$ajax=lz::h('ajax');
$ajax->register('save',dirname(__FILE__).'/admin.style.ajax.php');
$ajax->register('store',dirname(__FILE__).'/admin.style.ajax.php');
$ajax->register('del',dirname(__FILE__).'/admin.style.ajax.php');


$ajax->process();
$template=lz::h('template');

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
$template->assign('theme',$theme);
$template->assign('style',$db->getrow('select * from style where theme=?',array(STYLEID)));
admin::$content=$template->fetch('style');
?>
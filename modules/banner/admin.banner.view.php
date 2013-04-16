<?php
//define('SETVIEW',true);
$db=lz::h('db');
if(!$banner=$db->GetRow('select * from banner where id=?',array(lz::$f[0])))
{
	lz::move(PATHMIN.SERVICE_LINK,false);
}

$option=lz::get('banner');
if(!$option['width'])$option['width']=980;
if(!$option['height'])$option['height']=400;
if(!$option['type'])$option['type']='png';

if($_FILES['file_post']['tmp_name'])
{
	$photo=lz::h('photo');
	if($s=$photo->thumb($banner['id'].'_s',$_FILES['file_post']['tmp_name'],'banner',100,50,'bothtop',0,0,'png'))
	{
		$db->execute('update banner set s=? where id=?',array($s,$banner['id']));
			echo $_POST['file_name'].'#<img src="'.HTTP.'files/banner/'.$s.'?'.rand(1,9999).'">';
	}
	if($l=$photo->thumb($banner['id'].'_l',$_FILES['file_post']['tmp_name'],'banner',$option['width'],$option['height'],'width',0,0,$option['type']))
	{
		$db->execute('update banner set l=? where id=?',array($l,$banner['id']));
	}
	exit;
}
if($_FILES)
{
	print_r($_FILES);
	exit;
}
$ajax=lz::h('ajax');
$ajax->register('update',dirname(__FILE__).'/admin.banner.ajax.php');
$ajax->process();

$template=lz::h('template');
$template->assign('html',lz::h('html'));
$template->assign('banner',$banner);
admin::$content=$template->fetch('banner.view');
?>
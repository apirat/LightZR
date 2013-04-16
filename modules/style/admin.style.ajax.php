<?php
function del($type)
{
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	if($img=$db->GetOne('select '.$type.'_img from style where theme=?',array(STYLEID)))
	{
		if(file_exists(FILES.'style/'.$img))unlink(FILES.'style/'.$img);	
	}
	$db->Execute('update style set '.$type.'_img=? where theme=?',array('',STYLEID));
	require_once(MODULES.'style/admin.style.function.php');
	savefile();
	$ajax->alert('ลบรูปภาพเรียบร้อยแล้ว');
	$ajax->script('setTimeout(function(){top.location.reload();},3000);');
}

function save($frm)
{
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	if(!$style=$db->GetRow('select * from style where theme=?',array(STYLEID)))
	{
		$db->Execute('insert style set theme=?',array(STYLEID));	
	}
	$db->Execute("update style set css=?,
			bg_color=?,bg_fix=?,bg_align=?,bg_repeat=?,
			head_color=?,head_align=?,head_repeat=?,
			content_color=?,content_align=?,content_repeat=?,
			foot_color=?,foot_align=?,foot_repeat=?,
			left_color=?,left_align=?,left_repeat=?,
			right_color=?,right_align=?,right_repeat=?,
			lbar_color=?,lbar_align=?,lbar_repeat=?,lbar_font=?,
			tab_color=?,tab_align=?,tab_repeat=?,
			tab_bg=?,tab_font=?,tab_hbg=?,tab_hfont=?,
			text_font=?,text_link=?, flip=?
			where theme=?",
	array(trim($frm['css']),
			trim($frm['bg_color']),trim($frm['bg_fix']),trim($frm['bg_align']),trim($frm['bg_repeat']),
			trim($frm['head_color']),trim($frm['head_align']),trim($frm['head_repeat']),
			trim($frm['content_color']),trim($frm['content_align']),trim($frm['content_repeat']),
			trim($frm['foot_color']),trim($frm['foot_align']),trim($frm['foot_repeat']),
			trim($frm['left_color']),trim($frm['left_align']),trim($frm['left_repeat']),
			trim($frm['right_color']),trim($frm['right_align']),trim($frm['right_repeat']),
			trim($frm['lbar_color']),trim($frm['lbar_align']),trim($frm['lbar_repeat']),trim($frm['lbar_font']),
			trim($frm['tab_color']),trim($frm['tab_align']),trim($frm['tab_repeat']),
			trim($frm['tab_bg']),trim($frm['tab_font']),trim($frm['tab_hbg']),trim($frm['tab_hfont']),
			trim($frm['text_font']),trim($frm['text_link']),intval($frm['flip']),
			STYLEID));
	require_once(MODULES.'style/admin.style.function.php');
	savefile();
	$ajax->alert('บันทึกข้อมูลเรียบร้อยแล้ว');
}

function store()
{
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	if(is_file(ROOT.'themes/'.STYLEID.'/'.STYLEID.'.php'))
	{
		require_once(MODULES.'style/admin.style.function.php');
		restorefile();
		savefile();
		$ajax->alert('บันทึกข้อมูลเรียบร้อยแล้ว');
		$ajax->script('setTimeout(function(){top.location.reload();},3000);');
	}
	else
	{
			$ajax->alert('ข้อมูล Themes/Templates ไม่ถูกต้อง');
	}
}

?>
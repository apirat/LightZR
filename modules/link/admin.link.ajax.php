<?php
function newlink($frm)
{
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	$frm['link']=lz::h('format')->link(trim($frm['link']));
	if(!trim($frm['link']))
	{
		$ajax->show('กรุณากรอกลิ้งค์ที่ต้องการ');
	}
	elseif(!trim($frm['url']))
	{
		$ajax->show('กรุณากรอก URL ปลายทาง');
	}
	elseif($db->getrow('select * from link where link=?',array(trim($frm['link']))))
	{
		$ajax->show('มีลิ้งค์นี้อยู่ในระบบแล้ว');
	}
	elseif($id=$db->Execute('insert link set link=?,url=?',array(trim($frm['link']),trim($frm['url']))))
	{
		$ajax->show('เพิ่มลิ้งค์เรียบร้อยแล้ว.');
		$ajax->assign('getlink','innerHTML',getlink());
	}
	else
	{
		$ajax->show('เกิดข้อผิดพลาด.');
	}
}
function update($service,$type,$id,$value,$input='input')
{
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	$html=lz::h('html');
	$value=trim($value);
	if($service=='link')
	{
		if($type=='link')$value=lz::h('format')->link($value);
		$db->Execute("update link set ".$type."=? where id=?",array($value,$id));
		$tmp=$db->GetOne("select ".$type." from link where id=?",array($id));
		list($text,$input)=$html->form($service.'_'.$type.'_'.$id,$tmp,$input);
	}
	$ajax->html($service.'_'.$type.'_'.$id,$text,$input);
}

function del($id)
{
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	$db->Execute('delete from link where id=?',array($id));
	$ajax->assign('getlink','innerHTML',getlink());
	$ajax->show('ลบลิ้งค์เรียบร้อยแล้ว.');
}
?>

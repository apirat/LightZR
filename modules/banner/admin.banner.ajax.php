<?php
function newbanner($frm)
{
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	if(!trim($frm['title']))
	{
		$ajax->show('กรุณากรอกหัวข้อแบนเนอร์');
	}
	elseif($id=$db->Execute('insert banner set title=?,time=now()',array(trim($frm['title']))))
	{
		$ajax->show('เพิ่มลิ้งค์เรียบร้อยแล้ว.');
		$ajax->assign('getbanner','innerHTML',getbanner());
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
	if($service=='banner')
	{
		$db->Execute("update banner set ".$type."=? where id=?",array($value,$id));
		$tmp=$db->GetOne("select ".$type." from banner where id=?",array($id));
		list($text,$input)=$html->form($service.'_'.$type.'_'.$id,$tmp,$input);
	}
	$ajax->html($service.'_'.$type.'_'.$id,$text,$input);
}

function del($id)
{
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	$db->Execute('delete from banner where id=?',array($id));
	$ajax->assign('getbanner','innerHTML',getbanner());
	$ajax->show('ลบลิ้งค์เรียบร้อยแล้ว.');
}
?>

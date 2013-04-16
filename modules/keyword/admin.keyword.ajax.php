<?php
function bclear()
{
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	$db->execute('TRUNCATE `keyword`;');
	$ajax->assign('getkeyword','innerHTML',getkeyword());
}
function del($id)
{
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	$db->execute('delete from keyword where id=?',array($id));
	$ajax->assign('getkeyword','innerHTML',getkeyword());
}


function newkeyword($frm)
{
	$found=false;
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	$tmp=explode("\n",$frm['keyword']);
	$co=0;
	$inco=0;
	
	for($i=0;$i<count($tmp);$i++)
	{
		if($tmp[$i]=trim($tmp[$i]))
		{
			if(!$db->getrow('select * from keyword where title=?',array($tmp[$i])))
			{
				$db->Execute('insert keyword set word=? ',array($tmp[$i]));
				$co++;
			}
			else
			{
				$inco++;
			}
		}
	}
	$ajax->show('เพิ่มข้อมูลใหม่ สำเร็จ '.$co.' รายการ, ไม่สำเร็จ '.$inco.' รายการ');
	$ajax->assign('getkeyword','innerHTML',getkeyword());
}

?>

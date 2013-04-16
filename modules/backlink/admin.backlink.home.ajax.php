<?php
function update($service,$type,$id,$value,$input='input')
{
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	$html=lz::h('html');
	$value=trim($value);
	if($service=='blog')
	{
		$db->Execute("update blog set ".$type."=? where id=?",array($value,$id));
		$tmp=$db->GetOne("select ".$type." from blog where id=?",array($id));
		list($text,$input)=$html->form($service.'_'.$type.'_'.$id,$tmp,$input);
	}
	$ajax->html($service.'_'.$type.'_'.$id,$text,$input);
}


function newblog($frm)
{
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	if(!trim($frm['blogid']))
	{
		$ajax->show('กรุณากรอก url ของ wordpress');
	}
	elseif(!trim($frm['email']))
	{
		$ajax->show('กรุณากรอก username ของ wordpress');
	}
	elseif(!trim($frm['password']))
	{
		$ajax->show('กรุณากรอก password ของ wordpress');
	}
	elseif($db->getrow('select * from blog where blogid=?',array(trim($frm['blogid']))))
	{
		$ajax->show('มีบล็อกนี้อยู่ในระบบแล้ว');
	}
	elseif($id=$db->Execute('insert blog set blogid=?,email=?,password=?',array(trim($frm['blogid']),trim($frm['email']),trim($frm['password']))))
	{
		$ajax->assign('getblog','innerHTML',getblog());
		$ajax->show('เพิ่มบล็อกเรียบร้อยแล้ว.');
	}
	else
	{
		$ajax->show('เกิดข้อผิดพลาด.');
	}
}

function newblogs($frm)
{
	$found=false;
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	$tmp=explode("\n",$frm['blogs']);
	for($i=0;$i<count($tmp);$i++)
	{
		if(trim($tmp[$i]))
		{
			$blog=array_values(array_filter(explode(",",trim($tmp[$i]))));
			if(trim($blog[0])&&trim($blog[1])&&trim($blog[2]))
			{
				if(!$db->getrow('select * from blog where blogid=?',array(trim($blog[0]))))
				{
					$db->Execute('insert blog set blogid=?,email=?,password=?',array(trim($blog[0]),trim($blog[1]),trim($blog[2])));
					$found=true;
				}
			}
		}
	}
	if($found)
	{
		$ajax->show('เพิ่มข้อมูลใหม่เรียบร้อยแล้ว.');
	}
	else
	{
		$ajax->show('เกิดข้อผิดพลาด.'.$tmp[0]);
	}
	$ajax->assign('getblog','innerHTML',getblog());
}

function delblog($id)
{
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	$db->Execute('delete from blog where id=?',array($id));
	$db->Execute('delete from blog_post where blog=?',array($id));
	$ajax->assign('getblog','innerHTML',getblog());
	$ajax->show('ลบบล็อกเรียบร้อยแล้ว.');
}
function delblogpost($id)
{
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	$db->Execute('delete from blog_post where id=?',array($id));
	$ajax->assign('getblogpost','innerHTML',getblogpost());
	$ajax->show('ลบบล็อกเรียบร้อยแล้ว.');
}


?>

<?php
function newbox($mbox='',$position='')
{
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	if(in_array($position,array('menu','bar1','bar2')))
	{
		$all=$db->GetOne("select count(id) from service_box where site=?",array(LAYOUTID));
		if($all>=15)
		{
			$ajax->alert('คุณสามารถเพิ่มกล่องข้อมูลได้สูงสุด 15กล่อง');
		}
		elseif($box=$db->GetRow("select b.id,b.name,b.func,b.detail,m.folder from module_box as b left join module as m on b.module=m.id where b.id=?",array($mbox)))
		{
			if($id=$db->Execute("insert service_box set name=?,site=?,mbox=?,position=?",array($box['name'],LAYOUTID,$box['id'],$position)))
			{
				$ajax->script("addnew('".$position."','".$id."','".$box['name']."','".$box['folder']."','".$box['func']."','".$box['detail']."')");
				lz::h('cache')->clean();
			}
		}
		else
		{
			$ajax->alert('ยังไม่ได้เลือกกล่องข้อมูล');
		}
	}
	else
	{
		$ajax->alert('ยังไม่ได้เลือกตำแหน่ง');
	}
}
function setshow($frm)
{
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	if(!is_array($frm['show']))
	{
		$frm['show']=array($frm['show']);
	}
	$frm['show']=array_values(array_filter(array_unique(array_map('trim',$frm['show']))));
	if(count($frm['show']))
	{
		$frm['show']=','.implode(',',$frm['show']).',';
	}
	else
	{
		$frm['show']='';
	}
	$db->Execute('update service_box set service_box.show=? where id=? and site=?',array($frm['show'],$frm['box'],LAYOUTID));
	$ajax->script('$("#name'.$frm['box'].'").attr("show","'.$db->GetOne('select service_box.show from service_box where id=? and site=?',array($frm['box'],LAYOUTID)).'")');
	lz::h('cache')->clean();
}
function editname($frm)
{
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	$db->Execute('update service_box set name=? where id=? and site=?',array(trim($frm['name']),$frm['box'],LAYOUTID));
	$ajax->assign('name'.$frm['box'],'innerHTML',$db->GetOne('select name from service_box where id=? and site=?',array($frm['box'],LAYOUTID)));
	lz::h('cache')->clean();
}
function delete($id)
{
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	$db->Execute('delete from service_box where id=? and site=?',array($id,LAYOUTID));
	lz::h('cache')->clean();
}
function option($id)
{
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	if($m=$db->GetRow("select s.option,m.folder,b.func from service_box as s left join  module_box as b on s.mbox=b.id left join module as m on b.module=m.id where s.id=? and s.site=? and b.func!=?",array($id,LAYOUTID,'')))
	{
		require_once(ROOT.'modules/'.$m['folder'].'/'.$m['folder'].'.php');
		$ajax->assign('setoption','innerHTML',call_user_func_array($m['folder'].'_box_'.$m['func'],array('get',$id,$m['option'])));
		$ajax->script('lz.box.open("#setoption")');
		lz::h('cache')->clean();
	}
}
function setoption($id,$value)
{
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	if($m=$db->GetRow("select s.option,m.folder,b.func from service_box as s left join  module_box as b on s.mbox=b.id left join module as m on b.module=m.id where s.id=? and s.site=? and b.func!=?",array($id,LAYOUTID,'')))
	{
		require_once(ROOT.'modules/'.$m['folder'].'/'.$m['folder'].'.php');
		if($val=call_user_func_array($m['folder'].'_box_'.$m['func'],array('set',$id,$value)))
		{
			lz::h('db')->execute('update service_box set service_box.option=? where id=? and site=?',array($val,$id,LAYOUTID));
		}
		lz::h('cache')->clean();
		$ajax->alert('บันทึกข้อมูลเรียบร้อยแล้ว');
	}
}
function position($frm)
{
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	foreach($frm as $key=>$val)
	{
		if(in_array($key,array('menu','bar1','bar2')))
		{
			if(is_array($val))
			{
				foreach($val as $i=>$id)
				{
					$db->Execute("update service_box set position=?,service_box.order=? where id=? and site=?",array($key,$i,$id,LAYOUTID));
				}
			}
			lz::h('cache')->clean();
		}
	}
	$ajax->alert('บันทึกข้อมูลเรียบร้อยแล้ว');
}
?>
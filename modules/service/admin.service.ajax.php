<?php
function update($service,$type,$id,$value)
{
	$ajax=lz::h('ajax');
	$value=trim($value);
	if(in_array($service,array('service','module'))&&$value)
	{
		if(in_array($type,array('name','link')))
		{
			if($type=='link')
			{
				$format=lz::h('format');
				$value=trim($format->link($value));
			}
			$db=lz::h('db');
			if($value)$db->Execute("update ".$service." set ".$type."=? where id=?",array($value,$id));
			$update=$db->GetOne("select ".$type." from ".$service." where id=?",array($id));
			//$ajax->assign('_'.$service.'_'.$type.'_'.$id,'innerHTML',$update);
			if($type=='link'&&$id==SERVICE_ID&&$update!=SERVICE_LINK)
			{
				$ajax->redirect(QUERY.$update);
			}
			else
			{
				$ajax->assign('menu','innerHTML',admin::menu());
				$ajax->assign('services','innerHTML',getservices());
			}
			lz::h('cache')->clean('system_db');
		}
	}
	return $ajax;
}
function setdefault($id)
{
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	$db->Execute('update service set service.default=?',array('no'));
	$db->Execute('update service set service.default=? where id=?',array('yes'));
	$cache=lz::h('cache');
	$cache->clean('system_db');
	$ajax->assign('services','innerHTML',getservices());
}
function seticon($id,$icon)
{
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	$db->Execute('update service set icon=? where id=?',array($icon,$id));
	$cache=lz::h('cache');
	$cache->clean('system_db');
	$ajax->assign('services','innerHTML',getservices());
}
function suninstall($id)
{
	$ajax=lz::h('ajax');
	$db=lz::h('db');
	if($service=$db->GetRow("select s.id,s.module,m.folder from service as s left join module as m on s.module=m.id where s.id=? and m.type!=?",array($id,'system')))
	{
		$db->Execute("delete from service where id=?",array($id));
		require_once(MODULES.$service['folder'].DS.$service['folder'].'.php');
		if(function_exists($service['folder'].'_service_remove'))call_user_func($service['folder'].'_service_remove',$service['id'],$service['module']);
		$cache=lz::h('cache');
		$cache->clean('system_db');
		$ajax->assign('menu','innerHTML',admin::menu());
		$ajax->assign('services','innerHTML',getservices());
	}
}
function sinstall($id)
{
	install_service($id);
	lz::h('cache')->clean('system_db');
	$ajax->assign('menu','innerHTML',admin::menu());
	$ajax->assign('services','innerHTML',getservices());
}
function install_service($id)
{
	$ajax=lz::h('ajax');
	$format=lz::h('format');
	$db=lz::h('db');
	if($modules=$db->GetRow("select m.id,m.name,m.folder,m.url,m.multi,m.status from module as m where m.id=?",array($id)))
	{
		if($modules['status']=='paused')
		{
			$ajax->alert('โมดูลนี้ถูกระงับการใช้งานชั่วคราว');
		}
		elseif($modules['status']=='install')
		{
			if(!$db->GetOne("select s.id from service as s left join module as m on s.module=m.id where s.module=?",array($id)))
			{
				if(!$already=$db->GetOne("select s.name from service as s left join module as m on s.module=m.id where m.url=?",array($modules['url'])))
				{
					if($id=$db->execute("insert service set service.name=?,service.link=?,service.module=?",array($modules['name'],$modules['url'],$modules['id'])))
					{
						require_once(MODULES.$modules['folder'].DS.$modules['folder'].'.php');
						if(function_exists($modules['folder'].'_service_create'))call_user_func($modules['folder'].'_service_create',$id,$modules['id']);
					}
				}
				else
				{
					$ajax->alert('คุณมีโมดูล "'.$already.'" ซึ่งคล้ายกับโมดูลนี้อยู่แล้ว หากต้องการติดตั้งโมดูลนี้ กรุณาถอนการติดตั้งโมดูล "'.$already.'" ออกก่อน');
				}
			}
		}
		else
		{
			$ajax->alert('โมดูลนี้ยังไม่เปิดให้ใช้บริการ');
		}
	}
}
function createpage($frm)
{
	$ajax=lz::h('ajax');
	$link=lz::h('format')->link(strtolower($frm['url']));
	$db=lz::h('db');
	if(!$page=$db->getrow('select id,status from module where folder=?',array('page')))
	{
		$ajax->alert('โมดูลนี้ยังไม่เปิดให้ใช้บริการ.');
	}
	elseif($page['status']!='install')
	{
		$ajax->alert('โมดูลนี้ถูกระงับการใช้งานชั่วคราว.');
	}
	elseif(!trim($frm['name']))
	{
		$ajax->alert('กรุณากรอกชื่อหน้าเว็บ.');
	}
	elseif($db->GetOne('select id from service where link=? and site=?',array($link,lz::$s['id'])))
	{
		$ajax->alert('มีชื่อไฟล์นี้อยู่ในบริการของคุณแล้ว.');
	}
	elseif($db->GetOne('select id from service where link=? and site=?',array($link,lz::$s['id'])))
	{
		$ajax->alert($link.' มีชื่อไฟล์นี้อยู่ในบริการของคุณแล้ว.');
	}
	elseif(is_dir(ROOT.$link)||file_exists(ROOT.$link))
	{
		$ajax->alert($link.' ไม่สามารถตั้งชื่อไฟล์นี้ได้.');
	}
	elseif($id=$db->execute("insert service set service.name=?,service.site=?,service.link=?,service.module=?",array(trim($frm['name']),lz::$s['id'],$link,9)))
	{
		require_once(MODULES.'page/page.php');
		if(function_exists('page_service_create'))call_user_func('page_service_create',$id,$modules['id']);
		lz::h('cache')->clean('system/db');
		$ajax->assign('menu','innerHTML',admin::menu());
		$ajax->assign('services','innerHTML',getservices());
	}
	else
	{
		$ajax->alert('เกิดข้อผิดพลาด ไม่สามารถเพิ่มข้อมูลได้ในขณะนี้้.');
	}
}
?>
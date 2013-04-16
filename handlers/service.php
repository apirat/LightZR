<?php
class service
{
	public function install($folder)
	{
		$format=lz::h('format');
		$db=lz::h('db');
		if($modules=$db->GetRow("select m.id,m.name,m.folder,m.url,m.multi,m.status,m.www from module as m where m.folder=?",array($folder)))
		{
			if($modules['status']=='paused')
			{
				return array('error'=>'โมดูลนี้ถูกระงับการใช้งานชั่วคราว');
			}
			elseif($modules['status']=='install')
			{
				if($modules['multi']=='yes'||!$db->GetOne("select s.id from service as s left join module as m on s.module=m.id where s.site=? and s.module=?",array(lz::$s['id'],$modules['id'])))
				{
					if($modules['multi']=='yes'||!$already=$db->GetOne("select s.name from service as s left join module as m on s.module=m.id where s.site=? and m.url=?",array(lz::$s['id'],$modules['url'])))
					{
						if($id=$db->execute("insert service set service.name=?,service.site=?,service.link=?,service.module=?",array($modules['name'],lz::$s['id'],$modules['url'],$modules['id'])))
						{
							require_once(MODULES.$modules['folder'].DS.$modules['folder'].'.php');
							if(function_exists($modules['folder'].'_service_create'))call_user_func($modules['folder'].'_service_create',$id,$modules['id']);
							return array('service'=>$id,'module'=>$modules['id'],'www'=>$modules['www']);
						}
					}
					else
					{
						return array('error'=>'คุณมีโมดูล "'.$already.'" ซึ่งคล้ายกับโมดูลนี้อยู่แล้ว หากต้องการติดตั้งโมดูลนี้ กรุณาถอนการติดตั้งโมดูล "'.$already.'" ออกก่อน');
					}
				}
			}
			else
			{
				return array('error'=>'โมดูลนี้ยังไม่เปิดให้ใช้บริการ');
			}
		}
	}
}
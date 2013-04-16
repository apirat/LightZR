<?php
function minstall($folder)
{
	$ajax=lz::h('ajax');
	if(trim($folder))
	{
		$path=MODULES.$folder.DS.$folder.'.php';
		if(file_exists($path))
		{
			require_once($path);
			if($module&&$module['name'])
			{
				$module['folder']=$folder;
				install_module($module);
				lz::h('cache')->clean('system_db');
				$ajax->assign('menu','innerHTML',admin::menu());
				$ajax->assign('getmodules','innerHTML',getmodules());
			}
		}
	}
}
function install_module($module)
{
	$db=lz::h('db');
	if(is_array($module['category']))
	{
		$key=implode(' - ',array_keys($module['category']));
		$value=implode(' - ',array_values($module['category']));
		if($category=$db->GetOne('select id from module_category where module_category.key=?',array($key)))
		{
			$db->Execute('update module_category set name=? where id=?',array($value,$category));
		}
		else
		{
			$category=$db->Execute('insert module_category set module_category.key=?,name=?',array($key,$value));
		}
	}
	if($tmp=$db->GetRow('select id,status,type from module where folder=?',array($module['folder'])))
	{
		$db->Execute('update module set site=?,category=?,name=?,type=?,author=?,module.version=?,detail=?,time=now(),compatible=?,multi=?,url=?,admin=?,www=?,status=?,core=? where folder=?',
		array(intval($module['site']),$category,$module['name'],$module['type'],$module['author'],$module['version'],$module['detail'],$module['compatible'],$module['multi'],$module['url'],$module['admin'],$module['www'],($module['status']=='paused'?'paused':'install'),$module['core'],$module['folder']));
		$id=$tmp['id'];
	}
	else
	{
		$db->Execute('insert module set site=?,category=?,name=?,folder=?,type=?,author=?,module.version=?,detail=?,time=now(),compatible=?,multi=?,url=?,admin=?,www=?,status=?,core=?',
		array(intval($module['site']),$category,$module['name'],$module['folder'],$module['type'],$module['author'],$module['version'],$module['detail'],$module['compatible'],$module['multi'],$module['url'],$module['admin'],$module['www'],($module['status']=='paused'?'paused':'install'),$module['core']));
		$id=$db->Insert_ID();
	}
	if(is_array($module['box']))
	{
		foreach($module['box'] as $file=>$value)
		{
			$path=MODULES.$module['folder'].DS.$file;
			if(file_exists($path))
			{
				if($box=$db->GetOne('select id from module_box where file=? and module=?',array($file,$id)))
				{
					$db->Execute('update module_box set name=?,func=?,detail=? where id=?',array($value['name'],strval($value['option']),strval($value['detail']),$box));
				}
				else
				{
					$db->Execute('insert module_box set name=?,file=?,module=?,func=?,detail=?',array($value['name'],$file,$id,strval($value['option']),strval($value['detail'])));
				}
			}
		}
	}
	if(is_array($module['template']))
	{
		/*
		foreach($module['template'] as $file=>$name)
		{
			if($box=$db->GetOne('select id from template where file=? and module=?',array($file,$id)))
			{
				$db->Execute('update template set name=? where id=?',array($name,$box));
			}
			else
			{
				$db->Execute('insert template set name=?,file=?,module=?',array($name,$file,$id));
			}
		}
		*/
	}
	if(function_exists($module['folder'].'_module_install'))call_user_func($module['folder'].'_module_install',$id);
	return $id;
}
function status($folder,$status)
{
	$ajax=lz::h('ajax');
	if(in_array($status,array('paused','install')))
	{
		$db=lz::h('db');
		$db->Execute('update module set status=? where folder=? and status in (?,?)',array($status,$folder,'paused','install'));
	}
	$cache=lz::h('cache');
	$cache->clean('system/db');
	$ajax->assign('getmodules','innerHTML',getmodules());
}
function reload($folder)
{
	$ajax=lz::h('ajax');
	if(trim($folder))
	{
		$path=MODULES.$folder.DS.$folder.'.php';
		if(file_exists($path))
		{
			$db=lz::h('db');
			require_once($path);
			if($module&&$module['name'])
			{
				if(is_array($module['category']))
				{
					$key=implode(' - ',array_keys($module['category']));
					$value=implode(' - ',array_values($module['category']));
					if($category=$db->GetOne('select id from module_category where module_category.key=?',array($key)))
					{
						$db->Execute('update module_category set name=? where id=?',array($value,$category));
					}
					else
					{
						$category=$db->Execute('insert module_category set module_category.key=?,name=?',array($key,$value));
					}
				}
				if($tmp=$db->GetRow('select id,status,type from module where folder=?',array($folder)))
				{
					$db->Execute('update module set site=?,category=?,name=?,type=?,author=?,module.version=?,detail=?,time=now(),compatible=?,multi=?,url=?,admin=?,www=?,status=?,core=? where folder=?',
					array(intval($module['site']),$category,$module['name'],$module['type'],$module['author'],$module['version'],$module['detail'],$module['compatible'],$module['multi'],$module['url'],$module['admin'],$module['www'],($module['status']=='paused'?'paused':'install'),$module['core'],$folder));
					//$ajax->alert(mysql_error());
					$id=$tmp['id'];
					if(is_array($module['box']))
					{
						foreach($module['box'] as $file=>$value)
						{
							$path=MODULES.$folder.DS.$file;
							if(file_exists($path))
							{
								if($box=$db->GetOne('select id from module_box where file=? and module=?',array($file,$id)))
								{
									$db->Execute('update module_box set name=?,func=?,detail=? where id=?',array($value['name'],strval($value['option']),strval($value['detail']),$box));
								}
								else
								{
									$db->Execute('insert module_box set name=?,file=?,module=?,func=?,detail=?',array($value['name'],$file,$id,strval($value['option']),strval($value['detail'])));
								}
							}
						}
					}
					if(is_array($module['template']))
					{
						foreach($module['template'] as $file=>$name)
						{
							if($box=$db->GetOne('select id from template where file=? and module=?',array($file,$id)))
							{
								$db->Execute('update template set name=? where id=?',array($name,$box));
							}
							else
							{
								$db->Execute('insert template set name=?,file=?,module=?',array($name,$file,$id));
							}
						}
					}
					if(function_exists($folder.'_module_reload'))call_user_func($folder.'_module_reload',$id);
					$cache=lz::h('cache');
					$cache->clean('system/db');
					$ajax->assign('getmodules','innerHTML',getmodules());
					//$ajax->script('lz.load.show("complete!",3000);');
				}
			}
		}
	}
}
function muninstall($folder)
{
	$ajax=lz::h('ajax');
	if(trim($folder)&&lz::$cf['uninstall_module'])
	{
		$db=lz::h('db');
		if($tmp=$db->GetRow('select id,status,type from module where folder=?',array($folder)))
		{
			$db->Execute('update module set status=? where folder=?',array('uninstall',$folder));
			$cache=lz::h('cache');
			$cache->clean('system/db');
			if(function_exists($folder.'_module_uninstall'))call_user_func($folder.'_module_uninstall',$tmp['id']);
		}
	}
	elseif(!lz::$cf['uninstall_module'])
	{
		$ajax->show('ไม่สามารถถอนโมดูลได้.<br> เนื่องจากมีการ config ปิดการถอนโมดูลไว้');
	}
	$ajax->assign('menu','innerHTML',admin::menu());
	$ajax->assign('getmodules','innerHTML',getmodules());
}
?>
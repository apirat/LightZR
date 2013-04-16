<?php
$ajax=lz::h('ajax');
$ajax->register('minstall',dirname(__FILE__).DS.'admin.module.ajax.php','getmodules');
$ajax->register('muninstall',dirname(__FILE__).DS.'admin.module.ajax.php','getmodules');
$ajax->register('reload',dirname(__FILE__).DS.'admin.module.ajax.php','getmodules');
$ajax->register('status',dirname(__FILE__).DS.'admin.module.ajax.php','getmodules');
$ajax->process();
$template=lz::h('template');
$template->assign('getmodules',getmodules());
admin::$content=$template->fetch('module');
function getmodules()
{
	$modules=array();
	$db=lz::h('db');
	//if($tmp=$db->GetAll("select * from module where type='module' order by status asc"))
	if($tmp=$db->GetAll("select m.*,c.name as cate from module as m left join module_category as c on m.category=c.id order by m.category asc,m.name asc,m.status asc"))
	{
		for($i=0;$i<count($tmp);$i++)
		{
			if($tmp[$i]['type']=='system')
			{
				$tmp[$i]['found']=is_dir(MODULES.'system'.DS.$tmp[$i]['folder'])?true:false;
				$modules[$tmp[$i]['folder']]=$tmp[$i];
			}
			else
			{
				$tmp[$i]['found']=is_dir(MODULES.$tmp[$i]['folder'])?true:false;
				if(!$tmp[$i]['found']&&$tmp[$i]['status']=='uninstall')
				{
					if(lz::$cf['uninstall_module'])$db->execute('delete from module where folder=?',array($tmp[$i]['folder']));
				}
				else
				{
					$modules[$tmp[$i]['folder']]=$tmp[$i];
				}
			}
		}
	}
	if (is_dir(MODULES))
	{
		if ($dh = opendir(MODULES))
		{
			while (($dir=readdir($dh)) !== false)
			{
				if(is_dir(MODULES.$dir)&&!in_array($dir,array('.','..')))
				{
					if(file_exists($file=MODULES.$dir.DS.$dir.'.php'))
					{
						unset($module);
						if(!array_key_exists($file,$modules))
						{
							require_once($file);
							if($module&&$module['name'])
							{
								if(!$module['type'])$module['type']='module';
								if(is_array($module['category']))$module['cate']=implode(' - ',array_values($module['category']));
								$modules[$dir]=array_merge($module,array('folder'=>$dir,'status'=>($modules[$dir]?$modules[$dir]['status']:'uninstall'),'found'=>true));
							}
						}
					}
				}
			}
			closedir($dh);
		}
	}
	$template=lz::h('template');
	$template->assign('modules',$modules);
	return $template->fetch('module.list');
}
?>
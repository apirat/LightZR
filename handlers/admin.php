<?php
class admin
{
	public static $content;
	protected static $lastmenu;
	protected static $lastsubmenu;
	public function admin()
	{
		if(strstr($_SERVER['HTTP_USER_AGENT'],'Googlebot'))
		{
			lz::move(QUERY,true);
		}
		if(!defined('SERVICE_ID'))
		{
			lz::h('session')->logged();
			$db=lz::h('db');
			$cache=lz::h('cache');
			if(!$service=$cache->get('system_db_admin-'.lz::$f[0]))
			{
				$service=$db->GetRow('select s.id,s.name,s.link,s.icon,m.folder,m.type from service as s left join module as m on s.module=m.id where s.link=? and m.status in (?,?) and m.admin=?',array(lz::$f[0],'install','paused','yes'));
				$cache->set('system_db_admin-'.lz::$f[0],$service,0);
			}
			if(lz::$f[0])array_shift(lz::$f);
			if(!$service)
			{
				$service=$db->GetRow('select s.id,s.name,s.link,s.icon,m.folder,m.type from service as s left join module as m on s.module=m.id where m.status in (?,?) and m.admin=? order by s.id limit 0,1',array('install','paused','yes'));
			}
			if($service)
			{
				define('SERVICE_ID',$service['id']);
				define('SERVICE_NAME',$service['name']);
				define('SERVICE_LINK',$service['link']);
				define('SERVICE_TYPE',$service['type']);
				define('SERVICE_FOLDER',$service['folder']);
				if($service['icon'])define('SERVICE_ICON',$service['icon']);
			}
			define('THEMES',HTTP.'themes/lightzr/');
			define('THEMES_A',THEMES);
			define('IMAGES',THEMES.'images/admin/');
			define('IMAGES_A',IMAGES);
			$template=lz::h('template');
			if(defined('MY_ADMIN')&&$service)
			{
				require_once(MODULES.SERVICE_FOLDER.DS.'admin.'.SERVICE_FOLDER.'.php');
			}
			elseif(!$service)
			{
				admin::$content=$template->fetch('content.permission.service');
			}
			else
			{
				admin::$content=$template->fetch('content.permission.user');
			}
			$template->assign(array('menu'=>admin::menu(),'content'=>admin::$content));
			admin::$content=$template->fetch('content');
		}
	}
	public function get()
	{
		return array('content'=>admin::$content);
	}
	public static function menu()
	{
		$db=lz::h('db');
		$service=$db->GetAll('select s.id,s.name,s.link,s.icon,s.submenu,m.folder,m.multi,m.detail,m.category,c.key,c.name as cate from service as s left join module as m on s.module=m.id left join module_category as c on m.category=c.id where (s.menu!=? or s.submenu!=?) and m.status in (?,?) order by c.id asc,m.id asc',array('hide','hide','install','paused'));
		
		if($service)
		{
			$category=-1;
			foreach($service as $menu)
			{
				$menu['name']=$menu['name'];
				if($menu['icon'])
				{
					$menu['icon']=HTTP.'static/images/menu/'.$menu['icon'].'16.png';
				}
				else
				{
					$menu['icon']=HTTP.'modules/'.$menu['folder'].'/images/icon16.png';
				}
				if(in_array($menu['folder'],array('home','user','product')))
				{
					$html.=admin::_menu($menu,'');
					//admin::$lastsubmenu='';
					//admin::$lastmenu='';
				}
				elseif($menu['category']==$category)
				{
					$menu['insub']=1;
					admin::$lastsubmenu.=admin::_menu($menu);
				}
				else
				{
					if(admin::$lastmenu)
					{
						$html.=admin::_menu(admin::$lastmenu,admin::$lastsubmenu?'<ul>'.admin::$lastsubmenu.'</ul>':'');
					}
					$menu['insub']=1;
					admin::$lastsubmenu=admin::_menu($menu);
					admin::$lastmenu=array('name'=>$menu['cate'],'icon'=>HTTP.'static/images/menu/'.$menu['key'].'.png');
					$category=$menu['category'];
				}
			}
			$html.=admin::_menu(admin::$lastmenu,admin::$lastsubmenu?'<ul>'.admin::$lastsubmenu.'</ul>':'');
		}
		$html.=admin::_menu(array('link'=>'?logout','name'=>'ออกจากระบบ','folder'=>'logout','icon'=>HTTP.'static/images/logout.png'));
		return $html;
	}
	public static function _menu($menu,$submenu='')
	{
		$template=lz::h('template');
		$template->assign(array('menu'=>$menu,'submenu'=>$submenu));
		return $template->fetch('content.menu');
	}
}
?>
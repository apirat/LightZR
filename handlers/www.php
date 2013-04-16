<?php
class www
{
	public static $content;
	public static $service;
	public static $box=array();
	public function www()
	{
		if(in_array(lz::$f[0],array('privacy.html','about.html','sitemap.xml','rss.xml')))
		{
			lz::$f[0]=substr(lz::$f[0],0,strpos(lz::$f[0],'.'));
			require_once(MODULES.lz::$f[0].'/www.'.lz::$f[0].'.php');
		}
		elseif(lz::$f[0]=='cron'&&SUB=='www')
		{
			require_once(MODULES.lz::$f[0].'/www.cron.php');
		}
		elseif(!lz::$f[0]&&SUB=='www')
		{
			define('SERVICE_FOLDER','home');
			require_once(MODULES.'home/www.home.php');
		}
		else
		{
			define('SERVICE_FOLDER','product');
			require_once(MODULES.'product/www.product.php');
		}
	}
	public function get()
	{
		if(defined('PAGE'))
		{
			if(!$box=lz::h('cache')->get('box_'.PAGE.'_'.lz::$s['id']))
			{
				$db=lz::h('db');
				$box=array();
				if($b=$db->GetAll('select sb.name,sb.position,sb.option,b.file,m.folder from service_box as sb left join module_box as b on sb.mbox=b.id left join module as m on b.module=m.id where sb.site=? and sb.position in (?,?,?) and (sb.show=? or sb.show like ?) order by sb.order asc',array(1,'menu','bar1','bar2','',','.PAGE.',')))
				{
					for($i=0;$i<count($b);$i++)
					{
						$box[$b[$i]['position']].=$this->box($b[$i]);
					}
				}
				lz::h('cache')->set('box_'.PAGE.'_'.lz::$s['id'],$box,0);
			}
		}
		
		$product=(lz::$s['title']?lz::$s['title']:'products');
		$sitename=(lz::$s['title']?lz::$s['title']:lz::$c['sitename']);
		
		if(lz::$s['mtitle'])lz::$c['title']=lz::$s['mtitle'];
		if(lz::$s['mdescription'])lz::$c['description']=lz::$s['mdescription'];
		if(lz::$s['mkeywords'])lz::$c['keywords']=lz::$s['mkeywords'];
		if(lz::$s['footer'])lz::$c['disclaimer']=lz::$s['footer'];
	
		
		lz::$c['title']=((lz::$s['ptitle'])?lz::$s['ptitle'].' - ':'').str_replace(array('{PRODUCT}','{SITENAME}'),array($product,$sitename),lz::$c['title']);
		lz::$c['description']=str_replace(array('{PRODUCT}','{SITENAME}'),array($product,$sitename),lz::$c['description']);
		lz::$c['disclaimer']=str_replace(array('{PRODUCT}','{SITENAME}'),array($product,$sitename),lz::$c['disclaimer']);
		lz::$c['keywords']=str_replace('{KEYWORDS}',(lz::$s['title']?lz::$s['title']:strtolower($sitename)).(lz::$s['title']?', '.str_replace(' ',', ',lz::$s['title']):''),lz::$c['keywords']);
		
		lz::$c['og:site_name']=$sitename;
		if(lz::$s['ptitle'])lz::$c['og:title']=lz::$s['ptitle'];
		
		$template=lz::h('template');
		$template->assign(array('content'=>www::$content,'box'=>$box));
		

		if(lz::$c['sub']==2||lz::$s['domain'])
		{
			$url=array('category'=>QUERY,'home'=>'http://www.'.lz::$cf['domain'].QUERY);
		}
		else
		{
			$url=array('category'=>QUERY.lz::$s['link'],'home'=>QUERY);
		}
		$template->assign('url',$url);
		return array('content'=>(www::$content=$template->fetch('content')));
	}
	
	public function box($box)
	{
		$template=lz::h('template');
		if(in_array($box['position'],array('bar1','bar2')))
		{
			$bor='full';
		}
		else
		{
			$bor='menu';
		}
	//	$box['option']=unserialize($box['option']);
		$template->assign(array('box'=>$box,'border'=>$bor));
		ob_start();
		include(ROOT.'modules/'.$box['folder'].'/'.$box['file']);
		$tmp=ob_get_clean();
		if(preg_match('/(?:\<\!--border=([menu|full|no]+)--\>)/',$tmp,$border))
		{
			$tmp=str_replace($border[0], "", $tmp);
		}
		else
		{
			$border=array('',$bor);
		}
		if($border[1]!='no')
		{
			$template->assign(array('box_content'=>$tmp));
			$tmp=$template->fetch('content.box.'.$border[1].'');
		}
		return $tmp;
	}
}
?>
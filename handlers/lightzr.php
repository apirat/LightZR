<?php
/*
+ ----------------------------------------------------------------------------+
|     LightZr Amazon Script
|
|     ©Positron 2013
|     http://boxza.com
|     positron@boxza.com
|
|     $Revision: 3.0 RC1 $
|     $Date: 2013/04/17 04:31:00 $
|     $Author: Positron $
+-----------------------------------------------------------------------------+
*/
ob_start();
define('START',array_sum(explode(' ',microtime())));
ini_set('html_errors',0);
ini_set('display_errors',E_ALL & ~E_NOTICE);
error_reporting(E_ALL & ~E_NOTICE);
set_error_handler('lz::e',E_ALL & ~E_NOTICE);
header('Content-type: text/html; charset=utf-8');
define('VERSION','3.0 RC1');
define('DS',DIRECTORY_SEPARATOR);
define('ROOT',dirname(dirname(__FILE__)).'/');
define('HANDLERS',ROOT.'handlers/');
define('MODULES',ROOT.'modules/');
class lz
{
	public static $h;
	public static $f;
	public static $fu;
	public static $cf;
	public static $t;
	public static $s;
	public static $c=array();
	public function lz()
	{
   	if(!defined('LightZr')) 
		{
			if(!file_exists(HANDLERS.'config.php'))lz::move('/install.php');
			require_once(HANDLERS.'config.php');
			if(!isset($config))lz::move('/install.php');
			lz::$cf=$config;
			define('LightZr',VERSION);
			define('HTTP',lz::$cf['http']);
			define('HOST',strtolower($_SERVER['HTTP_HOST']));
			define('DOMAIN',preg_replace('/^www\./','',HOST));
			if(preg_match("/([a-z0-9\._\-]*)(\.)?".lz::$cf['domain']."(.*)/iU", HOST,$p))
			{
				define('SUB',$p[1]?$p[1]:'www');
			}
			elseif(!lz::$s=lz::h('cache')->get('domain_'.DOMAIN))
			{
				if(!lz::$s=lz::h('db')->getrow('select * from product_category where domain=?',array(DOMAIN)))
				{
					echo 'invalid domain';
					exit;
				}
				define('SUB',lz::$s['link']);
				define('MAPPING',DOMAIN);
				lz::h('cache')->set('domain_'.DOMAIN,lz::$s,0);
			}
			elseif(lz::$s)
			{
				define('SUB',lz::$s['link']);
				define('MAPPING',DOMAIN);
			}
			lz::$fu=($_SERVER['REQUEST_URI']?$_SERVER['REQUEST_URI']:$_SERVER['SCRIPT_NAME']);
			if(strstr(lz::$fu,'?')) lz::$f=substr(lz::$fu,0,strpos(lz::$fu,'?'));
			define('FILES',ROOT.'files/');
			define('URL',preg_match("/http:\/\/".HOST."(.*)/iU",lz::$fu,$path)?$path[3]:lz::$fu);
			lz::$fu=array_values(array_filter(array_map('urldecode',explode('/',substr(URL,strlen(HTTP))))));
			lz::$f=array_map('strtolower',lz::$fu);
			if(in_array(lz::$f[0],array('images','themes','css','files','handlers','js','templates','cache')))exit;
		}
	}
	public static function e($t,$m,$f,$l,$c)
	{
		while(@ob_end_clean());
		if(isset($_POST['ajax']))
		{			
			echo json_encode(array('f'=>array(array("a"=>"al",'v'=>'ERROR '.$t.': '.$m.', Line '.$l.' of '.$f))));
		}
		else
		{
			$template=lz::h('template');
			$template->assign(array('type'=>$t,'message'=>$m,'file'=>$f,'line'=>$l,'content'=>$c));
			$template->display('content.error','admin');
		}
		exit;
	}
	public static function set($n,$v)
 	{
		lz::h('db')->Execute('replace core set name=?,value=?',array($n,$v));
		lz::h('cache')->del('system_db_core');
	}
	public static function get()
 	{
		if(!lz::$c=lz::h('cache')->get('system_db_core'))
		{	
				lz::$c=array();
				if(is_array($v=lz::h('db')->GetAll('select value,name from core')))foreach($v as $k)lz::$c[$k['name']]=$k['value'];
				lz::h('cache')->set('system_db_core',lz::$c,0);
		}
	}
	public static function h($c,$n='default')
 	{
		if (empty(lz::$h[$c.'.'.$n]))
    	{
			require_once(HANDLERS.str_replace('.','/',$c).'.php');
			$_=str_replace('.','_',$c);
			lz::$h[$c.'.'.$n]=new $_($n);
		}
		return lz::$h[$c.'.'.$n];
	}
	
	public static function hook($f)
	{
		if(function_exists($f))call_user_func($f);
	}
	
	public static function move($u,$m=false)
	{
		if(isset($_POST['ajax']))
		{			
			echo json_encode(array('f'=>array(array("a"=>"js",'v'=>'window.location.href="'.$u.'";'))));
		}
		else
		{
			if($m)header('HTTP/1.1 301 Moved Permanently');
			header('Location: '.$u);
		}
		exit;
	}
}
$LightZr=new lz();
?>
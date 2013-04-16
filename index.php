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
require_once(dirname(__FILE__).'/handlers/lightzr.php');
define('QUERY',HTTP);
define('PATHMIN',HTTP.lz::$cf['pathmin'].'/');
if(lz::$f[0]==lz::$cf['pathmin'])
{
	lz::$t='admin';
	array_shift(lz::$f);
}
lz::get();
lz::h('session');
if(!lz::$t)lz::$t='www';
if(!lz::$c['zone'])lz::$c['zone']='com';

lz::hook('hook_index_loaded');
$template=lz::h('template');
$template->assign(lz::h(lz::$t)->get());
$template->display();	

if($_SERVER['HTTP_REFERER']&&lz::$c['referer'])
{
	$p=parse_url($_SERVER['HTTP_REFERER']);
	parse_str($p[ 'query' ],$s);
	if(isset($s['q'])&&strpos($p['host'],'google.')>-1)
	{
		lz::h('db')->Execute('replace referer set ip=?,refer=?,site=?,host=?,uri=?,ua=?,time=now()',array(strval($_SERVER['REMOTE_ADDR']),strval($_SERVER['HTTP_REFERER']),intval(lz::$s['id']),HOST,URL,strval($_SERVER['HTTP_USER_AGENT'])));	
	}
}

if(lz::$c['bot'])
{
	if (strstr($_SERVER['HTTP_USER_AGENT'], 'Googlebot'))
	{
		lz::h('db')->Execute('insert bot set host=?,ip=?,refer=?,bot=?,site=?,uri=?,ua=?,time=now()',array(HOST,strval($_SERVER['REMOTE_ADDR']),strval($_SERVER['HTTP_REFERER']),'Googlebot',intval(lz::$s['id']),URL,strval($_SERVER['HTTP_USER_AGENT'])));
	}
}
exit;
?>
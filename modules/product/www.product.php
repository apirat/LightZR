<?php
if(lz::$f[0]=='link')
{
	if($l=lz::h('db')->getrow('select * from link where link=?',array(lz::$f[1])))
	{
		if($l['url'])
		{
			lz::move(str_replace(array('{AWSTAG}','{HTTP}','{QUERY}'),array(lz::$c['awstag'],HTTP,QUERY),$l['url']));
		}
	}
	lz::move(QUERY);
}
elseif(is_numeric(lz::$f[0])&&preg_match('/^b0([a-z0-9]+)$/',lz::$f[1],$param)||preg_match('/^([0-9]{10})$/',lz::$f[1],$param))
{
	if($site=lz::h('db')->getrow('select id,domain from product_category where id=?',array(lz::$f[0])))
	{
		if($product=lz::h('db')->getrow('select asin,link from product where category=? and asin=?',array(lz::$f[0],lz::$f[0])))
		{
			if($site['domain'])
			{
				$purl='http://www.'.$site['domain'].QUERY.$product['link'].(lz::$c['pinfo']?'/'.lz::$c['pinfo']:'');
			}
			elseif(lz::$c['sub']==2)
			{
				$purl='http://'.$site['link'].'.'.lz::$cf['domain'].QUERY.$product['link'].(lz::$c['pinfo']?'/'.lz::$c['pinfo']:'');
			}
			elseif(lz::$c['sub']==1)
			{
				$purl='http://www.'.lz::$cf['domain'].QUERY.$product['link'].(lz::$c['pinfo']?'/'.lz::$c['pinfo']:'');
			}
			else
			{
				$purl='http://www.'.lz::$cf['domain'].QUERY.$site['link'].'/'.$product['link'].(lz::$c['pinfo']?'/'.lz::$c['pinfo']:'');
			}
			lz::move($purl);
		}
		else
		{
			if($site['domain'])
			{
				$purl='http://www.'.$site['domain'].QUERY;
			}
			elseif(lz::$c['sub']==2)
			{
				$purl='http://'.$site['link'].'.'.lz::$cf['domain'].QUERY;
			}
			else
			{
				$purl='http://www.'.lz::$cf['domain'].QUERY.$site['link'].'/';
			}
			lz::move($purl);
		}
	}
	else
	{
		lz::move('http://www.'.lz::$cf['domain'].QUERY);
	}
}
elseif(preg_match('/\-b0([a-z0-9]+)$/',lz::$f[1],$param)||preg_match('/\-([0-9]{10})$/',lz::$f[1],$param))
{
	define('PAGE','view');
	p_info(substr($param[0],1),lz::$f[2]);
	require_once(dirname(__FILE__).'/www.product.view.php');
}
elseif(preg_match('/\-b0([a-z0-9]+)$/',lz::$f[0],$param)||preg_match('/\-([0-9]{10})$/',lz::$f[0],$param))
{
	define('IN_FIRST_FOLDER',1);
	define('PAGE','view');
	p_info(substr($param[0],1),lz::$f[1]);
	require_once(dirname(__FILE__).'/www.product.view.php');
}
elseif(isset(lz::$s))
{
	define('PAGE','vlist');
	require_once(dirname(__FILE__).'/www.product.domain.php');
}
else
{
	define('PAGE','vlist');
	require_once(dirname(__FILE__).'/www.product.home.php');
}

function p_info($asin,$file)
{
	if($file==lz::$c['pinfo'])
	{
		return;
	}
	elseif($file==lz::$c['pcompare'])
	{
		header("Location: http://www.amazon.".lz::$c['zone']."/gp/offer-listing/".$asin."/?tag=".lz::$c['awstag']);		
	}
	elseif($file==lz::$c['preview'])
	{
		header("Location: http://www.amazon.".lz::$c['zone']."/review/product/".$asin."/?tag=".lz::$c['awstag']);		
	}
	elseif($file==lz::$c['pstore'])
	{
		if($url=lz::h('db')->GetOne("select p.url from product as p where p.asin=?",array($asin)))
		{
			header("Location: ".$url);
		}
		else
		{
			header("Location: http://www.amazon.".lz::$c['zone']."/gp/product/".$asin."/?tag=".lz::$c['awstag']);
		}
	}
	else
	{
		lz::move(QUERY,true);
	}
	if(lz::$c['click']&&strpos($_SERVER['HTTP_USER_AGENT'],'bot')===false)
	{
		lz::h('db')->Execute('replace click set asin=?,ip=?,ua=?,time=now()',array($asin,strval($_SERVER['REMOTE_ADDR']),strval($_SERVER['HTTP_USER_AGENT'])));
	}
	exit;
}
?>
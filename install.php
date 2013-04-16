<?php
header('Content-type: text/html; charset=utf-8');
define('DOMAIN',trim(strtolower(preg_replace('/^www\./','',$_SERVER['HTTP_HOST']))));
if($_POST)
{	
	if (!$con=@mysql_connect($_POST['hostname'],$_POST['username'],$_POST['password']))
	{
		$err2='ไม่สามารถติดต่อ MySQL ได้';
	}
	elseif(!@mysql_select_db($_POST['database'],$con))
	{
		$err2='ไม่สามารถเลือก Database ใน MySQL ได้';
	}
	elseif($fp = @fopen('handlers/config.php', 'wb')) 
	{
			@fwrite($fp, "<?php
	# domain
	\$config['domain']='".DOMAIN."';
	\$config['http']='".str_replace('install.php','',$_SERVER['SCRIPT_NAME'])."';
	
	# multi database
	\$config['db']['default']['hostname']='".$_POST['hostname']."';
	\$config['db']['default']['username']='".$_POST['username']."';
	\$config['db']['default']['password']='".$_POST['password']."';
	\$config['db']['default']['database']='".$_POST['database']."';
	\$config['db']['default']['type']='mysql';
	\$config['db']['default']['encode']='utf8';
	
	# Path Admin
	\$config['pathmin'] = 'admin';
	?>");
		@fclose($fp);
	
		require_once('handlers/lightzr.php');
		lz::$t='admin';
		$db=lz::h('db');
		$modules=array();
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
							if(!array_key_exists($dir,$modules))
							{
								require_once($file);
								if($module&&$module['name'])
								{
									$module['folder']=$dir;
									if(!$module['type'])$module['type']='module';
									if(is_array($module['category']))$module['cate']=implode(' - ',array_values($module['category']));
									$modules[$dir]=$module;
								}
							}
						}
					}
				}
				closedir($dh);
			}
		}
		
		$s = array();
		$c = array();
		$f = array();
		$order = array('home'=>1,'user'=>2,'module'=>3,'service'=>4,'pref'=>5,'style'=>6,'layout'=>7,'product'=>8);
		$o = array();
		foreach($modules as $k=>$v)
		{
			if($v['type']=='system')
			{
				$s[$k]=0;
			}
			elseif($v['type']=='module')
			{
				$s[$k]=1;
			}
			else
			{
				$s[$k]=2;
			}
			
			$f[$k]=$v['folder'];
			if(isset($order[$k]))
			{
				$o[$k]=$order[$k];
				$modules[$k]['install']=true;
			}
			else
			{
				$o[$k]=99;
			}
		}
		array_multisort($o, SORT_ASC, $s, SORT_ASC,  $f, SORT_ASC, SORT_STRING, $modules);

		foreach($modules as $folder=>$module)
		{
			lz::hook($folder.'_database');
			//install_module($folder);
		}
		
		require_once(MODULES.'module/admin.module.ajax.php');
		require_once(MODULES.'service/admin.service.ajax.php');
		foreach($modules as $folder=>$module)
		{
			install_service(install_module($module));
		}

		$email=trim($_POST['email']);
		$pass=md5(md5($_POST['pass']));
		$prefix=chr(rand(97,122)).substr(md5(rand(1,9999)),5,5);
		$ext=array('.html','.php','.htm','');
		shuffle($ext);
		$ext=implode('',array_slice($ext,0,1));
		
		$lang=array('ga','sv','fr','it');
		shuffle($lang);
		$lang1=implode(', ',array_slice($lang,0,rand(2,3))).', en';
		shuffle($lang);
		$lang2=implode(', ',array_slice($lang,0,rand(2,3))).', en';
		
		lz::set('version', VERSION);
		lz::set('bot', '1');
		lz::set('referer', '1');
		lz::set('click', '1');
		lz::set('sitename', DOMAIN);
		lz::set('title', '{SITENAME} - best cheap {PRODUCT}, Compare Prices and Shop Online for best cheap {PRODUCT}!');
		lz::set('description', 'Online Shopping with great {PRODUCT}, Compare prices and reviews for best cheap {PRODUCT}');
		lz::set('keywords', '{KEYWORDS}, review, amazon, discount, buy, compare, best, shop, review, cheap, directory, compare');
		lz::set('awskey', '');
		lz::set('awssecret', '');
		lz::set('awstag', '');
		lz::set('disclaimer', 'Online Shopping with great {PRODUCT}, Compare prices for best cheap {PRODUCT}, prices and reviews');
		lz::set('theme', 'lightzr');
		lz::set('antiindex', '0');
		lz::set('bldelay', '0');
		lz::set('meta', '');
		lz::set('order', 'title');
		lz::set('by', 'asc');
		lz::set('sub', '2');
		lz::set('homestar', '0');
		lz::set('homeprice', '1');
		lz::set('pddelay', '0');
		lz::set('cron', 'secret');
		lz::set('pgdelay', '0');
		lz::set('rrdelay', '0');
		lz::set('image', '0');
		lz::set('prefix', $prefix);
		lz::set('pinfo', 'prices'.$ext);
		lz::set('pstore', 'store'.$ext);
		lz::set('preview','review'.$ext);
		lz::set('pcompare', 'compare'.$ext);
		lz::set('fbappid', '');
		lz::set('fbappsecret', '');
		lz::set('feed', '0');
		lz::set('sitemap', '0');
		lz::set('rss', '0');
		lz::set('apdelay','0');
		lz::set('rwdelay','0');
		lz::set('aptype','0');
		lz::set('apdlang',$lang1);
		lz::set('aprlang',$lang2);
		lz::set('apping','0');
		lz::set('linkword', rand(3,6));
		lz::set('pgroup', 'Apparel, Automotive, Baby, Beauty, Blended, Books, Classical, DVD, Digital Music, Electronics, Gourmet Food, Grocery, Health Personal Care, Home & Garden, Industrial, Jewelry, Kindle Store, Kitchen, MP3 Downloads, Magazines, Merchants, Miscellaneous, Music, Music Tracks, Musical Instruments, Office Products, Outdoor Living, PC Hardware, Pet Supplies, Photo, Shoes, Silver Merchants, Software, Sporting Goods, Tools, Toys, Unbox Video, VHS, Video, Video Games, Watches, Wireless, Wireless Accessories');

		lz::$c['prefix']=$prefix;
		define('STYLEID','lightzr');
		require_once(MODULES.'style/admin.style.function.php');
		if(!$style=$db->getrow('select * from style where theme=?',array(STYLEID)))
		{
			restorefile();
		}
		savefile();
		if(!$db->getone('select count(id) from user'))
		{
			$db->Execute("INSERT INTO `user` (`id`, `email`, `password`, `username`, `display`, `time`, `lasttime`, `type`, `class`, `ip`, `ban`,`added`, `status`) VALUES (1, '$email', '$pass', 'lightzr', 'LightZr', now(), now(), 'sysop', 1, '".$_SERVER['REMOTE_ADDR']."', 'no', now(), 'confirm')");
		}
		$complete=true;	
	}
	else 
	{
		$err2='กรุณา chmod 0777 ไฟล์ handlers/config.php';
	}
}

?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>LightZr Amazon - Installer 3.0</title>
<style type="text/css">
body, dd, dl, dt, fieldset, form,div, h1, h2, h3, h4, h5, h6, li, ol, p, ul,hr {padding:0px;margin:0px;}
body,td,th,div,input,select,textarea { font-family: tahoma; font-size:12px; color:#333333; }
body{background:#E8E8E8; text-align:center}
a:visited, a:active, a:link{color:#696969;text-decoration:none;}
a:hover{text-decoration:underline;}
.clear { clear:both; }
img { border:none; }

#outter{ text-align:center; background:#d5d5d5; margin:20px auto; width:750px;padding:5px;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px}
#inner{ text-align:left; }
#content{ margin:0px 0px; background:#FFFFFF; text-align:left;}
#header{ background:#000000 url(static/images/logo.png) left top no-repeat; height:85px;}
#sh{background:url(static/images/bg_content.jpg) left top repeat-x; margin-top:1px; padding:20px 0px;}
.reset,.button,.submit {background-color:#E3E3E3;border-color:#EEEEEE #888888 #888888 #EEEEEE;border-style:solid;border-width:1px;color:#666666;font-size:12px;font-weight:bold;margin:0px; padding:3px 10px;overflow:visible;}
.submit{cursor:pointer; color:#000}
.tbox,.tboxerror{padding:3px;scrollbar-face-color: #dddddd;scrollbar-highlight-color: #ffffff;scrollbar-shadow-color: #dddddd;scrollbar-3dlight-color: #ddddddd;scrollbar-arrow-color: #c4c4c4;scrollbar-track-color: #f5f5f5;scrollbar-darkshadow-color: #c4c4c4;background-color: #F9F9F9;color:#333333;border-top:1px solid #c4c4c4; border-left:1px solid #c4c4c4; border-right:1px solid #f6f6f6; border-bottom:1px solid #f6f6f6;font-size:11px;}
.tb{background:#1A71B0; color:#ffffff; font-size:14px; padding:5px;}
.tbs{-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;; border:1px solid #bbb; padding:10px; margin:0px auto 0px; width:700px;}
</style>
</head>

<body>
<div id="outter">
<div id="inner">
<div id="content">
<div id="header"></div>
<div id="sh">
<form method="post" action="install.php">
<table cellpadding="5" cellspacing="1" border="0" align="center" class="tbs">
<tr><th colspan="2" align="center" class="tb">ระบบติดตั้ง LightZr Amazon Script v. 3.0+</th></tr>
<tr><td align="right">Domain:</td><td><?php echo DOMAIN?></td></tr>
<tr><td colspan="2"></td></tr>
<?php if($complete):?>
<tr><td colspan="2" style="background:#53A600; color:#FFF; font-weight:bold; text-align:center; font-size:20px">ติดตั้ง LightZr Amazon Script เรียบร้อยแล้ว</td></tr>
<tr><td colspan="2" align="center">กรุณาลบไฟล์ install.php ออกจากระบบ เพื่อป้องกันการติดตั้งซ้ำซ้อน<br><br><a href="admin">คลิกที่นี่</a> เพื่อไปยังระบบ Admin<br></td></tr>
<?php elseif($err):?>
<tr><td colspan="2" style="background:#F00; color:#FFF; font-weight:bold; text-align:center; font-size:20px"><?php echo $err?></td></tr>
<tr><td colspan="2"><br><br><br></td></tr>
<?php else:?>
<?php if($err2):?>
<tr><td colspan="2" style="background:#F00; color:#FFF; font-weight:bold; text-align:center; font-size:20px"><?php echo $err2?></td></tr>
<?php endif?>
<tr><td colspan="2" align="center" class="tb"><strong>ข้อมูลของ MySQL</strong></td></tr>
<tr><td align="right">MySQL Host:</td><td><input type="text" class="tbox" size="30" name="hostname" value="<?php echo $_POST['hostname']?$_POST['hostname']:'localhost'?>"></td></tr>
<tr><td align="right">MySQL Username:</td><td><input type="text" class="tbox" size="30" name="username" value="<?php echo $_POST['username']?$_POST['username']:''?>"></td></tr>
<tr><td align="right">MySQL Password:</td><td><input type="text" class="tbox" size="30" name="password" value="<?php echo $_POST['password']?$_POST['password']:''?>"></td></tr>
<tr><td align="right">MySQL Database:</td><td><input type="text" class="tbox" size="30" name="database" value="<?php echo $_POST['database']?$_POST['database']:''?>"></td></tr>
<tr><td colspan="2"></td></tr>
<tr><td colspan="2" align="center" class="tb"><strong>ข้อมูลสำหรับจัดการภายในระบบ Admin</strong></td></tr>
<tr><td align="right">Email สำหรับระบบ Admin:</td><td><input type="text" class="tbox" size="30" name="email" value="<?php echo $_POST['email']?$_POST['email']:''?>"> (ใช้สำหรับล็อคอิน)</td></tr>
<tr><td align="right">Password สำหรับระบบ Admin:</td><td><input type="text" class="tbox" size="30" name="pass" value="<?php echo $_POST['pass']?$_POST['pass']:''?>"> (ใช้สำหรับล็อคอิน)</td></tr>
<tr><td colspan="2"></td></tr>
<tr><td colspan="2" align="center"><input type="submit" class="submit" value=" ติดตั้ง "></td></tr>
<?php endif?>
 </table>
 </form>
 </div>
</div>
</div>
</div>
</body>
</html>
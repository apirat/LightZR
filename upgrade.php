<?php



header('Content-type: text/html; charset=utf-8');

require_once('handlers/lightzr.php');			
lz::get();

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
}
require_once(MODULES.'module/admin.module.ajax.php');
require_once(MODULES.'service/admin.service.ajax.php');
foreach($modules as $folder=>$module)
{
	install_service(install_module($module));
}

if(!lz::$c['version'])
{
	$r=$db->getall("select price,saleprice,minvar,maxvar,minprice,maxprice,asin,category from product  ");
	for($i=0;$i<count($r);$i++)
	{
		$rs=$r[$i];
		$db->execute("update product set 
				pricef='\$".cut00($rs['price'])."',
				salepricef='\$".cut00($rs['saleprice'])."',
				minvarf='\$".cut00($rs['minvar'])."',
				maxvarf='\$".cut00($rs['maxvar'])."',
				minpricef='\$".cut00($rs['minprice'])."',
				maxpricef='\$".cut00($rs['maxprice'])."'
				where asin='".$rs['asin']."' and category='".$rs['category']."';");
		}
	}
	_cleanDir('cache/');

lz::set('version',VERSION);


function cut00($d)
{
	$v=strval(number_format(intval($d)/100,2));
	if(substr($v,-2)=='.00')$v=substr($v,0,-3);
	return $v;
}

 function _unlink($file)
{
	return (file_exists(ROOT.$file)&&!@unlink(ROOT.$file))?false:true;
}
 function _cleanDir($dir)
{
	if (!is_dir(ROOT.$dir)||!($dh=@opendir(ROOT.$dir))) return;
	$result=true;
	while($file=readdir($dh))
	{
		if(!in_array($file,array('.','..')))
		{
			$file2=$dir.$file;
			if(is_dir(ROOT.$file2))
			{
				_cleanDir($file2.'/');
			}
			else
			{
				if(substr($file,-10)=='.cache.php'&&is_file(ROOT.$file2)) $result=($result&&(_unlink($file2)));
			}
		}
	}
	return false;
}
?>


<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>LightZr Amazon - Installer 1.0</title>
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
#header{ background:#000000 url(images/admin/logo.png) left top no-repeat; height:85px;}
#sh{background:url(images/admin/bg_content.jpg) left top repeat-x; margin-top:1px; padding:20px 0px}
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
<tr><th colspan="2" align="center" class="tb">ระบบ Upgrade LightZr Amazon Script</th></tr>
<tr><td align="right">Domain:</td><td><?php echo DOMAIN?></td></tr>
<tr><td colspan="2"></td></tr>
<?php if(!$err):?>
<tr><td colspan="2" style="background:#53A600; color:#FFF; font-weight:bold; text-align:center; font-size:20px">Upgrade LightZr Amazon Script เรียบร้อยแล้ว</td></tr>
<tr><td colspan="2" align="center"><br><br><a href="admin">คลิกที่นี่</a> เพื่อไปยังระบบ Admin<br></td></tr>
<?php else:?>
<tr><td colspan="2" style="background:#F00; color:#FFF; font-weight:bold; text-align:center; font-size:20px"><?php echo $err?></td></tr>
<tr><td colspan="2"><br><br><br></td></tr>
<?php endif?>
 </table>
 </form>
 </div>
</div>
</div>
</div>
</body>
</html>
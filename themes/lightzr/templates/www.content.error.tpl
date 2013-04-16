<!DOCTYPE html>
<html xmlns="HTTP://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />	
<title>LightZr Engine - Error! - License: <?php echo LICENSE?></title>	
<link rel="stylesheet" type="text/css" href="<?php echo HTTP?>themes/lightzr/css/error.css" />
</head>
<body>
<div id="outter">
<div id="header"></div>
<div class="border"></div>
<div id="inner">
<div id="content">
<div style="padding:5px 5px;">
<h1 id="error">LightZr Engine - Error!</h1>
<div id="detail">
<strong>Domain</strong>: <?php echo HOST?><br />
<strong>Type</strong>: <?php echo $this->type?><br />
<strong>Fail</strong>: <?php echo $this->message?><br />
<strong>Code</strong>: line <?php echo $this->line?> ในไฟล์ <?php echo $this->file?>


<?php if(defined('ERROR_RELOAD')):?>
<div style="text-align:center; padding:10px; border:1px solid #ccc">
ระบบจะทำการรีโหลดข้อมูลใหม่อีกครั้ง<br />
กรุณารอซักครู่  (<span id="rec">5</span>)
<script>
var wt=5,tmw;
function rec()
{
	clearTimeout(tmw);
	wt-=1;
	document.getElementById('rec').innerHTML=wt;
	if(wt>0)
	{
		tmw=setTimeout('rec()',1000);
	}
	else
	{
		top.location.href='<?php echo URL?>';	
	}
}
rec();
</script>
</div>
<?php endif?>
</div>
</div>
<div align="center"><a href="/"><strong>Home</strong></a> | <a href="/"><strong><?php echo lz::$s['title']?></strong></a></div>
</div></div>
<div class="border"></div>
</div>
</body>
</html>

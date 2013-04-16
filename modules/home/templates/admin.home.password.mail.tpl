<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>{HOST}</title>
<style type="text/css">
dd, dl, dt, fieldset, form, h1, h2, h3, h4, h5, h6, li, ol, p, ul,hr {padding:0px;margin:0px;}
h1{ font-size:20px;}
h2{font-size:16px;}
h3{font-size:14px;}
h4{font-size:12px;}
small{font-size:11px; font-weight:normal;}
h1,h2,h3,h3,h4,div{line-height:1.6em;}
body {background:#666666; text-align:center; padding:20px;}
body,td,th{font-family:Tahoma,"MS Sans Serif";font-size:12px;color:#666666;text-decoration:none;}
a:visited, a:active, a:link{color:#000000;text-decoration:none;}
a:hover{background:#000000; color:#FFFFFF;}
img {border:transparent 0px;}
</style>
</head>
<body>
<div align="center">
<div style="width:700px; padding:10px;border:3px solid #CCCCCC;background:#FFFFFF; text-align:left">
<h1 style="color:#3399CC; padding:5px; margin:5px;"><?php echo DOMAIN?></h1>
<div style="border:1px dashed #CCCCCC; background:#FFFFFF; padding:10px;">
<h2 align="center" style="color:#000000">ข้อมูลรหัสผ่านใหม่</h2><br>
<div style="border:1px dashed #CCCCCC; background:#F5F5F5; padding:10px;">
<b>ชื่อสมาชิก</b>: &nbsp; <?php echo $this->site['firstname']?> <?php echo $this->site['lastname']?><br />
<b>ชื่อในการแสดงผล</b>: &nbsp; <?php echo $this->site['display']?><br /><br />
<b>อีเมลล์</b>: &nbsp; <?php echo $this->site['email']?> (ใช้ในการล็อคอิน)<br />
<b>รหัสผ่าน</b>: &nbsp; <?php echo $this->site['password_new']?><br />
<br />
<h3 style="color:#3399CC; padding:5px; margin:5px; border-top:1px dashed #CCCCCC">ขอบคุณที่ใช้บริการ<br>
<a href="http://www.phukettech.com"><?php echo DOMAIN?></a></h3>
</div>
</div>
</div>
</div>
</body>
</html>

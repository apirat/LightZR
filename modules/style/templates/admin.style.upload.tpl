<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo HTTP?>css/admin.css" rel="stylesheet" type="text/css" />
</head>

<body style="background:url(<?php echo HTTP?>static/images/loading.gif) center 45px no-repeat">
<form method="post" enctype="multipart/form-data" action="<?php echo URL?>" onsubmit="this.style.display='none'">
<br />
<br />
<table cellpadding="2" cellspacing="1" border="0" width="100%" bgcolor="#FFFFFF">
<tr><th colspan="2" align="center">อัพโหลดรูปภาพ</th></tr>
<tr><th align="right" width="100">ไฟล์:</th><td><input type="file" class="tbox" size="20" name="upfile" /></td></tr>
<tr><th align="right" width="100">&nbsp;</th><td><input type="submit" value=" อัพโหลด " class="submit" /> <input type="button" value=" ยกเลิก " class="button" onclick="window.parent.lz.box.close();" />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
</td></tr>
</table>
</form>
</body>
</html>
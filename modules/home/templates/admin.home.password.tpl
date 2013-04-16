<form action="<?php echo URL?>" method="post" onSubmit="ajax_password(this);setbox('');return false;">
<table cellpadding="5" cellspacing="1" border="0" width="100%" class="tbservice">
<tr><th align="center" colspan="2">เปลี่ยนรหัสผ่าน</th></tr>
<tr><td width="45%" valign="top" align="right">รหัสผ่านเดิม</td><td><input type="password" name="password_old" class="tbox password" /></td></tr>
<tr><td width="45%" valign="top" align="right">รหัสผ่านใหม่</td><td><input type="password" name="password_new" class="tbox password" /></td></tr>
<tr><td width="45%" valign="top" align="right">ยืนยันรหัสใหม่</td><td><input type="password" name="password_confirm" class="tbox password" /></td></tr>
<tr><td colspan="2" align="center"><input type="submit" class="submit" value=" บันทึก " />  <input type="button" class="button" value=" ยกเลิก " onClick="setbox('')" /></td></tr>
<tr><td colspan="2" align="center"><br /><br />* ระบบจะทำการส่งข้อมููลการแก้ไขไปยังอีเมลล์ของท่านอีกครั้ง</td></tr>
</table>
</form>
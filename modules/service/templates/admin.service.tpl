<div id="seticon" class="setview">
<h2>เปลี่ยน Icon</h2>
<div style="margin:10px; text-align:center; width:380px; height:160px; overflow:auto">
<?php for($i=0;$i<count($this->icon);$i++):?>
<a href="javascript:;" onclick="seticon('<?php echo $this->icon[$i]?>')" style="margin:3px; padding:5px;"><img src="<?php echo HTTP?>static/images/menu/<?php echo $this->icon[$i]?>32.gif" /></a>
<?php endfor?><br />
<a href="javascript:;" onclick="seticon('')">ใช้ค่าเริ่มต้น</a>
</div>
</div>
<input type="hidden" id="service_icon" value="" />
<div id="newservice" class="setview" style="width:400px">
<h2>เพิ่มหน้าเว็บใหม่</h2>
<form id="log" method="post" onsubmit="ajax_createpage(this);lz.box.close();return false;">
<table cellpadding="5" cellspacing="1" border="0" width="100%">
<tr><td align="right" width="100"><b>ชื่อหน้าเว็บ</b>:</td><td><input type="text" name="name" size="30" class="tbox"></td></tr>
<tr><td align="right" valign="top"><b>ชื่อไฟล์</b>:</td><td><input type="text" name="url" size="30" class="tbox"><br />เช่น mypage, mypage.html, mypage.xml, หน้าเว็บของฉัน, หน้าเว็บของฉัน.html, ... (ห้ามใช้อักษรพิเศษ)</td></tr>
<tr><td></td><td><input type="submit" class="submit" value=" สร้าง "> <input type="button" class="button" value=" ยกเลิก " onclick="lz.box.close()"></td></tr>
</table>
</form>
</div>
<script type="text/javascript">
function showicon(a){$('#service_icon').val(a);lz.box.open('#seticon');}
function seticon(a){ajax_seticon($('#service_icon').val(),a);lz.box.close();}
function uninstall(a){if(confirm('ระบบจะลบข้อมูลในระบบบริการนี้ทั้งหมด คุณต้องการดำเนินการต่อไปหรือไม่'))ajax_suninstall(a)}
</script>
<div id="services"><?php echo $this->services?></div>
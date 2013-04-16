<h2>ตั้งค่าการแสดงผล</h2>
<form action="<?php echo URL?>" method="post" onSubmit="ajax_setoption(<?php echo $this->box?>,this);lz.box.close();return false;">
<table cellpadding="5"  cellspacing="5" border="0">
<tr><td align="right">จำนวนวิดีโอที่จะแสดง</td><td><input type="text" class="tbox" name="amount" value="<?php echo $this->val['amount']>0?$this->val['amount']:1?>"></td></tr>
<tr><td align="right">ความกว้างของวิดีโอ</td><td><input type="text" class="tbox" name="width" value="<?php echo $this->val['width']>0?$this->val['width']:300?>"></td></tr>
<tr><td align="right">ความสูงของวิดีโอ</td><td><input type="text" class="tbox" name="height" value="<?php echo $this->val['height']>0?$this->val['height']:230?>"></td></tr>
<tr><td align="right">ไอดีของวิดีโอที่แสดงในหน้าแรกโดเมน</td><td><input type="text" class="tbox" name="default" value="<?php echo $this->val['default']?>"></td></tr>
</table>
<div align="center"><input type="submit" class="submit" value=" บันทึก " />  <input type="button" class="button" value=" ยกเลิก " onClick="lz.box.close()" /></div><br>
<br>
* ระบบจะดึง video ด้วยคีย์เวิร์ดสินค้ามาแสดงในแต่ละ sub โดยอัตโนมัติ
</form>
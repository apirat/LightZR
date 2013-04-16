<h2>ตั้งค่าการแสดงผล</h2>
<form action="<?php echo URL?>" method="post" onSubmit="ajax_setoption(<?php echo $this->box?>,this);lz.box.close();return false;">
<table cellpadding="5"  cellspacing="5" border="0">
<tr><td align="right">จำนวนครั้งในการค้นหาขั้นต่ำที่จะให้แสดง</td><td><input type="text" class="tbox" name="amount" value="<?php echo $this->val['amount']>0?$this->val['amount']:5?>"></td></tr>
<tr><td align="right">จำนวนคีย์เวิร์ดที่จะแสดง</td><td><input type="text" class="tbox" name="count" value="<?php echo $this->val['count']>0?$this->val['count']:5?>"></td></tr>
</table>
<div align="center"><input type="submit" class="submit" value=" บันทึก " />  <input type="button" class="button" value=" ยกเลิก " onClick="lz.box.close()" /></div>
</form>
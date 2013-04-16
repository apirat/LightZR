<h2>ตั้งค่าการแสดงผล</h2>
<form action="<?php echo URL?>" method="post" onSubmit="ajax_setoption(<?php echo $this->box?>,this);lz.box.close();return false;">
<table cellpadding="5"  cellspacing="5" border="0">
<tr><td align="right">จำนวนที่จะแสดงผล</td><td><input type="text" class="tbox" name="amount" value="<?php echo $this->val['amount']>0?$this->val['amount']:0?>"></td></tr>
</table>
<div align="center"><input type="submit" class="submit" value=" บันทึก " />  <input type="button" class="button" value=" ยกเลิก " onClick="lz.box.close()" /></div>
</form>
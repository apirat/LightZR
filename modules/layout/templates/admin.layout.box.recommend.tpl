<h2>ตั้งค่าการแสดงผล</h2>
<form action="<?php echo URL?>" method="post" onSubmit="ajax_setoption(<?php echo $this->box?>,this);lz.box.close();return false;">
<table cellpadding="5"  cellspacing="5" border="0">
<tr><td align="right">จำนวนสินค้าแนะนำ</td><td><input type="text" class="tbox" name="count" value="<?php echo $this->val['count']>0?$this->val['count']:6?>"></td></tr>
</table>
<div align="center"><input type="submit" class="submit" value=" บันทึก " />  <input type="button" class="button" value=" ยกเลิก " onClick="lz.box.close()" /></div>
</form>
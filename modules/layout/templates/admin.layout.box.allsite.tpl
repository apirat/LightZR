<h2>ตั้งค่าการแสดงผล</h2>
<form action="<?php echo URL?>" method="post" onSubmit="ajax_setoption(<?php echo $this->box?>,this);lz.box.close();return false;">
<table cellpadding="5"  cellspacing="5" border="0">
<tr><td align="right">จำนวน sub ที่แสดงในหน้าแรกของโดเมน</td><td><input type="text" class="tbox" name="home" value="<?php echo $this->val['home']>0?$this->val['home']:40?>"></td></tr>
<tr><td align="right">จำนวน sub ที่แสดงในหน้าอื่นๆ</td><td><input type="text" class="tbox" name="more" value="<?php echo $this->val['more']>0?$this->val['more']:20?>"></td></tr>
</table>
<div align="center"><input type="submit" class="submit" value=" บันทึก " />  <input type="button" class="button" value=" ยกเลิก " onClick="lz.box.close()" /></div>
</form>
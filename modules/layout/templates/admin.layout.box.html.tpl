<h2>โค๊ด</h2>
<form action="<?php echo URL?>" method="post" onSubmit="ajax_setoption(<?php echo $this->box?>,this);lz.box.close();return false;">
<textarea class="tbox" style="width:500px; height:150px" name="html"><?php echo $this->val?></textarea>
<div align="center"><input type="submit" class="submit" value=" บันทึก " />  <input type="button" class="button" value=" ยกเลิก " onClick="lz.box.close()" /></div>
</form>
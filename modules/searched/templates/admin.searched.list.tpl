<div id="barsearch" align="right">ผลลัพธ์ <?php echo number_format($this->count)?> รายการ</div>
<div style="padding:5px;">
<table cellpadding="5" cellspacing="1" border="0" width="100%" class="tbservice">
<tr align="center">
<?php foreach($this->allorder as $key=>$val):?>
<th> &nbsp; <?php echo $val?> <?php if($this->order!=$key||$this->by!='asc'):?><a href="javascript:;" onClick="order('<?php echo $key?>','asc');return false" class="order"><img src="<?php echo IMAGES?>asc.gif" /></a><?php endif?><?php if($this->order!=$key||$this->by!='desc'):?><a href="javascript:;" onClick="order('<?php echo $key?>','desc');return false" class="order"><img src="<?php echo IMAGES?>desc.gif" /></a><?php endif?></th>
<?php endforeach?>
<th>&nbsp;</th>
    </tr>
<?php for($i=0;$i<count($this->searched);$i++):?>
<tr align="center">
<?php foreach($this->allorder as $key=>$val):?>
<td class="tab_<?php echo $key?>"><?php echo $this->searched[$i][$key]?></td>
<?php endforeach?>
<td width="20"><a href="javascript:;" onClick="del('<?php echo $this->searched[$i]['id']?>')"><img src="<?php echo IMAGES?>del.gif"></a></td>
   </tr>
<?php endfor?>
</table></div><br /><?php echo $this->pager?><br />

<?php echo lz::h('setview')->popup()?>

<div id="newkeyword" class="setview">
<h2>เพิ่มหมวดใหม่</h2>
<div style="margin:10px; text-align:left; width:500px;">
<form method="post" onsubmit="ajax_newkeyword(this);lz.box.close();return false;">
<table cellpadding="0" cellspacing="5" border="0" align="center">
<tr><td colspan="2" align="center"><textarea class="tbox" name="keyword" style="width:480px; height:150px"></textarea><p align="left">หนึ่งบรรทัดต่อ 1 คีย์เวิร์ด</p></td></tr>
<tr><td colspan="2" align="center"><input type="submit" class="submit" value=" บันทึก " /> <input type="button" class="button" value=" ยกเลิก " onClick="lz.box.close()" /></td></tr>
</table>
</form>
</div>
</div>
<div id="barsearch" align="right"><div style="float:left; margin:5px">ผลลัพธ์ <?php echo number_format($this->count)?> รายการ</div>
<form onSubmit="search2();return false">ค้นหา <input type="text" id="search" class="tbox" value="<?php echo $this->search?>" size="15" /> เรียงโดย <select id="order"  class="tbox"><?php foreach($this->allorder as $key=>$value){?><option value="<?php echo $key?>" <?php echo $this->order==$key?'selected=\'selected\'':''?>><?php echo $value?></option><?php }?></select> จาก <select id="by" class="tbox"><?php foreach($this->allby as $key=>$value){?><option value="<?php echo $key?>" <?php echo $this->by==$key?'selected=\'selected\'':''?>><?php echo $value?></option><?php }?></select><input type="submit" id="find" value="" /></form>
</div>


<div style="padding:5px;">
<table cellpadding="5" cellspacing="1" border="0" width="100%" class="tbservice">
<tr align="center">
<?php foreach($this->allorder as $key=>$val):?>
<th> &nbsp; <?php echo $val?> <?php if($this->order!=$key||$this->by!='asc'):?><a href="javascript:;" onClick="order('<?php echo $key?>','asc');return false" class="order"><img src="<?php echo HTTP?>static/images/asc.gif" /></a><?php endif?><?php if($this->order!=$key||$this->by!='desc'):?><a href="javascript:;" onClick="order('<?php echo $key?>','desc');return false" class="order"><img src="<?php echo HTTP?>static/images/desc.gif" /></a><?php endif?></th>
<?php endforeach?>
<th width="120">&nbsp;</th>
</tr>
<?php for($i=0;$i<count($this->keyword);$i++):?>
<tr align="center">

<?php foreach($this->allorder as $key=>$val):?>
<?php if($key=='id'):?>
<td width="30"><?php echo $this->keyword[$i]['id']?></td>
<?php elseif(in_array($key,array('amount'))):?>
<td width="170"><?php echo $this->keyword[$i]['amount']?number_format($this->keyword[$i]['amount']):''?></td>
<?php elseif(in_array($key,array('lastupdate'))):?>
<td class="tab_<?php echo $key?>"><?php echo time::show($this->keyword[$i][$key],'datetime')?></td>
<?php else:?>
<td class="tab_<?php echo $key?>"><?php echo $this->keyword[$i][$key]?></td>
<?php endif?>

<?php endforeach?>

<td width="120">
    <a href="javascript:;" title="ลบ" onClick="if(confirm('คุณต้องการลบคีย์เวิร์ดนี้หรือไม่'))ajax_del('<?php echo $this->keyword[$i]['id']?>')"><img src="<?php echo HTTP?>static/images/delete.gif" alt="ลบหมวด" /></a>
</td>
   </tr>
<?php endfor?>
<?php if(!count($this->keyword)):?>
<tr><td colspan="<?php echo count($this->allorder)+1?>" align="center" valign="middle" height="100">ไม่มีข้อมูล</td></tr>

<?php endif?>
</table></div>
<div style="margin:5px"><?php echo $this->pager?></div>

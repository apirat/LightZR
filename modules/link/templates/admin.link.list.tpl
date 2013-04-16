<div id="newlink" class="setview">
<h2>เพิ่มลิ้งค์ใหม่</h2>
<div style="margin:10px; text-align:left; width:500px;">
<form method="post" onsubmit="ajax_newlink(this);lz.box.close();return false;">
<table cellpadding="5" cellspacing="5" border="0" align="center">
<tr><td align="right" width="100">Link</td><td>http://www.<?php echo lz::$cf['domain'].QUERY?>link/<input type="text" name="link" size="18" class="tbox" /></td></tr>
<tr><td align="right" width="100">URL ปลายทาง</td><td><input type="text" name="url" size="60" class="tbox" value="http://" /></td></tr>
<tr><td colspan="2" align="center"><input type="submit" class="submit" value=" บันทึก " /> <input type="button" class="button" value=" ยกเลิก " onClick="lz.box.close()" /></td></tr>
</table>
</form>
</div>
</div>
<div id="barsearch" align="right"><div style="float:left; margin:5px">ผลลัพธ์ <?php echo number_format($this->count)?> รายการ
</div><form onSubmit="search2();return false">ค้นหา <input type="text" id="search" class="tbox" value="<?php echo $this->search?>" size="15" /> เรียงโดย <select id="order"  class="tbox"><?php foreach($this->allorder as $key=>$value){?><option value="<?php echo $key?>" <?php echo $this->order==$key?'selected=\'selected\'':''?>><?php echo $value?></option><?php }?></select> จาก <select id="by" class="tbox"><?php foreach($this->allby as $key=>$value){?><option value="<?php echo $key?>" <?php echo $this->by==$key?'selected=\'selected\'':''?>><?php echo $value?></option><?php }?></select><input type="submit" id="find" value="" /></form></div>
<div style="padding:5px;">
<table cellpadding="5" cellspacing="1" border="0" width="100%" class="tbservice">
<tr align="center">
<?php foreach($this->allorder as $key=>$val):?>
<th> &nbsp; <?php echo $val?> <?php if($this->order!=$key||$this->by!='asc'):?><a href="javascript:;" onClick="order('<?php echo $key?>','asc');return false" class="order"><img src="<?php echo HTTP?>static/images/asc.gif" /></a><?php endif?><?php if($this->order!=$key||$this->by!='desc'):?><a href="javascript:;" onClick="order('<?php echo $key?>','desc');return false" class="order"><img src="<?php echo HTTP?>static/images/desc.gif" /></a><?php endif?></th>
<?php endforeach?>
<th>&nbsp;</th>
    </tr>
<?php for($i=0;$i<count($this->link);$i++):?>
<tr align="center">
<?php foreach($this->allorder as $key=>$val):?>
<?php if($key=='link'):?>
<?php echo $this->html->td('link_link_'.$this->link[$i]['id'],$this->link[$i]['link'],'input',array('text1'=>'http://www.'.lz::$cf['domain'].QUERY.'link/'))?>
<?php elseif($key=='url'):?>
<?php echo $this->html->td('link_url_'.$this->link[$i]['id'],$this->link[$i]['url'],'input',array('full'=>true))?>
<?php else:?>
<td class="tab_<?php echo $key?>"><?php echo $this->link[$i][$key]?></td>
<?php endif?>
<?php endforeach?>
<td width="20"><a href="javascript:;" onClick="del(<?php echo $this->link[$i]['id']?>)"><img src="<?php echo HTTP?>static/images/del.gif"></a></td>
   </tr>
<?php endfor?>
</table></div><br /><?php echo $this->pager?><br />

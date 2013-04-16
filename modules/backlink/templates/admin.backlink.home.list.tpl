<div id="newblog" class="setview">
<h2>เพิ่มบล็อกใหม่ (Wordpress)</h2>
<div style="margin:10px; text-align:left; width:350px;">
<form method="post" onsubmit="ajax_newblog(this);lz.box.close();return false;">
<table cellpadding="5" cellspacing="5" border="0" align="center">
<tr><td align="right" width="100">URL</td><td><input type="text" name="blogid" size="50" class="tbox" /></td></tr>
<tr><td align="right" width="100">Username</td><td><input type="text" name="email" size="30" class="tbox" /></td></tr>
<tr><td align="right" width="100">Password</td><td><input type="text" name="password" size="30" class="tbox" /></td></tr>
<tr><td colspan="2" align="center"><input type="submit" class="submit" value=" บันทึก " /> <input type="button" class="button" value=" ยกเลิก " onClick="lz.box.close()" /></td></tr>
</table>
</form>
</div>
</div>
<div id="newblogs" class="setview">
<h2>เพิ่มบล็อกใหม่ (Wordpress)</h2>
<div style="margin:10px; text-align:left; width:450px;">
<form method="post" onsubmit="ajax_newblogs(this);lz.box.close();return false;">
<table cellpadding="0" cellspacing="5" border="0" align="center">
<tr><td colspan="2" align="center"><textarea class="tbox" name="blogs" style="width:430px; height:150px"></textarea><p align="left">url, username, password<br>หนึ่งบรรทัดต่อบล็อก และใช้ , คั่นระหว่างข้อมูล</p></td></tr>
<tr><td colspan="2" align="center"><input type="submit" class="submit" value=" บันทึก " /> <input type="button" class="button" value=" ยกเลิก " onClick="lz.box.close()" /></td></tr>
</table>
</form>
</div>
</div>
<ul class="tabs" style="text-align: left; margin-bottom: 3px;">
<li class="on"><a href="<?php echo PATHMIN.SERVICE_LINK?>">บล็อกทั้งหมด</a></li>
<li><a href="<?php echo PATHMIN.SERVICE_LINK?>/post">รายงานการโพสแบ็คลิ้งค์ทั้งหมด</a></li>
<li><a href="<?php echo PATHMIN.SERVICE_LINK?>/category">หมวดสินค้า</a></li>
</ul>

<div id="barsearch" align="right"><div style="float:left; margin:5px">ผลลัพธ์ <?php echo number_format($this->count)?> รายการ</div></div>
<div style="padding:5px;">
<table cellpadding="5" cellspacing="1" border="0" width="100%" class="tbservice">
<tr align="center">
<?php foreach($this->allorder as $key=>$val):?>
<th> &nbsp; <?php echo $val?> <?php if($this->order!=$key||$this->by!='asc'):?><a href="javascript:;" onClick="order('<?php echo $key?>','asc');return false" class="order"><img src="<?php echo HTTP?>static/images/asc.gif" /></a><?php endif?><?php if($this->order!=$key||$this->by!='desc'):?><a href="javascript:;" onClick="order('<?php echo $key?>','desc');return false" class="order"><img src="<?php echo HTTP?>static/images/desc.gif" /></a><?php endif?></th>
<?php endforeach?>
<th>&nbsp;</th>
    </tr>
<?php for($i=0;$i<count($this->blog);$i++):?>
<tr align="center">
<?php foreach($this->allorder as $key=>$val):?>
<?php if($key=='blogid'):?>
<?php echo $this->html->td('blog_'.$key.'_'.$this->blog[$i]['id'],$this->blog[$i][$key],'input',array('class'=>'tab_title'))?>
<?php elseif(in_array($key,array('lastpost'))):?>
<td class="tab_<?php echo $key?>"><?php echo time::show($this->blog[$i][$key],'datetime')?></td>
<?php else:?>
<?php echo $this->html->td('blog_'.$key.'_'.$this->blog[$i]['id'],$this->blog[$i][$key],'input',array('class'=>'tab_'.$key))?>
<?php endif?>
<?php endforeach?>
<td width="40"><a href="<?php echo $this->blog[$i]['blogid']?>" target="_blank"><img src="<?php echo HTTP?>static/images/view.gif"></a> <a href="javascript:" onClick="if(confirm('คุณต้องการลบบล็อกนี้หรือไม่'))ajax_delblog(<?php echo $this->blog[$i]['id']?>)"><img src="<?php echo HTTP?>static/images/delete.gif"></a></td>
   </tr>
<?php endfor?>
</table></div><br /><?php echo $this->pager?><br />

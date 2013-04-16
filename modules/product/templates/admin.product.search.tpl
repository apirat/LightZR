
<div style="padding:5px;">
<h2><?php echo $this->category['title']?></h2>
ค้นพบ <?php echo $this->item['TotalResults']?> รายการ จาก <?php echo $this->item['TotalPages']?> หน้า
<?php if($this->error):?>
<div style="text-align:center; padding:10px; border:1px solid #FFC1C1; background:#FFF2F2; line-height:2.0em">
<b>เกิดความผิดพลาดในการค้นหา</b><br />
<?php echo $this->error?>
<?php if($this->auto==2):?>
<script>var lasin;setTimeout(function(){top.location.href='<?php echo PATHMIN.SERVICE_LINK.'/'.($this->category['id']+1).'/auto/'.$this->auto?>';},5000);</script>
<?php endif?>
</div>
<?php elseif(!$this->item):?>
<div style="text-align:center; padding:10px; border:1px solid #FFC1C1; background:#FFF2F2; line-height:2.0em">
<b>เกิดความผิดพลาดในการค้นหา</b><br />
กรุณารอซักครู่ ระบบจะทำการค้นใหม่อีกครั้งโดยอัตโนมัติ (<span id="rec">10</span>)
<script>
var wt=<?php echo $this->delay['error']?>,lasin,tmw;
function rec()
{
	clearTimeout(tmw);
	wt-=1;
	$('#rec').html(wt);
	if(wt>0)
	{
		tmw=setTimeout('rec()',1000);
	}
	else
	{
		top.location.href='<?php echo URL?>';	
	}
}
</script>
</div>
<?php elseif($this->auto):?>
<div style="text-align:center; padding:10px; border:1px solid #FFCEB7; background:#FFF7F2" id="showrec">
<?php if(lz::$c['zone']=='com'):?>ระบบกำลังดึงข้อมูล rating / review โดยอัตโนมัติ<br /><?php endif?>
กรุณารอซักครู่  (<span id="rec">5</span>)
<script>
var wt=<?php echo $this->delay['rating']?>,lasin,tmw,curavg=0;
function rec()
{
	clearTimeout(tmw);
	wt-=1;
	$('#rec').html(wt);
	if(wt>0)
	{
		tmw=setTimeout('rec()',1000);
	}
	else if(curavg < lasin)
	{
		ajax_avg($('#avg'+curavg).attr('asin'));
		$('#avg'+curavg).html('- <a href="javascript:;" onclick="ajax_avg($(\'#avg'+curavg+'\').attr(\'asin\'));">กำลังโหลดข้อมูล</a> -');
	}
	else
	{
		<?php if($this->page<$this->category['maxpage'] && $this->page<$this->item['TotalPages']):?>
		top.location.href='<?php echo PATHMIN.SERVICE_LINK.'/'.$this->category['id'].'/page/'.($this->page+1).'/auto/'.$this->auto?>';
		<?php elseif($this->auto==2):?>
		top.location.href='<?php echo PATHMIN.SERVICE_LINK.'/'.($this->category['id']+1).'/auto/'.$this->auto?>';
		<?php else:?>
		$('#showrec').css({display:'none'});
		$('#gcompl').css({display:'block'});
		<?php endif?>
	}
}
</script>
</div>
<?php endif?>

<div style="text-align:center; padding:10px; border:1px solid #DCFFB9; background:#FAFFF4; display:none; margin-bottom:5px;" id="gcompl">เพิ่มข้อมูลเรียบร้อยแล้ว</div>
<table cellpadding="5" cellspacing="1" border="0" width="100%" class="tbservice">
<tr align="center">
<th>รูปภาพ</th>
<th>ASIN</th>
<th>ชื่อสินค้า</th>
<th>เรทติ้ง</th>
<th>ผลิตโดย</th>
<th>หมวด</th>
<th width="40">เพิ่มเข้าdb</th>
<th width="40">&nbsp;</th>
</tr>
<?php $lasin=0;?>
<?php for($i=0;$i<count($this->item['Item']);$i++):?>
<tr align="center">
<td><img src="<?php echo $this->item['Item'][$i]['SmallImage']['URL']?>" /></td>
<td><?php echo $this->item['Item'][$i]['ASIN']?></td>
<td class="tab_title"><?php echo $this->item['Item'][$i]['ItemAttributes']['Title']?></td>
<td><?php if($this->item['Item'][$i]['onlybinding']&&lz::$c['zone']=='com'):?><span id="avg<?php echo $lasin?>" asin="<?php echo $this->item['Item'][$i]['ASIN']?>">กำลังรอโหลดข้อมูล</span><?php endif?></td>
<td><?php echo $this->item['Item'][$i]['ItemAttributes']['Manufacturer']?></td>
<td><?php echo $this->item['Item'][$i]['ItemAttributes']['ProductGroup']?></td>
<td><?php if($this->item['Item'][$i]['onlybinding']):?>

<?php if(lz::$c['zone']=='com')$lasin++;?>
<img src="<?php echo HTTP?>static/images/pass.gif" alt="เพิ่มเข้าดาต้าเบสแล้ว" />
<?php endif?></td>
    <td width="50">
    <a href="<?php echo $this->item['Item'][$i]['DetailPageURL']?>" target="_blank"><img src="<?php echo HTTP?>static/images/view.gif" alt="ดูรายละเอียด" /></a>
   </td>
   </tr>
<?php endfor?>
<?php if(!count($this->item['Item'])):?>
<tr align="center"><td colspan="8" align="center" valign="middle" height="100">- ไม่มีสินค้า -</td></tr>
<?php endif?>
</table></div><br /><?php echo $this->pager?><br />
<script>lasin=<?php echo intval($lasin)?>;if(typeof(rec)=='function')rec();</script>
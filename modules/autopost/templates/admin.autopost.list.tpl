<div id="barsearch" align="right"><div style="float:left; margin:5px">ผลลัพธ์ <?php echo number_format($this->count)?> รายการ
<?php if($this->btime['tmin']!=$this->btime['tmax']):?> ( ข้อมูลเื่มื่อ <?php echo time::show($this->btime['tmin'],'datetime')?> - <?php echo time::show($this->btime['tmax'],'datetime')?> )<?php endif?></div><form onSubmit="search2();return false">ค้นหา <input type="text" id="search" class="tbox" value="<?php echo $this->search?>" size="15" /> เรียงโดย <select id="order"  class="tbox"><?php foreach($this->allorder as $key=>$value){?><option value="<?php echo $key?>" <?php echo $this->order==$key?'selected=\'selected\'':''?>><?php echo $value?></option><?php }?></select> จาก <select id="by" class="tbox"><?php foreach($this->allby as $key=>$value){?><option value="<?php echo $key?>" <?php echo $this->by==$key?'selected=\'selected\'':''?>><?php echo $value?></option><?php }?></select><input type="submit" id="find" value="" /></form></div>
<div style="padding:5px;">
<table cellpadding="5" cellspacing="1" border="0" width="100%" class="tbservice">
<tr align="center">
<?php foreach($this->allorder as $key=>$val):?>
<th> &nbsp; <?php echo $val?> <?php if($this->order!=$key||$this->by!='asc'):?><a href="javascript:;" onClick="order('<?php echo $key?>','asc');return false" class="order"><img src="<?php echo HTTP?>static/images/asc.gif" /></a><?php endif?><?php if($this->order!=$key||$this->by!='desc'):?><a href="javascript:;" onClick="order('<?php echo $key?>','desc');return false" class="order"><img src="<?php echo HTTP?>static/images/desc.gif" /></a><?php endif?></th>
<?php endforeach?>
    </tr>
<?php for($i=0;$i<count($this->autopost);$i++):?>
<tr align="center">
<?php foreach($this->allorder as $key=>$val):?>
<?php if(in_array($key,array('rew1','rew2','ping'))):?>
<td><?php if($this->autopost[$i][$key]):?><img src="<?php echo HTTP?>static/images/pass.gif" class="icon" /><?php endif?></td>
<?php elseif(in_array($key,array('title'))):?>
<td align="center"><?php echo $this->autopost[$i][$key]?></td>
<?php elseif(in_array($key,array('status'))):?>
<td align="center">
<?php 
switch($this->autopost[$i][$key])
{
	case 1:
		echo '<strong style="color:#62B548">เรียบร้อย</strong>';
		break;
	case 2:
		echo '<strong style="color:#dd0000">ผิดพลาด</strong>';
		break;
	case 3:
		echo '<strong style="color:#FF9900">ไม่สมบูรณ์</strong>';
		break;
}
?>
</td>
<?php elseif(in_array($key,array('added','time'))):?>
<td class="tab_<?php echo $key?>"><?php echo time::show($this->autopost[$i][$key],'datetime')?></td>
<?php elseif(in_array($key,array('detail'))):?>
<td align="center"><?php if($this->autopost[$i]['status']==1||$this->autopost[$i]['status']==3):?><a href="<?php echo $this->autopost[$i]['detail']?>" target="_blank">หน้าสินค้า</a><?php else:?><?php echo $this->autopost[$i]['detail']?><?php endif?></td>
<?php else:?>
<td class="tab_<?php echo $key?>"><?php echo $this->autopost[$i][$key]?></td>
<?php endif?>
<?php endforeach?>
   </tr>
<?php endfor?>
</table></div><br /><?php echo $this->pager?><br />
<div align="center"><input type="button" class="submit" value="  เคลียร์ข้อมูล " onClick="if(confirm('คุณต้องการเคลียร์ข้อมูลนี้ทั้งหมดหรือไม่'))ajax_bclear()"></div>

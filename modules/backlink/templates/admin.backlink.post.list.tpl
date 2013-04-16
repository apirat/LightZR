
<ul class="tabs" style="text-align: left; margin-bottom: 3px;">
<li><a href="<?php echo PATHMIN.SERVICE_LINK?>">บล็อกทั้งหมด</a></li>
<li class="on"><a href="<?php echo PATHMIN.SERVICE_LINK?>/post">รายงานการโพสแบ็คลิ้งค์ทั้งหมด</a></li>
<li><a href="<?php echo PATHMIN.SERVICE_LINK?>/category">หมวดสินค้า</a></li>
</ul>

<div id="barsearch" align="right"><div style="float:left; margin:5px">ผลลัพธ์ <?php echo number_format($this->count)?> รายการ
<?php if($this->btime['tmin']!=$this->btime['tmax']):?> ( ข้อมูลเื่มื่อ <?php echo time::show($this->btime['tmin'],'datetime')?> - <?php echo time::show($this->btime['tmax'],'datetime')?> )<?php endif?></div><form onSubmit="search2();return false">ค้นหา <input type="text" id="search" class="tbox" value="<?php echo $this->search?>" size="15" /> เรียงโดย <select id="order"  class="tbox"><?php foreach($this->allorder as $key=>$value){?><option value="<?php echo $key?>" <?php echo $this->order==$key?'selected=\'selected\'':''?>><?php echo $value?></option><?php }?></select> จาก <select id="by" class="tbox"><?php foreach($this->allby as $key=>$value){?><option value="<?php echo $key?>" <?php echo $this->by==$key?'selected=\'selected\'':''?>><?php echo $value?></option><?php }?></select><input type="submit" id="find" value="" /></form></div>
<div style="padding:5px;">
<table cellpadding="5" cellspacing="1" border="0" width="100%" class="tbservice">
<tr align="center">
<?php foreach($this->allorder as $key=>$val):?>
<th> &nbsp; <?php echo $val?> <?php if($this->order!=$key||$this->by!='asc'):?><a href="javascript:;" onClick="order('<?php echo $key?>','asc');return false" class="order"><img src="<?php echo HTTP?>static/images/asc.gif" /></a><?php endif?><?php if($this->order!=$key||$this->by!='desc'):?><a href="javascript:;" onClick="order('<?php echo $key?>','desc');return false" class="order"><img src="<?php echo HTTP?>static/images/desc.gif" /></a><?php endif?></th>
<?php endforeach?>
<th>&nbsp;</th>
    </tr>
<?php for($i=0;$i<count($this->blogpost);$i++):?>
<tr align="center">
<?php foreach($this->allorder as $key=>$val):?>
<?php if($key=='postid'):?>
<td width="60" class="tab_<?php echo $key?>"><?php echo $this->blogpost[$i][$key]?'<b>สำเร็จ</b>':'ผิดพลาด'?></td>
<?php elseif(in_array($key,array('time'))):?>
<td class="tab_<?php echo $key?>"><?php echo time::show($this->blogpost[$i][$key],'datetime')?></td>
<?php else:?>
<td><?php echo $this->blogpost[$i][$key]?></td>
<?php endif?>
<?php endforeach?>
<td width="40">
<a href="<?php echo $this->blogpost[$i]['posturl']?>" target="_blank"><img src="<?php echo HTTP?>static/images/view.gif"></a>
 <?php if(!$this->blogpost[$i]['postid']):?><a href="javascript:" onClick="if(confirm('คุณต้องการลบรายงานนี้หรือไม่'))ajax_delblogpost(<?php echo $this->blogpost[$i]['id']?>)"><img src="<?php echo HTTP?>static/images/delete.gif"></a><?php endif?>
 </td>
   </tr>
<?php endfor?>
</table></div><br /><?php echo $this->pager?><br />

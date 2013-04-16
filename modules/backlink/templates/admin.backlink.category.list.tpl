
<ul class="tabs" style="text-align: left; margin-bottom: 3px;">
<li><a href="<?php echo PATHMIN.SERVICE_LINK?>">บล็อกทั้งหมด</a></li>
<li><a href="<?php echo PATHMIN.SERVICE_LINK?>/post">รายงานการโพสแบ็คลิ้งค์ทั้งหมด</a></li>
<li class="on"><a href="<?php echo PATHMIN.SERVICE_LINK?>/category">หมวดสินค้า</a></li>
</ul>

<div id="barsearch" align="right"><div style="float:left; margin:5px">ผลลัพธ์ <?php echo number_format($this->count)?> รายการ</div><form onSubmit="search2();return false">ค้นหา <input type="text" id="search" class="tbox" value="<?php echo $this->search?>" size="15" /> เรียงโดย <select id="order"  class="tbox"><?php foreach($this->allorder as $key=>$value){?><option value="<?php echo $key?>" <?php echo $this->order==$key?'selected=\'selected\'':''?>><?php echo $value?></option><?php }?></select> จาก <select id="by" class="tbox"><?php foreach($this->allby as $key=>$value){?><option value="<?php echo $key?>" <?php echo $this->by==$key?'selected=\'selected\'':''?>><?php echo $value?></option><?php }?></select><input type="submit" id="find" value="" /></form></div>
<div style="padding:5px;">
<table cellpadding="5" cellspacing="1" border="0" width="100%" class="tbservice">
<tr align="center">
<?php foreach($this->allorder as $key=>$val):?>
<th> &nbsp; <?php echo $val?> <?php if($this->order!=$key||$this->by!='asc'):?><a href="javascript:;" onClick="order('<?php echo $key?>','asc');return false" class="order"><img src="<?php echo HTTP?>static/images/asc.gif" /></a><?php endif?><?php if($this->order!=$key||$this->by!='desc'):?><a href="javascript:;" onClick="order('<?php echo $key?>','desc');return false" class="order"><img src="<?php echo HTTP?>static/images/desc.gif" /></a><?php endif?></th>
<?php endforeach?>
    </tr>
<?php for($i=0;$i<count($this->category);$i++):?>
<tr align="center">
<?php foreach($this->allorder as $key=>$val):?>
<?php if($key=='domain'):?>
<td>
<?php if($this->category[$i]['domain']):?>
    <a href="http://www.<?php echo $this->category[$i]['domain'].QUERY?>" target="_blank" class="show-tooltip-s" title="แสดงข้อมูลสินค้าที่หน้าเว็บ"><?php echo $this->category[$i]['domain'].QUERY?></a>
<?php elseif(lz::$c['sub']==2):?>
    <a href="http://<?php echo $this->category[$i]['link']?>.<?php echo lz::$cf['domain'].QUERY?>" target="_blank" class="show-tooltip-s" title="แสดงข้อมูลสินค้าที่หน้าเว็บ"><?php echo $this->category[$i]['link']?>.<?php echo lz::$cf['domain'].QUERY?></a>
<?php else:?>
    <a href="<?php echo QUERY.$this->category[$i]['link']?>" target="_blank" class="show-tooltip-s" title="แสดงข้อมูลสินค้าที่หน้าเว็บ"><?php echo lz::$c['domain'].QUERY.$this->category[$i]['link']?></a>
<?php endif?>
</td>
<?php elseif($key=='backlink'):?>
<td>
<?php if($this->category[$i]['backlink']=='no'):?>
    <a href="javascript:;" onclick="ajax_backlink('<?php echo $this->category[$i]['id']?>','yes')"><img src="<?php echo HTTP?>static/images/fail.gif" class="icon" /></a>
    <?php else:?>
    <a href="javascript:;" onclick="ajax_backlink('<?php echo $this->category[$i]['id']?>','no')"><img src="<?php echo HTTP?>static/images/pass.gif" class="icon" /></a>
<?php endif?>
</td>
<?php elseif(in_array($key,array('lastblog'))):?>
<td class="tab_<?php echo $key?>"><?php echo time::show($this->category[$i][$key],'datetime')?></td>
<?php else:?>
<td><?php echo $this->category[$i][$key]?></td>
<?php endif?>
<?php endforeach?>
   </tr>
<?php endfor?>
</table></div><br /><?php echo $this->pager?><br />

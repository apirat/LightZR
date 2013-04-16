<?php echo lz::h('setview')->popup()?>

<div id="newcategory" class="setview">
<h2>เพิ่มหมวดใหม่</h2>
<div style="margin:10px; text-align:left; width:300px;">
<form method="post" onsubmit="ajax_newcategory(this);lz.box.close();return false;">
<table cellpadding="5" cellspacing="5" border="0" align="center">
<tr><td align="right" width="100">ชื่อหมวด</td><td><input type="text" name="title" size="30" class="tbox" /></td></tr>
<tr><td colspan="2" align="center"><input type="submit" class="submit" value=" ถัดไป " /> <input type="button" class="button" value=" ยกเลิก " onClick="lz.box.close()" /></td></tr>
</table>
</form>
</div>
</div>

<div id="newcategories" class="setview">
<h2>เพิ่มหมวดใหม่</h2>
<div style="margin:10px; text-align:left; width:500px;">
<form method="post" onsubmit="ajax_newcategories(this);lz.box.close();return false;">
<table cellpadding="0" cellspacing="5" border="0" align="center">
<tr><td colspan="2" align="center"><textarea class="tbox" name="categories" style="width:480px; height:150px"></textarea><p align="left">ชื่อหมวด, ลิ้งค์, กลุ่มสินค้า, หมวดในการค้น, คำค้นหา, ค้นหาไม่เกินหน้า, เรียกข้อมูลจาก, node<br>หนึ่งบรรทัดต่อหมวด และใช้ , คั่นระหว่างข้อมูล<br>ดูข้อมูลเพิ่มเติมได้ที่ <a href="http://seo.phukettech.com/index.php/topic,10.0.html" target="_blank">วิธีเพิ่มหมวดจำนวนมากในครั้งเดียว</a></p></td></tr>
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
<?php for($i=0;$i<count($this->cate);$i++):?>
<tr align="center">

<?php foreach($this->allorder as $key=>$val):?>
<?php if($key=='id'):?>
<td width="30"><?php echo $this->cate[$i]['id']?></td>
<?php elseif(in_array($key,array('added','time'))):?>
<td class="tab_<?php echo $key?>"><?php echo time::show($this->cate[$i][$key],'datetime')?></td>
<?php elseif(in_array($key,array('title','link'))):?>
<?php echo $this->html->td('category_'.$key.'_'.$this->cate[$i]['id'],$this->cate[$i][$key],'input',array('class'=>'tab_'.$key))?>
<?php elseif(in_array($key,array('domain'))):?>
<?php echo $this->html->td('category_'.$key.'_'.$this->cate[$i]['id'],$this->cate[$i][$key],'input',array('space'=>''))?>
<?php elseif(in_array($key,array('amount'))):?>
<td class="tab_<?php echo $key?>"><?php echo $this->cate[$i][$key]?></td>
<?php elseif(in_array($key,array('price'))):?>
<td class="tab_<?php echo $key?>"><?php echo number_format($this->cate[$i][$key]/100,2)?></td>
<?php elseif(in_array($key,array('asinpost'))):?>
<td width="100">
<?php if(trim($this->cate[$i]['asinpost'])):?>
(<?php echo number_format(count(explode(',',$this->cate[$i]['asinpost'])))?>) 
<?php endif?>
<a href="javascript:;" onClick="ajax_asinpost('<?php echo $this->cate[$i]['id']?>')"><img src="<?php echo HTTP?>static/images/edit.gif" alt="แก้ไข ASIN" class="icon" /></a>
</td>
<?php elseif(in_array($key,array('autopost'))):?>
<td width="90">
<?php if($this->cate[$i]['autopost']=='no'):?>
    <a href="javascript:;" onclick="ajax_autopost('<?php echo $this->cate[$i]['id']?>','yes')"><img src="<?php echo HTTP?>static/images/fail.gif" class="icon" /></a>
    <?php else:?>
    <a href="javascript:;" onclick="ajax_autopost('<?php echo $this->cate[$i]['id']?>','no')"><img src="<?php echo HTTP?>static/images/pass.gif" class="icon" /></a>
<?php endif?>
</td>

<?php else:?>
<td class="tab_<?php echo $key?>"><?php echo $this->click[$i][$key]?></td>
<?php endif?>

<?php endforeach?>

<td width="120">
<?php if($this->cate[$i]['domain']):?>
    <a href="http://www.<?php echo $this->cate[$i]['domain'].QUERY?>" target="_blank" title="แสดงข้อมูลสินค้าที่หน้าเว็บ"><img src="<?php echo HTTP?>static/images/list.png" alt="แสดง" /></a>
<?php elseif(lz::$c['sub']==2):?>
    <a href="http://<?php echo $this->cate[$i]['link']?>.<?php echo lz::$cf['domain'].QUERY?>" target="_blank" title="แสดงข้อมูลสินค้าที่หน้าเว็บ"><img src="<?php echo HTTP?>static/images/list.png" alt="แสดง" /></a>
<?php else:?>
    <a href="<?php echo QUERY.$this->cate[$i]['link']?>" target="_blank" title="แสดงข้อมูลสินค้าที่หน้าเว็บ"><img src="<?php echo HTTP?>static/images/list.png" alt="แสดง" /></a>
<?php endif?>
    <a href="<?php echo PATHMIN.SERVICE_LINK?>/list/<?php echo $this->cate[$i]['id']?>" title="ข้อมูลสินค้าที่มีอยู่แล้ว"><img src="<?php echo HTTP?>static/images/icon/txt.gif" alt="สินค้าที่มีอยู่แล้ว" /></a>
    <a href="<?php echo PATHMIN.SERVICE_LINK?>/setting/<?php echo $this->cate[$i]['id']?>" title="แก้ไขเพิ่มเติม"><img src="<?php echo HTTP?>static/images/edit.gif" alt="แก้ไขเพิ่มเติม" /></a>
    <a href="<?php echo PATHMIN.SERVICE_LINK?>/<?php echo $this->cate[$i]['id']?>" title="ค้นหา"><img src="<?php echo HTTP?>static/images/search.gif" alt="ค้นหา" /></a>
    <a href="<?php echo PATHMIN.SERVICE_LINK?>/<?php echo $this->cate[$i]['id']?>/auto/1" title="เพิ่มข้อมูลอัตโนมัติ"><img src="<?php echo HTTP?>static/images/find.png" alt="ค้นหาเปลี่ยนหน้าอัตโนมัติ" /></a>
    <a href="javascript:;" title="ลบ" onClick="if(confirm('คุณต้องการลบหมวดสินค้านี้หรือไม่'))ajax_del('<?php echo $this->cate[$i]['id']?>')"><img src="<?php echo HTTP?>static/images/delete.gif" alt="ลบหมวด" /></a>
</td>
   </tr>
<?php endfor?>
<?php if(!count($this->cate)):?>
<tr>
<td colspan="<?php echo count($this->allorder)+1?>" align="center" valign="middle" headers="150">ยังไม่มีข้อมูล</td>
</tr>
<?php endif?>
</table></div>
<div style="margin:5px"><?php echo $this->pager?></div>

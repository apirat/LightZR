<div id="barsearch" align="right"><div style="float:left; margin:5px"><?php echo $this->category['title']?> - ผลลัพธ์ <?php echo number_format($this->count)?> ข้อมูล</div><form onSubmit="search2();return false">ค้นหา <input type="text" id="search" class="tbox" value="<?php echo $this->search?>" size="15" /> เรียงโดย <select id="order"  class="tbox"><?php foreach($this->allorder as $key=>$value){?><option value="<?php echo $key?>" <?php echo $this->order==$key?'selected=\'selected\'':''?>><?php echo $value?></option><?php }?></select> จาก <select id="by" class="tbox"><?php foreach($this->allby as $key=>$value){?><option value="<?php echo $key?>" <?php echo $this->by==$key?'selected=\'selected\'':''?>><?php echo $value?></option><?php }?></select><input type="submit" id="find" value="" /></form></div>
<div style="padding:5px;">
<table cellpadding="5" cellspacing="1" border="0" width="100%" class="tbservice">
<tr align="center">
<?php foreach($this->allorder as $key=>$val):?>
<th> &nbsp; <?php echo $val?> <?php if($this->order!=$key||$this->by!='asc'):?><a href="javascript:;" onClick="order('<?php echo $key?>','asc');return false" class="order"><img src="<?php echo HTTP?>static/images/asc.gif" /></a><?php endif?><?php if($this->order!=$key||$this->by!='desc'):?><a href="javascript:;" onClick="order('<?php echo $key?>','desc');return false" class="order"><img src="<?php echo HTTP?>static/images/desc.gif" /></a><?php endif?></th>
<?php endforeach?>
<th width="70">&nbsp;</th>
    </tr>
<?php for($i=0;$i<count($this->product);$i++):?>
<tr align="center">
<?php foreach($this->allorder as $key=>$val):?>
<?php if(in_array($key,array('title'))):?>
<?php echo $this->html->td('product_title_'.$this->product[$i]['asin'],$this->product[$i]['title'],'input',array('class'=>'tab_'.$key))?>
<?php elseif($key=='s'):?>
<td width="60" class="tab_<?php echo $key?>"><img src="<?php echo $this->product[$i]['s']?>" /> </td>
<?php elseif($key=='content'):?>
<td width="80" class="tab_<?php echo $key?>">
<?php if($this->product[$i]['content']):?>
<a href="javascript:;" onClick="ajax_editcontent('<?php echo $this->product[$i]['asin']?>')"><img src="<?php echo HTTP?>static/images/edit.gif" alt="แก้ไขเนื้อหา" /></a>
<a href="javascript:;" onClick="delcontent('<?php echo $this->product[$i]['asin']?>')"><img src="<?php echo HTTP?>static/images/delete.gif" alt="ลบเนื้อหา" /></a>
<?php else:?>
<a href="javascript:;" onClick="ajax_editcontent('<?php echo $this->product[$i]['asin']?>')"><img src="<?php echo HTTP?>static/images/add.gif" alt="เพื่อเนื้อหา" /></a>
<?php endif?>
</td>
<?php elseif(in_array($key,array('price','saleprice'))):?>
<td width="80"><?php echo number_format($this->product[$i][$key]/100)?></td>
<?php elseif(in_array($key,array('added','lastupdate'))):?>
<td width="100"><?php echo time::show($this->product[$i][$key],'datetime')?></td>
<?php else:?>
<td><?php echo $this->product[$i][$key]?></td>
<?php endif?>
<?php endforeach?>
    <td width="90">
    <?php if($this->category['domain']):?>
        <a href="http://www.<?php echo $this->category['domain'].QUERY?><?php echo $this->product[$i]['link']?><?php echo lz::$c['pinfo']?'/'.lz::$c['pinfo']:''?>" target="_blank" title="แสดงข้อมูลสินค้าที่หน้าเว็บ"><img src="<?php echo HTTP?>static/images/list.png" alt="แสดง" /></a>
    <?php elseif(lz::$c['sub']==2):?>
        <a href="http://<?php echo $this->category['link']?>.<?php echo lz::$cf['domain'].QUERY?><?php echo $this->product[$i]['link']?><?php echo lz::$c['pinfo']?'/'.lz::$c['pinfo']:''?>" target="_blank" title="แสดงข้อมูลสินค้าที่หน้าเว็บ"><img src="<?php echo HTTP?>static/images/list.png" alt="แสดง" /></a>
    <?php elseif(lz::$c['sub']==1):?>
        <a href="<?php echo QUERY.$this->product[$i]['link']?><?php echo lz::$c['pinfo']?'/'.lz::$c['pinfo']:''?>" target="_blank" title="แสดงข้อมูลสินค้าที่หน้าเว็บ"><img src="<?php echo HTTP?>static/images/list.png" alt="แสดง" /></a> 
     <?php else:?>
        <a href="<?php echo QUERY.$this->category['link']?>/<?php echo $this->product[$i]['link']?><?php echo lz::$c['pinfo']?'/'.lz::$c['pinfo']:''?>" target="_blank" title="แสดงข้อมูลสินค้าที่หน้าเว็บ"><img src="<?php echo HTTP?>static/images/list.png" alt="แสดง" /></a>
    <?php endif?>
    	<a href="http://www.amazon.<?php echo lz::$c['zone']?>/gp/product/<?php echo $this->product[$i]['asin']?>" target="_blank"><img src="<?php echo HTTP?>static/images/view.gif" alt="detail" /></a>
    	<a href="javascript:;" onClick="return re('<?php echo $this->product[$i]['asin']?>')"><img src="<?php echo HTTP?>static/images/cache.gif" alt="refresh" /></a>
        <a href="javascript:;" onClick="return del('<?php echo $this->product[$i]['asin']?>')"><img src="<?php echo HTTP?>static/images/del.gif" alt="delete" /></a>
   </td>
   </tr>
<?php endfor?>
</table></div><br /><?php echo $this->pager?><br />

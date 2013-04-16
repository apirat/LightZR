<div id="setview" class="setview" onopen="$('#gbox ul.columnsort').sortable({revert:true});$('#gbox ul.columnsort').disableSelection();">
<form id="formsetview" action="<?php echo URL?>" method="post" onSubmit="var r=new Object(),i=0;$('#gbox ul.columnsort input').each(function(){if($(this).attr('value')){r[i]=$(this).attr('value');i++;}});ajax_setlist(this,r);lz.box.close();return false;">
<div class="gbox_header"><h2>ปรับแต่งการแสดงผล</h2></div>
<div class="gbox_content">
<table cellpadding="5" cellspacing="5" border="0" width="350">
<tr><td valign="top">
<h4>แสดงข้อมูล</h4>
<ul class="columnsort">
<?php foreach(setview::$view as $key=>$name):?>
<li><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
<label><input type="checkbox" name="column" <?php echo setview::$allorder[$key]?' checked="checked"':''?> value="<?php echo $key?>"> <?php echo $name?></label>
</li>
<?php endforeach?>
</ul>
</td><td valign="top" width="125">
<h4>จำนวนข้อมูลต่อหน้า</h4>
<input type="number" size="5" name="rows"  pattern="[0-9]+" class="tbox" value="<?php echo setview::$rows?>" style="width:50px">
</td>
</tr></table>
</div>
<div class="gbox_footer">
<input type="submit" class="submit" value="  บันทึก  ">
<input type="button" class="button" value="   ยกเลิก   " onClick="lz.box.close();">
</div>
</form>
</div>      
<style>
.columnsort li { margin: 0 0px 1px 0px; font-size: 12px; height: 18px; line-height:18px; font-weight:normal; border-bottom:1px solid #e5e5e5; position:relative }
.columnsort li span { position: absolute; margin-left:2px; top:0px}
.columnsort li label{margin-left:20px}
.columnsort li input{display:inline}
</style>


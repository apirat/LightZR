<style type="text/css">
	.columnbox { padding: 5px 5px 5px 5px;border:1px dashed #CCCCCC; margin-bottom:10px;}
	.column { padding: 5px 5px 20px 5px;}
	.columnM{margin-right:10px;}
	#layoutright .halfwidth .columnbox {width:330px; float: left; }
	.layout { margin: 0 0 10px 0; border:1px solid #CCC; display:block;}
	.layout-header { margin: 0.3em; padding: 3px 2px 5px; color:#666666; cursor:move;background:#F5F5F5 url(<?php echo HTTP?>/images/admin/bg_menutop.jpg) bottom left repeat-x;border-top:5px solid #7ABF0B;}
	.layout-header .ui-icon { float: right; width:16px; height:16px; background:url(<?php echo HTTP?>static/images/delete.gif) center center no-repeat; cursor:pointer; vertical-align:middle}
	.layout-header .ui-icon-edit { float: right; width:16px; height:16px; background:url(<?php echo HTTP?>static/images/edit.gif) center center no-repeat; cursor:pointer; vertical-align:middle}
	.layout-header .ui-icon-show { float: right; width:16px; height:16px; background:url(<?php echo HTTP?>static/images/view.gif) center center no-repeat; cursor:pointer; vertical-align:middle}
	.layout-header .ui-icon-option { float: right; width:16px; height:16px; background:url(<?php echo HTTP?>static/images/search.gif) center center no-repeat; cursor:pointer; vertical-align:middle}
	.ui-sortable-placeholder { border: 1px dotted black; background-color:#7ABF0B; visibility: visible !important; height: 30px !important; }
	.ui-sortable-placeholder * { visibility: hidden; }
	#layoutleft{float:left; width:240px}
	#layoutright{float:right;width:700px}
	#newbox{display:none; border:1px solid #EFEFEF; margin-bottom:10px;}
	#newbox h3{padding:3px; background:#000; color:#FFF;}
	.lnewbox{border:1px solid #EFEFEF; padding: 0px 3px 0px 1px; margin: 3px;height: 21px; line-height:20px;width: 175px;display: block;float:left; cursor:pointer}
	.lnewbox:hover{text-decoration: underline;}
	.lpos{border:1px solid #EFEFEF;padding: 0px 3px 0px 1px; margin: 3px;height: 21px; line-height:20px;display: block;cursor:pointer}
	.lpos:hover{text-decoration: underline;}
	#btnnew{display:block; padding:30px 0px; border:1px solid #86AA09; background:#ADDD0B; margin-top:5px; color:#000000; font-size:16px; font-weight:bold; text-align:center}
	#btnnew:hover{ background:#000; color:#ADDD0B}
	#savepos{display:none;}
	</style>
	<script type="text/javascript">
$(function() {
	$(".column").sortable({connectWith: '.column'});
	$(".column").disableSelection();
	$(".column").droppable({drop: function(event, ui){if(!opensave)$('#savepos').hide().animate({height:'toggle',opacity:'toggle'},500,function(){opensave=true;});}});
	$('#btnnew').click(function(){var a=$('input[name=inewbox]:checked').val(),b=$('input[name=npos]:checked').val();if(a==''||b=='')return;$('input[name=inewbox]:checked').removeAttr("checked").next('label').removeClass("bselected");$('input[name=npos]:checked').removeAttr("checked").next('label').removeClass("pselected");ajax_newbox(a,b)});
	$('input:radio').checkbox();
	$('input:checkbox:not(.notcb)').checkbox();
	initbyall();
});
var opensave=false;
function addnew(position,id,name,folder,option,detail){$('#pos_'+position).append('<div class="layout"><div class="layout-header" box="'+id+'"><span class="ui-icon show-tooltip-s" title="ลบกล่องข้อมูลนี้"></span><span class="ui-icon-edit show-tooltip-s" title="แก้ไขชื่อเมนู"></span><span class="ui-icon-show show-tooltip-s" title="แก้ไขการแสดงผล"></span>'+(option?'<span class="ui-icon-option show-tooltip-s" title="'+detail+'"></span>':'')+'<img src="<?php echo HTTP?>modules/'+folder+'/images/icon16.gif" class="icon show-tooltip-s" title="ย้ายตำแหน่งกล่องข้อมูลนี้"><span id="name'+id+'" show="">'+name+'</span></div></div>').children(':last').hide().animate({height:'toggle',opacity:'toggle'},500);initbyall();}
function initbyall()
{
	$(".layout-header .ui-icon").click(function(){ajax_delete($(this).parent().attr('box'));$(this).parent().parent().animate({opacity:0.1,height:0},500,function(){$(this).remove()})});
	$(".layout-header .ui-icon-edit").click(function(){lz.box.open('#editname');$('#_box_id').val($(this).parent().attr('box'));$('#_box_name').val($('#name'+$('#_box_id').val()).html());});
	$(".layout-header .ui-icon-show").click(function(){
		lz.box.open('#setshow');
		var id=$(this).parent().attr('box'),show=$('#name'+id).attr('show');
		$('#_box_id').val(id);
		$('#_box_name').html($('#name'+id).html());
		$(show.split(',')).each(function() {
         if(this!='')$('#_box_'+this).prop('checked',true);
      });
	});
	$(".layout-header .ui-icon-option").click(function(){ajax_option($(this).parent().attr('box'))});
}
function closesave(){if(opensave){$('#savepos').animate({opacity:'toggle',height:'toggle'},500,'easeOutBounce');opensave=false}}
function gendata2save(){var data=new Object();$(['menu','bar1','bar2']).each(function(i,d){data[d]=new Array();$("#pos_"+d).find('.layout-header').each(function(i){data[d][i]=$(this).attr('box')});});ajax_position(data);}
</script>
<div id="setoption" class="setview"></div>
<div id="editname" class="setview">
<div style="width:250px; text-align:center">
<h2>เปลี่ยนชื่อเมนู</h2>
<form method="post" onsubmit="ajax_editname(this);lz.box.close();return false;">
<input type="hidden" name="box" id="_tmp_id" /><input type="text" name="name" id="_tmp_name" size="30" class="tbox" /><br />
<input type="submit" class="submit" value=" บันทึก "> <input type="button" class="button" value=" ยกเลิก " onclick="lz.box.close()">
</form>
</div></div>
<div id="setshow" class="setview">
<div style="width:450px; text-align:center">
<h2>แก้ไขการแสดงผล "<span id="_tmp_name"></span>"</h2>
เลือกหน้าที่ต้องการให้กล่องข้อมูลนี้แสดง
<div style="width:150px; margin:5px auto; text-align:left; line-height:1.8em">
<form method="post" onsubmit="ajax_setshow(this);lz.box.close();return false;">
<input type="hidden" name="box" id="_tmp_id">
<label><input type="checkbox" id="_tmp_home" class="notcb" name="show" value="home">หน้าแรกของโดนเมน</label><br>
<label><input type="checkbox" id="_tmp_list" class="notcb" name="show" value="list">หน้าหมวดสินค้า</label><br>
<label><input type="checkbox" id="_tmp_view" class="notcb" name="show" value="view">หน้ารายละเอียดสินค้า</label><br>
<input type="submit" class="submit" value=" บันทึก "> <input type="button" class="button" value=" ยกเลิก " onclick="lz.box.close()">
</form>
</div>
*** หากปล่อยว่างคือแสดงหมดทุกหน้า
</div></div>
<div align="center">
<div style="margin:0px auto; width:950px; text-align:left">
<div id="newbox">
<div style="width:570px; float:left; border:1px solid #EEEEEE; background:#F6F6F6">
<h3>1. เลือกประเภทกล่องข้อมูล</h3>
<div>
<?php for($i=0;$i<count($this->module);$i++):?>
<label for="nbox<?php echo $i?>" class="lnewbox"><input type="radio" id="nbox<?php echo $i?>" name="inewbox" value="<?php echo $this->module[$i]['id']?>" class="inewbox" autocomplete="off" /><img src="<?php echo HTTP?>modules/<?php echo $this->module[$i]['folder']?>/images/icon16.gif" class="icon">  <?php echo $this->module[$i]['name']?></label>
<?php endfor?>
<div class="clear"></div>
</div>
</div>
<div style="width:200px; float:left; border:1px solid #EEEEEE; background:#F6F6F6; margin-left:5px">
<h3>2. เลือกตำแหน่งที่จะใส่กล่องข้อมูล</h3>
<div>
<label for="npos_menu" class="lpos"><input type="radio" id="npos_menu" name="npos" value="menu" class="ipos" autocomplete="off" />ตำแหน่งเมนู</label>
<label for="npos_bar1" class="lpos"><input type="radio" id="npos_bar" name="npos" value="bar1" class="ipos" />ตำแหน่งบาร์ 1</label>
<label for="npos_bar2" class="lpos"><input type="radio" id="npos_bar" name="npos" value="bar2" class="ipos" />ตำแหน่งบาร์ 2</label>
</div>
</div>
<div style="width:160px; float:left;border:1px solid #EEEEEE; background:#F6F6F6; margin-left:5px"><h3>3. คลิก</h3><a href="javascript:;" id="btnnew">เพิ่มกล่องข้อมูล</a></div>
<div class="clear"></div>
<br />
</div>
<div id="savepos"><div style="margin:5px 0px; padding:5px; border:1px solid #8AB009; background:#000; text-align:center"><input type="button" class="submit" value=" บันทึกตำแหน่ง " onclick="gendata2save();closesave()" /> <input type="button" class="button" value=" ปิดหน้าต่างนี้ " onclick="closesave()" /></div></div>
<div id="layoutleft">
	<div class="columnbox">
        <h3>ตำแหน่งเมนู <small>(แสดงทุกหน้า)</small></h3>
        <div id="pos_menu" class="column">
        <?php echo $this->box['menu']?>
        </div>
     </div>
</div>
<div id="layoutright">
    <div class="fullwidth columnbox">
    	<h3>ตำแหน่งบาร์ 1<small>(แสดงทุกหน้า)</small></h3>
        <div id="pos_bar1" class="column">
        <?php echo $this->box['bar1']?>
        </div>
        <div class="clear"></div>
    </div>
    <div style="border:1px solid #ccc; padding:50px 10px; margin-bottom:10px;text-align:center; font-size:36px; font-weight:bold">เนื้อหา</div>
    <div class="fullwidth columnbox">
    	<h3>ตำแหน่งบาร์ 2<small>(แสดงทุกหน้า)</small></h3>
        <div id="pos_bar2" class="column">
        <?php echo $this->box['bar2']?>
        </div>
        <div class="clear"></div>
    </div>
</div>
<div class="clear"></div>
</div>
</div>
<style>
.tbbullet{background:#e0e0e0;}
.tbbullet th{font-weight:bold; text-align:left; text-indent:10px; background:url(/images/admin/bullet.gif) left 5px no-repeat; vertical-align:top; background:#F6F6F6}
.tabh{height:20px; line-height:20px; cursor:pointer; text-indent:20px;margin-top:5px; background:url(/images/admin/minus.gif) 3px 4px no-repeat}
.tbbullet td{font-size:10px; background:#fff}
</style>
  <link rel="Stylesheet" type="text/css" href="<?php echo HTTP?>js/colorpicker/colorpicker.css" />
  <script src="<?php echo HTTP?>js/colorpicker/colorpicker.js" type="text/javascript"></script>
<script type="text/javascript">        
  $(document).ready(
    function()
    {
	    $('.setcolor').each(function(){
        $(this).css({backgroundColor:'#'+$(this).val()});
      });

     $('.setcolor').ColorPicker({
	onSubmit: function(hsb, hex, rgb, el) {
		$(el).val(hex);
		$(el).css({backgroundColor:'#'+hex});
		$(el).ColorPickerHide();
	},
	onBeforeShow: function () {
		$(this).ColorPickerSetColor(this.value);
		$(this).css({backgroundColor:'#'+this.value});
	},	
	onChange: function (hsb, hex, rgb) {
		$(this).css({backgroundColor:'#'+hex});
	}

})
.bind('keyup', function(){
	$(this).ColorPickerSetColor(this.value);
});
    });
  
</script>

<?php
$align=array('top left','top center','top right','center left','center center','center right','bottom left','bottom center','bottom right');
$repeat=array('repeat','no-repeat','repeat-x','repeat-y');
$bar=array('blue','green','orange','red','pink','violet','white','black');
?>
<div id="iframeupload" style="display:none; width:400px; height:200px;"><iframe id="_tmp_upload" frameborder="0" marginheight="0" marginwidth="0" style="border:0px; margin:0px; padding:0px; width:400px; height:200px; overflow:auto"></iframe></div>
<div align="center">
<div style="width:800px; margin:0px auto; text-align:left">

    <table cellpadding="5" cellspacing="1" border="0" class="tbbullet" align="center" width="800">
    <tr>
    	<td align="center">Theme: <select id="stheme" onChange="top.location.href='<?php echo PATHMIN.SERVICE_LINK?>/'+this.value" class="tbox" autocomplete="off">
        <?php foreach($this->theme as $k=>$v):?><option value="<?php echo $k?>"<?php if(STYLEID==$k):?> selected="selected"<?php endif?>><?php echo $v?></option><?php endforeach?>
        </select>
        <input type="button" class="submit" onClick="top.location.href='<?php echo PATHMIN.SERVICE_LINK?>/'+$('#stheme').val()" value=" เลือก ">
        </td>
    </tr>
    <tr>
    	<td align="center">หรือ <a href="javascript:;" onClick="if(confirm('คุณต้องการย้อนกลับไปใช้งานค่าเริมต้นของ Theme นี้หรือไม่'))ajax_store()"><strong>คลิกที่นี่</strong></a> หากต้องการกลับไปใช้ค่าเริ่มต้นของ Theme ชื่อ <?php echo STYLEID?></td>
    </tr>
    </table><br>
    
    <form method="post" id="post" name="post" action="<?php echo URL?>" onSubmit="ajax_save(this);return false" enctype="multipart/form-data">
    <h2 align="center"><?php echo STYLEID?></h2>
    <table cellpadding="5" cellspacing="1" border="0" class="tbbullet" align="center" width="800">
    <tr>
    	 <td rowspan="2" width="150" valign="top"></td>
    	<th width="150" align="right"></th>
        <td><label><input type="checkbox" value="1" class="tbox" name="flip"<?php if($this->style['flip']):?> checked="checked"<?php endif?>autocomplete="off" /> สลับตำแหน่งซ้ายขวา</label></td>
    </tr>
    </table>
    
    <h3 class="tabh">พื้นหลังทั้งเว็บ</h3>
    <table cellpadding="5" cellspacing="1" border="0" class="tbbullet" align="center" width="800">
    <tr>
    	 <td rowspan="2" width="150" valign="top"><img src="<?php echo HTTP?>static/images/style/theme1.gif"></td>
    	<th width="150" align="right">สีพื้นหลังทั้งหน้า</th>
        <td><input type="text" autocomplete="off" class="tbox setcolor" size="10" name="bg_color" value="<?php echo $this->style['bg_color']?>"> รหัสสี</td>
    </tr>
    <tr>
      <th width="100" align="right" valign="top">ภาพพื้นหลัง</th>
      <td valign="top">
      	<div style="display:<?php echo $this->style['bg_img']?'none':'block'?>"><a href="javascript:;" onclick="lz.box.open('#iframeupload');setTimeout(function(){$('#_box_upload')[0].src='<?php echo PATHMIN.SERVICE_LINK?>/<?php echo STYLEID?>/upload/bg/<?php echo $this->style['id']?>';$('gboxc').style.padding='0px'},500)">อัพโหลดรูป</a></div>
        <div style="display:<?php echo $this->style['bg_img']?'block':'none'?>"><a href="<?php echo HTTP?>files/style/<?php echo $this->style['bg_img']?>" target="_blank">ดูรูป</a> |  [<a href="javascript:;" onclick="if(confirm('ต้องการลบรูปนี้หรือไม่'))ajax_del('bg')">ลบ</a>]</div>
       	<table width="83%">
        <tr><td width="18%" align="right">Fixed : </td><td width="82%"><input id="bg_fix" name="bg_fix" type="checkbox" value="1" class="tbox" <?php echo $this->style['bg_fix']?'checked':''?> autocomplete="off"> <font color="#999999">** ล็อคตำแหน่งรูปไม่ให้เลื่อนตามเวลาเลื่อนหน้าขึ้นลง </font></td></tr>
        <tr><td align="right">Align : </td><td><select id="bg_align" name="bg_align" class="tbox" autocomplete="off"><?php for($i=0;$i<count($align);$i++){?><option value="<?php echo $align[$i]?>" <?php echo $this->style['bg_align']==$align[$i]?'selected':''?>><?php echo $align[$i]?></option><?php }?></select> <font color="#999999">** ตั้งให้รูปชิดขอบที่กำหนด </font></td></tr>
        <tr><td align="right">Repeat : </td><td><select id="bg_repeat" name="bg_repeat" class="tbox" autocomplete="off"><?php for($i=0;$i<count($repeat);$i++){?><option value="<?php echo $repeat[$i]?>" <?php echo $this->style['bg_repeat']==$repeat[$i]?'selected':''?>><?php echo $repeat[$i]?></option><?php }?></select> <font color="#999999">** ตั้งให้รูปวางซ้ำตามแกนที่กำหนด </font></td></tr>
        </table>    </td>
    </tr>
    </table>
    
    <h3 class="tabh">Header</h3>
    <table cellpadding="5" cellspacing="1" border="0" class="tbbullet" align="center" width="800">
    <tr><td rowspan="2" width="150" valign="top"><img src="<?php echo HTTP?>static/images/style/theme10.gif"></td><th width="150" align="right">สีพื้นหลัง </th>
    <td><input type="text" autocomplete="off" class="tbox setcolor" size="10" name="head_color" value="<?php echo $this->style['head_color']?>" maxlength="7"> รหัสสี</td></tr>
  	<tr><th width="100" align="right" valign="top">ภาพพื้นหลัง </th>
  	  <td valign="top">
      <div style="display:<?php echo $this->style['head_img']?'none':'block'?>"><a href="javascript:;" onclick="lz.box.open('#iframeupload');setTimeout(function(){$('#_box_upload')[0].src='<?php echo PATHMIN.SERVICE_LINK?>/<?php echo STYLEID?>/upload/head/<?php echo $this->style['id']?>';$('gboxc').style.padding='0px'},500)">อัพโหลดรูป</a></div>
      <div style="display:<?php echo $this->style['head_img']?'block':'none'?>"><a href="<?php echo HTTP?>files/style/<?php echo $this->style['head_img']?>" target="_blank">ดูรูป</a> |  [<a href="javascript:;" onclick="if(confirm('ต้องการลบรูปนี้หรือไม่'))ajax_del('head')">ลบ</a>]</div>
   <table width="83%">
   <tr><td align="right">Align : </td><td><select id="head_align" name="head_align" class="tbox" autocomplete="off"><?php for($i=0;$i<count($align);$i++){?><option value="<?php echo $align[$i]?>" <?php echo $this->style['head_align']==$align[$i]?'selected':''?>><?php echo $align[$i]?></option><?php }?></select> <font color="#999999">** ตั้งให้รูปชิดขอบที่กำหนด </font></td></tr>
   <tr><td align="right">Repeat : </td><td><select id="head_repeat" name="head_repeat" class="tbox"  autocomplete="off"><?php for($i=0;$i<count($repeat);$i++){?><option value="<?php echo $repeat[$i]?>" <?php echo $this->style['head_repeat']==$repeat[$i]?'selected':''?>><?php echo $repeat[$i]?></option><?php }?></select> <font color="#999999">** ตั้งให้รูปวางซ้ำตามแกนที่กำหนด </font></td></tr>
   </table></td></tr>
   </table>
   
   <h3 class="tabh">สีเมนู</h3>
    <table cellpadding="5" cellspacing="1" border="0" class="tbbullet" align="center" width="800">
    <tr><td rowspan="7" width="150" valign="top"><img src="<?php echo HTTP?>static/images/style/theme2.gif"></td><th width="150" align="right">สีพื้นหลัง </th>
    <td><input type="text" autocomplete="off" class="tbox setcolor" size="10" name="tab_color" value="<?php echo $this->style['tab_color']?>" maxlength="7">  รหัสสี</td></tr>
    <tr>
      <th width="100" align="right" valign="top">ภาพพื้นหลัง</th>
      <td valign="top">
      	<div style="display:<?php echo $this->style['tab_img']?'none':'block'?>"><a href="javascript:;" onclick="lz.box.open('#iframeupload');setTimeout(function(){$('#_box_upload')[0].src='<?php echo PATHMIN.SERVICE_LINK?>/<?php echo STYLEID?>/upload/tab/<?php echo $this->style['id']?>';$('gboxc').style.padding='0px'},500)">อัพโหลดรูป</a></div>
        <div style="display:<?php echo $this->style['tab_img']?'block':'none'?>"><a href="<?php echo HTTP?>files/style/<?php echo $this->style['tab_img']?>" target="_blank">ดูรูป</a> |  [<a href="javascript:;" onclick="if(confirm('ต้องการลบรูปนี้หรือไม่'))ajax_del('tab')">ลบ</a>]</div>
       	<table width="83%">
        <tr><td align="right">Align : </td><td><select id="tab_align" name="tab_align" class="tbox" autocomplete="off"><?php for($i=0;$i<count($align);$i++){?><option value="<?php echo $align[$i]?>" <?php echo $this->style['tab_align']==$align[$i]?'selected':''?>><?php echo $align[$i]?></option><?php }?></select> <font color="#999999">** ตั้งให้รูปชิดขอบที่กำหนด </font></td></tr>
        <tr><td align="right">Repeat : </td><td><select id="tab_repeat" name="tab_repeat" class="tbox" autocomplete="off"><?php for($i=0;$i<count($repeat);$i++){?><option value="<?php echo $repeat[$i]?>" <?php echo $this->style['tab_repeat']==$repeat[$i]?'selected':''?>><?php echo $repeat[$i]?></option><?php }?></select> <font color="#999999">** ตั้งให้รูปวางซ้ำตามแกนที่กำหนด </font></td></tr>
        </table>    </td>
    </tr>
    <tr><th>สีตัวหนังสือเมนูหลัก</th><td><input type="text" autocomplete="off" class="tbox setcolor" size="10" name="tab_font" value="<?php echo $this->style['tab_font']?>" maxlength="7"> รหัสสี</td></tr>
    <tr><th>สีพื้นหลังเมนูหลัก</th><td><input type="text" autocomplete="off" class="tbox setcolor" size="10" name="tab_bg" value="<?php echo $this->style['tab_bg']?>" maxlength="7"> รหัสสี</td></tr>
    <tr><th>สีตัวหนังสือเมนูหลักเมื่อเมาท์ชี้ (mouse over)</th><td><input type="text" autocomplete="off" class="tbox setcolor" size="10" name="tab_hfont" value="<?php echo $this->style['tab_hfont']?>" maxlength="7"> รหัสสี</td></tr>
    <tr><th>สีพื้นหลังเมนูหลักเมื่อเมาท์ชี้ (mouse over)</th><td><input type="text" autocomplete="off" class="tbox setcolor" size="10" name="tab_hbg" value="<?php echo $this->style['tab_hbg']?>" maxlength="7"> รหัสสี</td></tr>
  </table>
    
    <h3 class="tabh">พื้นหลังเ้นื้อหา</h3>
    <table cellpadding="5" cellspacing="1" border="0" class="tbbullet" align="center" width="800">
    <tr><td rowspan="2" width="150" valign="top"><img src="<?php echo HTTP?>static/images/style/theme3.gif"></td><th width="150" align="right">สีพื้นหลัง </th>
    <td><input type="text" autocomplete="off" class="tbox setcolor" size="10" name="content_color" value="<?php echo $this->style['content_color']?>" maxlength="7"> รหัสสี</td></tr>
  	<tr><th width="100" align="right" valign="top">ภาพพื้นหลัง </th>
  	  <td valign="top">
      <div style="display:<?php echo $this->style['content_img']?'none':'block'?>"><a href="javascript:;" onclick="lz.box.open('#iframeupload');setTimeout(function(){$('#_box_upload')[0].src='<?php echo PATHMIN.SERVICE_LINK?>/<?php echo STYLEID?>/upload/content/<?php echo $this->style['id']?>';$('gboxc').style.padding='0px'},500)">อัพโหลดรูป</a></div>
      <div style="display:<?php echo $this->style['content_img']?'block':'none'?>"><a href="<?php echo HTTP?>files/style/<?php echo $this->style['content_img']?>" target="_blank">ดูรูป</a> |  [<a href="javascript:;" onclick="if(confirm('ต้องการลบรูปนี้หรือไม่'))ajax_del('content')">ลบ</a>]</div>
   <table width="83%">
   <tr><td align="right">Align : </td><td><select id="content_align" name="content_align" class="tbox" autocomplete="off"><?php for($i=0;$i<count($align);$i++){?><option value="<?php echo $align[$i]?>" <?php echo $this->style['content_align']==$align[$i]?'selected':''?>><?php echo $align[$i]?></option><?php }?></select> <font color="#999999">** ตั้งให้รูปชิดขอบที่กำหนด </font></td></tr>
   <tr><td align="right">Repeat : </td><td><select id="content_repeat" name="content_repeat" class="tbox" autocomplete="off"><?php for($i=0;$i<count($repeat);$i++){?><option value="<?php echo $repeat[$i]?>" <?php echo $this->style['content_repeat']==$repeat[$i]?'selected':''?>><?php echo $repeat[$i]?></option><?php }?></select> <font color="#999999">** ตั้งให้รูปวางซ้ำตามแกนที่กำหนด </font></td></tr>
   </table></td></tr>
   </table>
    <h3 class="tabh">พื้นหลังกล่องด้านซ้าย</h3>
    <table cellpadding="5" cellspacing="1" border="0" class="tbbullet" align="center" width="800">
    <tr><td rowspan="2" width="150" valign="top"><img src="<?php echo HTTP?>static/images/style/theme4.gif"></td><th width="150" align="right">สีพื้นหลัง </th>
    <td><input type="text" autocomplete="off" class="tbox setcolor" size="10" name="left_color" value="<?php echo $this->style['left_color']?>" maxlength="7"> รหัสสี</td></tr>
  	<tr><th width="100" align="right" valign="top">ภาพพื้นหลัง </th>
  	  <td valign="top">
      <div style="display:<?php echo $this->style['left_img']?'none':'block'?>"><a href="javascript:;" onclick="lz.box.open('#iframeupload');setTimeout(function(){$('#_box_upload')[0].src='<?php echo PATHMIN.SERVICE_LINK?>/<?php echo STYLEID?>/upload/left/<?php echo $this->style['id']?>';$('gboxc').style.padding='0px'},500)">อัพโหลดรูป</a></div>
      <div style="display:<?php echo $this->style['left_img']?'block':'none'?>"><a href="<?php echo HTTP?>files/style/<?php echo $this->style['left_img']?>" target="_blank">ดูรูป</a> |  [<a href="javascript:;" onclick="if(confirm('ต้องการลบรูปนี้หรือไม่'))ajax_del('left')">ลบ</a>]</div>
   <table width="83%">
   <tr><td align="right">Align : </td><td><select id="left_align" name="left_align" class="tbox" autocomplete="off"><?php for($i=0;$i<count($align);$i++){?><option value="<?php echo $align[$i]?>" <?php echo $this->style['left_align']==$align[$i]?'selected':''?>><?php echo $align[$i]?></option><?php }?></select> <font color="#999999">** ตั้งให้รูปชิดขอบที่กำหนด </font></td></tr>
   <tr><td align="right">Repeat : </td><td><select id="left_repeat" name="left_repeat" class="tbox" autocomplete="off"><?php for($i=0;$i<count($repeat);$i++){?><option value="<?php echo $repeat[$i]?>" <?php echo $this->style['left_repeat']==$repeat[$i]?'selected':''?>><?php echo $repeat[$i]?></option><?php }?></select> <font color="#999999">** ตั้งให้รูปวางซ้ำตามแกนที่กำหนด </font></td></tr>
   </table></td></tr>
   </table>
    <h3 class="tabh">พื้นหลังกล่องด้านขวา</h3>
    <table cellpadding="5" cellspacing="1" border="0" class="tbbullet" align="center" width="800">
    <tr><td rowspan="2" width="150" valign="top"><img src="<?php echo HTTP?>static/images/style/theme5.gif"></td><th width="150" align="right">สีพื้นหลัง </th>
    <td><input type="text" autocomplete="off" class="tbox setcolor" size="10" name="right_color" value="<?php echo $this->style['right_color']?>" maxlength="7"> รหัสสี</td></tr>
  	<tr><th width="100" align="right" valign="top">ภาพพื้นหลัง </th>
  	  <td valign="top">
      <div style="display:<?php echo $this->style['right_img']?'none':'block'?>"><a href="javascript:;" onclick="lz.box.open('#iframeupload');setTimeout(function(){$('#_box_upload')[0].src='<?php echo PATHMIN.SERVICE_LINK?>/<?php echo STYLEID?>/upload/right/<?php echo $this->style['id']?>';$('gboxc').style.padding='0px'},500)">อัพโหลดรูป</a></div>
      <div style="display:<?php echo $this->style['right_img']?'block':'none'?>"><a href="<?php echo HTTP?>files/style/<?php echo $this->style['right_img']?>" target="_blank">ดูรูป</a> |  [<a href="javascript:;" onclick="if(confirm('ต้องการลบรูปนี้หรือไม่'))ajax_del('right')">ลบ</a>]</div>
   <table width="83%">
   <tr><td align="right">Align : </td><td><select id="right_align" name="right_align" class="tbox" autocomplete="off"><?php for($i=0;$i<count($align);$i++){?><option value="<?php echo $align[$i]?>" <?php echo $this->style['right_align']==$align[$i]?'selected':''?>><?php echo $align[$i]?></option><?php }?></select> <font color="#999999">** ตั้งให้รูปชิดขอบที่กำหนด </font></td></tr>
   <tr><td align="right">Repeat : </td><td><select id="right_repeat" name="right_repeat" class="tbox" autocomplete="off"><?php for($i=0;$i<count($repeat);$i++){?><option value="<?php echo $repeat[$i]?>" <?php echo $this->style['right_repeat']==$repeat[$i]?'selected':''?>><?php echo $repeat[$i]?></option><?php }?></select> <font color="#999999">** ตั้งให้รูปวางซ้ำตามแกนที่กำหนด </font></td></tr>
   </table></td></tr>
   </table>
    <h3 class="tabh">พื้นหลังบาร์ภายในกล่องซ้าย</h3>
    <table cellpadding="5" cellspacing="1" border="0" class="tbbullet" align="center" width="800">
    <tr><td rowspan="4" width="150" valign="top"><img src="<?php echo HTTP?>static/images/style/theme6.gif"></td><th width="150" align="right">สีพื้นหลัง </th>
    <td><input type="text" autocomplete="off" class="tbox setcolor" size="10" name="lbar_color" value="<?php echo $this->style['lbar_color']?>" maxlength="7"> รหัสสี</td></tr>
  	<tr><th width="100" align="right" valign="top">ภาพพื้นหลัง </th>
  	  <td valign="top">
      <div style="display:<?php echo $this->style['lbar_img']?'none':'block'?>"><a href="javascript:;" onclick="lz.box.open('#iframeupload');setTimeout(function(){$('#_box_upload')[0].src='<?php echo PATHMIN.SERVICE_LINK?>/<?php echo STYLEID?>/upload/lbar/<?php echo $this->style['id']?>';$('gboxc').style.padding='0px'},500)">อัพโหลดรูป</a></div>
      <div style="display:<?php echo $this->style['lbar_img']?'block':'none'?>"><a href="<?php echo HTTP?>files/style/<?php echo $this->style['lbar_img']?>" target="_blank">ดูรูป</a> |  [<a href="javascript:;" onclick="if(confirm('ต้องการลบรูปนี้หรือไม่'))ajax_del('lbar')">ลบ</a>]</div>
   <table width="83%">
   <tr><td align="right">Align : </td><td><select id="bar_align" name="lbar_align" class="tbox" autocomplete="off"><?php for($i=0;$i<count($align);$i++){?><option value="<?php echo $align[$i]?>" <?php echo $this->style['lbar_align']==$align[$i]?'selected':''?>><?php echo $align[$i]?></option><?php }?></select> <font color="#999999">** ตั้งให้รูปชิดขอบที่กำหนด </font></td></tr>
   <tr><td align="right">Repeat : </td><td><select id="bar_repeat" name="lbar_repeat" class="tbox" autocomplete="off"><?php for($i=0;$i<count($repeat);$i++){?><option value="<?php echo $repeat[$i]?>" <?php echo $this->style['lbar_repeat']==$repeat[$i]?'selected':''?>><?php echo $repeat[$i]?></option><?php }?></select> <font color="#999999">** ตั้งให้รูปวางซ้ำตามแกนที่กำหนด </font></td></tr>
   </table></td></tr>
	<tr><th>สีตัวหนังสือ</th><td><input type="text" autocomplete="off" class="tbox setcolor" size="10" name="lbar_font" value="<?php echo $this->style['lbar_font']?>" maxlength="7"> รหัสสี</td></tr>
      </table>
    <h3 class="tabh">Footer</h3>
    <table cellpadding="5" cellspacing="1" border="0" class="tbbullet" align="center" width="800">
    <tr><td rowspan="2" width="150" valign="top"><img src="<?php echo HTTP?>static/images/style/theme11.gif"></td><th width="150" align="right">สีพื้นหลัง </th>
    <td><input type="text" autocomplete="off" class="tbox setcolor" size="10" name="foot_color" value="<?php echo $this->style['foot_color']?>" maxlength="7"> รหัสสี</td></tr>
  	<tr><th width="100" align="right" valign="top">ภาพพื้นหลัง </th>
  	  <td valign="top">
      <div style="display:<?php echo $this->style['foot_img']?'none':'block'?>"><a href="javascript:;" onclick="lz.box.open('#iframeupload');setTimeout(function(){$('#_box_upload')[0].src='<?php echo PATHMIN.SERVICE_LINK?>/<?php echo STYLEID?>/upload/foot/<?php echo $this->style['id']?>';$('gboxc').style.padding='0px'},500)">อัพโหลดรูป</a></div>
      <div style="display:<?php echo $this->style['foot_img']?'block':'none'?>"><a href="<?php echo HTTP?>files/style/<?php echo $this->style['foot_img']?>" target="_blank">ดูรูป</a> |  [<a href="javascript:;" onclick="if(confirm('ต้องการลบรูปนี้หรือไม่'))ajax_del('foot')">ลบ</a>]</div>
   <table width="83%">
   <tr><td align="right">Align : </td><td><select id="foot_align" name="foot_align" class="tbox" autocomplete="off"><?php for($i=0;$i<count($align);$i++){?><option value="<?php echo $align[$i]?>" <?php echo $this->style['foot_align']==$align[$i]?'selected':''?>><?php echo $align[$i]?></option><?php }?></select> <font color="#999999">** ตั้งให้รูปชิดขอบที่กำหนด </font></td></tr>
   <tr><td align="right">Repeat : </td><td><select id="foot_repeat" name="foot_repeat" class="tbox" autocomplete="off"><?php for($i=0;$i<count($repeat);$i++){?><option value="<?php echo $repeat[$i]?>" <?php echo $this->style['foot_repeat']==$repeat[$i]?'selected':''?>><?php echo $repeat[$i]?></option><?php }?></select> <font color="#999999">** ตั้งให้รูปวางซ้ำตามแกนที่กำหนด </font></td></tr>
   </table></td></tr>
   </table>
   <h3 class="tabh">สีข้อความ</h3>
    <table cellpadding="5" cellspacing="1" border="0" width="100%">
   <tr><th>สีตัวหนังสือทั่วไป</th><td><input type="text" autocomplete="off" class="tbox setcolor" size="10" name="text_font" value="<?php echo $this->style['text_font']?>" maxlength="7"> รหัสสี</td></tr>
    <tr><th>สีลิ้งค์ทั่วไป</th><td><input type="text" autocomplete="off" class="tbox setcolor" size="10" name="text_link"  value="<?php echo $this->style['text_link']?>" maxlength="7"> รหัสสี</td></tr>
    </table>
    <h3 class="tabh">CSS</h3>
    <table cellpadding="5" cellspacing="1" border="0" class="tbbullet" align="center" width="800">
    <tr>
    	 <td width="150" valign="top"><textarea id="css" name="css" class="tbox" style="width:788px; height:300px" autocomplete="off"><?php echo $this->style['css']?></textarea>
         </td>
    </tr>
    </table><br />

    <table cellpadding="5" cellspacing="1" border="0" class="tbbullet" align="center" width="800"><tr><td align="center"><br><input type="submit" class="submit" value="           บันทึก           "></td></tr>
    </table>
    </form>
    </div>
    </div>
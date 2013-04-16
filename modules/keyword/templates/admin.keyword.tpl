<?php if($this->searchnext==2):?>
<div style="border:1px solid #5A0; background:#EFD; color:#5A0; text-align:center; font-size:12px; padding:10px;">ค้นหาคีย์เวืร์ดและหมวดสินค้าทั้งหมดเรียบร้อยแล้ว</div>
<script>setTimeout(function(){window.location.href='<?php echo PATHMIN.SERVICE_LINK?>/';},5000)</script>
<?php elseif($this->searchnext==1):?>
<div style="border:1px solid #5A0; background:#FFF0D8; color:#FFB000; text-align:center; font-size:12px; padding:10px;">กรุณารอซักครู่... ระบบจะคำการค้นหา 5 คีย์เวิร์ดถัดไป</div>
<script>setTimeout(function(){window.location.reload();},2000)</script>
<?php endif?>

<div id="opencontent" style="display:none">
</div>
<div id="getkeyword"><?php echo $this->getkeyword?></div>

<div style="padding:5px; text-align:right; margin:5px 0px; border:1px solid #ddd; background:#f5f5f5">
<input type="button" class="button" value=" ค้นหาข้อมูลหมวดและจำนวนสินค้า " onClick="window.location.href='<?php echo PATHMIN.SERVICE_LINK?>/?searching';"> | 
<input type="button" class="button" value=" ลบข้อมูลทั้งหมด " onClick="if(confirm('คุณต้องการลบข้อมูลนี้ทั้งหมดหรือไม่'))ajax_bclear();">
</div>
<div style="padding:5px; text-align:right; margin:5px 0px; border:1px solid #ddd; background:#f5f5f5">
<form target="_blank" method="get" action="<?php echo PATHMIN.SERVICE_LINK?>/">
<input type="hidden" name="type" value="csv">
ส่งออกข้อมูล:
เฉพาะคีย์เวิร์ดที่มีสินค้า >= <input type="number" name="amount" class="tbox" value="1" size="5"> ชิ้น -
สร้างล้งค์โดย
<select name="link" class="tbox">
<option value="">ตัดช่องว่างออก</option>
<option value="-">แทนที่ช่องว่างด้วย -</option>
</select> -
เรียงโดย
<select name="order" class="tbox">
<option value="ใหม่ไปเก่า">ใหม่ไปเก่า</option>
<option value="เก่าไปใหม่">เก่าไปใหม่</option>
<option value="Rankมากสุด">Rankมากสุด</option>
<option value="Rankน้อยสุด">Rankน้อยสุด</option>
</select> -
จำนวนหน้าสูงสุด
<input type="number" name="limit" class="tbox" size="5" value="5">
<input type="submit" value=" ส่งออก " class="submit">
</form>
</div>
<script type="text/javascript">
function del(i){if(confirm('คุณต้องการลบหมวดนี้หรือไม่?'))ajax_del(i);}
function order(i,j){var search=$('#search').val();if(search.indexOf('/')>=0)alert("ไม่สามารถใช้งาน '/' ได้");else window.location.href='<?php echo PATHMIN.SERVICE_LINK?>/'+(search?'search/'+search+'/':'')+'order/'+i+'/by/'+j;}
function search2(){var search=$('#search').val(),order=$('#order').val(),by=$('#by').val();if(search.indexOf('/')>=0)alert("ไม่สามารถใช้งาน '/' ได้");else window.location.href='<?php echo PATHMIN.SERVICE_LINK?>/'+(search?'search/'+search+'/':'')+(order?'order/'+order+'/':'')+(by?'by/'+by+'/':'');}
</script>

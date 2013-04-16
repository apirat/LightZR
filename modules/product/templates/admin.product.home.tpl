<?php if($_SERVER['QUERY_STRING']=='updated'):?>
<div style="border:1px solid #5A0; background:#EFD; color:#5A0; text-align:center; font-size:12px; padding:10px;">อัพเดทสินค้าทุกหมวดเรียบร้อยแล้ว</div>
<?php endif?>
<?php if(isset($this->success)):?>
<div style="border:1px solid #5A0; background:#EFD; color:#5A0; text-align:center; font-size:12px; padding:10px;">อัพเดทหมวดสินค้าเรียบร้อยแล้ว (<?php echo number_format($this->success)?> หมวด)</div>
<?php endif?>

<div id="opencontent" style="display:none">
</div>
<div id="getcategory"><?php echo $this->getcategory?></div>
<div style="padding:5px; text-align:right; margin:5px 0px; border:1px solid #ddd; background:#f5f5f5">
<form action="<?php echo URL?>" method="post" enctype="multipart/form-data" onSubmit='if(!confirm("โปรดระวังการแก้ไขข้อมูลที่ไม่ถูกต้อง อาจจะทำให้หมวดสินค้าภายในเว็บของท่านเสียหายได้\r\nคุณต้องการดำเนินการอัพเดทข้อมูลด้วยวิธีนี้่ต่อหรือไม่"))return false;'><input type="file" class="tbox" name="file" size="0"> <input type="submit" class="button" value=" Import ">
| <input type="button" class="button" value=" Export " onClick="window.location.href='<?php echo PATHMIN.SERVICE_LINK?>/csv';">
</form>
</div>
<script type="text/javascript">
function del(i){if(confirm('คุณต้องการลบหมวดนี้หรือไม่?'))ajax_del(i);}
function order(i,j){var search=$('#search').val();if(search.indexOf('/')>=0)alert("ไม่สามารถใช้งาน '/' ได้");else window.location.href='<?php echo PATHMIN.SERVICE_LINK?>/'+(search?'search/'+search+'/':'')+'order/'+i+'/by/'+j;}
function search2(){var search=$('#search').val(),order=$('#order').val(),by=$('#by').val();if(search.indexOf('/')>=0)alert("ไม่สามารถใช้งาน '/' ได้");else window.location.href='<?php echo PATHMIN.SERVICE_LINK?>/'+(search?'search/'+search+'/':'')+(order?'order/'+order+'/':'')+(by?'by/'+by+'/':'');}
</script>
<div style="margin:5px 0px; padding:10px; text-align:left; line-height:1.8em; border:1px solid #FFD7AE; background:#FFF8F0"><strong>ไอคอนสัญลักษณ์</strong><br>
<img src="<?php echo HTTP?>static/images/list.png" alt="แสดง" /> - แสดงรายการสินค้าของหมวดนั้นๆ ภายในหน้าเว็บไซต์<br>
<img src="<?php echo HTTP?>static/images/icon/txt.gif" alt="สินค้าที่มีอยู่แล้ว" /> - แสดงรายการสินค้าของหมวดนั้นๆ ที่ทำการเพิ่มไว้แล้วในระบบ admin<br>
<img src="<?php echo HTTP?>static/images/edit.gif" alt="แก้ไขเพิ่มเติม" /> - กำหนดค่าในการค้นหาสินค้า<br>
<img src="<?php echo HTTP?>static/images/search.gif" alt="ค้นหา" /> - แสดงสินค้าที่ได้จากการค้นหาจากอเมซอน<br>
<img src="<?php echo HTTP?>static/images/find.png" alt="ค้นหาเปลี่ยนหน้าอัตโนมัติ" />  - แสดงสินค้าที่ได้จากการค้นหาจากอเมซอน พร้อมทั้งเพิ่มสินค้านั้นๆเข้าระบบโดยอัตโนมัติตามเงื่ิอนไขที่เซ็ทค่าไว้<br>
<br>
<img src="<?php echo HTTP?>static/images/pass.gif" alt="เปิดการใช้งาน autopost" /> <img src="<?php echo HTTP?>static/images/fail.gif" alt="ปิดการใช้งาน autopost" /> - เปิด/ปิด การใช้งานโพสสินค้าอัตโนมัติของแต่ละหมวดสินค้า (คลิกที่ไอคอนเพื่อสลับการเปิดปิด)
</div>
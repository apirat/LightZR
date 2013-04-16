<div id="newproduct" class="setview">
<h2>เพิ่มสินค้า</h2>
<div style="margin:10px; text-align:left; width:320px;">
<form method="post" onsubmit="ajax_newproduct(this);lz.box.close();return false;">
<table cellpadding="5" cellspacing="5" border="0">
<tr><td align="right">รหัสสินค้า (asin)</td><td><input type="text" name="asin" size="30" class="tbox"></td></tr>
<tr><td colspan="2" align="center"><input type="submit" class="submit" value=" ตกลง "> <input type="button" class="button" value=" ยกเลิก " onClick="lz.box.close()" /></td></tr>
</table>
</form>
</div>
</div>
<div id="opencontent" style="display:none">
</div>
<div id="getproduct"><?php echo $this->getproduct?></div>
<script type="text/javascript">
function re(i){if(confirm('คุณต้องการดึงข้อมูลสินค้านี้ใหม่หรือไม่?'))ajax_reload(i);}
function del(i){if(confirm('คุณต้องการลบสินค้านี้หรือไม่?'))ajax_del(i);}
function delcontent(i){if(confirm('คุณต้องการลบเนื้อหาของสินค้านี้หรือไม่?'))ajax_delcontent(i);}
function search2(){var search=$('#search').val(),order=$('#order').val(),by=$('#by').val();if(search.indexOf('/')>=0)alert("ไม่สามารถใช้งาน '/' ได้");else window.location.href='<?php echo PATHMIN.SERVICE_LINK?>/list/<?php echo lz::$f[1]?>/'+(search?'search/'+search+'/':'')+(order?'order/'+order+'/':'')+(by?'by/'+by+'/':'');}
function order(i,j){var search=$('#search').val();if(search.indexOf('/')>=0)alert("ไม่สามารถใช้งาน '/' ได้");else window.location.href='<?php echo PATHMIN.SERVICE_LINK?>/list/<?php echo lz::$f[1]?>/'+(search?'search/'+search+'/':'')+'order/'+i+'/by/'+j;}
</script>
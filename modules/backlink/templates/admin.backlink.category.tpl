<div id="getcategory"><?php echo $this->getcategory?></div>
<script type="text/javascript">
function re(i){if(confirm('คุณต้องการดึงข้อมูลสินค้านี้ใหม่หรือไม่?'))ajax_reload(i);}
function del(i){if(confirm('คุณต้องการลบสินค้านี้หรือไม่?'))ajax_del(i);}
function search2(){var search=$('#search').val(),order=$('#order').val(),by=$('#by').val();if(search.indexOf('/')>=0)alert("ไม่สามารถใช้งาน '/' ได้");else window.location.href='<?php echo PATHMIN.SERVICE_LINK?>/post/'+(search?'search/'+search+'/':'')+(order?'order/'+order+'/':'')+(by?'by/'+by+'/':'');}
function order(i,j){var search=$('#search').val();if(search.indexOf('/')>=0)alert("ไม่สามารถใช้งาน '/' ได้");else window.location.href='<?php echo PATHMIN.SERVICE_LINK?>/post/'+(search?'search/'+search+'/':'')+'order/'+i+'/by/'+j;}
</script>
<div style="margin:5px 0px; padding:10px; text-align:left; line-height:1.8em; border:1px solid #FFD7AE; background:#FFF8F0"><strong>ไอคอนสัญลักษณ์</strong><br>
<img src="<?php echo HTTP?>static/images/pass.gif" alt="เปิดการใช้งาน backlink" /> <img src="<?php echo HTTP?>static/images/fail.gif" alt="ปิดการใช้งาน backlink" /> - เปิด/ปิด การใช้งานสร้าง backlink อัตโนมัติของแต่ละหมวดสินค้า (คลิกที่ไอคอนเพื่อสลับการเปิดปิด)
</div>
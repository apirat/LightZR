<div id="getsearched"><?php echo $this->getsearched?></div>
<script type="text/javascript">
function re(i){if(confirm('คุณต้องการดึงข้อมูลสินค้านี้ใหม่หรือไม่?'))ajax_reload(i);}
function del(i){if(confirm('คุณต้องการลบคีย์เวิร์ดนี้หรือไม่?'))ajax_del(i);}
function search2(){var search=$('#search').val(),order=$('#order').val(),by=$('#by').val();if(search.indexOf('/')>=0)alert("ไม่สามารถใช้งาน '/' ได้");else window.location.href='<?php echo PATHMIN.SERVICE_LINK?>/'+(search?'search/'+search+'/':'')+(order?'order/'+order+'/':'')+(by?'by/'+by+'/':'');}
function order(i,j){var search=$('#search').val();if(search.indexOf('/')>=0)alert("ไม่สามารถใช้งาน '/' ได้");else window.location.href='<?php echo PATHMIN.SERVICE_LINK?>/'+(search?'search/'+search+'/':'')+'order/'+i+'/by/'+j;}
</script>
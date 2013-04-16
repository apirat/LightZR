<div id="getblog"><?php echo $this->getblog?></div>
<script type="text/javascript">
function re(i){if(confirm('คุณต้องการดึงข้อมูลสินค้านี้ใหม่หรือไม่?'))ajax_reload(i);}
function del(i){if(confirm('คุณต้องการลบสินค้านี้หรือไม่?'))ajax_del(i);}
function search2(){var search=$('#search').val(),order=$('#order').val(),by=$('#by').val();if(search.indexOf('/')>=0)alert("ไม่สามารถใช้งาน '/' ได้");else window.location.href='<?php echo PATHMIN.SERVICE_LINK?>/'+(search?'search/'+search+'/':'')+(order?'order/'+order+'/':'')+(by?'by/'+by+'/':'');}
function order(i,j){var search=$('#search').val();if(search.indexOf('/')>=0)alert("ไม่สามารถใช้งาน '/' ได้");else window.location.href='<?php echo PATHMIN.SERVICE_LINK?>/'+(search?'search/'+search+'/':'')+'order/'+i+'/by/'+j;}
</script>
<div style="margin:5px 0px; padding:10px; text-align:center; border:1px solid #FFD7AE; background:#FFF8F0">เซ็ท CronJob ด้วยค่ำสั่ง  &nbsp; &nbsp; */15 &nbsp; * &nbsp; * &nbsp; * &nbsp; * &nbsp; curl http://www.<?php echo lz::$cf['domain'].HTTP?>cron/<b><?php echo lz::$c['cron']?></b></div>
<div style="margin:5px 0px; padding:10px; text-align:center; border:1px solid #FFD7AE; background:#FFF8F0">สามารถแก้ไข template ของบทความได้ที่ไฟล์ /themes/<b><?php echo lz::$c['theme']?></b>/templates/www.cron.blacklink.tpl</div>

<div id="getautopost"><?php echo $this->getautopost?></div>
<script type="text/javascript">
function re(i){if(confirm('คุณต้องการดึงข้อมูลสินค้านี้ใหม่หรือไม่?'))ajax_reload(i);}
function del(i){if(confirm('คุณต้องการลบสินค้านี้หรือไม่?'))ajax_del(i);}
function search2(){var search=$('#search').val(),order=$('#order').val(),by=$('#by').val();if(search.indexOf('/')>=0)alert("ไม่สามารถใช้งาน '/' ได้");else window.location.href='<?php echo PATHMIN.SERVICE_LINK?>/'+(search?'search/'+search+'/':'')+(order?'order/'+order+'/':'')+(by?'by/'+by+'/':'');}
function order(i,j){var search=$('#search').val();if(search.indexOf('/')>=0)alert("ไม่สามารถใช้งาน '/' ได้");else window.location.href='<?php echo PATHMIN.SERVICE_LINK?>/'+(search?'search/'+search+'/':'')+'order/'+i+'/by/'+j;}
</script>
<div style="margin:5px 0px; padding:10px; text-align:left; line-height:1.8em; border:1px solid #FFD7AE; background:#FFF8F0">
<b>เปิดใช้งาน โพสสินค้าอัตโนมัติ</b><br>
ระบบสามารถเพิ่มสินค้าอัตโนมัติได้โดยการ<br>
1. เพิ่มหมวดสินค้าและกำหนดการค้นหาให้เรียบร้อย โดยสามารถดูรายละเอียดได้ที่ <a href="http://seo.phukettech.com/index.php/topic,86.0.html" target="_blank">วิธีการเพิ่มหมวด</a> โดยไม่ต้องทำการเพิ่มสินค้า<br>
2. เปิดใช้งานใน "ปรับแต่งค่าพื้นฐาน" -&gt; Cronjob -> ในส่วนของดีเลย์การใช้งานระบบโพสสินค้าอัตโนมัติ<br>
3. ปรับแต่งการทำงานใน "ปรับแต่งค่าพื้นฐาน" -&gt; ระบบโพสสินค้าิอัตโนมัติ<br>
4. เซ็ท Cpanel -> CronJob ด้วยค่ำสั่ง  &nbsp; &nbsp; */15 &nbsp; * &nbsp; * &nbsp; * &nbsp; * &nbsp; curl http://www.<?php echo lz::$cf['domain'].HTTP?>cron/<?php echo lz::$c['cron']?> (สำหรับโฮสบางที่อาจจะสามารถใช้ดีเลย์ได้น้อยกว่า 15นาที) (<a href="http://seo.phukettech.com/index.php/topic,88.0.html" target="_blank">การใช้งาน cronjob</a>)
</div>

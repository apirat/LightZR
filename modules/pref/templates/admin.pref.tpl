<table cellpadding="3" cellspacing="1" border="0" width="100%" class="tbservice">
<tr><th colspan="2" align="center">รายละเอียดเว็บไซต์</th></tr>
<?php echo $this->html->tr('Site Name','sitename',$this->pref['sitename'],'input',array('full'=>true,'space'=>''))?>
<?php echo $this->html->tr('Site Title','title',$this->pref['title'],'input',array('full'=>true,'space'=>''))?>
<?php echo $this->html->tr('Site Footer','disclaimer',$this->pref['disclaimer'],'textarea',array('full'=>true,'space'=>''))?>
<tr><th colspan="2" align="center">Meta Tags</th></tr>
<?php echo $this->html->tr('Description','description',$this->pref['description'],'input',array('full'=>true,'space'=>''))?>
<?php echo $this->html->tr('Keywords','keywords',$this->pref['keywords'],'input',array('full'=>true,'space'=>''))?>
<?php echo $this->html->tr('Meta-tags อื่นๆ<br /><br /><span style=" font-family:tahoma;font-weight:normal;font-size:9px !important">เช่น. &lt;meta name=\'author\' content=\'your name\' /&gt;</span>','meta',$this->pref['meta'],'textarea',array('full'=>true,'space'=>''))?>
<tr><th colspan="2" align="center">การแสดงผล</th></tr>
<?php echo $this->html->tr('ชุดรูปแบบ Theme/Template','theme',$this->pref['theme'],'select',array('full'=>true),$this->theme)?>
<?php echo $this->html->tr('รูปแบบของ url','sub',$this->pref['sub'],'select',array('full'=>true),array('0'=>'1. Sub Folder  - domain.com/keyword/product','1'=>'2. Sub Folder - domain.com/product','2'=>'3. Sub Domain - keyword.domain.com/product'))?>
<?php echo $this->html->tr('จำนวนคำมากสุดของชื่อสินค้าบน url','linkword',$this->pref['linkword'],'input',array('full'=>true))?>
<?php echo $this->html->tr('url ลงท้ายสำหรับหน้ารายละเอียดสินค้า','pinfo',$this->pref['pinfo'],'input',array('full'=>true,'space'=>''))?>
<?php echo $this->html->tr('url ลงท้ายสำหรับหน้า redirect ไปหน้าสินค้าในอเมซอน','pstore',$this->pref['pstore'],'input',array('full'=>true))?>
<?php echo $this->html->tr('url ลงท้ายสำหรับหน้า redirect ไปหน้าเปรียบเทียบราคาในอเมซอน','pcompare',$this->pref['pcompare'],'input',array('full'=>true))?>
<?php echo $this->html->tr('url ลงท้ายสำหรับหน้า redirect ไปหน้าสินค้า customer review','preview',$this->pref['preview'],'input',array('full'=>true))?>
<?php echo $this->html->tr('เรียงลำดับสินค้าโดย','order',$this->pref['order'],'select',array('full'=>true),array('title'=>'ชื่อสินค้า','avg'=>'ดาว(rating)','price'=>'ราคาเริ่มต้นสินค้า','saleprice'=>'ราคาพิเศษ','added'=>'เวลาที่เพิ่มข้อมูลครั้งแรก','lastupdate'=>'เวลาที่อัพเดทข้อมูลล่าสุด'))?>
<?php echo $this->html->tr('เรียงลำดับสินค้าจาก','by',$this->pref['by'],'select',array('full'=>true),array('desc'=>'หลังไปหน้า(มากไปน้อย)','asc'=>'หน้าไปหลัง(น้อยไปมาก)'))?>

<?php echo $this->html->tr('จำนวนดาวขั้นต่ำของสินค้าที่แสดงในหน้าแรกโดเมน','homestar',$this->pref['homestar'],'input',array('full'=>true))?>
<?php echo $this->html->tr('ราคาขั้นต่ำของสินค้าที่แสดงในหน้าแรกโดเมน','homeprice',$this->pref['homeprice'],'input',array('full'=>true))?>
<?php echo $this->html->tr('รายชื่อกลุ่มสินค้า','pgroup',$this->pref['pgroup'],'textarea',array('full'=>true,'space'=>''))?>
<tr><th colspan="2" align="center">Amazon</th></tr>
<?php echo $this->html->tr('Zone','zone',$this->pref['zone']?$this->pref['zone']:lz::$c['zone'],'select',array('full'=>true),array('ca'=>'Canada (ca)','com'=>'America (com)','co.uk'=>'England (co.uk)','de'=>'Germany (de)','fr'=>'France (fr)','jp'=>'Japan (jp)'))?>
<?php echo $this->html->tr('Associate Key','awskey',$this->pref['awskey'],'input',array('full'=>true,'space'=>''))?>
<?php echo $this->html->tr('Associate Secret','awssecret',$this->pref['awssecret'],'input',array('full'=>true,'space'=>''))?>
<?php echo $this->html->tr('Associate Tag','awstag',$this->pref['awstag'],'input',array('full'=>true,'space'=>''))?>
<tr><th colspan="2" align="center">Facebook</th></tr>
<?php echo $this->html->tr('Application ID','fbappid',$this->pref['fbappid'],'input',array('full'=>true,'space'=>''))?>
<?php echo $this->html->tr('Application Secret','fbappsecret',$this->pref['fbappsecret'],'input',array('full'=>true,'space'=>''))?>
<!--
<tr><th colspan="2" align="center">Twitter (สำหรับสุ่มโพสสินค้าไปยัง twiiter หากมีหลาย account ให้ใช้ , คั่น)</th></tr>
<?php echo $this->html->tr('Twitter Username','twuser',$this->pref['twuser'],'input',array('full'=>true,'space'=>''))?>
<?php echo $this->html->tr('Twitter Password','twpass',$this->pref['twpass'],'input',array('full'=>true,'space'=>''))?>
<?php echo $this->html->tr('รูปแบบสำหรับการโพส','twformat',$this->pref['twformat'],'input',array('full'=>true,'space'=>'','text2'=>' (เช่น {message} at {link} #amazon #cheap #price)'))?>
-->
<tr><th colspan="2" align="center">บันทึกรายงาน</th></tr>
<?php echo $this->html->tr('เก็บข้อมูลของ Google Bot','bot',$this->pref['bot'],'select',array('full'=>true),array('1'=>'เก็บ','0'=>'ไม่เก็บ'))?>
<?php echo $this->html->tr('เก็บข้อมูลการเข้าเว็บผ่าน Google','referer',$this->pref['referer'],'select',array('full'=>true),array('1'=>'เก็บ','0'=>'ไม่เก็บ'))?>
<?php echo $this->html->tr('เก็บข้อมูลการคลิกสินค้า','click',$this->pref['click'],'select',array('full'=>true),array('1'=>'เก็บ','0'=>'ไม่เก็บ'))?>
<tr><th colspan="2" align="center">Cronjob</th></tr>
<?php echo $this->html->tr('ดีเลย์ระบบโพสสินค้าด้วย ASIN','asindelay',$this->pref['asindelay'],'select',array('full'=>true),array('0'=>'ปิดการทำงาน','1'=>'1 นาที (สำหรับโฮสที่ตั้ง cron ได้ 1นาที)','2'=>'2 นาที (สำหรับโฮสที่ตั้ง cron ได้น้อยกว่าหรือเท่ากับ 2นาที)','5'=>'5 นาที (สำหรับโฮสที่ตั้ง cron ได้น้อยกว่าหรือเท่ากับ 5นาที)','10'=>'10 นาที (สำหรับโฮสที่ตั้ง cron ได้น้อยกว่าหรือเท่ากับ 10นาที)','15'=>'15 นาที','30'=>'30 นาที','30'=>'1 ชม','120'=>'2 ชม','180'=>'3 ชม','360'=>'6 ชม','720'=>'12 ชม','1080'=>'18 ชม','1440'=>'24 ชม'))?>
<?php echo $this->html->tr('ดีเลย์ระบบโพสสินค้าอัตโนมัติ (AutoPost)','apdelay',$this->pref['apdelay'],'select',array('full'=>true),array('0'=>'ปิดการทำงาน','1'=>'1 นาที (สำหรับโฮสที่ตั้ง cron ได้ 1นาที)','2'=>'2 นาที (สำหรับโฮสที่ตั้ง cron ได้น้อยกว่าหรือเท่ากับ 2นาที)','5'=>'5 นาที (สำหรับโฮสที่ตั้ง cron ได้น้อยกว่าหรือเท่ากับ 5นาที)','10'=>'10 นาที (สำหรับโฮสที่ตั้ง cron ได้น้อยกว่าหรือเท่ากับ 10นาที)','15'=>'15 นาที','30'=>'30 นาที','30'=>'1 ชม','120'=>'2 ชม','180'=>'3 ชม','360'=>'6 ชม','720'=>'12 ชม','1080'=>'18 ชม','1440'=>'24 ชม'))?>
<?php echo $this->html->tr('ดีเลย์ระบบ rewrite สินค้าที่เคยเพิ่มไว้แล้ว','rwdelay',$this->pref['rwdelay'],'select',array('full'=>true),array('0'=>'ปิดการทำงาน','1'=>'1 นาที (สำหรับโฮสที่ตั้ง cron ได้ 1นาที)','2'=>'2 นาที (สำหรับโฮสที่ตั้ง cron ได้น้อยกว่าหรือเท่ากับ 2นาที)','5'=>'5 นาที (สำหรับโฮสที่ตั้ง cron ได้น้อยกว่าหรือเท่ากับ 5นาที)','10'=>'10 นาที (สำหรับโฮสที่ตั้ง cron ได้น้อยกว่าหรือเท่ากับ 10นาที)','15'=>'15 นาที','30'=>'30 นาที','30'=>'1 ชม','120'=>'2 ชม','180'=>'3 ชม','360'=>'6 ชม','720'=>'12 ชม','1080'=>'18 ชม','1440'=>'24 ชม'))?>
<?php echo $this->html->tr('ดีเลย์ระบบการสร้างแบ็คลิ้งค์ (Backlink)','bldelay',$this->pref['bldelay'],'select',array('full'=>true),array('0'=>'ปิดการทำงาน','1'=>'1 นาที (สำหรับโฮสที่ตั้ง cron ได้ 1นาที)','2'=>'2 นาที (สำหรับโฮสที่ตั้ง cron ได้น้อยกว่าหรือเท่ากับ 2นาที)','5'=>'5 นาที (สำหรับโฮสที่ตั้ง cron ได้น้อยกว่าหรือเท่ากับ 5นาที)','10'=>'10 นาที (สำหรับโฮสที่ตั้ง cron ได้น้อยกว่าหรือเท่ากับ 10นาที)','15'=>'15 นาที','30'=>'30 นาที','30'=>'1 ชม','120'=>'2 ชม','180'=>'3 ชม','360'=>'6 ชม','720'=>'12 ชม','1080'=>'18 ชม','1440'=>'24 ชม'))?>
<!--
<?php echo $this->html->tr('ดีเลย์ระบบการโพสสินค้าไปยัง Twitter','twdelay',$this->pref['twdelay'],'select',array('full'=>true),array('0'=>'ปิดการทำงาน','1'=>'1 นาที (สำหรับโฮสที่ตั้ง cron ได้ 1นาที)','2'=>'2 นาที (สำหรับโฮสที่ตั้ง cron ได้น้อยกว่าหรือเท่ากับ 2นาที)','5'=>'5 นาที (สำหรับโฮสที่ตั้ง cron ได้น้อยกว่าหรือเท่ากับ 5นาที)','10'=>'10 นาที (สำหรับโฮสที่ตั้ง cron ได้น้อยกว่าหรือเท่ากับ 10นาที)','15'=>'15 นาที','30'=>'30 นาที','30'=>'1 ชม','120'=>'2 ชม','180'=>'3 ชม','360'=>'6 ชม','720'=>'12 ชม','1080'=>'18 ชม','1440'=>'24 ชม'))?>
-->
<?php echo $this->html->tr('ดีเลย์ในการ ping เรียกบอท','pgdelay',$this->pref['pgdelay'],'select',array('full'=>true),array('0'=>'ปิดการทำงาน','1'=>'1 นาที (สำหรับโฮสที่ตั้ง cron ได้ 1นาที)','2'=>'2 นาที (สำหรับโฮสที่ตั้ง cron ได้น้อยกว่าหรือเท่ากับ 2นาที)','5'=>'5 นาที (สำหรับโฮสที่ตั้ง cron ได้น้อยกว่าหรือเท่ากับ 5นาที)','10'=>'10 นาที (สำหรับโฮสที่ตั้ง cron ได้น้อยกว่าหรือเท่ากับ 10นาที)','15'=>'15 นาที','30'=>'30 นาที','30'=>'1 ชม','120'=>'2 ชม','180'=>'3 ชม','360'=>'6 ชม','720'=>'12 ชม','1080'=>'18 ชม','1440'=>'24 ชม'))?>
<?php echo $this->html->tr('url สำหรับเรียกใช้งาน cronjob','cron',$this->pref['cron'],'input',array('text1'=>'http://www.'.lz::$cf['domain'].QUERY.'cron/'))?>
<tr><th colspan="2" align="center">ระบบโพสสินค้าอัตโนมัติ / rewrite บทความ</th></tr>
<?php echo $this->html->tr('ข้อมูลที่ต้องการ rewrite','aptype',$this->pref['aptype'],'select',array('full'=>true),array('0'=>'ปิดการทำงาน','1'=>'รายละเอียดสินค้า','2'=>'ชื่อสินค้า + รายละเอียดสินค้า','3'=>'รายละเอียดสินค้า + ความคิดเห็นของลูกค้า','4'=>'ชื่อสินค้า + รายละเอียดสินค้า + ความคิดเห็นของลูกค้า'))?>
<?php echo $this->html->tr('ภาษาที่ใช้ในการแปลงรายละเอียดสินค้า','apdlang',$this->pref['apdlang'],'input',array('full'=>true,'text2'=>' (หากปล่อยว่างคือไม่ใช่งาน rewrite, รูปแบบที่กรอกเช่น fr, it, en)'))?>
<?php echo $this->html->tr('ภาษาที่ใช้ในการแปลงความคิดเห็นของลูกค้า','aprlang',$this->pref['aprlang'],'input',array('full'=>true,'text2'=>' (หากปล่อยว่างคือไม่ใช่งาน rewrite, รูปแบบที่กรอกเช่น ga, sv, en)'))?>
<?php echo $this->html->tr('ทำการ ping ทันทีเมื่อมีการโพสสินค้า','apping',$this->pref['apping'],'select',array('full'=>true),array('0'=>'ปิดการทำงาน','1'=>'เปิดการทำงานทุกครั้ง','2'=>'เปิดการทำงานแบบสุ่ม(ใช้งาน/ไม่ใช้งาน)'))?>

<tr><th colspan="2" align="center">Account สำหรับ The Best Spinner</th></tr>
<?php echo $this->html->tr('Email','spuser',$this->pref['spuser'],'input',array('full'=>true,'space'=>''))?>
<?php echo $this->html->tr('Password','sppass',$this->pref['sppass'],'input',array('full'=>true,'space'=>''))?>
<tr><td></td><td>* หากไม่ต้องการใช้งานส่วนนี้ ให้ปล่อยว่างหรือลบ Username/Password ออก<br>* ระบบจะเลือกการ spin ก่อน หากในกรณีที่ spin ไม่สำเร็จ จะเปลี่ยนไปใช้การ rewrite แทน</td></tr>
<tr><th colspan="2" align="center">อื่นๆ</th></tr>
<?php echo $this->html->tr('ป้องกันการเพิ่ม indexd จาก Google','antiindex',$this->pref['antiindex'],'select',array('full'=>true),array('0'=>'ปิดการทำงาน','1'=>'ตั้ง nofollow สำหรับสินค้าที่บอทไม่เึคยเข้า','2'=>'ตั้ง nofollow และ redirect ไปยังหน้ารวมสินค้า สำหรับสินค้าที่บอทไม่เึคยเข้า','3'=>'ตั้ง nofollow สำหรับสินค้าที่ไม่ได้ rewrite หรือไม่ได้เพิ่มรายละเอียดสินค้าใหม่'))?>
<?php echo $this->html->tr('เปิดใช้งาน Feed','rss',$this->pref['rss'],'select',array('full'=>true),array('1'=>'เปิดการทำงาน','0'=>'ปิดการทำงาน'))?>
<?php echo $this->html->tr('เปิดใช้งาน Sitemap','sitemap',$this->pref['sitemap'],'select',array('full'=>true),array('1'=>'เปิดการทำงาน','0'=>'ปิดการทำงาน'))?>
<?php echo $this->html->tr('ดึงรูปภาพมาเก็บไว้ที่โฮสอัตโนมัติเมื่อมีการเพิ่มสินค้า','image',$this->pref['image'],'select',array('full'=>true),array('0'=>'ปิดการทำงาน','1'=>'ดึงเฉพาะภาพเล็กสุด(list)และภาพใหญ่สุด(view)','2'=>'ดึงเฉพาะภาพขนาดกลาง(gallery)และภาพใหญ่สุด(view)'))?>
<?php echo $this->html->tr('prefix สำหรับแทรกใน html','prefix',$this->pref['prefix'],'input',array('full'=>true))?>
</table>
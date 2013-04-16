<div id="newblog" class="setview">
<h2>เพิ่มบล็อกใหม่</h2>
<div style="margin:10px; text-align:left; width:300px;">
<form method="post" onsubmit="ajax_newblog(this);lz.box.close();return false;">
<table cellpadding="5" cellspacing="5" border="0" align="center">
<tr><td align="right" width="100">บล็อก</td><td>
<select name="blog"><option value="">เลือกบล็อก</option>
<?php if(is_array($this->allblog)):?>
<?php foreach($this->allblog as $val):?>
<option value="<?php echo $val['id']?>"><?php echo $val['title']?> (<?php echo $val['blogtype']?>)</option>
<?php endforeach?>
<?php endif?>
</select>
</td></tr>
<tr><td colspan="2" align="center"><input type="submit" class="submit" value=" ถัดไป " /> <input type="button" class="button" value=" ยกเลิก " onClick="lz.box.close()" /></td></tr>
</table>
</form>
</div>
</div>


<div style="padding:5px;">
<table cellpadding="5" cellspacing="1" border="0" width="100%" class="tbservice">

<tr><th colspan="2" align="center">รายละเอียด</th></tr>
<tr><td class="colum">ชื่อหมวด</td><td><?php echo $this->cate['title']?></td></tr>
<?php echo $this->html->tr('<strong style="color:red">*</strong> ลิ้งค์','link',$this->cate['link'],'input',array('full'=>true))?>
<?php echo $this->html->tr('<strong style="color:red">*</strong> กลุ่มสินค้า','pgroup',$this->cate['pgroup'],'select',array('full'=>true,'space'=>''),$this->pgroup)?>
<?php echo $this->html->tr('หมวดกล่องโฆษณา','cmode',$this->cate['cmode'],'select',array('full'=>true,'space'=>''),$this->cmode)?>
<?php echo $this->html->tr('Ads 120','ads120',$this->cate['ads120'],'select',array('full'=>true,'space'=>''),$this->ads120)?>
<?php echo $this->html->tr('Ads 468','ads468',$this->cate['ads468'],'select',array('full'=>true,'space'=>''),$this->ads468)?>

<tr><th colspan="2" align="center">รูปแบบการแสดงผล (หากปล่อยว่าง ระบบจะใช้ค่าดั้งเดิมจากระบบปรับแต่งพื้นฐาน)</th></tr>
<?php echo $this->html->tr('Domain','domain',$this->cate['domain'],'input',array('space'=>'','full'=>true,'text2'=>' สำหรับ mapping domain เข้ากับสินค้าหมวดนี้'))?>
<?php echo $this->html->tr('Title','mtitle',$this->cate['mtitle'],'input',array('space'=>'','full'=>true))?>
<?php echo $this->html->tr('Description','mdescription',$this->cate['mdescription'],'input',array('space'=>'','full'=>true))?>
<?php echo $this->html->tr('Keywords','mkeywords',$this->cate['mkeywords'],'input',array('space'=>'','full'=>true))?>
<?php echo $this->html->tr('Meta-tags อื่นๆ<br /><br /><span style=" font-family:tahoma;font-weight:normal;font-size:9px !important">เช่น. &lt;meta name=\'author\' content=\'your name\' /&gt;</span>','meta',$this->cate['meta'],'textarea',array('full'=>true,'space'=>''))?>
<?php echo $this->html->tr('Footer','footer',$this->cate['footer'],'input',array('space'=>'','full'=>true))?>
<?php echo $this->html->tr('AwsTag','awstag',$this->cate['footer'],'input',array('space'=>'','full'=>true))?>

<?php echo $this->html->tr('ชุดรูปแบบ Theme/Template','theme',$this->cate['theme'],'select',array('full'=>true,'space'=>''),$this->theme)?>
<tr><th colspan="2" align="center">วิธีค้นหาสินค้า</th></tr>


<?php echo $this->html->tr('<strong style="color:red">*</strong> หมวดในการค้น','searchindex',$this->cate['searchindex'],'select',array('space'=>''),$this->searchindex)?>
<?php echo $this->html->tr('<strong style="color:red">*</strong> คำค้นหา','keywords',$this->cate['keywords'],'input',array('space'=>'','full'=>true))?>
<?php echo $this->html->tr('BrowseNode','node',$this->cate['node'],'input',array('space'=>'','full'=>true))?>
<?php echo $this->html->tr('เพิ่มเฉพาะหมวด','onlygroup',$this->cate['onlygroup'],'input',array('space'=>'','full'=>true))?>
<?php echo $this->html->tr('สินค้าที่มีคำนี้(บางคำ)','intitle',$this->cate['intitle'],'input',array('space'=>'','full'=>true))?>
<?php echo $this->html->tr('สินค้าที่มีคำนี้(ทุกคำ)','inalltitle',$this->cate['inalltitle'],'input',array('space'=>'','full'=>true))?>
<?php echo $this->html->tr('สินค้าที่ไม่มีคำนี้','outtitle',$this->cate['outtitle'],'input',array('space'=>'','full'=>true))?>
<?php //=$this->html->tr('มีเรทติ้งมากกว่าหรือเท่ากับ','rate',$this->cate['rate'],'input',array('space'=>'0','full'=>true))?>
<?php echo $this->html->tr('จากผู้ผลิตเท่านั้น','onlymanu',$this->cate['onlymanu'],'input',array('space'=>'','full'=>true))?>
<?php //=$this->html->tr('จำนวนข้อมูล','getmax',$this->cate['getmax'],'input',array('space'=>'0','full'=>true))?>
<?php echo $this->html->tr('<strong style="color:red">*</strong> ค้นหาไม่เกินหน้า','maxpage',$this->cate['maxpage'],'input',array('space'=>'0','full'=>true))?>
<?php echo $this->html->tr('<strong style="color:red">*</strong> เรียกข้อมูลจาก','rsort',$this->cate['rsort'],'select',array('space'=>'0'),$this->amazon->reviewsort)?>

<tr><td colspan="2" align="center"><input type="button" class="submit" value=" กลับไปหน้าหมวดสินค้า " onClick="window.location.href='<?php echo PATHMIN.SERVICE_LINK?>';"></td></td>
</table>
<br />
</div>



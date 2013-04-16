<table cellpadding="3" cellspacing="1" border="0" class="tbservice" width="100%">
<tr><th colspan="2" align="center">ข้อมูลการใช้เว็บไซต์</td></tr>
<?php echo $this->html->tr('ชื่อในการแสดงผล','display',$this->profile['display'],'input',array('full'=>1))?>
<tr><td valign='top' align="right" width="150"><b>อีเมลล์</b>:</td><td valign='top'><?php echo $this->profile['email']?></td></tr>
<tr><td valign='top' align="right" width="150"><b>สิทธิ์การใช้งาน</b>:</td><td valign='top'><?php echo $this->status[$this->profile['status']]?></td></tr>
<tr><td valign='top' align="right" width="150"><b>เข้าร่วมเมื่อ</b>:</td><td valign='top'><?php echo time::show($this->profile['joined'],'datetime')?></td></tr>
<tr><th colspan="2" align="center">ข้อมูลส่วนตัว</td></tr>
<?php echo $this->html->tr('ชื่อ','firstname',$this->profile['firstname'],'input',array('full'=>1))?>
<?php echo $this->html->tr('นามสกุล','lastname',$this->profile['lastname'],'input',array('full'=>1))?>
<?php echo $this->html->tr('บัตรประชาชน','bid',$this->profile['bid'],'input',array('full'=>1))?>
<?php echo $this->html->tr('เพศ','gender',$this->profile['gender'],'select',array('full'=>1),array('male'=>'ผู้ชาย','female'=>'ผู้หญิง'))?>
<?php echo $this->html->tr('วันเดือนปีเกิด','birthday',$this->profile['birthday'],'date',array('full'=>1),array('startyear'=>date('Y')-120,'stopyear'=>date('Y')))?>
<tr><th colspan="2" align="center">ที่อยู่ปัจจุบัน</td></tr>
<?php echo $this->html->tr('ที่อยู่','address',$this->profile['address'],'textarea',array('full'=>1))?>
<?php echo $this->html->tr('แขวง/ตำบล','zone',$this->profile['zone'],'input',array('full'=>1))?>
<?php echo $this->html->tr('เขต/อำเภอ','district',$this->profile['district'],'input',array('full'=>1))?>
<?php echo $this->html->tr('จังหวัด','province',$this->profile['province'],'province',array('space'=>'เลือกจังหวัด','full'=>1))?>
<?php echo $this->html->tr('รหัสไปรษณีย์','zipcode',$this->profile['zipcode'],'input',array('full'=>1))?>
<?php echo $this->html->tr('โทรศัพท์','phone',$this->profile['phone'],'input',array('full'=>1))?>
<?php echo $this->html->tr('โทรสาร','fax',$this->profile['fax'],'input',array('full'=>1))?>
<?php echo $this->html->tr('มือถือ','mobile',$this->profile['mobile'],'input',array('full'=>1))?>
<tr><td colspan="2" align="center"><input type="button" class="button" value=" ยกเลิก " onClick="setbox('')" /></td></tr>
</table>
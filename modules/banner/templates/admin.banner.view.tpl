<table cellpadding="5" cellspacing="1" border="0" width="100%" class="tbservice">
<tr>
<th align="center" colspan="2">รายละเอียดแบนเนอร์</th>
</tr>
<?php echo $this->html->tr('หัวข้อแบนเนอร์','banner_title_'.$this->banner['id'],$this->banner['title'],'input',array('full'=>1))?>
<?php echo $this->html->tr('Link ปลายทาง','banner_link_'.$this->banner['id'],$this->banner['link'],'input',array('full'=>1))?>
<?php echo $this->html->tr('รูปภาพ','thumbnail',$this->banner['s']?HTTP.'files/banner/'.$this->banner['s']:'','photo',array('full'=>1))?>
</table>

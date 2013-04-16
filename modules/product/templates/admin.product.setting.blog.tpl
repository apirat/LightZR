<table cellpadding="5" cellspacing="1" border="0" width="100%" class="tbservice">
<tr align="center">
<th>ชื่อบล็อก</th>
<th>ประเภท</th>
<th>บัญชี Account</th>
<th>จำนวนข้อมูลที่โพสต่อวัน</th>
<th>ข้อความเพิ่มเติมที่โพส</th>
<th width="50">&nbsp;</th>
</tr>
<?php for($i=0;$i<count($this->myblog);$i++):?>
<tr align="center">
<td class="tab_title"><?php echo $this->myblog[$i]['title']?></td>
<td><?php echo $this->myblog[$i]['blogtype']?></td>
<td><?php echo $this->myblog[$i]['email']?></td>
<?php echo $this->html->td('blog_ppd_'.$this->myblog[$i]['id'],$this->myblog[$i]['ppd'],'input',array('space'=>'0','size'=>2))?>
<?php echo $this->html->td('blog_message_'.$this->myblog[$i]['id'],$this->myblog[$i]['message'],'textarea',array())?>
    <td width="50">
        <a href="javascript:;" onclick="ajax_del('<?php echo $this->myblog[$i]['id']?>');"><img src="<?php echo HTTP?>static/images/del.gif" alt="ลบ" /></a>
   </td>
   </tr>
<?php endfor?>
</table>
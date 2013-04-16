<table cellpadding="3" cellspacing="1" border="0" width="100%" class="tbservice">
<tr>
<th width="24" align="center">&nbsp;</th>
<th align="center">ไอคอน</th>
<th width="200" align="center">ชื่อบริการ</th>
<th align="center">รายละเอียด</th>
<th width="170" align="center">ตำแหน่งลิ้งค์</th>
<th width="70" align="center">หน้าเว็บ</th>
<th width="70" align="center">หลังบ้าน</th>
</tr>
<?php $_c=-1?>
<?php for($i=0;$i<count($this->services);$i++):?>
<?php if($_c!=$this->services[$i]['category']):?>
<tr><td colspan="12"><h3><?php echo $this->services[$i]['cate']?></h3></td></tr>
<?php $_c=$this->services[$i]['category']?>
<?php endif?>
<tr>
<td align="center">
	<?php if(!$this->services[$i]['id']):?>
	<a href="javascript:;" onclick="ajax_sinstall(<?php echo $this->services[$i]['mid']?>)" class="show-tooltip-s" style="display:block"  title="คลิก! ติดตั้งระบบนี้"><img src="<?php echo HTTP?>static/images/uncheck.png" /></a>
    <?php elseif($this->services[$i]['id']&&$this->services[$i]['type']=='system'):?>
	<img src="<?php echo HTTP?>static/images/check.png" class="opacity" />
    <?php else:?>
	<a href="javascript:;" onclick="uninstall(<?php echo $this->services[$i]['id']?>)" class="show-tooltip-s" style="display:block"  title="คลิก! ถอนการติดตั้งระบบนี้"><img src="<?php echo HTTP?>static/images/check.png" /></a>
	<?php endif?>
</td>
<td align="center" width="20" style="background-image:url(<?php echo HTTP?>static/images/grippy.png); background-position:5px center; background-repeat:no-repeat; padding-left:20px">
<?php if(!$this->services[$i]['id']):?>
<img src="<?php echo HTTP.'modules/'.$this->services[$i]['folder'].'/images/icon16.gif'?>" width="16" height="16" class="opacity" />
<?php else:?>
<a href="javascript:;" onclick="showicon('<?php echo $this->services[$i]['id']?>')" class="show-tooltip-s" title="คลิก! เพื่อเปลี่ยน Icon นี้"><?php if($this->services[$i]['icon']):?><img src="<?php echo HTTP.'static/images/menu/'.$this->services[$i]['icon'].'16.gif'?>" width="16" height="16" /><?php else:?><img src="<?php echo HTTP.'modules/'.$this->services[$i]['folder'].'/images/icon16.gif'?>" width="16" height="16" /><?php endif?></a>
<?php endif?>
</td>
<?php if($this->services[$i]['id']):?>
<td class="edit show-tooltip-s"  title="คลิก! เพื่อเปลี่ยนชื่อบริการ"><span id="_service_name_<?php echo $this->services[$i]['id']?>"><?php echo $this->services[$i]['service']?></span><strong><input type="text" class="tbox" style="width:130px" id="tmp_service_name_<?php echo $this->services[$i]['id']?>"  maxlength="30" name="tmp_service_name_<?php echo $this->services[$i]['id']?>" value="<?php echo $this->services[$i]['service']?>" /></strong></td>
<?php else:?>
<td><?php echo ($this->services[$i]['module'])?></td>
<?php endif?>
<td align="left"><?php echo $this->services[$i]['detail']?></td>
<?php if($this->services[$i]['id']):?>
<?php //if($this->services[$i]['folder']=='page'):?>
<td  class="edit show-tooltip-s" title="คลิก! เพื่อเปลี่ยนลิ้งค์ของบริการ">/<span id="_service_link_<?php echo $this->services[$i]['id']?>"><?php echo $this->services[$i]['link']?></span><strong><input type="text" class="tbox" style="width:115px" id="tmp_service_link_<?php echo $this->services[$i]['id']?>"  maxlength="30" name="tmp_service_link_<?php echo $this->services[$i]['id']?>" value="<?php echo $this->services[$i]['link']?>" /></strong></td-->
<?php //else:?>
<!--td>/<?php echo $this->services[$i]['link']?></td-->
<?php //endif?>
<?php else:?>
<td></td>
<?php endif?>
<?php if($this->services[$i]['status']=='install'):?>
<td align="center"><?php if(in_array($this->services[$i]['www'],array('yes','first'))):?><img src="<?php echo HTTP?>static/images/pass.gif" alt=""<?php echo $this->services[$i]['id']?'':' class="opacity"'?> /><?php endif?></td>
<td align="center"><?php if($this->services[$i]['admin']=='yes'):?><img src="<?php echo HTTP?>static/images/pass.gif" alt=""<?php echo $this->services[$i]['id']?'':' class="opacity"'?> /><?php endif?></td>
<?php else:?>
<td align="center" colspan="2" bgcolor="#EEEEEE"><strong>โมดูลนี้ถูกระงับการใช้งานชั่วคราว</strong></td>
<?php endif?>
</tr>
<?php endfor?>
</table>
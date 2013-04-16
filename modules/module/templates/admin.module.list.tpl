<table cellspacing="5" cellpadding="3" border="0" width="100%">
<tr><td colspan='3' style="border:1px solid #E5E5E5; background:#F5F5F5; text-indent:5px; line-height:23px; height:23px;">&raquo; Installed</td></tr>
<?php foreach($this->modules as $module): ?>
<?php if(in_array($module['status'],array('install','paused'))): ?>
    <tr>
    <td width='150'>
    <table width='100%'><tr><td align="left" width="40" valign="top">
    <img src='<?php echo HTTP?>modules/<?php echo $module['folder']?>/images/icon32.gif' alt='' style='vertical-align: bottom;' /></a></td>
    <td><b><?php echo $module['name']?></b><br />Version <?php echo $module['version']?><br />Status:
    <?php if($module['status']=='paused'):?>
    <a href="javascript:;" onclick="ajax_status('<?php echo $module['folder']?>','install')"><img src="<?php echo HTTP?>static/images/fail.gif" class="icon" /></a>
    <?php else:?>
    <a href="javascript:;" onclick="ajax_status('<?php echo $module['folder']?>','paused')"><img src="<?php echo HTTP?>static/images/pass.gif" class="icon" /></a>
    <?php endif?>
    </td>
    </tr></table>
    </td>
    <td style="border:1px solid #F0F0F0; background:#F7F7F7">
        <table cellspacing='3' style='width:100%'>
            <tr><td width="60"><b>Detail</b>:</td><td colspan="3"><?php echo $module['detail']?>&nbsp;</td><td width="60"><b>Type</b>:</td><td width="50"><u><?php echo ucfirst($module['type'])?></u></td><td width="60"><b>Admin</b>:</td><td width="50"><?php echo ucfirst($module['admin'])?></td><td width="60"><b>Core</b>:</td><td width="30"><?php echo ucfirst($module['core'])?></td></tr>
            <tr><td width="60"><b>Author</b>:</td><td width="100"><?php echo $module['author']?>&nbsp;</td><td width="60"><b>Category</b>:</td><td><?php echo $module['cate']?>&nbsp;</td><td width="60"><b>Compatible</b>:</td><td><span><?php echo $module['compatible']?>&nbsp;</span></td><td width="60"><b>WWW</b>:</td><td><?php echo ucfirst($module['www'])?></td><td width="60"><b>Multi</b>:</td><td width="30"><?php echo ucfirst($module['multi'])?></td></tr>
        </table>
    </td><td style='width:70px;text-align:center'>
        	<input type='button' class='button' onclick="ajax_reload('<?php echo $module['folder']?>')" title='Reload' value='Reload' />
    	<?php if($module['type']!='system'):?>
        	<input type='button' class='button' onclick="ajax_muninstall('<?php echo $module['folder']?>')" title='Uninstall' value='Uninstall' />
    	<?php endif?>
    </td>
  </tr>
<?php endif?>
<?php endforeach?>
<tr><td colspan='3' style="border:1px solid #E5E5E5; background:#F5F5F5; text-indent:5px; line-height:23px; height:23px;">&raquo; Not installed</td></tr>
<?php foreach($this->modules as $module): ?>
<?php if($module['status']=='uninstall'): ?>
    <tr>
    <td width='150'>
    <table width='100%'><tr><td align="left" width="40" valign="top">
    <img src='<?php echo HTTP?>modules/<?php echo $module['folder']?>/images/icon32.gif' alt='' style='vertical-align: bottom;' /></a></td>
    <td><b><?php echo $module['name']?></b><br />Version <?php echo $module['version']?></td>
    </tr></table>
    </td>
    <td style="border:1px solid #F0F0F0; background:#F7F7F7">
        <table cellspacing='3' style='width:100%'>
            <tr><td width="60"><b>Detail</b>:</td><td colspan="3"><?php echo $module['detail']?>&nbsp;</td><td width="60"><b>Type</b>:</td><td width="50"><u><?php echo ucfirst($module['type'])?></u></td><td width="60"><b>Admin</b>:</td><td width="50"><?php echo ucfirst($module['admin'])?></td><td width="60"><b>Core</b>:</td><td width="30"><?php echo ucfirst($module['core'])?></td></tr>
            <tr><td width="60"><b>Author</b>:</td><td width="100"><?php echo $module['author']?>&nbsp;</td><td width="60"><b>Category</b>:</td><td><?php echo $module['cate']?>&nbsp;</td><td width="60"><b>Compatible</b>:</td><td><span><?php echo $module['compatible']?>&nbsp;</span></td><td width="60"><b>WWW</b>:</td><td><?php echo ucfirst($module['www'])?></td><td width="60"><b>Multi</b>:</td><td width="30"><?php echo ucfirst($module['multi'])?></td></tr>
        </table>
    </td>
    	<?php if($module['compatible']<=VERSION):?>
    	<td style='width:70px;text-align:center'>
    	<input type='button' class='button' onclick="ajax_minstall('<?php echo $module['folder']?>')" title='Install' value='Install' />
        </td>
        <?php else:?>
    	<td class="error" style='width:70px;text-align:center'>Version of CMS not support this module</td>
        <?php endif?>
     </td>
  </tr>
<?php endif?>
<?php endforeach?>
</table>
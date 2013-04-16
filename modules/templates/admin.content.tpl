
<div id="outter">
<div id="inner"> 
<div id="content_c">
<div id="header"><a href="<?php echo PATHMIN?>"></a></div>


<div id="sidebar"><ul id="menu"><li style="float:right"><a href="<?php echo QUERY?>">หน้าเว็บไซต์</a></li><?php echo $this->menu?></ul><br class="clearit"></div>

<div id="content">
<div id="navigator">
<ul><?php echo $this->navigator?><?php if(class_exists('setview',false)):?><li><a href="javascript:;" onclick="lz.box.open('#setview')"><img src="<?php echo HTTP?>static/images/setview.gif" align="absmiddle"> ปรับแต่งการแสดงผล</a></li><?php endif?></ul>
<?php if(defined('SERVICE_LINK_SUB')):?>
<a href="<?php echo PATHMIN.SERVICE_LINK_SUB?>"><img src="<?php echo SERVICE_ICON_SUB?>" /> <?php echo (SERVICE_NAME_SUB)?></a>
<?php elseif(defined('SERVICE_ICON')):?>
<a href="<?php echo PATHMIN.SERVICE_LINK?>"><img src="<?php echo HTTP?>static/images/menu/<?php echo SERVICE_ICON?>32.png" /> <?php echo (SERVICE_NAME)?></a>
<?php else:?>
<a href="<?php echo PATHMIN.SERVICE_LINK?>"><img src="<?php echo HTTP?>modules/<?php echo SERVICE_FOLDER?>/images/icon32.png" /> <?php echo (SERVICE_NAME)?></a>
<?php endif?>
</div>

<div id="incontent"><?php echo $this->content?></div>
</div>



<div id="footer">
<div>memory: <?php echo number_format(memory_get_usage()/1024,2)?> KB, peak memory: <?php echo number_format(memory_get_peak_usage()/1024,2)?> KB, render: <?php echo number_format(array_sum(explode(' ', microtime()))-START,4)?>s, cache: <?php echo cache::$log['get']?> files, db: <?php echo defined('DB')?lz::h('db')->count()." queries.":"not load!"?></div>
</div>
</div>
</div>
</div>

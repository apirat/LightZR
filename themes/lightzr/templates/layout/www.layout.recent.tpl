<?php lz::h('product')->get();?>

<?php if(lz::h('product')->count):?>
<ul id="r<?php echo lz::$c['prefix']?>ecent">
<?php while($p = lz::h('product')->fetch()):?>
<li><a <?php echo $p['a']['href']['info'].' '.$p['a']['title'].' '.$p['a']['rel']?>><?php echo $p['title']?></a></li>
<?php endwhile?>
<div class="clear"></div>
</ul>
<style type="text/css">
#r<?php echo lz::$c['prefix']?>ecent a{ line-height:22px; height:22px; overflow:hidden; display:block; text-align:left; padding-left:22px; background:url(<?php echo HTTP?>themes/<?php echo lz::$c['theme']?>/images/bullet.gif) 5px center no-repeat; font-size:10px}
#r<?php echo lz::$c['prefix']?>ecent li{border-bottom:1px dashed #dfdfdf;}
#r<?php echo lz::$c['prefix']?>ecent{clear:both}
#r<?php echo lz::$c['prefix']?>ecent span{font-size:9px}
</style>
<?php else:?>
<!--border=no-->
<?php endif?>
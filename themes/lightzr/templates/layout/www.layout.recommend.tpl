
<?php lz::h('product')->get();?>

<?php if(lz::h('product')->count):?>
<ul id="hotprd">
<?php while($p = lz::h('product')->fetch()):?>
<li><a <?php echo $p['a']['href']['info'].' '.$p['a']['title'].' '.$p['a']['rel']?>><?php echo $p['title']?></a></li>
<?php endwhile?>
<div class="clear"></div>
</ul>
<?php else:?>
<!--border=no-->
<?php endif?>
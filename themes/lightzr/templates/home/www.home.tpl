
<?php  lz::h('product')->get(array('limit'=>10,'length'=>300)); ?>

<div>
<table cellpadding="5" cellspacing="0" border="0" width="100%" class="<?php echo lz::$c['prefix']?>prod">
<?php while($p = lz::h('product')->fetch()):?>
<tr class="l<?php echo $p['i']%2?>">
<td class="img"><a <?php echo $p['a']['href']['info'].' '.$p['a']['title'].' '.$p['a']['rel']?>><img <?php echo $p['img']['src']['s'].' '.$p['img']['alt'].' '.$p['img']['title']?>></a></td>
<td class="detail">
<h4><a <?php echo $p['a']['href']['info'].' '.$p['a']['title'].' '.$p['a']['rel']?>><?php echo $p['title']?></a></h4>
<p><?php echo $p['content']?> - <img src="<?php echo IMAGES?>rating/<?php echo $p['avg']?>.gif" alt="<?php echo $p['avg']?>stars" align="absmiddle" /></p>
<ul class="offer" style="margin:3px 0px 0px 0px"><?php if(is_array($p['offer'])): foreach($p['offer'] as $k=>$v) echo '<li>'.$k.': $'.$v.'</li>'; endif;?></ul>
<p style="clear:both"></p>
<p class="boxp"><a <?php echo $p['a']['href']['store']?> rel="noreferrer nofollow" target="_blank">
<?php if($p['seller']>1&&$p['minprice']!=$p['maxprice']):?><?php echo $p['minpricef']?> - <?php echo $p['maxpricef']?> <small>at <?php echo $p['seller']?> Sellers</small><?php elseif($p['minvar']&&$p['maxvar']&&$p['minvar']!=$p['maxvar']):?><?php echo $p['minvarf']?> - <?php echo $p['maxvarf']?><?php else:?><?php echo $p['salepricef']?><?php endif?>
 <img src="<?php echo IMAGES?>turst2.gif" alt=""></a></p> 
</td>
</tr>
<?php endwhile?>
</table>
</div>
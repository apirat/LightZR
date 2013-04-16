
<?php  lz::h('product')->get(array('limit'=>15,'length'=>300)); ?>

<h3 class="bestcaption"><a href="<?php echo $this->category['link']?>"><?php echo $this->category['title']?></a><?php if($this->brand):?> &gt; Brand: <?php echo $this->brand?><?php elseif($this->color):?> &gt; Color: <?php echo $this->color?><?php elseif($this->price):?> &gt; Price: <?php echo $this->price?><?php endif?> <?php if($this->search):?> &gt; Search "<?php echo $this->search?>"<?php endif?></h3>
<div class="clear"></div>
<div style="border-bottom:3px solid #ddd; padding:0px 10px 5px">
<div style="float:right">
<form onSubmit="search2();return false">search <input type="text" id="search" class="tbox" value="<?php echo $this->search?$this->search:'Enter Keywords...'?>" size="20" onFocus="if(this.value=='Enter Keywords...')this.value='';" onBlur="if(this.value=='')this.value='Enter Keywords...';" /> <input type="submit" id="find" value="" /></form>
</div>
<div style="float:left; margin:5px 0px 0px 5px;">
about <?php echo number_format(lz::h('product')->count)?> results (<?php echo $this->search?$this->search:lz::$s['title']?>)
</div>
<div class="clear"></div>
</div>
<hr class="ln" />
<?php if(!count(lz::h('product')->count)):?><div style="text-align:center; padding:100px 0px; font-size:24px">did not match any products</div><?php endif?>
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
<?php echo lz::h('product')->pager?>




<script type="text/javascript">
function search2(){var search=$('#search').val();if(search=='Enter Keywords...')search='';if(search.indexOf('/')>=0)alert("not allowed '/'");else window.location.href='<?php echo $this->category['link']?>'+(search?'search-'+search:'');}
</script>
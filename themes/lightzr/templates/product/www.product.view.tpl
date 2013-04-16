
<h3 class="bestcaption"><a href="<?php echo $this->category['link']?>"><?php echo $this->category['title']?></a></h3>
<h2 align="center"><?php echo $this->product["title"]?></h2>
<div align="center"><a <?php echo $this->product['a']['href']['store']?> rel="noreferrer nofollow" target="_blank"><img <?php echo $this->product['img']['src']['l']?> <?php echo $this->product['img']['alt']?>></a></div>
<table cellpadding="5" cellspacing="1" border="0" align="center">
<tr>
<td style="line-height:2em">
<?php if($this->product['price']>0&&$this->product['saleprice']>0&&$this->product['sprice']>$this->product['saleprice']):?>
<table cellpadding="0" cellspacing="5" border="0" align="center">
<tr><td align="right">List Price:</td><td><span style="text-decoration:line-through; font-size:16px"><strong><?php echo $this->product['pricef']?></strong></span></td></tr>
<tr><td align="right">Price:</td><td><span style="color:#090; font-size:16px"><strong><?php echo $this->product['salepricef']?></strong></span></td></tr>
<tr><td align="right">You Save:</td><td><span style="color:#FF0000; font-size:16px"><strong><?php echo number_format(intval(($m=$this->product['price']-$this->product['saleprice'])/100),0)?></strong> (<?php echo number_format(($m/$this->product['price'])*100,2)?>)</span></td></tr>
</table>
<?php elseif($this->product['seller']>1&&$this->product['minprice']!=$this->product['maxprice']):?>
<p align="center">Prices: <strong style="color:#090; font-size:16px"><?php echo $this->product['minpricef']?> - <?php echo $this->product['maxpricef']?></strong><br> at <?php echo $this->product['seller']?> Sellers</p>
<?php elseif($this->product['minvar']&&$this->product['maxvar']&&$this->product['minvar']!=$this->product['maxvar']):?>
<p align="center">Prices: <strong style="color:#090; font-size:16px"><?php echo $this->product['minvarf']?> - <?php echo $this->product['maxvarf']?></strong></p>
<?php else:?>
<p align="center">Price: <strong style="color:#090; font-size:16px"><?php echo $this->product['salepricef']?></strong></p>
<?php endif?>
</p>
<p align="center"><img src="<?php echo IMAGES?>rating/<?php echo $this->product['avg']?>.gif" alt="<?php echo $this->product['avg']?>" align="absmiddle">  <?php echo $this->product['tavg']?> reviews</p>
<p style="text-align:center; margin:5px;"><a href="<?php echo QUERY.$this->product['link']?>/<?php echo lz::$c['pstore']?>" rel="noreferrer nofollow" target="_blank"><img src="<?php echo IMAGES?>go/buynow.png" alt=""></a></p>
</td>
</tr>
</table>  
<div style="padding:5px">
<ul class="tbs<?php echo lz::$c['prefix']?>">
    <li><a href="#des<?php echo lz::$c['prefix']?>">Product Description</a></li>
    <?php if($this->offer):?><li><a href="#of<?php echo lz::$c['prefix']?>">Compare Prices</a></li><?php endif?>
    <?php if($this->review):?><li><a href="#ve<?php echo lz::$c['prefix']?>">Reviews</a></li><?php endif?>
</ul>

<div class="tab_container">
<div id="des<?php echo lz::$c['prefix']?>" class="<?php echo lz::$c['prefix']?>_tct">
<p align="center"><a href="<?php echo QUERY.$this->product['link']?>/<?php echo lz::$c['pstore']?>" rel="noreferrer nofollow" target="_blank"><img src="<?php echo IMAGES?>turst.gif" alt=""></a></p> 
<?php echo $this->product['content'];?>
<ul class="detaillist"><?php echo $this->product['feature']?></ul>
</div>


<?php if($this->offer):?>
<div id="of<?php echo lz::$c['prefix']?>" class="<?php echo lz::$c['prefix']?>_tct">
<table cellpadding="3" cellspacing="1" width="100%" border="0" class="ioffer">
<tr>
<th>Store</th>
<th>Rating</th>
<th>List Price</th>		
<th>Price</th>		
<th>Shipping</th>
<th></th>
</tr>
<?php for($i=0;$i<count($this->offer);$i++):?>
<tr<?php if($this->offer[$i]["saleprice"]==$this->lowprice){ ?> class="low"<?php } ?>>
<td align="left"><?php echo $this->offer[$i]["name"]?></td>
<td><?php echo $this->offer[$i]["rating"]!='0.0'?$this->offer[$i]["rating"].' ':''?><?php echo $this->offer[$i]["cond"]?></td>
<td><span style="text-decoration:line-through"><?php echo $this->offer[$i]["pricef"]?></span></td>
<td><?php echo $this->offer[$i]["salepricef"]?><?php if($this->offer[$i]["saleprice"]==$this->lowprice){ ?> <br>(<b style="color:#499300">Best Value!</b>)<?php } ?></td>
<td><?php if($this->offer[$i]["supersave"]): ?><small style="color:#090">FREE Shipping </small><br /><?php endif?><?php echo $this->offer[$i]["ava"]?></td>
<td width="120"><a href="<?php echo QUERY.$this->product['link']?>/<?php echo lz::$c['pcompare']?>" rel="noreferrer nofollow" title="<?php echo $this->offer[$i]["name"]?>" target="_blank"><img src="<?php echo IMAGES?>go/g.gif" alt=""></a></td>
</tr>                  
<?php endfor?>
</table>
</div>
<?php endif?>

<?php if($this->review):?>
<div id="ve<?php echo lz::$c['prefix']?>" class="<?php echo lz::$c['prefix']?>_tct" style="padding-bottom:0px;">
<?php for($i=0;$i<count($this->review);$i++):?>
<div class="reviews">
<p class="v1">Review by <?php echo $this->review[$i]["name"]?> : <?php echo $this->review[$i]["summary"]?> <img src="<?php echo IMAGES?>star/<?php echo $this->review[$i]["rating"]?>.0.gif" alt="<?php echo $this->review[$i]["rating"]?> Star" /></p>
<p class="v2"><?php echo $this->review[$i]["content"]?></p>
</div>
<?php endfor?>
</div>
<?php endif?>

</div>
</div>


<?php lz::h('product')->get(array('limit'=>6,'length'=>300));?>

<?php if(lz::h('product')->count):?>
<h3 class="bestcaption">Other (<?php echo $this->category['title']?>)</h3>
<div style="padding-left:5px">
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
<?php endif?>
<style type="text/css">
ul.tbs<?php echo lz::$c['prefix']?> {margin: 0px;padding: 0;float: left;list-style: none;height: 32px;border-bottom: 1px solid #ccc;border-left: 1px solid #ccc;width: 100%;}
ul.tbs<?php echo lz::$c['prefix']?> li {float: left;margin: 0;padding: 0;height: 31px;line-height: 31px;border: 1px solid #ccc;border-left: none;margin-bottom: -1px;overflow: hidden;position: relative;background: #e0e0e0;}
ul.tbs<?php echo lz::$c['prefix']?> li a{text-decoration: none;color: #000;display: block;font-size: 1.2em;padding: 0 20px;border: 1px solid #fff;outline: none;}
ul.tbs<?php echo lz::$c['prefix']?> li a:hover {	background: #ccc;}
html ul.tbs<?php echo lz::$c['prefix']?> li.active, html ul.tbs<?php echo lz::$c['prefix']?> li.active a:hover {background: #fff;border-bottom: 1px solid #fff;}
.tab_container {border: 1px solid #ccc;border-top: none;overflow: hidden;clear: both;width: 100%;background: #fff;margin:0px;}
.<?php echo lz::$c['prefix']?>_tct{padding: 10px; line-height:1.6em;}
</style>
<script type="text/javascript">
$(document).ready(function() {
	$(".<?php echo lz::$c['prefix']?>_tct").hide();
	$("ul.tbs<?php echo lz::$c['prefix']?> li:first").addClass("active").show();
	$(".<?php echo lz::$c['prefix']?>_tct:first").show();
	$("ul.tbs<?php echo lz::$c['prefix']?> li").click(function() {
		$("ul.tbs<?php echo lz::$c['prefix']?> li").removeClass("active");
		$(this).addClass("active");
		$(".<?php echo lz::$c['prefix']?>_tct").hide();
		var activeTab = $(this).find("a").attr("href");
		$(activeTab).fadeIn();
		return false;
	});
});
</script>
<hr class="ln" />
<h3 class="bestcaption">Comments</h3>
<div style="margin:5px; border:1px solid #CCC; padding:5px;">
<form method="post" action="<?php echo URL?>">
<table cellpadding="5" cellspacing="1" border="0" width="100%">
<tr><th align="right">Name</th><td><input type="text" class="tbox" name="name" size="50"></td></tr>
<tr><th align="right">Website</th><td><input type="text" class="tbox" name="website" size="50"></td></tr>
<tr><th align="right">Comment</th><td><textarea class="tbox" name="comment" rows="10" cols="90"></textarea></td></tr>
<tr><th align="right"></th><td><input type="submit" class="submit" value=" Submit "></td></tr>
</table>
</form>
</div>
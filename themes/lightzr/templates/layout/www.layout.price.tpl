<?php if(count($this->price)):?>
<ul class="listitm">
<?php for($i=0;$i<count($this->price);$i++):?>
<?php 
if(lz::$c['sub']==2||lz::$s['domain']):
	$url=QUERY.'price-'.$this->price[$i]['min'].'-'.$this->price[$i]['max'];
else:
	$url=QUERY.lz::$s['link'].'/price-'.$this->price[$i]['min'].'-'.$this->price[$i]['max'];
endif;
?>
<li><a href="<?php echo $url?>">$<?php echo number_format($this->price[$i]['min'],0)?> - $<?php echo number_format($this->price[$i]['max'])?></a></li>
<?php endfor;?>
</ul>
<?php else:?>
<!--border=no-->
<?php endif?>
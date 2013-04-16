<?php if(count($this->color)):?>
<ul class="listitm">
<?php for($i=0;$i<count($this->color);$i++):?>
<?php 
if(lz::$c['sub']==2||lz::$s['domain']):
	$url=QUERY.'color-'.urlencode(str_replace('/','%',$this->color[$i]['color']));
else:
	$url=QUERY.lz::$s['link'].'/color-'.urlencode(str_replace('/','%',$this->color[$i]['color']));
endif;
?>
<li><a href="<?php echo $url?>"><?php echo $this->color[$i]['color']=='*'?'All Color':$this->color[$i]['color']?> <small>(<?php echo $this->color[$i]["amount"]?>)</small></a></li>
<?php endfor;?>
</ul>
<?php else:?>
<!--border=no-->
<?php endif?>
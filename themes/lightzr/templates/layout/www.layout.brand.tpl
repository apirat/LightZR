<?php if(count($this->brand)):?>
<ul class="listitm">
<?php for($i=0;$i<count($this->brand);$i++):?>
<?php 
if(lz::$c['sub']==2||lz::$s['domain']):
	$url=QUERY.'brand-'.urlencode(str_replace('/','%',$this->brand[$i]['brand']));
else:
	$url=QUERY.lz::$s['link'].'/brand-'.urlencode(str_replace('/','%',$this->brand[$i]['brand']));
endif;
?>
<li><a href="<?php echo $url?>"><?php echo $this->brand[$i]['brand']?> <small>(<?php echo $this->brand[$i]["amount"]?>)</small></a></li>
<?php endfor;?>
</ul>
<?php else:?>
<!--border=no-->
<?php endif?>
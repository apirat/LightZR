<?php if(count($this->searched)):?>
<ul class="listitm">
<?php for($i=0;$i<count($this->searched);$i++):?>
<?php 
if(lz::$c['sub']==2||lz::$s['domain']):
	$url=QUERY.'search-'.urlencode($this->searched[$i]['keyword']);
else:
	$url=QUERY.lz::$s['link'].'/search-'.urlencode($this->searched[$i]['keyword']);
endif;
?>
<li><a href="<?php echo $url?>"><?php echo $this->searched[$i]['keyword']?> <small>(<?php echo $this->searched[$i]["amount"]?>)</small></a></li>
<?php endfor;?>
</ul>
<?php else:?>
<!--border=no-->
<?php endif?>
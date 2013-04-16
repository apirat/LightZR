<?php if(count($this->tags)):?>
<div id="t<?php echo lz::$c['prefix']?>cloud">
<?php for($i=0;$i<count($this->tags);$i++):?>
<?php 
if(lz::$c['sub']==2||lz::$s['domain']):
	$url=QUERY.'tag-'.urlencode(strtolower($this->tags[$i]));
else:
	$url=QUERY.lz::$s['link'].'/tag-'.urlencode(strtolower($this->tags[$i]));
endif;
?>
<a href="<?php echo $url?>" class="a<?php echo rand(1,5)?>"><?php echo $this->tags[$i]?></a>
<?php endfor;?>
</div>
<style type="text/css">
#t<?php echo lz::$c['prefix']?>cloud{ line-height:1.8em;}
#t<?php echo lz::$c['prefix']?>cloud .a1{color:#AAA; font-size:9px}
#t<?php echo lz::$c['prefix']?>cloud .a2{color:#888; font-size:10px}
#t<?php echo lz::$c['prefix']?>cloud .a3{color:#666; font-size:12px}
#t<?php echo lz::$c['prefix']?>cloud .a4{color:#444; font-size:14px}
#t<?php echo lz::$c['prefix']?>cloud .a5{color:#222; font-size:16px}
#t<?php echo lz::$c['prefix']?>cloud a{margin:0px 2px;}
#t<?php echo lz::$c['prefix']?>cloud a:hover{text-decoration:underline;}
</style>
<?php else:?>
<!--border=no-->
<?php endif?>
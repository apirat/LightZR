<?php $column=($this->border=='full'?3:1);?>

<?php 
if(count($this->review)):
$review=array();
?>
<div>
<?php for($i=0;$i<count($this->review);$i++):?>
<?php 
if(lz::$c['sub']==2||lz::$c['sub']==1||lz::$s['domain']):
	$url=QUERY.$this->review[$i]['link'];
else:
	$url=QUERY.lz::$s['link'].'/'.$this->review[$i]['link'];
endif;
if(!is_array($review[$i%$column]))$review[$i%$column]=array();
$review[$i%$column][]='<li><a href="'.$url.(lz::$c['pinfo']?'/'.lz::$c['pinfo']:'').'" title="'.$this->review[$i]['summary'].'"><img src="'.HTTP.'themes/'.lz::$c['theme'].'/images/bullet2.gif" alt="'.$this->review[$i]['summary'].'"></a> '.$this->review[$i]['name'].': '.$this->review[$i]['summary'].'</li>';
endfor;?>
<?php for($i=0;$i<count($review);$i++):?>
<ul class="sreview">
<?php for($j=0;$j<count($review[$i]);$j++):?>
<?php echo $review[$i][$j]?>
<?php endfor?>
</ul>
<?php endfor?>
<div class="clear"></div>
</div>
<?php else:?>
<!--border=no-->
<?php endif?>
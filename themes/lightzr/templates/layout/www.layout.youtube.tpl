<?php $column=($this->border=='full'?3:1);?>

<?php 
if(count($this->youtube)):
$youtube=array();
?>
<div>
<?php for($i=0;$i<count($this->youtube);$i++):?>
<div>
<p align="center" style="font-size:9px"><a href="http://www.youtube.com/watch?v=<?php echo $this->youtube[$i]['id']?>" target="_blank" rel="nofollow"><?php echo $this->youtube[$i]['title']?></a></p>
<object width="<?php echo $this->cf['width']?>" height="<?php echo $this->cf['height']?>"><param name="movie" value="http://www.youtube.com/v/<?php echo $this->youtube[$i]['id']?>?fs=1&hl=en_US"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/<?php echo $this->youtube[$i]['id']?>?fs=1&hl=en_US" type="application/x-shockwave-flash" width="<?php echo $this->cf['width']?>" height="<?php echo $this->cf['height']?>" allowscriptaccess="always" allowfullscreen="true"></embed></object>
</div>
<?php endfor?>
<div class="clear"></div>
</div>
<?php else:?>
<!--border=no-->
<?php endif?>
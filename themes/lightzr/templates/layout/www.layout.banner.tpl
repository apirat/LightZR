<!--border=no-->
<?php if(count($this->banner)):?>
<section id="bigbanner" style="margin-bottom:10px;">
<div class="slider-wrapper theme-default">
   <div class="ribbon"></div>
   <div id="slider" class="nivoSlider">
   <?php for($i=0;$i<count($this->banner);$i++):?>
       <a href="<?php echo $this->banner[$i]['link']?>" target="_blank"><img src="<?php echo HTTP?>files/banner/<?php echo $this->banner[$i]['l']?>"></a>
   <?php endfor?>
   </div>
</div>
</section>
<link rel="stylesheet" href="<?php echo HTTP?>js/nivo-slider/themes/default/default.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo HTTP?>js/nivo-slider/nivo-slider.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo HTTP?>js/nivo-slider/jquery.nivo.slider.pack.js"></script>
<script>
 $(window).load(function(){$("#slider").nivoSlider({
        effect:"random",
        slices:15,
        boxCols:8,
        boxRows:4,
        animSpeed:500,
        pauseTime:3000,
        startSlide:0,
        directionNav:true,
        directionNavHide:true,
        controlNav:true,
        controlNavThumbs:false,
        controlNavThumbsFromRel:true,
        keyboardNav:true,
        pauseOnHover:true,
        manualAdvance:false
 });
 });
 </script>
<?php endif?>
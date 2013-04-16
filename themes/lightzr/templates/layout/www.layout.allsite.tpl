<!--border=no-->
<div id="<?php echo lz::$c['prefix']?>gp">
<?php
$last='';
$open=-1;
$openindex=0;
for($i=0;$i<count($this->site2);$i++)
{
	if($last!=$this->site2[$i]['pgroup'])
	{
		if($last!='')
		{
			echo '</ul>';
			$openindex++;
		}
		$last=$this->site2[$i]['pgroup'];
		if($last==lz::$s['pgroup'])$open=$openindex;
		echo '<h3><a href="javascript:;" rel="nofollow">'.$this->site2[$i]['pgroup'].'</a></h3>
		<ul>';
	}
	echo '<li><a href="'.($this->site2[$i]['domain']?'http://www.'.$this->site2[$i]['domain']:(lz::$c['sub']==2?'http://'.$this->site2[$i]['link'].'.'.lz::$cf['domain']:QUERY.$this->site2[$i]['link'])).'"><span>'.trim($this->site2[$i]['title']).'</span></a></li>';
}
echo '</ul>';
?>
</div>
<script language="JavaScript" type="text/javascript">$(document).ready(function(){$('#<?php echo lz::$c['prefix']?>gp ul').hide();<?php if($open>-1):?>$('#<?php echo lz::$c['prefix']?>gp h3:eq(<?php echo $open?>)').addClass('active').next().show();<?php endif?>$('#<?php echo lz::$c['prefix']?>gp h3').click(function(){if($(this).next().is(':hidden')){$('#<?php echo lz::$c['prefix']?>gp h3').removeClass('active').next().slideUp();$(this).toggleClass('active').next().slideDown();};return false;});$('#<?php echo lz::$c['prefix']?>gp li a:last').css({'border-bottom':'none'});}); </script>
<style type="text/css">
#<?php echo lz::$c['prefix']?>gp{width:300px; overflow:hidden}
#<?php echo lz::$c['prefix']?>gp li a{display:block; height:26px; line-height:26px; overflow:hidden; padding-left:25px; background:url(<?php echo IMAGES?>search.gif) 5px center no-repeat; border-bottom:1px solid #eee; color:#555;text-shadow: #fff 1px 1px 0px; font-weight:bold;}
#<?php echo lz::$c['prefix']?>gp h3 {padding: 0;margin: 0 0 3px 0;background: url(<?php echo HTTP?>themes/<?php echo lz::$c['theme']?>/images/trigger.png) no-repeat;height: 46px;line-height: 46px;width: 300px;font-size: 24px;font-weight: normal;float: left; text-shadow:1px 1px 0px #000}
#<?php echo lz::$c['prefix']?>gp h3 a {color: #fff;text-decoration: none;display: block;padding: 0 0 0 45px;}
#<?php echo lz::$c['prefix']?>gp h3 a:hover {color: #ccc;}
#<?php echo lz::$c['prefix']?>gp h3.active {background-position: left bottom;}
#<?php echo lz::$c['prefix']?>gp ul {margin: 0 0 5px; padding: 0;overflow: hidden;font-size: 11px;width: 298px;clear: both;background: #fff;border: 1px solid #d6d6d6;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px; }
</style>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo SERVICE_NAME?> : Admin Panel</title>
<meta name="Description" content="<?php echo SERVICE_NAME?>">
<link rel="stylesheet" type="text/css" href="<?php echo HTTP?>static/js/ui/jquery-ui-1.10.1.custom.css">	 
<link rel="stylesheet" type="text/css" href="<?php echo HTTP?>static/css/admin.css">
<script type="text/javascript">var URL='<?php echo URL?>',HTTP='<?php echo HTTP?>',QUERY='<?php echo QUERY?>',HOST='<?php echo HOST?>',DOMAIN='<?php echo DOMAIN?>',MY_ID='<?php echo MY_ID?>',MY_NAME='<?php echo MY_NAME?>';</script>
<script type="text/javascript" src="<?php echo HTTP?>static/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="<?php echo HTTP?>static/js/lz.js"></script>
<script type="text/javascript" src="<?php echo HTTP?>static/js/ui/jquery-ui-1.10.1.custom.min.js"></script>
<?php echo defined('jsAJAX')?jsAJAX:''?>
<script type="text/javascript">
$(function(){
		   $("#menu ul").css({display:"none"});$("#menu li").hover(function(){$(this).find('ul:first').css({visibility: "visible",display: "none"}).show();$(this).find('a.trigger:first').addClass("trickbg");},function(){$(this).find('ul:first').hide();$(this).find('a.trigger:first').removeClass("trickbg");});
		   $("#navigator ul ul").css({display:"none"});$("#navigator li").hover(function(){$(this).find('ul:first').css({visibility: "visible",display: "none"}).show();$(this).find('a.trigger:first').addClass("trickbg");},function(){$(this).find('ul:first').hide();$(this).find('a.trigger:first').removeClass("trickbg");});
		   });
</script>
</head>
<body>
<?php echo $this->content?>
</body>
</html>
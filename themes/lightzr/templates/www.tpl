<!DOCTYPE HTML>
<html xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:og="http://ogp.me/ns#" xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo lz::$c['title']?></title>
<meta name="Keywords" content="<?php echo lz::$c['keywords']?>">
<meta name="Description" content="<?php echo lz::$c['description']?>">
<meta name="Copyright" content="<?php echo lz::$cf['domain']?>">
<meta charset="UTF-8">
<?php echo lz::$c['meta']?>
<meta property="og:title" content="<?php echo lz::$c['og:title']?lz::$c['og:title']:lz::$c['title']?>">
<meta property="og:type" content="product">
<meta property="og:url" content="http://<?php echo HOST.URL?>">
<?php if(lz::$c['og:image']):?><meta property="og:image" content="<?php echo lz::$c['og:image']?>"><?php endif?>
<meta property="og:site_name" content="<?php echo lz::$c['og:site_name']?>">
<meta property="og:description" content="<?php echo lz::$c['og:description']?lz::$c['og:description']:lz::$c['description']?>">
<meta property="og:country-name" content="U.S.A.">
<meta property="og:email" content="info@<?php echo lz::$cf['domain']?>">
<link rel="stylesheet" type="text/css" href="<?php echo HTTP?>static/js/ui/jquery-ui-1.10.1.custom.css">	 
<link rel="stylesheet" type="text/css" href="<?php echo HTTP?>themes/<?php echo lz::$c['theme']?>/css/<?php echo lz::$c['theme']?>.css.php?<?php echo lz::$c['prefix']?>">
<link rel="stylesheet" type="text/css" href="<?php echo HTTP?>files/style/<?php echo lz::$c['theme']?>.css">
<script type="text/javascript">var URL='<?php echo URL?>',FB_APPID='<?php echo lz::$c['fbappid']?>',HTTP='<?php echo HTTP?>',QUERY='<?php echo QUERY?>',AWS_TAG='<?php echo lz::$c['awstag']?>',SUB_TYPE='<?php echo lz::$c['sub']?>',MY_ID='<?php echo MY_ID?>';</script>
<script type="text/javascript" src="<?php echo HTTP?>static/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="<?php echo HTTP?>static/js/lz.js"></script>
<script type="text/javascript" src="<?php echo HTTP?>static/js/ui/jquery-ui-1.10.1.custom.min.js"></script>
<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
<?php echo defined('jsAJAX')?jsAJAX:''?>
<link rel="icon" href="<?php echo HTTP?>themes/<?php echo lz::$c['theme']?>/images/favicon.png?<?php echo lz::$c['prefix']?>" type="image/x-icon">
<?php if(lz::$c['rss']):?><link rel="alternate" type="application/rss+xml" title="<?php echo htmlspecialchars(lz::$c['title'])?>" href="http://<?php echo SUB?>.<?php echo lz::$cf['domain'].QUERY?>rss.xml"><?php endif?>
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
</head>
<body>
<?php echo $this->content?>
</body>
</html>
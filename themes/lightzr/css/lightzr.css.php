<?php @header('Content-type: text/css; charset=utf-8');?>
@charset "utf-8";
/* CSS Document */
<?php $q=$_SERVER['QUERY_STRING']?>
body, dd, dl, dt, fieldset, form,div, h1, h2, h3, h4, h5, h6, li, ol, p, ul,hr {padding:0px;margin:0px;}
body,td,th,input,select,textarea { font-family: Arial; font-size:12px; }
body{text-align:center}
a:visited, a:active, a:link{text-decoration:none;}
a:hover{ text-decoration:none;}
.clear { clear:both; }
img { border:none; }
h1{ font-size:20px;}
h2{font-size:18px;}
h3{font-size:16px;}
h4{font-size:14px;}
h1,h2,h3,h3,h4,h5,h6{line-height:1.6em;}
.clear{clear:both;}
small{font-size:11px; font-weight:normal;}
.small{font-size:9px;}
ul{list-style:none}

header,nav,footer,section,aside,article,details,summary,hgroup{display:block; margin:0px; padding:0px}
.opacity{-moz-opacity:.3;filter:alpha(opacity=30);opacity:.3;}
.icon{vertical-align:text-bottom;}

header{margin-bottom:5px}

.pager{height:22px; margin:2px;}
.page1,.page2{padding:2px 7px 2px 7px; margin-right:2px; border:1px solid #d9d9d9}


#<?php echo $q?>wrap{ text-align:center;margin:0px auto;overflow:hidden; background:#f9f9f9;}
#<?php echo $q?>ner{text-align:left; margin:0px;}
#<?php echo $q?>head{text-align:left; padding:0px; height:90px;position:relative; width:980px; margin:0px auto; }
#<?php echo $q?>c { margin:0px auto; width:980px;text-shadow:1px 1px 0px #fff;}


#<?php echo $q?>foot {color:#CCC; text-align:center; padding:20px 5px; line-height:1.8em; font-size:10px }
#<?php echo $q?>foot a { color:#ccc; }
#ads468{position:absolute; right:10px; bottom:12px;}
#slogan{position:absolute; left:10px; bottom:10px; text-align:left}
#<?php echo $q?>head h1{font-size:26px}
#<?php echo $q?>head h1 a{text-shadow: 0px 0px 2px #999}
#<?php echo $q?>head h2{font-size:10px; font-weight:normal; color:#bbb;}
#slogan div{font-size:10px; font-weight:normal;color:#99}
#logo{display:block; width:400px; height:100px;}

#<?php echo $q?>left{float:right; width:669px; margin:px;}
#<?php echo $q?>right{float:left; width:300px;overflow:hidden; margin:0px}
.<?php echo $q?>bestbox{ margin:5px 0px;}
#find,.find{width:20px;height:20px;background:#efefef url(../../lightzr/images/admin/search.gif) center center no-repeat;border:1px solid #cfcfcf;margin:0px 5px 0px 3px;cursor:pointer;}

.<?php echo $q?>box{margin:0px 0px 5px 0px}
#<?php echo $q?>br {padding:5px 0 0px 0px; width:100%; position:relative;}
#<?php echo $q?>mn{margin:0px auto;list-style: none;position:relative;padding: 0px; width:980px;}
#<?php echo $q?>mn a {display: block;text-decoration: none;padding: 8px 10px 2px 10px;}
#<?php echo $q?>mn li {float: left;position:relative;}
#<?php echo $q?>mn li:hover ul{display: block; z-index:9}
#<?php echo $q?>mn li {width: auto; background:#f9f9f9;-webkit-border-top-left-radius: 3px;
-webkit-border-top-right-radius: 3px;
-moz-border-radius-topleft: 3px;
-moz-border-radius-topright: 3px;
border-top-left-radius: 3px;
border-top-right-radius: 3px;
margin-left:5px;
}
#<?php echo $q?>mn li img{vertical-align:middle; margin:0px 5px 3px 0px;}

hr.ln{size:1px; margin:5px 20px;border:none;border-top:1px dashed #CCCCCC; clear:both}

.reset,.button,.submit {background-color:#E3E3E3;border-color:#EEEEEE #888888 #888888 #EEEEEE;border-style:solid;border-width:1px;color:#666666;font-size:12px;font-weight:bold;margin:0px; padding:3px 10px;overflow:visible;}
.submit{cursor:pointer; color:#000}
.tbox,.tboxerror{padding:3px;scrollbar-face-color: #dddddd;scrollbar-highlight-color: #ffffff;scrollbar-shadow-color: #dddddd;scrollbar-3dlight-color: #ddddddd;scrollbar-arrow-color: #c4c4c4;scrollbar-track-color: #f5f5f5;scrollbar-darkshadow-color: #c4c4c4;background-color: #F9F9F9;color:#333333;border-top:1px solid #c4c4c4; border-left:1px solid #c4c4c4; border-right:1px solid #f6f6f6; border-bottom:1px solid #f6f6f6;font-size:11px;}
.submitfindsearch{background:url(../images/searchdiscount.png) center center no-repeat; width:95px; height:28px; border:none; cursor:pointer;}

.<?php echo $q?>prod td{vertical-align:middle; border-bottom:1px solid #e0e0e0; height:80px;background:#fff;}
.<?php echo $q?>prod .img{width:80px; text-align:center; }
.<?php echo $q?>prod .img a{ display:block;}
.<?php echo $q?>prod .img a img{ display:block; width:75px !important;}
.<?php echo $q?>prod .l0 td{background-color:#fff;}

#slider a{display:block}

.<?php echo $q?>prod .img a:hover img{
transform:rotate(360deg);
-webkit-transform:rotate(360deg); /* Safari and Chrome */
-ms-transform:rotate(360deg); /* Internet Explorer */
-moz-transform:rotate(360deg); /* Firefox */
-o-transform:rotate(360deg); /* Opera */
}
.<?php echo $q?>prod .img a img{
transition-duration: 1.2s;
transition-property:transform, margin-top;
-webkit-transition-duration: 1.2s;
-webkit-transition-property:-webkit-transform,margin-top;
-ms-transition-duration: 1.2s;
-ms-transition-property:-ms-transform, margin-top;
-moz-transition-duration: 1.2s;
-moz-transition-property:-moz-transform, margin-top;
-o-transition-duration: 1.2s; /* Opera */
-o-transition-property: -o-transform,margin-top; /* Opera */
}

.<?php echo $q?>prod .detail{font-size:11px}
.<?php echo $q?>prod h4 a{font-size:14px; font-weight:normal; text-decoration:underline; color:#237AAE}
.<?php echo $q?>prod p{font-size:11px; line-height:1.6em}
.<?php echo $q?>prod .offer{clear:both}
.<?php echo $q?>prod .offer li{list-style:inside disc; float:left; margin:0px 10px 0px 0px; color:#999} 
.<?php echo $q?>prod .boxp{text-align:right;font-size:16px; font-weight:bold; color:#002142}
.<?php echo $q?>prod .boxp img{vertical-align:middle; margin-bottom:5px}
.<?php echo $q?>prod .go2shop{ width:120px; display:block; height:22px; margin:3px auto; text-align:center; line-height:22px; background:#F70; color:#FFFFFF; font-size:12px; font-weight:bold;-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;}
.go2shop2{ width:120px; display:block; height:22px; margin:3px 0px; text-align:center; line-height:22px; background:#F70; color:#FFFFFF; font-size:12px; font-weight:bold;-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;}
a.go2shop:hover,a.go2shop:hover,a.listshop:hover{text-decoration:underline}

#fbpublish{display:none; background:#fff; border:1px solid #ddd; width:120px;}
#fbpublish ul{padding:5px}
#fbpublish ul li a{display:block; height:20px; line-height:20px; padding:0 10px 0px 25px; text-align:left}
#fbpublish ul li a.tw{background:url(../../lightzr/images/admin/twitter.png) left center no-repeat}
#fbpublish ul li a.fb{background:url(../../lightzr/images/admin/facebook.png) left center no-repeat}
#fbpublish ul li a.em{background:url(../../lightzr/images/admin/email.gif) left center no-repeat}
.fbshare{color:#237AAE; padding-right:15px; background:url(../../lightzr/images/admin/menu_split.gif) right center no-repeat}


.ioffer{background:#074A6F}
.ioffer th{text-align:center; background:#237AAE; color:#FFF}
.ioffer td{text-align:center; background:#fff}
.ioffer tr.low td{background:#F3FFE8}


.reviews{margin-bottom:10px;padding:10px; border:1px solid #ccc; font-size:11px;}
.reviews .v1{margin-bottom:5px; padding-bottom:5px; border-bottom:1px dashed #ddd}
.reviews .v2{text-indent:10px}

#hotprd a{ line-height:22px; height:22px; overflow:hidden; display:block; text-align:left; padding-left:22px; background:url(../images/bullet.gif) 5px center no-repeat; font-size:10px}
#hotprd li{border-bottom:1px dashed #dfdfdf;}
#hotprd{clear:both}
#hotprd span{font-size:9px}

.post{clear:both; margin:5px}
.cover{clear:both}
.listitm li a{display:block; height:22px; line-height:22px; overflow:hidden; font-size:11px; padding-left:20px; background:url(../images/bullet.gif) left center no-repeat; margin:0px 5px 0px 10px}
.listitm{max-height:500px; overflow:auto}


#<?php echo $q?>right h2{font-size:14px; overflow:hidden;padding:5px 10px 3px 10px; margin:2px 0px 3px;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;text-shadow:2px 2px 0px #fff;}

.bestcaption{margin:5px; padding-left:5px;}


#findsearch,#findsearch td{font-size:10px;}
#findsearch td{ border-top:1px dashed #f0f0f0;border-bottom:1px dashed #d0d0d0; padding:2px 2px 2px 0px;}

h3.tabs{border-bottom:3px solid #ccc;padding-right: 10px;margin-top: 3px;text-align:right;line-height:1.4em;font-size:12px; font-weight:normal; margin-bottom:5px; height:20px; clear:both}
h3.tabs a{background: #eee;padding: 4px 15px;margin: 0 1px;font-weight:normal;border: 1px solid #ddd;}
h3.tabs a.on{font-size:12px;color:#F90;font-weight:bold;background:#ffffff;border: 1px solid #ccc;border-bottom: 1px solid #fff;}
h3.tabs a:hover { color:#ffffff; background: #F90}
h3.tabs a.on:hover { color:#F90; background: #ffffff}

.detaillist{list-style:inside circle}


.barfull{font-size:14px; overflow:hidden;padding:5px 10px 3px; margin:2px 0px 3px;padding-left:20px}
.sreview{width:300px; overflow:hidden; float:left;}
.sreview li{ line-height:1.8em; height:1.8em; overflow:hidden; padding-left:10px;}
#<?php echo $q?>left .sreview{margin:0px 10px;}

#<?php echo $q?>social{ height:10px; overflow:hidden;background:#000000; border-top:2px solid #29447E}
#<?php echo $q?>social_button{ text-align:center; font-size:9px; height:24px; position:absolute; right:20px; top:0px; padding:0px 0px 5px 15px; background:#000000;border-bottom-left-radius:8px;-moz-border-radius-bottomleft:8px;-webkit-border-bottom-left-radius:8px;border-bottom-right-radius:8px;-moz-border-radius-bottomright:8px;-webkit-border-bottom-right-radius:8px;}
#<?php echo $q?>social_button .tbox{font-size:9px; padding:0px;}
#<?php echo $q?>social_button div{float:left; height:18px; margin:2px 5px}
#<?php echo $q?>social_button p{clear:both}


<style type="text/css">
#sphoto{display:none; margin:0px 0px 5px 277px;; border:1px solid #cccccc; padding:5px; text-align:center}
.home_left{float:left; width:270px; border:1px solid #EEEEEE; margin:4px 0px 0px 0px}
.home_left h3{padding:3px 3px 3px 10px; margin:0px; background:#F0F0F0; line-height:22px;}
.hlist{list-style:none; margin:0px 0px 0px 5px; padding:5px; line-height:1.6em}
.hlist a.b{display:block; padding:3px}
.hlist a.b:hover{background:#F0F0F0; text-decoration:none}
.home_icon{float:left; text-align:center; width:120px; height:120px; border:1px solid #EEEEEE; overflow:hidden; margin:4px 0 3px 7px; background:#FCFCFC; border-radius:5px; box-shadow:0px 0px 5px #e5e5e5;
transition-duration: 0.8s;
transition-property:border-bottom-right-radius,box-shadow;
-webkit-transition-duration: 0.8s;
-webkit-transition-property:-webkit-border-bottom-right-radius,-webkit-box-shadow;
-moz-transition-duration: 0.8s;
-moz-transition-property:-moz-border-radius-bottomright,-moz-box-shadow;
-o-transition-duration: 0.8s;
-o-transition-property: border-bottom-right-radius,box-shadow; 
}
a.home_icon:hover{
	border-bottom-right-radius: 50% 20px;
	-webkit-border-bottom-right-radius: 50% 20px;
	-moz-border-radius-bottomright: 50% 20px;
	-webkit-box-shadow: 5px 5px 15px #ddd;
	-moz-box-shadow: 5px 5px 15px #ddd;
	box-shadow: 5px 5px 15px #ddd;
	position: relative;

}
.home_icon strong{display:block; margin:0px auto; width:110px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap}
.home_icon img{width:32px; height:32px; margin:30px auto 20px;
transition-duration: 1.2s;
transition-property:transform, margin-top;
-webkit-transition-duration: 1.2s;
-webkit-transition-property:-webkit-transform,margin-top;
-ms-transition-duration: 1.2s;
-ms-transition-property:-ms-transform, margin-top;
-moz-transition-duration: 1.2s;
-moz-transition-property:-moz-transform, margin-top;
-o-transition-duration: 1.2s;
-o-transition-property: -o-transform,margin-top; 
}
a.home_icon:hover img{
transform:rotate(360deg);
-webkit-transform:rotate(360deg);
-ms-transform:rotate(360deg);
-moz-transform:rotate(360deg); 
-o-transform:rotate(360deg);
}
a.home_icon:hover{text-decoration:none; background:#FFFFFF; border:1px solid #F90;}
li.progress1{text-align:center; margin:0px auto 5px; width:250px; height:12px; font-size:9px; border:1px solid #FFB63C; line-height:12px; background:url(<?php echo HTTP?>static/images/orange.gif) center center repeat; overflow:hidden}
li.progress1 p{text-align:center;background:url(<?php echo HTTP?>static/images/orange2bar.gif) <?php echo intval((($this->product['indexed']-$this->product['allproduct'])/max($this->product['allproduct'],1))*250)?>px -14px no-repeat;}
li.progress2{text-align:center; margin:0px auto 5px; width:250px; height:12px; font-size:9px; border:1px solid #95CD36; line-height:12px; background:url(<?php echo HTTP?>static/images/green.gif) center center repeat; overflow:hidden}
li.progress2 p{text-align:center;background:url(<?php echo HTTP?>static/images/green2bar.gif) <?php echo min(0,intval((($this->click24-$this->referer24)/max($this->referer24,1))*250))?>px -14px no-repeat;}
</style>


<div class="home_left">
<h3>ข้อมูลเว็บไซต์</h3>
<ul class="hlist">
<li class="progress1"><p title="จำนวนสินค้าที่บอทเคยเข้า / จำนวนสินค้าทั้งหมด" class="show-tooltip-s"><?php echo number_format(intval($this->product['indexed']))?> / <?php echo number_format(intval($this->product['allproduct']))?> (<?php echo intval((intval($this->product['indexed'])/max($this->product['allproduct'],1))*100)?>%)</p></li>
<?php if(isset($this->referer24)&&isset($this->click24)):?><li class="progress2"><p title="จำนวนคลิกสินค้าภายใน 24ชม / จำนวนผู้ที่เข้ามาจากกูเกิ้ลภายใน 24ชม" class="show-tooltip-s"><?php echo number_format($this->click24)?> / <?php echo number_format($this->referer24)?> (<?php echo intval(($this->click24/max($this->referer24,1))*100)?>%)</p></li><?php endif?>
<li><img src="<?php echo HTTP?>modules/product/images/icon16.png" class="icon" /> หมวดสินค้า : <?php echo number_format($this->cate)?></li>
<li><img src="<?php echo HTTP?>static/images/view.gif" class="icon" /> จำนวนสินค้า : <?php echo number_format($this->product['allproduct'])?></li>
<li><img src="<?php echo HTTP?>static/images/options.gif" class="icon" /> สินค้าที่มีการ rewrite : <?php echo number_format(intval($this->rewrite))?></li>
<li><img src="<?php echo HTTP?>static/images/heart.gif" class="icon" /> จำนวนรูปภาพ : <span id="cphoto"><?php echo number_format($this->photo)?></span> (<a href="javascript:;" onClick="getphoto()" class="show-tooltip-s" title="ดึงรูปภาพมาเก็บไว้ที่โฮส"><img src="<?php echo HTTP?>static/images/add.gif" class="icon" /></a> <a href="javascript:;" onClick="delphoto()" class="show-tooltip-s" title="ลบรูปภาพภายในโฮสทั้งหมด"><img src="<?php echo HTTP?>static/images/del.gif" class="icon" /></a>)</li>
<?php if(isset($this->referer)):?><li><img src="<?php echo HTTP?>modules/referer/images/icon16.png" class="icon" /> ผู้เยี่ยมชมผ่าน google : <?php echo number_format($this->referer)?></li><?php endif?>
<?php if(isset($this->bot)):?><li><img src="<?php echo HTTP?>modules/bot/images/icon16.png" class="icon" /> จำนวนบอทที่เข้ามา : <?php echo number_format($this->bot)?></li><?php endif?>
<?php if(isset($this->click)):?><li><img src="<?php echo HTTP?>modules/click/images/icon16.png" class="icon" /> จำนวนคลิกลิ้งค์สินค้า : <?php echo number_format($this->click)?></li><?php endif?>
</ul>
<h3>เมนูจัดการ</h3>
<ul class="hlist">
<li><a href="javascript:;" onClick="setbox('password')" class="b"><img src="<?php echo HTTP?>static/images/password.gif" class="icon" />  เปลี่ยนรหัสผ่าน</a></li>
<li><a href="javascript:;" onClick="ajax_clearcache()" class="b"><img src="<?php echo HTTP?>static/images/delcache.gif" class="icon" /> ล้างข้อมูล Cache ของระบบ</a></li>
</ul>
<script type="text/javascript">
var cur='',wt=5,tmw;
function setbox(_){if(_!=cur||!_){$('#boxhome').slideDown('slow');$('#boxset').slideUp('fast');}if(_&&_!=cur)ajax_setbox(_,cur);cur=_;}
function getphoto(){if(confirm('คุณต้องการดึงรูปภาพสินค้ามาเก็บไว้ภายในโฮสหรือไม่')){wt=0;sendget();}}
function delphoto(){if(confirm('คุณต้องการลบรูปภาพภายในโฮสทั้งหมดหรือไม่')){ wt=0;senddel();}}
function sendget()
{
	clearTimeout(tmw);
	wt-=1;
	if(wt<1)
	{
		ajax_getphoto();
		$('#sphoto').css({display:'block'});
		$('#sphoto').html('กำลังดึงรูปสินค้า กรุณารอซักครู่...');
	}
	else
	{
		$('#sphoto').html('กำลังรอการดึงรูปสินค้า กรุณารอซักครู่... (<span id="rec">'+wt+'</span>)');
		tmw=setTimeout('sendget()',1000);
	}	
}
function senddel()
{
	clearTimeout(tmw);
	wt-=1;
	if(wt<1)
	{
		ajax_delphoto();
		$('#sphoto').css({display:'block'});
		$('#sphoto').html('กำลังลบรูปสินค้าทั้งหมด กรุณารอซักครู่...');
	}
	else
	{
		$('#sphoto').html('กำลังรอการลบรูปสินค้า กรุณารอซักครู่... (<span id="rec">'+wt+'</span>)');
		tmw=setTimeout('senddel()',1000);
	}	
}
</script>
<div class="clear"></div>
<br />
</div>
<div id="sphoto"></div>
<div id="boxset" style="margin:0px 0px 0px 277px;"></div>
<div id="boxhome" style="margin:0px 0px 0px 270px">
<?php for($i=0;$i<count($this->service);$i++):?>
<a href="<?php echo PATHMIN.$this->service[$i]['link']?>" class="home_icon">
<img src="<?php echo HTTP?>modules/<?php echo $this->service[$i]['folder']?>/images/icon32.png" />
<strong><?php echo $this->service[$i]['name']?></strong>
</a>
<?php endfor?>
<div class="clear"></div>
</div>
<div class="clear"></div>
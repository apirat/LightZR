<?php $q=lz::$c['prefix']?>
<div id="<?php echo $q?>wrap">
  <div id="<?php echo $q?>social"></div>
  <div id="<?php echo $q?>ner">
  <header>
    <section id="<?php echo $q?>head">
       <div id="<?php echo $q?>social_button">
         <div><a name="fb_share" type="button_count" href="http://www.facebook.com/sharer.php" target="_blank">Facebook</a><script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" type="text/javascript"></script></div>
         <div><g:plusone size="medium" count="true" href="http://<?php echo HOST.URL?>"></g:plusone></div>
         <div><a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal" target="_blank">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></div>
         <p></p>
       </div>
       <?php if(trim(lz::$s['ads468'])):?><div class="<?php echo $q?>468" id="ads468"><iframe src="http://rcm.amazon.com/e/cm?t=<?php echo lz::$c['awstag']?>&o=1&p=<?php echo lz::$s['ads468']?>" width="468" height="60" scrolling="no" border="0" marginwidth="0" style="border:none;" frameborder="0"></iframe></div><?php endif?>
       <hgroup id="slogan"><h1><a href="<?php echo $this->url['category']?>" title="<?php echo lz::$s['title']?lz::$s['title']:lz::$c['sitename']?>"><?php echo lz::$s['title']?lz::$s['title']:lz::$c['sitename']?></a></h1><h2><?php echo lz::$c['description']?></h2></hgroup>
    </section>
    <nav id="<?php echo $q?>br">
      <ul id="<?php echo $q?>mn">
        <?php if(!lz::$s['domain']):?><li><a href="<?php echo $this->url['home']?>"><img src="<?php echo HTTP?>themes/<?php echo lz::$c['theme']?>/images/home.gif"><span>Home</span></a></li><?php endif?>
        <?php if(lz::$s['title']):?><li<?php echo lz::$f[0]=='all'?' class="current"':''?>><a href="<?php echo $this->url['category']?>"><img src="<?php echo HTTP?>themes/<?php echo lz::$c['theme']?>/images/search.gif"><span><?php echo lz::$s['title']?></span></a></li><?php endif?>
      </ul>
      <p class="clear"></p>
    </nav>
    </header>
      <div id="<?php echo $q?>c">
      <div id="<?php echo $q?>left">
      
      <div class="<?php echo $q?>bestbox">
		<?php echo $this->box['bar1']?>
        <div class="clear"></div>
         <article>
            <?php echo $this->content?>
            <div class="clear"></div>
         </article>
         </div>
       </div>
       <div class="<?php echo $q?>right" id="<?php echo $q?>right">
          <aside>
	<?php echo $this->box['menu']?>
   		 </aside>
       </div>
       <div class="clear"></div>
	<?php echo $this->box['bar2']?>
  </div>
<footer id="<?php echo $q?>foot">
<section>
<div>&copy; <?php echo date('Y')?> <?php echo lz::$s['domain']?lz::$s['domain']:lz::$cf['domain']?>, All Rights Reserved <?php if(lz::$c['rss']):?> | <a href="<?php echo QUERY?>rss.xml">Feed</a><?php endif?><?php if(lz::$c['sitemap']):?> | <a href="<?php echo QUERY?>sitemap.xml">Sitemap</a><?php endif?></div>
<div><?php echo lz::$c['disclaimer']?></div>
</section>
</footer>
  </div>
</div>


<script type="text/javascript">
function search3(){var search=$('#search3').val();if(search=='Enter Keywords...')search='';if(search.indexOf('/')>=0)alert("not allowed '/'");else window.location.href='<?php echo $this->url['category']?>'+(search?'search-'+search:'');}
</script>
<?php if(lz::$c['fbappid']):?>
<div id="fb-root"></div>
<script type="text/javascript">
window.fbAsyncInit = function() {FB.init({appId: '<?php echo lz::$c['fbappid']?>',status: true,cookie: true,xfbml: true});}
loadFBConnectJS = function() {
var e = document.createElement('script');
e.async = true;
e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
document.getElementById('fb-root').appendChild(e);
};
$(loadFBConnectJS);
</script>
<?php endif?>
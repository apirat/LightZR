<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">            
<url>
<?php 
if(lz::$c['sub']==2):
	$url='http://'.SUB.'.'.lz::$cf['domain'].QUERY;
else:
      	$url='http://www.'.lz::$cf['domain'].QUERY.lz::$s['link'];
endif;
?>
  <loc><?php echo $url?></loc><changefreq>daily</changefreq><priority>0.9</priority>
</url>
<?php for($i=0;$i<count($this->product);$i++):?>
<?php 
if(lz::$s['domain']):
	$url='http://'.HOST.QUERY.$this->product[$i]['link'];
elseif(lz::$c['sub']==2):
	$url='http://'.$this->product[$i]['clink'].'.'.lz::$cf['domain'].QUERY.$this->product[$i]['link'];
elseif(lz::$c['sub']==1):
      	$url='http://www.'.lz::$cf['domain'].QUERY.$this->product[$i]['link'];
else:
      	$url='http://www.'.lz::$cf['domain'].QUERY.$this->product[$i]['clink'].'/'.$this->product[$i]['link'];
endif;
?>
<url>
  <loc><?php echo $url?><?php echo lz::$c['pinfo']?'/'.lz::$c['pinfo']:''?></loc><changefreq>weekly</changefreq><priority>0.8</priority>
</url>
<?php endfor?>
</urlset>
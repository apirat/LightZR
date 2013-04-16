<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
<url>
  <loc>http://www.<?php echo lz::$cf['domain'].QUERY?></loc><changefreq>daily</changefreq><priority>1.0</priority>
</url>
<?php for($i=0;$i<count($this->site);$i++):?>
<?php 
if($this->site[$i]['domain']):
	$cate='http://www.'.$this->site[$i]['domain'].QUERY;
elseif(lz::$c['sub']==2):
	$cate='http://'.$this->site[$i]['link'].'.'.lz::$cf['domain'].QUERY;
else:
	$cate='http://www.'.lz::$cf['domain'].QUERY.$this->site[$i]['link'];
endif;
?>
<url>
  <loc><?php echo $cate?></loc><changefreq>weekly</changefreq><priority>0.9</priority>
</url>
<?php endfor?>
</urlset>
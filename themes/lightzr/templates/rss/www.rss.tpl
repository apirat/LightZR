<?php echo '<?xml version="1.0" encoding="utf-8"?>'?>
<rss version="2.0">
<channel>
	<title><?php echo lz::$c['title']?></title>
	<description><?php echo lz::$c['description']?></description>
	<language>en-us</language>
	<link>http://<?php echo HOST?></link>
	<pubDate><?php echo date('r')?></pubDate>
	<generator><?php echo HOST?></generator>
	<copyright><?php echo HOST?></copyright>
	<image>
		<title><?php echo lz::$c['title']?></title>
		<link>http://<?php echo SUB?>.<?php echo DOMAIN.QUERY?></link>
		<description><?php echo lz::$c['description']?></description>
	</image>
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
	<item>
		<title><![CDATA[<?php echo $this->product[$i]['title']?>]]></title>
		<guid isPermaLink="false"><?php echo $url?><?php echo lz::$c['pinfo']?'/'.lz::$c['pinfo']:''?></guid>
		<description><![CDATA[<?php echo mb_substr(trim(str_replace("\n"," ",strip_tags($this->product[$i]['editor']))),0,200,'utf-8')?>]]></description>
		<link><?php echo $url?><?php echo lz::$c['pinfo']?'/'.lz::$c['pinfo']:''?></link>
		<enclosure
			url="<?php echo $this->product[$i]['s']?>" 
			type="image/jpeg" 
		/>
		<pubDate><?php echo date('r',strtotime($this->product[$i]['added']))?></pubDate>
	</item>
          <?php endfor?>
</channel>
</rss>

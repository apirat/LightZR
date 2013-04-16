<?php for($i=0;$i<count($this->site);$i++):?>
<?php echo $i>0?', ':''?><a href="<?php echo $this->site[$i]['domain']?'http://www.'.$this->site[$i]['domain']:(lz::$c['sub']==2?'http://'.$this->site[$i]['link'].'.'.lz::$cf['domain']:QUERY.$this->site[$i]['link'])?>"><?php echo trim($this->site[$i]['title'])?></a></li>
<?php endfor?>

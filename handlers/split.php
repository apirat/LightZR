<?php
class split
{
	function get($url,$start,$all,$allorder=false,$allby=false)
	{
		$split=array();
		for($i=$start;$i<count(lz::$f);$i++)
		{
			
			if(preg_match('/^page\-([0-9]+)$/',lz::$f[$i],$p))
			{
				$split['page']=$p[1];
			}
			elseif(in_array(lz::$f[$i],$all))
			{
				if($split[lz::$f[$i]]=lz::$f[$i+1])
				{
					if(lz::$f[$i]!='page')$url.=lz::$f[$i].'/'.lz::$f[$i+1].'/';
				}
				$i++;
			}
		}
		if($allorder)
		{
			$keyorder=array_keys($allorder);
			if(($split['order']&&!array_key_exists($split['order'],$allorder))||!$split['order']) $split['order']=$keyorder[0];
		}
		if($allby)
		{
			$keyby=array_keys($allby);
			if(($split['by']&&!array_key_exists($split['by'],$allby))||!$split['by']) $split['by']=$keyby[0];
		}
		if(array_key_exists('page',$split)&&$split['page']<1) $split['page']=1;
		return array_merge($split,array('url'=>$url));
	}
}
?>
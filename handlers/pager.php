<?php
class pager
{
	function page($rpp,$count,$href,$fpage='',$page=1,$qstring='')
	{
		$pages=ceil($count/$rpp);
		if($page=='last')$page=$pages;
		if($page<1)$page=1;
		if($page>1)
		{
			$fp=($page-1);
			$page1='<a href="'.$href.($fp>1?$fpage.$fp:'').'" class="page1">&larr;</a>';
		}
		if($page<$pages&&$pages>1)$page2='<a href="'.$href.$fpage.($page+1).'" class="page1">&rarr;</a>';
		if($count)
		{
			$pagerarr=array();
			$start_p=($page>5?$page-5:0);
			$stop_p=$start_p+10;
			for ($i=1;$i<=$pages; $i++)
			{
				if (($i!=$pages&&$i!=1)&&($start_p>$i||$stop_p<$i))
				{
					if(!$dotted)$pagerarr[]=" | ";
					$dotted=true;
					continue;
				}
				$dotted=false;
				if ($i!=$page)
				{
					$fp=$href.($i>1?$fpage.$i:'');
					$pagerarr[]='<a href="'.$fp.($qstring?$qstring:'').'" class="page1">'.$i.'</a>';
				}
				else $pagerarr[]="<b class=\"page2\">$i</b>";
			}
			$pager=join("",$pagerarr);
		}
		$pagertop="<p class=\"pager\" align=\"right\">$page1 $pager $page2</p>";
		return array($pagertop,"LIMIT ".(($page-1)*$rpp).", $rpp",$page);
	}
}
?>
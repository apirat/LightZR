<?php
$db=lz::h('db');
$cate=$db->GetAll('select * from product_category order by id asc');

$fr=array();
$fields = mysql_list_fields(lz::$cf['db']['default']['database'], "product_category",$db->Connected);
$columns = mysql_num_fields($fields);
for ($i = 0; $i < $columns; $i++) 
{
	$n=mysql_field_name($fields, $i);
	if(!in_array($n,array('menu','autosearch','thumbnail','rate','dorder','countbl','autodb','parent','code','lastsearch','added','getmax','spage','scur','pingo','site','lastblog','lastasin','referer')))
	{
		$fr[] = $n;
	}
}
		
$f=ROOT.'files/category.csv';
if(file_exists($f))@unlink($f);
$fp = @fopen($f, 'w');
fputcsv($fp, $fr);
for($i=0;$i<count($cate);$i++)
{
	$fa=array();
	for($j=0;$j<count($fr);$j++)
	{
		$fa[]=$cate[$i][$fr[$j]];
	}
	@fputcsv($fp, $fa);
}
@fclose($fp);

header('Content-type: application/ms-excel');
header ("Content-Disposition: attachment; filename=".DOMAIN."-category.csv");
echo @file_get_contents($f);
if(file_exists($f))@unlink($f);
exit
?>
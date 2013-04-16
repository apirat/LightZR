<?php
header('Content-type: application/ms-excel');
header ("Content-Disposition: attachment; filename=".DOMAIN."-referer.xls");
lz::h('time');
$rf=lz::h('db')->GetAll('select * from referer order by time desc');
echo "Time\tKeyword\tIP\tDomain\tURI\n";
for($i=0;$i<count($rf);$i++)
{
	$p=parse_url($rf[$i]['refer']);
	parse_str($p[ 'query' ],$s);
	echo iconv('utf-8','tis-620',time::show($rf[$i]['time'],'datetime'))."\t".$s['q']."\t".$rf[$i]['ip']."\t".$rf[$i]['host']."\t".$rf[$i]['uri']."\n";
}
exit;
?>